<?php
require_once __DIR__ . "/../models/abstract/dbModelAbstract.php";
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class DBController extends ControllerPermissions {
    
    protected ?PDO $conn;
    protected DBModelAbstract $model;

    public mixed $key;
    public string $ref;
    public ?array $data;
    public string $module;

    public function __construct(?PDO $conn, DBModelAbstract $model, string $module, string $ref='id') {
        // Permissions::data();
        $this->conn = $conn;
        $this->model = $model;
        $this->module = $module;
        $this->ref = $ref;

        $this->key = $this->model->setParseKey(VarsData::general('key'));
        $this->data = $this->model->setParseData(VarsData::general( 'data'));
    }

    private function renderInvalidKey() {
        $error = new ResultError($GLOBALS['lang-controllers']['general']['missing-key']);
        $this->renderJson($error);
    }

    private function renderInvalidData() {
        $this->renderJson($this->model->error);
    }

    //-------------------------------------------

    public function table(): void {
        if($this->isValid('access', $this->module)){
            $data = $this->model->getAll($this->model->query);
            $data = $this->model->getParseData($data);
            $this->renderJson($data);
        } $this->renderJson403();
    }

    public function paginate(): void {
        if($this->isValid('access', $this->module)){
            $page = VarsData::integer('page');
            $limit = VarsData::integer('limit');
            if (!$page || !$limit) {
                $this->table();
            }

            $data = $this->model->paginate($page, $limit, $this->model->query);
            $data = $this->model->getParseData($data);
            $this->renderJson($data);
        } $this->renderJson403();
    }

    public function insert() {
        if($this->isValid('insert', $this->module)) {
            if ($this->model->validate($this->data)) {
                $msg = $GLOBALS['lang-controllers']['db'][ $this->model->table ]['insert'];
                $data = $this->model->insert($this->data, $this->ref, $msg);
                $this->renderJson($data);
            } $this->renderInvalidData();
        } $this->renderJson403();
    }
    
    public function update() {
        if($this->isValid('update', $this->module)) {
            if ($this->key) {
                if ($this->model->validate($this->data)) {
                    $msg = $GLOBALS['lang-controllers']['db'][ $this->model->table ]['update'];
                    $data = $this->model->updateByKey($this->ref, $this->key, $this->data, $msg);
                    $this->renderJson($data);
                } $this->renderInvalidData();
            } $this->renderInvalidKey();
        } $this->renderJson403();
    }

    public function delete() {
        if($this->isValid('delete', $this->module)) {
            if ($this->key) {
                $msg = $GLOBALS['lang-controllers']['db'][ $this->model->table ]['delete'];
                $data = $this->model->deleteByKey($this->ref, $this->key, $msg);
                $this->renderJson($data);
            } $this->renderInvalidKey();
        } $this->renderJson403();
    }
}