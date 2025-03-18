<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/actionsModel.php';
require_once __DIR__ . '/../../models/db/modulesModel.php';
require_once __DIR__ . '/../../models/db/permissionsModel.php';

class PermissionsController extends DBController { 

    public function __construct(?PDO $conn) {
        $model = new PermissionsModel($conn);
        parent::__construct($conn, $model, 'settings-permissions');
    } 

    protected function getModel(): PermissionsModel {
        return $this->model;
    }

    public function tableGroupedModules(): void {
        $this->dataTable($this->getModel()->getAllGroupedByModules());
    }

    public function dataActions(): void {
        $this->dataList(new ActionsModel($this->conn));
    }

    public function dataModules(): void {
        $this->dataList(new ModulesModel($this->conn));
    }

    public function dataGroupedModules(): void {
        $model = new ModulesModel($this->conn);
        $this->dataList($model->getAllGroupedByModules(true, 'id'));
    }
}