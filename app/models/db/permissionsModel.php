<?php
require_once __DIR__ . "/modulesModel.php";
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class PermissionsModel extends DBModelAbstract {
    
    public string $table = 'permissions';
    public string $query = "SELECT
        P.`id` AS `id`,
        P.`action` AS `action`,
        P.`module` AS `module`
    FROM `permissions` P
    LEFT JOIN `modules` M ON M.`id` = P.`module`
    LEFT JOIN `actions` A ON A.`id` = P.`action`
    ORDER BY M.`module`, M.`submodule`, A.`name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function setParseData(?array $data): array|null {
        if($data){
            $data['module'] = idxval($data['module'] ?? '');
            $data['action'] = idxval($data['action'] ?? '');
        } return $data;
    }

    public function validate(?array $data): bool {
        $this->error = null;
        if (!$data) {
            return $this->setError();
        } if (!isset($data['module']) || !$data['module']) {
            return $this->setError('invalid-module');
        } if (!isset($data['action']) || !$data['action']) {
            return $this->setError('invalid-action');
        } return true;
    }

    //-----------------------------------

    public function getAllGroupedByModules(?string $indexPerm=null, ?string $indexMod=null, ?array $conditionsMod=null, ?string $msg=null): ResultError|ResultData {
        if ($this->conn) {
            try {

                $modulesModel = new ModulesModel($this->conn);
                $modules = $modulesModel->getAllGroupedByModules(false, $indexMod, $conditionsMod, $msg);

                if ($modules->success) {

                    $query = "SELECT
                        P.`id` AS `id`,
                        P.`action` AS `action`,
                        P.`module` AS `module`
                    FROM `permissions` P
                    LEFT JOIN `modules` M ON M.`id` = P.`module`
                    LEFT JOIN `actions` A ON A.`id` = P.`action`
                    WHERE P.`module` = :module
                    ORDER BY M.`module`, M.`submodule`, A.`name` ASC";

                    foreach ($modules->data as $key => $module) {
                        $permissions = $this->getAll($query, $indexPerm, false, [
                            'module' => $module['id']
                        ]); 
                        
                        if ($permissions->success) {
                            $modules->data[$key]['permissions'] = $permissions->data;
                        } else {
                            return $permissions;
                        }

                        if ($modules->data[$key]['submodules'] && is_array($modules->data[$key]['submodules'])) {
                            foreach ($modules->data[$key]['submodules'] as $keySub => $submodule) {
                                $permissions = $this->getAll($query, $indexPerm, false, [
                                    'module' => $submodule['id']
                                ]); 

                                if ($permissions->success) {
                                    $modules->data[$key]['submodules'][$keySub]['permissions'] = $permissions->data;
                                } else {
                                    return $permissions;
                                }
                            }
                        }
                    }
                }

                return $modules;
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }
}