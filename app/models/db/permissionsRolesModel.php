<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class PermissionsRolesModel extends DBModelAbstract {

    public string $table = 'permissions_roles';
    public string $query = "SELECT * FROM permissions_roles";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function parseKey(mixed $key): string {
        return idxval($key);
    }

    public function parseData(?array $data): array|null {
        if($data){
            $data['rol'] = idxval($data['rol'] ?? '');
            $data['permission'] = idxval($data['permission'] ?? '');
            $data['value'] = strboolval($data['value'] ?? false);
        } return $data;
    }

    public function parseDataFromRoles(?string $rol, ?array $data): array|null {
        if ($rol && $data && is_array($data)) {
            foreach ($data as $key => $item) {
                $item['rol'] = $rol;
                $data[$key] = $this->parseData($item);
            }
        } return $data;
    }

    public function parseTable(ResultError|ResultData|ResultPaginate $data): ResultError|ResultData|ResultPaginate {
        if ($data->success && is_array($data->data)) {
            foreach ($data->data as $key => $item) {
                $data->data[$key] = $this->parseTableItem($item);
            }
        } return $data;
    }

    public function parseTableArray(?array $data): array|null{
        if ($data && is_array($data)) {
            foreach ($data as $key => $item) {
                $data[$key] = $this->parseTableItem($item);
            }
        } return $data;
    }

    public function parseTableItem(?array $item): array|null {
        if ($item) {
            $item['value'] = strboolval($item['value']);
        } return $item;
    }

    //-----------------------------------------
    
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