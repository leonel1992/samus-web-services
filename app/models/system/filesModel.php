<?php
// require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/systemLang.php";

// class FilesModel {

//     private $type;
//     private $file;
//     private $tmpPath = __DIR__ . '/../../../assets/tmp/';

//     public function __construct($type=null, $file=null) {
//         $this->type = $type;
//         $this->file = $file;
//     }

//     private function generateName() {
//         $ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);
//         return uniqid() .'.'. $ext;
//     }

//     private function validateFile() {
//         $extensions = JSON::open(__DIR__ ."/../../json/extensions.json");
        
//         //image size
//         $validSize = false;
//         if ($this->type == 'image') {
//             $validSize = getimagesize($this->file['tmp_name']);
//         } if ($validSize === false) {
//             return false;
//         }

//         //mime type
//         $count = 0;
//         $validType = false;
//         while ( !$validType && $count < count($extensions[$this->type]) ) {
//             if (stripos($this->file['type'], $extensions[$this->type][$count]) !== false) {
//                 $validType = true;
//             } $count++;
//         } if (!$validType) {
//             return false;
//         }

//         //dark list
//         $count = 0;
//         $validDark = false;
//         while ( !$validDark && $count < count($extensions["dark-list"]) ) {
//             if (stripos($this->file['name'], ".". $extensions["dark-list"][$count]) !== false) {
//                 $validDark = true;
//             } $count++;
//         } if ($validDark) {
//             return false;
//         }

//         return true;
//     }

//     // ------------------------------------------------------------------

//     public function copy($path, $name) {
//         $pathTo = $path . $name;
//         $pathFr = $this->tmpPath . $name;
//         if (file_exists($pathFr) && file_exists($path)) {
//             if (copy($pathFr, $pathTo)) {
//                 return Result::success($GLOBALS['lang-controllers']['system']["success-file-copy"]);
//             } else {
//                 return Result::error($GLOBALS['lang-controllers']['system']["error-file-copy"]);
//             }
//         } else {
//             return Result::error($GLOBALS['lang-controllers']['system']['error-file-empty']);
//         }
//     }

//     public function delete($file) {
//         if (file_exists($file)) {
//             if (unlink($file)) { 
//                 return Result::success($GLOBALS['lang-controllers']['system']['success-file-delete']);
//             } else {
//                 return Result::error($GLOBALS['lang-controllers']['system']['error-file-delete']);
//             };
//         } else {
//             return Result::error($GLOBALS['lang-controllers']['system']['error-file-empty']);
//         }
//     }

//     public function read($file) {
//         if (file_exists($file)) {
//             $type = exif_imagetype($file);
//             $size = filesize($file);
//             $handle = fopen($file, "r");
//             $content = fread($handle, $size);
//             fclose($handle);
//             if ($content) {
//                 return Result::index(
//                     'file', [
//                         'type' => $type,
//                         'size' => $size,
//                         'content' => $content,
//                     ], 
//                     $GLOBALS['lang-controllers']['system']['success-file-read']
//                 );
//             } else {
//                 return Result::error($GLOBALS['lang-controllers']['system']['error-file-read']);
//             }
//         } else {
//             return Result::error($GLOBALS['lang-controllers']['system']['error-file-empty']);
//         }
//     } 

//     public function upload() { 
//         if ($this->file && $this->type) {
//             if ($this->validateFile()) {
//                 $name = $this->generateName();
//                 $path = $this->tmpPath . $name;
//                 if (move_uploaded_file($this->file['tmp_name'], $path)) {
//                     return Result::index(
//                         'file', $name, 
//                         $GLOBALS['lang-controllers']['system']["success-file-{$this->type}"]
//                     );
//                 } else {
//                     return Result::error($GLOBALS['lang-controllers']['system']["error-file-{$this->type}"]);
//                 }
//             } else {
//                 return Result::error($GLOBALS['lang-controllers']['system']['error-file-invalid']);
//             }
//         } else {
//             return Result::error($GLOBALS['lang-controllers']['system']['error-file-missing']);
//         }
//     }

// }