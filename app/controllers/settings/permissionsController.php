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
        if($this->isValid('access', $this->module)){
            $data = $this->getModel()->getAllGroupedByModules();
            $this->renderJson($data);
        } $this->renderJson403();
    }

    public function dataActions(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $model = new ActionsModel($this->conn);
            $result = $model->getAll($model->query, 'id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }

    public function dataModules(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $model = new ModulesModel($this->conn);
            $result = $model->getAll($model->query, 'id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }

    public function dataGroupedModules(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $model = new ModulesModel($this->conn);
            $result = $model->getAllGroupedByModules(true, 'id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }
}