<?php
class CurrenciesTypeModel extends ORM {
    public string $table = "currencies_type";
    public string $query = "SELECT * FROM `currencies_type` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}