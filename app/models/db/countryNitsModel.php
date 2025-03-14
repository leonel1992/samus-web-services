<?php
class CountryNitsModel extends ORM {

    public string $table = "country_nits";
    public string $query = "SELECT * 
    FROM `country_nits` 
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