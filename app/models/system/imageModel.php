<?php
require_once __DIR__ . '/filesModel.php';

class ImageModel {

    public function __construct() {}

    // blob images
    public function getBlob(string $blob): bool|string {
        return base64_decode($blob);
    }

    // Uploaded images
    public function getUploaded(string $folder, string $name): array|null {
        $model = new FilesModel();
        $file = __DIR__ . "/../../../assets/img/$folder/$name";
        $image = $model->read($file);
        if ($image->success) {
            return $image->data;
        } return null;
    }
}