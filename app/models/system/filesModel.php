<?php
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/systemLang.php";

class FilesModel {

    private ?string $type;
    private ?string $file;
    private string $tmpPath = __DIR__ . '/../../../assets/tmp/';

    public function __construct(?string $type=null, ?string $file=null) {
        $this->type = $type;
        $this->file = $file;
    }

    private function generateName(): string {
        $ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        return uniqid() .".$ext";
    }

    private function validateFile(): bool {
        $extensions = JSON::open(__DIR__ ."/../../../data/system/extensions.json");
        
        //image size
        $validSize = false;
        if ($this->type == 'image') {
            $validSize = getimagesize($this->file['tmp_name']);
        } if ($validSize === false) {
            return false;
        }

        //mime type
        $count = 0;
        $validType = false;
        while ( !$validType && $count < count($extensions[$this->type]) ) {
            if (stripos($this->file['type'], $extensions[$this->type][$count]) !== false) {
                $validType = true;
            } $count++;
        } if (!$validType) {
            return false;
        }

        //dark list
        $count = 0;
        $validDark = false;
        while ( !$validDark && $count < count($extensions["dark-list"]) ) {
            if (stripos($this->file['name'], ".". $extensions["dark-list"][$count]) !== false) {
                $validDark = true;
            } $count++;
        } if ($validDark) {
            return false;
        }

        return true;
    }

    // ------------------------------------------------------------------

    public function copy(string $name, string $pathTo, ?string $pathFr=null): ResultError|ResultSuccess {
        $pathFr ??= $this->tmpPath;
        $fileFr = "{$pathFr}{$name}";
        $fileTo = "{$pathTo}{$name}";
        if (file_exists($fileFr) && file_exists($pathTo)) {
            if (copy($fileFr, $fileTo)) {
                return new ResultSuccess($GLOBALS['lang-controllers']['system']["success-file-copy"]);
            }  return new ResultError($GLOBALS['lang-controllers']['system']["error-file-copy"]);
        } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-empty']);
    }

    public function delete(string $file): ResultError|ResultSuccess {
        if (file_exists($file)) {
            if (unlink($file)) { 
                return new ResultSuccess($GLOBALS['lang-controllers']['system']['success-file-delete']);
            } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-delete']);
        } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-empty']);
    }

    public function read(string $file): ResultData|ResultError {
        if (file_exists($file)) {
            $type = exif_imagetype($file);
            $size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $size);
            fclose($handle);
            if ($content) {
                return new ResultData($GLOBALS['lang-controllers']['system']['success-file-read'], [
                    'content' => $content,
                    'type' => $type,
                    'size' => $size,
                ], 'file');
            } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-read']);
        } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-empty']);
    } 

    public function upload() { 
        if ($this->file && $this->type) {
            if ($this->validateFile()) {
                $name = $this->generateName();
                $path = "{$this->tmpPath}{$name}";
                if (move_uploaded_file($this->file['tmp_name'], $path)) {
                    return new ResultData($GLOBALS['lang-controllers']['system']["success-file-{$this->type}"], $name, 'file');
                } return new ResultError($GLOBALS['lang-controllers']['system']["error-file-{$this->type}"]);
            } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-invalid']);
        } return new ResultError($GLOBALS['lang-controllers']['system']['error-file-missing']);
    }

}