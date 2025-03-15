<?php
require_once __DIR__ ."/../helpers/html.php";
require_once __DIR__ . "/../core/dmController.php";

class SettingsController extends DMController {
    
    public function __construct() {
        parent::__construct('settings');
    } 

    private function page(string $view): void {
        parent::loadView($view);
    }

    //-------------------------------------

    public function actions(): void {
        $this->page('actions');
    }

    public function modules(): void {
        $this->page('modules');
    }

    public function permissions(): void {
        $this->page('permissions');
    }

    public function roles(): void {
        $this->page('roles');
    }
}