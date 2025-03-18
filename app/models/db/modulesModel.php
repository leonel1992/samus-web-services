<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class ModulesModel extends DBModelAbstract {

    public string $table = 'modules';
    public string $query = "SELECT * FROM modules ORDER BY module,submodule ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function setParseData(?array $data): array|null {
        if($data){
            $data['id'] = idxval($data['id'] ?? '');
            $data['module'] = trimstrval($data['module'] ?? '');
            $data['submodule'] = trimstrval($data['submodule'] ?? null, true);
            $data['link_es'] = trimstrval($data['link_es'] ?? null, true);
        } return $data;
    }

    public function validate(?array $data): bool {
        return $this->runValidation($data, [
            'id' => !empty($data['id']),
            'module' => !empty($data['module']),
        ]);
    }

    //-----------------------------------------

    public function getQueryAllGroupedByModule(bool $includeLink = true): string {

        $jsonLink = '';
        $queryLink = '';
        if ($includeLink) {
            $queryLink = 'link_es, ';
            $jsonLink = ",'link_es', link_es";
        }

        return "SELECT 
            id, 
            module, 
            {$queryLink}
            CONCAT(
                '[', 
                GROUP_CONCAT(
                    CASE 
                        WHEN id <> (SELECT MIN(id) FROM modules AS m2 WHERE m2.module = m1.module) 
                        THEN JSON_OBJECT(
                            'id', id, 
                            'submodule', submodule
                            {$jsonLink}
                        ) 
                        ELSE NULL 
                    END
                    ORDER BY submodule ASC
                    SEPARATOR ','
                ), 
                ']'
            ) AS submodules
        FROM modules m1
        GROUP BY module
        ORDER BY module ASC";
    }

    //-----------------------------------------
    
    public function getAllModules(?string $index=null, $sublist=false, ?array $conditions=null, ?string $msg=null): ResultError|ResultData {
        $sql = "SELECT 
            `id`, 
            `module` AS `name`, 
            `link_es`
        FROM `modules`
        GROUP BY module
        ORDER BY `name` ASC";
        return $this->getAll($sql, $index, $sublist, $conditions, $msg);
    }

    public function getAllGroupedByModules(bool $includeLink=true, ?string $index=null, ?array $conditions=null, ?string $msg=null): ResultError|ResultData {
        $sql = $this->getQueryAllGroupedByModule($includeLink);
        $result = $this->getAll($sql, $index, false, $conditions, $msg);
        if ($result->success) {
            foreach ($result->data as $keyMod => $module) {
                $submodules = json_decode($module['submodules'], true) ?? [];

                $newSubmodules = [];
                if ($index !== null) {
                    foreach ($submodules as $keySub => $submodule) {
                        $newKey = $submodule[$index] ?? $keySub;
                        $newSubmodules[$newKey] = $submodule;
                    }
                } else {
                    $newSubmodules = $submodules;
                }

                $result->data[$keyMod]['submodules'] = $newSubmodules;
            }
        } return $result;
    }
}