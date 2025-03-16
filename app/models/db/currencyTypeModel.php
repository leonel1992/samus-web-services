<?php
class CurrencyTypeModel extends ORM {
    public string $table = "currency_type";
    public string $query = "SELECT * FROM `currency_type` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}