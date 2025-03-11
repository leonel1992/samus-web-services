<?php
class EmailController{

    private $code = "CODIGO";
    private $name = "Nombre Ejemplo";
    private $email = "correo.ejemplo@ejemplo.com";

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
    }

    // GENERAL -----------------------------------------------

    private function print(string $template) {
        header("Content-Type: text/html; charset=UTF-8");
        echo $template;
    }

    // PAGES -----------------------------------------------

    public function login() {
        $this->print(EmailService::loginTemplate($this->email, $this->name));
    }

    public function loginCode() {
        $this->print(EmailService::loginCodeTemplate($this->email, $this->name, $this->code));
    }

    public function register() {
        $this->print(EmailService::registerTemplate($this->email, $this->name));
    }

    public function registerCode() {
        $this->print(EmailService::registerCodeTemplate($this->email, $this->code));
    }

    public function recoverCode() {
        $this->print(EmailService::recoverCodeTemplate($this->email, $this->name, $this->code));
    }
}