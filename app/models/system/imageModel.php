<?php
// class ImageModel {

//     public function __construct() {}

//     // blob images
//     public function blob($blob) {
//         return base64_decode($blob);
//     }

//     // Uploaded images
//     public function uploaded($folder, $name) {
//         require_once __DIR__ . '/../../models/server/filesModel.php';
//         $path = __DIR__ . "/../../../assets/img/$folder/$name";
//         $model = new FilesModel();
//         $image = $model->read($path);
//         if ($image['success']) {
//             return $image['file'];
//         } else {
//             return null;
//         }
//     }
// }