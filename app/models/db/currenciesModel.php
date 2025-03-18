<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class CurrenciesModel extends DBModelAbstract {
    
    public string $table = 'currencies';
    public string $query = "SELECT 
        C.`id` as `id`,
        C.`type` as `type`,
        C.`code` as `code`,
        C.`symbol` as `symbol`,
        C.`digits` as `digits`,
        C.`name` as `name`
    FROM `currencies` C
    LEFT JOIN `currencies_types` T ON T.`id` = C.`type`
    ORDER BY 
        T.`name` DESC, 
        C.`code` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function getParseItem(array|null $item): array|null {
        if ($item) {
            $item['digits'] = intval($item['digits']);
        } return $item;
    }

    public function setParseData(?array $data): array|null {
        if($data){
            $data['id'] = idxval($data['code'] ?? '');
            $data['type'] = idxval($data['type'] ?? '');
            $data['code'] = trimstrval($data['code'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['digits'] = intval($data['digits'] ?? 2);
            $data['symbol'] = $data['symbol'] ? strval($data['symbol']) : null;
        } return $data;
    }

    public function validate(?array $data): bool {
        $this->error = null;
        if (!$data) {
            return $this->setError();
        } if (!isset($data['type']) || !$data['type']) {
            return $this->setError('invalid-type');
        } if (!isset($data['code']) || !$data['code']) {
            return $this->setError('invalid-code');
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } 

        if ($data['type']==='currency') {
            if (strlen($data['code']) !== 3) {
                return $this->setError('invalid-code');
            } if (!isset($data['symbol']) || !$data['symbol']) {
                return $this->setError('invalid-symbol');
            }
        }
        
        return true;
    }
}