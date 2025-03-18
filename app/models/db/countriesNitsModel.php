<?php
class CountriesNitsModel extends ORM {

    public string $table = "countries_nits";
    public string $query = "SELECT * 
    FROM `countries_nits` 
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