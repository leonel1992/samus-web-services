<?php
// require_once __DIR__ . "/../../helpers/validate.php";
// require_once __DIR__ . "/../../models/db/usersModel.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/sessionLang.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";

class DataController extends Controller  {

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
        Permissions::data();
    } 

    //--------------------------------------------------------------------

    private function sendCode(string $type, string $email, $id=null): ResultData|ResultError {
        $code = new CodeService($this->conn, $type, $email, $id);
        if (!$code->getError()) {
            return $this->resultCode(
                $code->getCodeID() ?? $code->getCodeCookie(),
                $code->getCodeCookie() != null
            );
        } return $code->getError() ?? new ResultError($GLOBALS['lang-controllers']['general']['error-unknown']);
    }

    private function resultCode(string $codeID, bool $isCodeCooke=false): ResultData {
        return new ResultData($GLOBALS['lang-controllers']['session'][$isCodeCooke ? 'error-code-time' : 'success-code-send'], $codeID, 'codeID');
    }
    
    //--------------------------------------------------------------------

    private function verifiedConn(): ResultError|ResultSuccess {
        if($this->conn){
            return new ResultSuccess();
        } return new ResultErrorConn();
    }

    private function verifiedEmail(): ResultError|ResultSuccess {
        $email = VarsData::string('email');
        if ($email && validateEmail($email)) {
            return new ResultSuccess();
        } return new ResultError($GLOBALS['lang-controllers']['session']['error-email-invalid']);
    }

    private function verifiedCode(): ResultError|ResultData {
        $codeID = VarsData::string('code_id');
        $code = VarsData::string('code');
        if ($code && $codeID) {
            $validate = CodeService::validate($this->conn, $codeID, $code);
            return $validate;
        } return new ResultError($GLOBALS['lang-controllers']['session']['error-code-missing']);
    }

    //--------------------------------------------------------------------

    public function logout(): void {
        $login = new LoginService();
        if (!$login->getError()) {
            $result = new ResultSuccess($GLOBALS['lang-controllers']['session']['success-logout']);
        } else {
            $result = $login->getError();
        } $this->renderJson($result);
    }

    public function login(): void {
        $login = new LoginService();
        if ($login->isSuccess()) {
            $data = $login->getData();
            unset($data['password']);
            $result = new ResultData($GLOBALS['lang-controllers']['session']['success-login'], $data);
        } elseif ($login->getCodeID() || $login->getCodeCookie()) {
            $isCookie = $login->getCodeCookie() != null;
            $codeID = $login->getCodeID() ?? $login->getCodeCookie();
            $result = $this->resultCode($codeID, $isCookie);
        } else {
            $result = $login->getError() ?? new ResultError($GLOBALS['lang-controllers']['general']['error-unknown']);
        } $this->renderJson($result);
    }

    public function register(): void {
        $email = VarsData::string('email');
        if ($email) {
            $result = $this->verifiedEmail(); 
            if ($result->success) {
                $terms = VarsData::boolean('terms');
                if($terms){
                    $model = new UsersModel($this->conn);
                    $data = $model->getByKey('email', $email);
                    if (!$data->success) {
                        $result = $this->sendCode(CodeService::REGISTER, $email);
                    } else {
                        $result = new ResultError($GLOBALS['lang-controllers']['session']['error-register-user']);
                    }
                } else {
                    $result = new ResultError($GLOBALS['lang-controllers']['session']['error-register-terms']);
                }
            } 
        } else {
            $result = $this->verifiedConn();
            if ($result->success) {
                $result = $this->verifiedCode();
                if ($result->success) {
                    $model = new UsersModel($this->conn);
                    $data = VarsData::general('data');
                    $data = $model->parseDataRegister($data, $result->data['email']);
                    if ($model->validateRegister($data)) {
                        $result = $model->register($data); 
                    } else {
                        $result = $model->error ?? new ResultError($GLOBALS['lang-controllers']['db'][$model->table]['register-error']);
                    }
                }
            }
        }

        $this->renderJson($result);
    }

    public function recover(): void {
        $email = VarsData::string('email');
        if ($email) {
            $result = $this->verifiedEmail();
            if ($result->success) {
                $model = new UsersModel($this->conn);
                $data = $model->getByKey('email', $email);
                $result = $data->success
                ? $this->sendCode(CodeService::RECOVER, $data->data['email'], $data->data['id'])
                : new ResultError($GLOBALS['lang-controllers']['session']['error-recover-email']);
            } 
        } else {
            $result = $this->verifiedConn();
            if ($result->success) {
                $result = $this->verifiedCode();
                if ($result->success) {
                    $model = new UsersModel($this->conn);
                    $data = VarsData::general('data');
                    $data = $model->parseDataPassword($data);
                    if ($model->validatePassword($data)) {
                        $result = $model->updatePassword($data, (int) $result->data['user']);
                    } else {
                        $result = $model->error ?? new ResultError($GLOBALS['lang-controllers']['db'][$model->table]['update-pass-error']);
                    }
                }
            }
        }

        $this->renderJson($result);
    }

    public function refresh() {
        $login = new LoginService(null, true);
        if ($login->isSuccess()) {
            $showDialog = $login->getExpire() - time() <= 30;
            $result = new ResultData('',  $showDialog, 'showDialog');
        } else {
            $message = $GLOBALS['lang-controllers']['session']['session-error-message'];
            $redirect = $GLOBALS['url-lang'] . $GLOBALS['routes']['session-login'][$GLOBALS['lang']];
            $result = new ResultData($message,  $redirect, 'redirect', false);
        } $this->renderJson($result);
    }

    public function ping() {
        new LoginService();
    }
}