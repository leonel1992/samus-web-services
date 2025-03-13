<?php
require_once __DIR__ . '/../../models/system/filesModel.php';

class FilesController extends Controller {
    
    private ?string $type;
    private ?string $file;
    private FilesModel $model;

    public function __construct() {
        global $_INPUT;
        $this->file = $_FILES['file'] ?? null;
        $this->type = VarsData::general('type');
        $this->model = new FilesModel($this->type, $this->file);
    }

    public function upload() {
        $result = $this->model->upload();
        $this->renderJson($result);
    }
}