<?php
require_once __DIR__ . "/permissionsRolesModel.php";
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class RolesModel extends DBModelAbstract {

    public PermissionsRolesModel $permModel;
    
    public string $table = 'roles';
    public string $query = '';

    public function __construct(?PDO $conn) {
        parent::__construct($conn);

        $this->permModel = new PermissionsRolesModel($conn);
        $this->query = "SELECT
            R.`id` AS `id`,
            R.`name` AS `name`,
            R.`description` AS `description`,
            (SELECT 
                CONCAT(
                    '[', 
                    GROUP_CONCAT(
                        JSON_OBJECT(
                            'id', P.`id`, 
                            'permission', P.`permission`, 
                            'value', P.`value`
                        ) SEPARATOR ','
                    ),
                    ']'
                )
            FROM `{$this->permModel->table}` P 
            WHERE P.`rol` = R.`id`
            ) AS `permissions`
        FROM `roles` R
        ORDER BY R.`name` ASC";
    }

    //-----------------------------------------

    public function getParseItem(?array $item): array|null {
        if ($item) {
            $permissions = json_decode($item['permissions'], JSON_OBJECT_AS_ARRAY);
            $item['permissions'] = $this->permModel->getParseDataArray($permissions);
        } return $item;
    }

    public function setParseData(?array $data): array|null {
        if($data){
            $data['id'] = idxval($data['id'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['description'] = trimstrval($data['description'] ?? null, true);
            $data['permissions'] = $this->permModel->setParseDataFromRoles($data['id'], $data['permissions'] ?? null); 
        } return $data;
    }

    public function validate(?array $data): bool {
        $this->error = null;

        if (!$data) {
            return $this->setError();
        } if (!isset($data['id']) || !$data['id']) {
            return $this->setError('invalid-id');
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } 

        if (isset($data['permissions']) && is_array($data['permissions']) && count($data['permissions']) > 0) {
            $count = 0;
            $valid = true;
            while ($valid && $count < count($data['permissions'])) {
                $valid = $this->permModel->validate($data['permissions'][$count]);
                $count++;
            } if (!$valid) {
                return $this->setError('invalid-permissions');
            }
        } else {
            return $this->setError('invalid-permissions');
        } return true;
    }

    //-----------------------------------------

    public function insertFields(): string {
        return "(
            id, 
            name,
            description
        )";
    }

    public function insertValues(): string {
        return "(
            :id, 
            :name,
            :description
        )";
    }

    public function updateFields(): string {
        return "
            id = :id,
            name = :name,
            description = :description
        ";
    }
    
    //-----------------------------------------

    public function insert(array $data, string $idKey='id', ?string $msg=null): ResultError|ResultData {
        if ($this->conn) {
            try {

                //init transaction
                $this->conn->beginTransaction();
                
                //roles
                $fields = $this->insertFields();
                $values = $this->insertValues();
                $sql = "INSERT INTO {$this->table} $fields VALUES $values"; 
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":id", $data['id']);
                $stmt->bindValue(":name", $data['name']);
                $stmt->bindValue(":description", $data['description']);
                $execRoles = $stmt->execute();
                
                //permissions
                $execPerm = true;
                $rol = $data['id'];
                if($execRoles && $rol){
                    $fields = $this->permModel->insertFields();
                    $values = $this->permModel->insertValues();
                    $sql = "INSERT INTO {$this->permModel->table} $fields VALUES $values";
                    foreach ($data['permissions'] as $item) {
                        $item['rol'] = $rol;
                        $stmt = $this->conn->prepare($sql);
                        foreach ($item as $key => $value) {
                            $stmt->bindValue(":$key", $value);
                        } if(!$stmt->execute()){
                            $execPerm = false;
                            break;
                        };
                    }
                }
                
                //commit
                if($execRoles && $execPerm && $this->conn->commit()){
                    return new ResultData($msg ?? $GLOBALS['lang-controllers']['db'][$this->table]['insert'], $idKey, 'id');
                } 
                
                return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

    //-----------------------------------------

    public function updateByKeys(array $keys, array $data, ?string $msg=null): ResultError|ResultSuccess {
        if ($this->conn) {
            try {

                //init transaction
                $this->conn->beginTransaction();

                //conditions
                $cond = "";
                foreach ($keys as $key => $value) {
                    if ($cond) {
                        $cond .= " AND ";
                    } $cond .= "`$key` = :KEY_$key";
                }

                //roles
                $update = $this->updateFields();
                $sql = "UPDATE {$this->table} SET {$update} WHERE $cond";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":id", $data['id']);
                $stmt->bindValue(":name", $data['name']);
                $stmt->bindValue(":description", $data['description']);
                foreach ($keys as $key => $value) {
                    $stmt->bindValue(":KEY_$key", $value);
                } $execRoles = $stmt->execute();

                //permissions
                $execPerm = true;
                $rol = $data['id'];
                if($execRoles){
                    $update = $this->permModel->updateFields();
                    $fields = $this->permModel->insertFields();
                    $values = $this->permModel->insertValues();
                    $sql = "INSERT INTO {$this->permModel->table} $fields VALUES $values ON DUPLICATE KEY UPDATE $update";
                    foreach ($data['permissions'] as $item) {
                        $item['rol'] = $rol;
                        $stmt = $this->conn->prepare($sql);
                        foreach ($item as $key => $value) {
                            $stmt->bindValue(":$key", $value);
                        } if(!$stmt->execute()){
                            $execPerm = false;
                            break;
                        };
                    }
                }
                
                //commit
                if($execRoles && $execPerm && $this->conn->commit()){
                    return new ResultSuccess($msg ?? $GLOBALS['lang-controllers']['db'][$this->table]['update']);
                } 
                
                return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

}