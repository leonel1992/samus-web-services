<?php

class AccountController extends ControllerPermissions {

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
    }

    // GENERAL -----------------------------------------------

    private function page(string $view) {
        $webInfo = new WebInfo('account', $view);
        $webInfo->module = "account";

        $webInfo->scripts = [
            $GLOBALS['files']['local']['script']['data'],
            $GLOBALS['files']['local']['script']['session'],
            $GLOBALS['files']['local']['script']['session-logout']
        ];

        $this->renderView('panel', 'account', $view, $webInfo);
    }

    // PAGES -----------------------------------------------

    public function home() {
        $this->page('home');
    }
}