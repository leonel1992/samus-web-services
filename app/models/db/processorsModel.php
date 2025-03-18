<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class ProcessorsModel extends DBModelAbstract {
    
    public string $table = 'processors';
    public string $query = "SELECT 
        P.id as id,
        P.icon as icon,
        P.name as name,
        P.payment as payment,
        P.country as country,
        P.currency as currency,
        P.status_buy as status_buy,
        P.status_sell as status_sell,
        P.invert as invert
    FROM processors P
    LEFT JOIN countries CT ON CT.id = P.country
    LEFT JOIN currencies CR ON CR.id = P.currency
    LEFT JOIN payment_methods PM ON PM.id = P.payment
    ORDER BY CT.name, PM.name, CR.code, PM.name ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function getParseItem(array|null $item): array|null {
        if ($item) {
            $item['invert'] = strboolval($item['invert']);
            $item['status_buy'] = strboolval($item['status_buy']);
            $item['status_sell'] = strboolval($item['status_sell']);
            $item['icon_url'] = "{$GLOBALS['url-path']}/image/processors/{$item['icon']}";
        } return $item;
    }
    
    public function setParseData(?array $data): array|null {
        if($data){
            $data['icon'] = $this->processFile('processors', $data['icon']);
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['payment'] = idxval($data['payment'] ?? '');
            $data['country'] = idxval($data['country'] ?? null, true);
            $data['currency'] = idxval($data['currency'] ?? '');
            $data['status_buy'] = strboolval($data['status_buy'] ?? false);
            $data['status_sell'] = strboolval($data['status_sell'] ?? false);
            $data['invert'] = strboolval($data['invert'] ?? false);
            
            $payment = $data['payment'];
            $country = $data['country'] ? "-{$data['country']}-" : '-';
            $name = normalizetext($data['name'], true, '-');
            $data['id'] = "{$payment}{$country}{$name}";
        } return $data;
    }

    public function validate(?array $data): bool {
        if ($this->error) {
            return false;
        } if (!$data) {
            return $this->setError();
        } if (!isset($data['icon']) || !$data['icon']) {
            return $this->setError('invalid-icon');
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } if (!isset($data['payment']) || !$data['payment']) {
            return $this->setError('invalid-payment');
        } if (isset($data['country']) && strlen($data['country']) != 3) {
            return $this->setError('invalid-country');
        } if (!isset($data['currency']) || !$data['currency']) {
            return $this->setError('invalid-currency');
        } return true;
    }
}