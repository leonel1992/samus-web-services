<?php
class CountriesDnisModel extends ORM {

    public string $table = "countries_dnis";
    public string $query = "SELECT * 
    FROM `countries_dnis` 
    ORDER BY 
        `country` ASC, 
        CASE 
            WHEN `code` IN ('OTHER', 'OTRA', 'OTRO') THEN 1 
            ELSE 0 
        END,
        `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}