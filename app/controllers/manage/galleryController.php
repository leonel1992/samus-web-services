<?php
require_once __DIR__ . '/../../core/dbController.php';
require_once __DIR__ . '/../../models/db/galleryModel.php';

class GalleryController extends DBController {
    public function __construct(?PDO $conn) {
        $model = new GalleryModel($conn);
        parent::__construct($conn, $model, 'manage-gallery');
    }
} 