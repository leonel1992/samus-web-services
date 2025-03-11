<?php
// require_once __DIR__ . '/../../models/server/filesModel.php';

// class FilesController extends Controller {
    
//     private $type;
//     private $file;
//     private $model;

//     public function __construct() {
//         global $_INPUT;
//         $this->file ??= $GLOBALS['files']['file'];
//         $this->type ??= $_POST['type'] ?? $_INPUT['type'];
//         $this->model = new FilesModel($this->type, $this->file);
//     }

//     public function upload() {
//         $this->json($this->model->upload());
//     }
// }