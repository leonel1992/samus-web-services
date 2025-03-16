<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/currenciesModel.php';
require_once __DIR__ . '/../../models/db/currenciesTypeModel.php';

class CurrenciesController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new CurrenciesModel($conn);
        parent::__construct($conn, $model, 'settings-currencies');
    }

    public function dataTypes(): void {
        $list = [];
        if($this->isValid('access', $this->module)){
            $model = new CurrenciesTypeModel($this->conn);
            $result = $model->getAll($model->query, 'id');
            $list = $result->data ?? [];
        } $this->renderArray($list);
    }
} 