<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/paymentMethodsModel.php';

class PaymentMethodsController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new PaymentMethodsModel($conn);
        parent::__construct($conn, $model, 'settings-payment-methods');
    }
}