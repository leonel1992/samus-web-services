<?php
class CurrenciesTypesModel extends ORM {
    public string $table = "currencies_types";
    public string $query = "SELECT * FROM `currencies_types` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}