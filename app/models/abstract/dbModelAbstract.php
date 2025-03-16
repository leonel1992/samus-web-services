<?php
require_once __DIR__ . "/../../helpers/values.php";
require_once __DIR__ . "/../../helpers/validate.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";

abstract class DBModelAbstract extends ORM {
    
    protected ?PDO $conn = null;
    public ?ResultError $error = null;

    public string $table;
    public string $query;

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
        $this->conn = $conn;
    }

    public function setError(?string $key = null): bool {
        $error = $key
        ? $GLOBALS['lang-controllers']['db'][$this->table][$key]
        : $GLOBALS['lang-controllers']['general']['missing-data'];
        $error ??= $GLOBALS['lang-controllers']['db']['general']['error-unknown'];
        $this->error = new ResultError($error);
        return false;
    }

    public function getParseData(ResultError|ResultData|ResultPaginate $data): ResultError|ResultData|ResultPaginate {
        if ($data->success && is_array($data->data)) {
            foreach ($data->data as $key => $item) {
                $data->data[$key] = $this->getParseItem($item);
            }
        } return $data;
    }

    public function getParseItem(?array $item): array|null {
        return $item;
    }

    public function setParseKey(mixed $key): mixed {
        return idxval($key);
    }
    
    abstract public function setParseData(?array $data): array|null;
    
    abstract public function validate(?array $data): bool;
}