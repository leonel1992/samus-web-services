<?php
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class ORM {

    protected ?PDO $conn;
    public string $table;
    
    public function __construct(?PDO $conn, string $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function getAll(?string $sql=null, ?string $index=null, bool $sublist=false, ?array $conditions=null, ?string $msg=null): ResultError|ResultData {

        if (!$sql) {
            $sql = "SELECT * FROM `{$this->table}`";
            if ($conditions) {
                $cont = 0;
                $sql .= " WHERE ";
                foreach ($conditions as $key => $value) {
                    $cont>0 ? $sql .= " AND " : null;
                    $sql .= "$key = :$key";
                }
            }
        }

        if ($this->conn) {
            try {

                $stmt = $this->conn->prepare($sql);
                if ($conditions) {
                    foreach ($conditions as $key => $value) {
                        $stmt->bindValue(":$key", $value);
                    }
                }

                if($stmt->execute()){
                    $data = [];
                    $i = $sublist ? [] : 0;
                    while($row = $stmt->fetch()){
                        if($index===null){
                            $data[$i] = $row;
                            $i++;
                        }else{
                            $aux = $row[$index];
                            if(!$sublist){
                                $data[$aux] = $row;
                            }else{
                                !array_key_exists($aux,$i) ? $i[$aux]=0 : null;
                                $data[$aux][$i[$aux]] = $row;
                                $i[$aux]++;
                            }
                        }
                    } 
                    
                    return new ResultData($msg ?? $GLOBALS['lang-controllers']['general']['query'], $data);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

    public function paginate(int $page, int $limit, ?string $sql=null, ?string $index=null, bool $sublist=false, ?array $conditions=null, ?string $msg=null): ResultError|ResultPaginate {
        if ($this->conn) {

            if (!$sql) {
                $sql = "SELECT * FROM `{$this->table}`";
                if ($conditions) {
                    $cont = 0;
                    $sql .= " WHERE ";
                    foreach ($conditions as $key => $value) {
                        $cont>0 ? $sql .= " AND " : null;
                        $sql .= "$key = :$key";
                    }
                }
            }

            try {

                $offset = ($page - 1) * $limit;
                $rows = (int) $this->conn->query("SELECT COUNT(*) FROM `{$this->table}`")->fetchColumn();
                $pages = ceil($rows / $limit);

                $sql = "{$sql} LIMIT {$offset},{$limit}";
                $stmt = $this->conn->prepare($sql);
                if ($conditions) {
                    foreach ($conditions as $key => $value) {
                        $stmt->bindValue(":$key", $value);
                    }
                }

                if($stmt->execute()){
                    $data = [];
                    $i = $sublist ? [] : 0;
                    while($row = $stmt->fetch()){
                        if($index===null){
                            $data[$i] = $row;
                            $i++;
                        }else{
                            $aux = $row[$index];
                            if(!$sublist){
                                $data[$aux] = $row;
                            }else{
                                !array_key_exists($aux,$i) ? $i[$aux]=0 : null;
                                $data[$aux][$i[$aux]] = $row;
                                $i[$aux]++;
                            }
                        }
                    } 
                    
                    return new ResultPaginate($page, $limit, $pages, $rows, $msg ?? $GLOBALS['lang-controllers']['general']['query'], $data);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }
    
    public function insert(array $data, string $ref='id', ?string $msg=null): ResultError|ResultData {
        if ($this->conn){
            try {
                $sql = "INSERT INTO `{$this->table}` (";
                foreach ($data as $key => $value) {
                    $sql .= "`{$key}`,";
                }
                $sql = rtrim($sql, ',');
                $sql .= ") VALUES (";
    
                foreach ($data as $key => $value) {
                    $sql .= ":{$key},";
                }
                $sql = rtrim($sql, ',');
                $sql .= ")";
    
                $stmt = $this->conn->prepare($sql);
                foreach ($data as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
    
                if($stmt->execute()){
                    if (isset($data[$ref]) && $data[$ref]) {
                        $insertKey = $data[$ref];
                    } else {
                        $insertKey = $this->conn->lastInsertId();
                        if ($insertKey == 0) {
                            $stmt = $this->conn->query("SELECT @last_inserted_id AS id");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $insertKey = $row['id'];
                        }
                    }

                    return new ResultData($msg ?? $GLOBALS['lang-controllers']['general']['insert'], $insertKey, $ref);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

    //--------------------------------------

    public function getByKey(string $key, string $value, ?string $sql=null, ?string $msg=null):ResultError|ResultData {
        return $this->getByKeys([
            $key => $value
        ], $sql, $msg);
    }

    public function getByKeys(array $keys, ?string $sql=null, ?string $msg=null): ResultError|ResultData { 
        if ($this->conn) {
            try {

                $cond = "";
                foreach ($keys as $key => $value) {
                    if ($cond) {
                        $cond .= " AND ";
                    } $cond .= "`$key` = :$key";
                }

                $sql ??= "SELECT * FROM `{$this->table}` WHERE $cond";
                $stmt = $this->conn->prepare($sql);
                foreach ($keys as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
                
                if($stmt->execute()){
                    if ($data = $stmt->fetch()) {
                        return new ResultData($msg ?? $GLOBALS['lang-controllers']['general']['query'], $data);
                    } return new ResultError($GLOBALS['lang-controllers']['general']['query-empty']);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

    //--------------------------------------

    public function deleteByKey(string $key, string $value, ?string $msg=null): ResultError|ResultSuccess {
        return $this->deleteByKeys([
            $key => $value
        ], $msg);
    }
    
    public function deleteByKeys(array $keys, ?string $msg=null): ResultError|ResultSuccess {
        if ($this->conn) {
            try {

                $cond = "";
                foreach ($keys as $key => $value) {
                    if ($cond) {
                        $cond .= " AND ";
                    } $cond .= "`$key` = :$key";
                }

                $sql = "DELETE FROM `{$this->table}` WHERE $cond";
                $stmt = $this->conn->prepare($sql);
                foreach ($keys as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                if($stmt->execute()){
                    return new ResultSuccess($msg ?? $GLOBALS['lang-controllers']['general']['delete']);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }

    //--------------------------------------

    public function updateByKey(string $key, mixed $value, array $data, ?string $msg=null): ResultError|ResultSuccess {
        return $this->updateByKeys([
            $key => $value,
        ], $data, $msg);
    }

    public function updateByKeys(array $keys, array $data, ?string $msg=null): ResultError|ResultSuccess {
        if ($this->conn){
            try {

                $cond = "";
                foreach ($keys as $key => $value) {
                    if ($cond) {
                        $cond .= " AND ";
                    } $cond .= "`$key` = :KEY_$key";
                }

                $sql = "UPDATE `{$this->table}` SET ";
                foreach ($data as $key => $val) {
                    $sql .= "`{$key}` = :{$key},";
                }
                $sql = rtrim($sql, ',');
                $sql .= " WHERE $cond ";
                
                $stmt = $this->conn->prepare($sql);
                foreach ($keys as $key => $value) {
                    $stmt->bindValue(":KEY_$key", $value);
                }
                foreach ($data as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                if($stmt->execute()){
                    return new ResultSuccess($msg ?? $GLOBALS['lang-controllers']['general']['update']);
                } return new ResultErrorPDO($stmt);
            } catch (PDOException $exception) {
                return new ResultErrorException($exception);
            } catch (Exception $exception) {
                return new ResultErrorException($exception);
            }
        } return new ResultErrorConn();
    }
}