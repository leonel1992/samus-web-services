<?php
require_once __DIR__ ."/../helpers/html.php";
require_once __DIR__ . "/../core/dmController.php";

class SettingsController extends DMController {
    
    public function __construct() {
        parent::__construct('settings');
    } 

    //-------------------------------------

    public function actions() {
        parent::loadView('actions');
    }

    public function modules() {
        parent::loadView('modules');
    }

    public function permissions() {
        parent::loadView('permissions');
    }

    public function roles() {
        parent::loadView('roles');
    }
}