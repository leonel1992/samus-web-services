<?php
require_once __DIR__ ."/../helpers/html.php";
require_once __DIR__ . "/../core/dmController.php";

class SettingsController extends DMController {
    
    public function __construct() {
        parent::__construct('settings');
    } 

    private function page(string $view, string $module=null): void {
        parent::loadView($view, $module);
    }

    //-------------------------------------

    public function countries(): void {
        $this->page('countries');
    }

    public function currencies(): void {
        $this->page('currencies');
    }

    public function processors(): void {
        $this->page('processors');
    }

    public function paymentMethods(): void {
        $this->page('paymentMethods', 'settings-payment-methods');
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