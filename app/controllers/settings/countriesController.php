<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/countriesModel.php';
require_once __DIR__ . '/../../models/db/currenciesModel.php';
require_once __DIR__ . '/../../models/db/timezonesModel.php';

class CountriesController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new CountriesModel($conn);
        parent::__construct($conn, $model, 'settings-countries');
    }

    public function dataCurrencies(): void {
        $this->dataList(new CurrenciesModel($this->conn));
    }

    public function dataTimezones(): void {
        $this->dataList(new TimezonesModel($this->conn));
    }
} 