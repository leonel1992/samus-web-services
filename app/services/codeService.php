<?php
require_once __DIR__ . "/../helpers/encrypt.php";
require_once __DIR__ . "/../models/db/codesModel.php";
require_once __DIR__ . "/../models/db/usersModel.php";
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/sessionLang.php";
class CodeService {

    public const EXPIRE = 5;      // minutes
    public const EXPIRE_REG = 30; // minutes
    public const EXPIRE_COOK = 1; // minutes

    public const REGISTER = 'register';
    public const RECOVER = 'recover';
    public const LOGIN = 'login';

    protected ?PDO $conn = null;
    protected ?ResultError $error = null;

    protected ?string $codeCookie = null;
    protected ?string $codeID = null;
    protected ?string $code = null;

    protected ?string $type = null;
    protected ?string $email = null;
    protected ?string $user = null;
    protected ?string $name = null;
    
    public function __construct(?PDO $conn, ?string $type, ?string $email, ?string $user=null) {
        $this->conn = $conn;
        $this->type = $type;
        $this->email = $email;
        $this->user = $user;
        $this->newCode();
    }
    
    // DB ---------------------------------------------------------- 

    private function newCode() {
        if($this->conn){
            $idCookie = 'CODE_ID_'. strtoupper($this->type) .'_'. preg_replace('/[^A-Za-z0-9@]/', '_', mb_strtoupper($this->email));
            if (!isset($_COOKIE[$idCookie]) || !$_COOKIE[$idCookie]) {
                $codesModel = new CodesModel($this->conn);
                $data = $codesModel->insert($this->type, $this->email, $this->user);
                if ($data->success) {
                    $this->code = $codesModel->getCode();
                    $this->codeID = $codesModel->getCodeID();
                    $this->codeCookie = null;
                    
                    $usersModel = new UsersModel($this->conn); 
                    $user = $usersModel->getByKey('email', $this->email);
                    if ($user->success) {
                        $this->name = $user->data['name'];
                    } 

                    if ($this->sendMail()) {
                        setcookie($idCookie, $this->codeID, time() + 60 * CodeService::EXPIRE_COOK, "/");
                    }
                } else {
                    $this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-code-generate']);
                }
            } else {
               $this->codeID = null;
               $this->codeCookie = $_COOKIE[$idCookie];
            }
        } else {
            $this->error = new ResultErrorConn();
        }
    }

    public static function validate(?PDO $conn, $id, $code) {
        $model = new CodesModel($conn);
        $dataCode = $model->getByKey('id', $id);
        if($dataCode->success){

            $today = new Date();
            $expire = null;
            if ($dataCode->data['date_expire']) {
                $expire = new Date($dataCode->data['date_expire']);
            }

            if ($expire && $expire > $today) {
                if (Encrypt::validateHash($code, $dataCode->data['code'])) {
                    return new ResultData( '', [
                        'type' => $dataCode->data['type'],
                        'user' => $dataCode->data['user'],
                        'email' => $dataCode->data['email']
                    ]);
                } 
                
                return new ResultError($GLOBALS['lang-controllers']['session']['error-code-invalid']);
            } return new ResultError($GLOBALS['lang-controllers']['session']['error-code-expire']);
        } return new ResultError($GLOBALS['lang-controllers']['session']['error-code-invalid']);
    }

    // METHODS ---------------------------------------------------------- 

    private function sendMail(): bool {
        $send = false;
        if ($this->type === CodeService::RECOVER) {
            $send = EmailService::sendRecoverCode($this->email, $this->name, $this->code);
        } elseif ($this->type === CodeService::REGISTER) {
            $send = EmailService::sendRegisterCode($this->email, $this->code);
        } else {
            $send = EmailService::sendLoginCode($this->email, $this->name, $this->code);
        }

        if(!$send) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-code-send']);
            $this->codeID = null;
            return false;
        } return true;
    }

    //DATA ---------------------------------------------------------- 

    public function getError(): ResultError|null {
        return $this->error;
    }

    public function getCodeCookie(): string|null {
        return $this->codeCookie;
    }

    public function getCodeID(): string|null {
        return $this->codeID;
    }
    
}