<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/currenciesModel.php';
require_once __DIR__ . '/../../models/db/currenciesTypesModel.php';

class CurrenciesController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new CurrenciesModel($conn);
        parent::__construct($conn, $model, 'settings-currencies');
    }

    public function dataTypes(): void {
        $this->dataList(new CurrenciesTypesModel($this->conn));
    }
} 