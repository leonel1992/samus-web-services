<?php
require_once __DIR__ . "/../../services/codeService.php";
require_once __DIR__ . '/../../models/db/usersModel.php';
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/sessionLang.php";

class CodeController extends Controller  {

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
        Permissions::data();
    }

    public function validate() {
        if($this->conn){
            $codeID = VarsData::string('code_id');
            $code = VarsData::string('code');
            if ($code && $codeID) {
                $validate = CodeService::validate($this->conn, $codeID, $code);
                if ($validate->success) {
                    switch ($validate->data['type']) {
                        case CodeService::RECOVER:
                        case CodeService::REGISTER:
                            $this->renderJson(new ResultSuccess($GLOBALS['lang-controllers']['session']['success-code']));
                            break;

                        case CodeService::LOGIN:
                            $login = new LoginService($validate->data['email']);
                            if ($login->isSuccess()) {
                                $userData = $login->getData();
                                unset($userData['password']);
                                $message = $GLOBALS['lang-controllers']['session']['success-login'];
                                $this->renderJson(new ResultData($message, $userData));
                            } else {
                                $this->renderJson($login->getError());
                            } break;
                        
                        default:
                            $this->renderJson(new ResultError($GLOBALS['lang-controllers']['session']['error-conection']));
                            break;
                    }
                } $this->renderJson($validate);
            } $this->renderJson(new ResultError($GLOBALS['lang-controllers']['session']['error-code-missing']));
        } $this->renderJson(new ResultError($GLOBALS['lang-controllers']['session']['error-conection']));
    }
}