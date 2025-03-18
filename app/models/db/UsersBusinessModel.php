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
        return $this->runValidation($data, [
            'name' => !empty($data['name']) && strlen($data['name']) > 0,
            'type' => !empty($data['type']) && strlen($data['type']) > 1,
            'date' => !empty($data['date']),
            'country' => !empty($data['country']) && strlen($data['country']) === 3,
            'state' => !empty($data['state']) && strlen($data['state']) > 1,
            'city' => !empty($data['city']) && strlen($data['city']) > 1,
            'address' => !empty($data['address']) && strlen($data['address']) > 9,
            'register-type'   => !empty($data['register_type']) && strlen($data['register_type']) > 1,
            'register-number' => !empty($data['register_number']) && strlen($data['register_number']) > 1,
            'phone' => !empty($data['phone']) && validatePhone($data['phone']),
            'email' => !empty($data['email']) && validateEmail($data['email']),
        ]);
    }
}