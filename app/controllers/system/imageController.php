<?php
// require_once __DIR__ . '/../../models/server/imageModel.php';

// class ImageController {
    
//     protected $conn;
//     private $model;
//     private $image; 
//     private $ext;

//     public function __construct(?PDO $conn) {
//         $url = mb_strtolower(URL);
//         $expl = explode('?', $url);
//         $explURL = explode('/', $expl[0]);
//         $explATTR = explode('.', $explURL[3]);
   
//         $this->model = new ImageModel();
//         $this->image = $explATTR[0];
//         $this->ext = isset($explATTR[1]) ? $explATTR[1] : null;
//         $this->conn = $conn;
//     }

//     //images ---------------------------------------------
    
//     public function data() {
//         require_once __DIR__ . '/../../models/db/dataImagesModel.php';
//         $dataModel = new DataImagesModel($this->conn);
//         $dataImage = $dataModel->getByKey('id', $this->image);

//         $type = null;
//         $image = null;
//         if ($dataImage['success']) {
//             $type = $dataImage['data']['type'];
//             $image = $this->model->blob($dataImage['data']['image']);
//         } $this->print($image, $type);
//     }

//     // print ------------------------------------------------------
    
//     private function print($image, $type) {
//         if ($image && $type) {
//             header("Content-type: " . $type);
//             echo $image;
//         } else {
//             $this->printError('image/jpeg');
//         }
//     }

//     private function printUploaded($folder, $id=null) {
//         $image = $this->model->uploaded($folder, "{$this->image}.{$this->ext}");
//         if ($image) {
//             header("Content-type: " . image_type_to_mime_type($image['type']));
//             echo $image['content'];
//         } else {
//             $this->printError('image/jpeg');
//         }
//     } 

//     private function printError($type) {
//         header("Content-type: $type");
//     }
// }