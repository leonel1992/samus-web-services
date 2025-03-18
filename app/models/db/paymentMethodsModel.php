<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class PaymentMethodsModel extends DBModelAbstract {
    
    public string $table = 'payment_methods';
    public string $query = "SELECT * FROM payment_methods ORDER BY name ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function getParseItem(?array $item): array|null {
        if ($item && is_array($item)) {
            $item['status'] = strboolval($item['status']);
            $item['need_country'] = strboolval($item['need_country']);
            $item['icon_url'] = "{$GLOBALS['url-path']}/image/payment-methods/{$item['icon']}";
        } return $item;
    }

    public function setParseData(?array $data): array|null {
        if($data){
            $data['id'] = idxval($data['id'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['status'] = strboolval($data['status'] ?? false);
            $data['need_country'] = strboolval($data['need_country'] ?? false);
            $data['description'] = trimstrval($data['description'] ?? null, true);
            $data['icon'] = $this->processFile('payment-methods', $data['icon']);
        } return $data;
    }

    public function validate(?array $data): bool {
        if ($this->error) {
            return false;
        } if (!$data) {
            return $this->setError();
        } if (!isset($data['id']) || !$data['id']) {
            return $this->setError('invalid-id');
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } if (!isset($data['icon']) || !$data['icon']) {
            return $this->setError('invalid-icon');
        } return true;
    }
}