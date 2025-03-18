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
        $this->dataList(new ActionsModel($this->conn));
    }

    public function dataModules(): void {
        $this->dataList(new ModulesModel($this->conn));
    }

    public function dataGroupedPermissions(): void {
        $model = new PermissionsModel($this->conn);
        $this->dataList($model->getAllGroupedByModules('id', 'id'));
    }
}