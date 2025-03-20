<?php
require_once __DIR__ ."/../helpers/html.php";
require_once __DIR__ . "/../core/dmController.php";

class ManageController extends DMController {
    
    public function __construct() {
        parent::__construct('manage');
    } 

    private function page(string $view, string $module=null): void {
        parent::loadView($view, $module);
    }

    //-------------------------------------

    public function gallery(): void {
        $this->page('gallery');
    }
}