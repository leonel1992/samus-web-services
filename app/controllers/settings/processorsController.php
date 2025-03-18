<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/countriesModel.php';
require_once __DIR__ . '/../../models/db/currenciesModel.php';
require_once __DIR__ . '/../../models/db/paymentMethodsModel.php';
require_once __DIR__ . '/../../models/db/processorsModel.php';

class ProcessorsController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new ProcessorsModel($conn);
        parent::__construct($conn, $model, 'settings-processors');
    }

    public function dataCountries(): void {
        $this->dataList(new CountriesModel($this->conn));
    }

    public function dataCurrencies(): void {
        $this->dataList(new CurrenciesModel($this->conn));
    }

    public function dataPaymentMethods(): void {
        $this->dataList(new PaymentMethodsModel($this->conn));
    }
} 