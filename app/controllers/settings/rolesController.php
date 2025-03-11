<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/rolesModel.php';
require_once __DIR__ . '/../../models/db/actionsModel.php';
require_once __DIR__ . '/../../models/db/modulesModel.php';
require_once __DIR__ . '/../../models/db/permissionsModel.php';

class RolesController extends DBController {

    public function __construct(?PDO $conn) {
        $model = new RolesModel($conn);
        parent::__construct($conn, $model, 'settings-actions');
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

    public function dataGroupedPermissions(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $model = new PermissionsModel($this->conn);
            $result = $model->getAllGroupedByModules('id', 'id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }
}