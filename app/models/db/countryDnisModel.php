<?php
class CountryDnisModel extends ORM {

    public string $table = "country_dnis";
    public string $query = "SELECT * 
    FROM `country_dnis` 
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