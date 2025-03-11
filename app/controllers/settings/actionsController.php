<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/actionsModel.php';

class ActionsController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new ActionsModel($conn);
        parent::__construct($conn, $model, 'settings-actions');
    }
} 