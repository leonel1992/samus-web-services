<?php
class JSON {

    public static function open($url) {
        try {
            if (file_exists($url)) {
                $json = file_get_contents($url);
                $jsonConv = mb_convert_encoding($json, 'UTF-8');
                $jsonData = json_decode($jsonConv, true);
                return $jsonData;
            } return null;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function print(array $json, $jsonForce = false) {
        $encodeFlags =  $jsonForce ? JSON_FORCE_OBJECT : 0;
        $jsonEncode = json_encode($json, $encodeFlags);
        if ($jsonEncode !== false) {
            echo $jsonEncode;
        } else {
            $result = new ResultError(json_last_error_msg());
            $result->print();
        }
    }

    public static function save(string $url, array $json): bool {
        try {
            $jsonData = json_encode($json);
            return file_put_contents($url, $jsonData);
        } catch (Exception $e) {
            return false;
        }
    }
}