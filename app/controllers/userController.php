<?php

class UserController extends ControllerPermissions {

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
    }

    // GENERAL -----------------------------------------------

    private function page(string $view) {
        $webInfo = new WebInfo('user', $view);
        $webInfo->module = "user-$view";

        $webInfo->scripts = [
            $GLOBALS['files']['local']['script']['data'],
            $GLOBALS['files']['local']['script']['session'],
            $GLOBALS['files']['local']['script']['session-logout']
        ];

        $this->renderView('panel', 'user', $view, $webInfo);
    }

    // PAGES -----------------------------------------------

    public function home() {
        $this->page('home');
    }
}