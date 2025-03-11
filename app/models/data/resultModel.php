<?php
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class Result {

    public bool $success;
    public string $message;

    public function __construct(bool $success, string $message='') {
        $this->success  = $success;
        $this->message = $message;
    }

    public function toJson(): array {
        return [
            'success' => $this->success,
            'message' => $this->message
        ];
    }

    public function print(): void {
        JSON::print($this->toJson());
    }
}

// -------------------------------------------------------

class ResultError extends Result {
    public function __construct(string $message='') {
        parent::__construct(false, $message);
    }
}

class ResultErrorConn extends ResultError {
    public function __construct() {
        parent::__construct($GLOBALS['lang-controllers']['general']['error-conn']);
    }
}

class ResultErrorException extends ResultError {
    public function __construct(Throwable $th) {
        parent::__construct($th->getMessage());
    }
}

class ResultErrorPDO extends ResultError {
    public function __construct(PDOStatement $stmt) {
        $errorInfo = $stmt->errorInfo();
        parent::__construct($errorInfo[2] ?? $GLOBALS['lang-controllers']['general']['error-unknown']);
    }
}

// -------------------------------------------------------

class ResultSuccess extends Result {
    public function __construct(string $message='') {
        parent::__construct(true, $message);
    }
}

// -------------------------------------------------------

class ResultData extends Result {

    public bool $success;
    public string $message;
    public mixed $data;
    public string $key;

    public function __construct(string $message='', mixed $data=null, string $key='data', bool $success=true) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->key = $key;
    }

    public function toJson(): array {
        return [
            'success' => $this->success,
            'message' => $this->message,
            $this->key => $this->data,
        ];
    }
}

// -------------------------------------------------------

class ResultPaginate extends Result {   
        
    public bool $success;
    public string $message;
    public int $page;
    public int $limit;
    public int $pages;
    public int $rows;
    public mixed $data;
    public string $key;

    public function __construct(int $page, int $limit, int $pages, int $rows, string $message='', mixed $data=null, string $key='data', bool $success=true) {
        $this->page = $page;
        $this->limit = $limit;
        $this->pages = $pages;
        $this->rows = $rows;
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->key = $key;
    }

    public function toJson(): array {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'paginate' => [
                'page' => $this->page,
                'limit' => $this->limit,
                'pages' => $this->pages,
                'rows' => $this->rows,
            ],
            'data' => $this->data,
        ];
    }
}