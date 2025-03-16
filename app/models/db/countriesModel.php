<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";
// require_once __DIR__ . '/../server/filesModel.php';
// require_once __DIR__ . '/../../helpers/values.php';

class CountriesModel extends DBModelAbstract {

    public string $table = 'countries';
    public string $query = "SELECT * FROM `countries` ORDER BY `name` ASC";
 
    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function getParseItem(?array $item): array|null {
        if ($item) {
            $item['prefix'] = "+{$item['prefix']}";
            $item['status_reg'] = strboolval($item['status_reg']);
            $item['status_calc'] = strboolval($item['status_calc']);
            $item['icon_url'] = $GLOBALS['url-path'] ."/image/countries/{$item['icon']}";
        } return $item;
    }

    public function setParseData(?array $data): array|null { return $data;
        // if($data){
        //     $data['id'] = idxval($data['iso_3']);
        //     $data['icon'] = strval($data['icon']);
        //     $data['prefix'] = intval($data['prefix']);
        //     $data['name'] = trimstrval($data['name']);
        //     $data['emoji'] = strval($data['emoji']);
        //     $data['iso_2'] = trimstrval($data['iso_2']);
        //     $data['iso_3'] = trimstrval($data['iso_3']);
        //     $data['currency'] = idxval($data['currency']);
        //     $data['timezone'] = trimstrval($data['timezone']);
        //     $data['status_reg'] = idxval($data['status_reg']);
        //     $data['status_calc'] = idxval($data['status_calc']);

        //     if ($data['icon']) {
        //         $path = __DIR__ . "/../../../assets/img/countries/";
        //         if (!file_exists($path . $data['icon'])) {
        //             $model = new FilesModel();
        //             $copy = $model->copy($path, $data['icon']);
        //             if (!$copy['success']) {
        //                 $data['icon'] = null;
        //             }
        //         }
        //     }
        // }
        // return $data;    
    }

    public function validate(?array $data): bool {
        // if (!$data['icon']) return false;
        // if (!is_numeric($data['prefix']) || $data['prefix'] < 1) return false;
        // if (!$data['name']) return false;
        // if (!$data['emoji']) return false;
        // if (!$data['iso_2']) return false;
        // if (!$data['iso_3']) return false;
        // if (!$data['currency']) return false;
        // if (!$data['timezone']) return false;
        // if (!$data['status_reg']) return false;
        // if (!$data['status_calc']) return false;
        return true;
    }

    //-------------------------------------------------

    public function getAllForRegister(?string $index=null, bool $sublist=false, ?string $msg=null): ResultError|ResultData {
        $sql = "SELECT * FROM {$this->table} WHERE `status_reg` = TRUE ORDER BY `name` ASC";
        return $this->getParseData($this->getAll($sql, $index, $sublist, $msg));
    }
}