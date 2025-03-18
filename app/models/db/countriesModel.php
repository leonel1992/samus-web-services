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
        if($data){
            $data['id'] = idxval($data['iso_3'] ?? '');
            $data['icon'] = $this->processFile('countries', $data['icon']);
            $data['prefix'] = intval($data['prefix'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['emoji'] = strval($data['emoji'] ?? '');
            $data['iso_2'] = strtoupper(trimstrval($data['iso_2'] ?? ''));
            $data['iso_3'] = strtoupper(trimstrval($data['iso_3'] ?? ''));
            $data['currency'] = idxval($data['currency'] ?? '');
            $data['timezone'] = trimstrval($data['timezone'] ?? '');
            $data['status_reg'] = boolval($data['status_reg'] ?? false);
            $data['status_calc'] = boolval($data['status_calc'] ?? false);
        }
        return $data;    
    }

    public function validate(?array $data): bool {
        return $this->runValidation($data, [
            'icon' => !empty($data['icon']),
            'name' => !empty($data['name']),
            'emoji' => !empty($data['emoji']),
            'iso_2' => !empty($data['iso_2']) && strlen($data['iso_2']) == 2,
            'iso_3' => !empty($data['iso_3']) && strlen($data['iso_3']) == 3,
            'currency' => !empty($data['currency']) && strlen($data['currency']) == 3,
            'timezone' => !empty($data['timezone']),
            'prefix' => !empty($data['prefix']) && is_numeric($data['prefix']) && $data['prefix'] > 0,
        ]);
    }

    //-------------------------------------------------

    public function getAllForRegister(?string $index=null, bool $sublist=false, ?string $msg=null): ResultError|ResultData {
        $sql = "SELECT * FROM {$this->table} WHERE `status_reg` = TRUE ORDER BY `name` ASC";
        return $this->getParseData($this->getAll($sql, $index, $sublist, $msg));
    }
}