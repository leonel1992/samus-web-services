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
        $this->dataTable($this->getModel()->getAllGroupedByModules());
    }

    public function tableModules(): void {
        $this->dataTable($this->getModel()->getAllModules());
    }

    public function dataModules(): void {
        $this->dataList($this->getModel()->getAllModules('id'));
    }

    public function dataRoutes(): void {
        $this->dataList($GLOBALS['routes']);
    }
    
}