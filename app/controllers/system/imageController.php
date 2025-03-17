<?php
require_once __DIR__ . '/../../models/system/imageModel.php';

class ImageController {
    
    protected ?PDO $conn;
    private ImageModel $model;
    private ?string $image; 
    private ?string $ext;

    public function __construct(?PDO $conn) {
        $url = mb_strtolower($GLOBALS['url']);
        $expl = explode('?', $url);
        $explUrl = explode('/', $expl[0]);
        $explData = explode('.', $explUrl[3]);

        $this->model = new ImageModel();
        $this->image = $explData[0] ?? null;
        $this->ext = $explData[1] ?? null;
        $this->conn = $conn;
    }

    //uploaded images ---------------------------------------------
    
    public function countries(): void {
        $this->printUploaded('countries');
    }

    public function processors() {
        $this->printUploaded('processors');
    }

    public function paymentMethods() {
        $this->printUploaded('payment-methods');
    }

    // print ------------------------------------------------------
    
    private function print(?string $image, ?string $type): void {
        if (!$image || !$type) {
            $this->printError();
        } 
         
        header("Content-type: $type");
        echo $image;
        exit;
    }

    private function printUploaded(string $folder): void {
        $image = $this->model->getUploaded($folder, "{$this->image}.{$this->ext}");
        if (!$image || !is_array($image)) {
            $this->printError();
        }
        
        header("Content-type: ". image_type_to_mime_type($image['type']));
        echo $image['content'];
        exit;
    } 

    private function printError(string $type='image/jpeg'): void {
        header("HTTP/1.1 404 Not Found");
        header("Content-type: $type");
        exit;
    }
}