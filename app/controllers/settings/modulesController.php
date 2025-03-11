<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/modulesModel.php';

class ModulesController extends DBController { 

    public function __construct(?PDO $conn) {
        $this->model = new ModulesModel($conn);
        parent::__construct($conn, $this->model, 'settings-modules');
    }

    protected function getModel(): ModulesModel {
        return $this->model;
    }

    public function tableGrouped(): void {
        if($this->isValid('access', $this->module)){
            $data = $this->getModel()->getAllGroupedByModules();
            $this->renderJson($data);
        } $this->renderJson403();
    }

    public function tableModules(): void {
        if($this->isValid('access', $this->module)){
            $data = $this->getModel()->getAllModules();
            $this->renderJson($data);
        } $this->renderJson403();
    }

    public function dataModules(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $result = $this->getModel()->getAllModules('id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }

    public function dataRoutes(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $list = $GLOBALS['routes'];
        } $this->renderArray($list);
    }
    
}