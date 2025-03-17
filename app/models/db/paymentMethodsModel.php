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
            $data['icon'] = trimstrval($data['icon'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['status'] = strboolval($data['status'] ?? false);
            $data['need_country'] = strboolval($data['need_country'] ?? false);
            $data['description'] = trimstrval($data['description'] ?? null, true);

            if ($data['icon']) {
                $path = __DIR__ . "/../../../assets/img/payment-methods/";
                if (!file_exists($path . $data['icon'])) {
                    $this->error = null;
                    $model = new FilesModel();
                    $copy = $model->copy($data['icon'], $path);
                    if (!$copy->success) {
                        $this->error = $copy;
                        $data['icon'] = null;
                    }
                }
            }
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