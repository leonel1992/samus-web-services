<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class ActionsModel extends DBModelAbstract {
    
    public string $table = 'actions';
    public string $query = "SELECT * FROM actions ORDER BY name ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function parseKey(mixed $key): string {
        return idxval($key);
    }
    
    public function parseData(?array $data): array|null {
        if($data){
            $data['id'] = idxval($data['id'] ?? '');
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['description'] = trimstrval($data['description'] ?? null, true);
        } return $data;
    }

    public function parseTable(ResultError|ResultData|ResultPaginate $data): ResultError|ResultData|ResultPaginate {
        return $data;
    }

    public function parseTableItem(?array $item): array|null {
        return $item;
    }

    //-----------------------------------------

    public function validate(?array $data): bool {
        $this->error = null;
        if (!$data) {
            return $this->setError();
        } if (!isset($data['id']) || !$data['id']) {
            return $this->setError('invalid-id');
        } if (!isset($data['name']) || !$data['name']) {
            return $this->setError('invalid-name');
        } return true;
    }
}