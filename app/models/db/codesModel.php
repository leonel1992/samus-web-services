<?php
require_once __DIR__ . '/../../helpers/encrypt.php';
require_once __DIR__ . '/../../services/codeService.php';

class CodesModel { 
    
    protected ORM $orm;
    protected ?PDO $conn;
    private string $table = 'codes';
    
    private string $code;
    private string $codeID;

    public function __construct(?PDO $conn) {
        $this->orm = new ORM($conn, $this->table);
        $this->conn = $conn;
    }

    private function generateID(): void {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $prefix = substr(str_shuffle($chars), 0, 10);
        $this->codeID = strtoupper(uniqid($prefix));
    }

    private function generateCode($email): void {
        if ( isset($GLOBALS['emails'][$email]['code']) ) {
            $this->code = $GLOBALS['emails'][$email]['code'];
        } else {
            if ( isset($GLOBALS['emails'][$_SERVER['SERVER_NAME']]) ) {
                $chars = '0123456789';
                $this->code = substr(str_shuffle($chars), 0, 6);
            } else {
                $this->code = '000000';
            }
        }
    }

    //-----------------------------------------------------

    public function getCode(): string {
        return $this->code;
    }

    public function getCodeID(): string {
        return $this->codeID;
    }

    //-----------------------------------------------------

    public function getByKey(string $key, string $value, ?string $sql=null): ResultData|ResultError {
        return $this->orm->getByKey($key, $value, $sql);
    }

    public function getByKeys(array $keys, ?string $sql=null): ResultData|ResultError {
        return $this->orm->getByKeys($keys, $sql);
    }

    public function insert(string $type, string $email, ?string $user=null): ResultData|ResultError {

        $this->generateID();
        $this->generateCode($email);
        $dateCreate = new Date();
        $dateExpire = new Date();
        $dateExpire->addMinutes($type === CodeService::REGISTER ? CodeService::EXPIRE_REG : CodeService::EXPIRE);

        return $this->orm->insert([
            'id'    => $this->codeID,
            'type'  => $type,
            'user'  => $user, 
            'email' => $email, 
            'code'  => Encrypt::generateHash($this->code), 
            'date_create' => $dateCreate->formatCompleteMySQL(),
            'date_expire' => $dateExpire->formatCompleteMySQL(),
        ]);
    }
}