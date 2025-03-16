<?php
class CountriesCompaniesModel extends ORM {

    public string $table = "countries_companies";
    public string $query = "SELECT * 
    FROM `country_companies` 
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