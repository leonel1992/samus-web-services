<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class PermissionsRolesModel extends DBModelAbstract {

    public string $table = 'permissions_roles';
    public string $query = "SELECT * FROM permissions_roles";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function getParseDataArray(?array $data): array|null{
        if ($data && is_array($data)) {
            foreach ($data as $key => $item) {
                $data[$key] = $this->getParseItem($item);
            }
        } return $data;
    }

    public function getParseItem(?array $item): array|null {
        if ($item) {
            $item['value'] = strboolval($item['value']);
        } return $item;
    }

    public function setParseData(?array $data): array|null {
        if($data){
            $data['rol'] = idxval($data['rol'] ?? '');
            $data['permission'] = idxval($data['permission'] ?? '');
            $data['value'] = strboolval($data['value'] ?? false);
        } return $data;
    }

    public function setParseDataFromRoles(?string $rol, ?array $data): array|null {
        if ($rol && $data && is_array($data)) {
            foreach ($data as $key => $item) {
                $item['rol'] = $rol;
                $data[$key] = $this->setParseData($item);
            }
        } return $data;
    }

    public function validate(?array $data): bool {
        $this->error = null;
        if ($data) {
            if (!isset($data['rol']) || !$data['rol']) {
                return $this->setError('invalid-rol');
            } if (!isset($data['permission']) || !$data['permission']) {
                return $this->setError('invalid-permission');
            }
        } return true;
    }

    //-----------------------------------------
    
    public function insertFields() {
        return "(
            rol, 
            permission,
            value
        )";
    }

    public function insertValues() {
        return "(
            :rol, 
            :permission,
            :value
        )";
    }

    public function updateFields() {
        return "value = :value";
    }

    //-----------------------------------------
    
    public function getAllPermissionsByRol(?string $rol): ResultData|ResultError {
        $sql = "SELECT `permission`,`value` FROM `{$this->table}` WHERE `rol` = :rol";
        return $this->getAll($sql, 'permission', false, [
            'rol' => $rol ?? 'client'
        ]);
    }

}