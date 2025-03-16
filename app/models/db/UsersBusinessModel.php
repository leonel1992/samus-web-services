<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class UsersBusinessModel extends DBModelAbstract {

    public string $table = 'users_business';
	public string $query = "SELECT * FROM `users_business` ORDER BY `name` ASC";

	public function __construct(?PDO $conn) {
		parent::__construct($conn);
	}

    // DATA -------------------------------------------------------------

    public function getParseItem(?array $item): array|null {
        if ($item) {
            $item['id'] = bigintval($item['id']);
        } return $item;
    }

    public function setParseKey(mixed $key): mixed {
        return bigintval($key);
    }

    public function setParseData(?array $data): array|null { return $data;
        if($data){
            $newData['user'] = bigintval($data['user'] ?? '');
            $newData['date'] = dateval($data['date'] ?? '');
            $newData['name'] = trimstrval($data['name'] ?? '');
            $newData['country'] = idxval($data['country'] ?? '');
            $newData['state'] = trimstrval($data['state'] ?? '');
            $newData['city'] = trimstrval($data['city'] ?? '');
            $newData['address'] = trimstrval($data['address'] ?? '');
            $newData['type'] = idxval($data['type'] ?? '');
            $newData['register_type'] = idxval($data['register_type'] ?? '');
            $newData['register_number'] = trimstrval($data['register_number'] ?? '');
            $newData['phone'] = bigintval($data['phone'] ?? null, true);
            $newData['email'] = mb_strtolower(trimstrval($data['email'] ?? null, true));
            $newData['web'] = trimstrval($data['web'] ?? null, true);
        } return $data;
    }

    // VALIDATE -------------------------------------------------------------

    public function validate(?array $data): bool {
        $this->error = null;
        if (!$data) {
            return $this->setError();
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } if (!isset($data['country']) || !$data['country']) {
            return $this->setError('invalid-country');
        } if (!isset($data['state']) || !$data['state']) {
            return $this->setError('invalid-state');
        } if (!isset($data['city']) || !$data['city']) {
            return $this->setError('invalid-city');
        } if (!isset($data['address']) || !$data['address']) {
            return $this->setError('invalid-address');
        } if (!isset($data['type']) || !$data['type']) {
            return $this->setError('invalid-type');
        } if (!isset($data['date']) || !$data['date']) {
            return $this->setError('invalid-date');
        } if (!isset($data['register_type']) || !$data['register_type']) {
            return $this->setError('invalid-register-type');
        } if (!isset($data['register_number']) || !$data['register_number']) {
            return $this->setError('invalid-register-number');
        } if (isset($data['phone']) && $data['phone'] && !validatePhone($data['phone'])) {
            return $this->setError('invalid-phone');
        } if (isset($data['email']) && $data['email'] && !validateEmail($data['email'])) {
            return $this->setError('invalid-email');
        } return true;
    }
}