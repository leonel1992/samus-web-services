<?php
class TimezonesModel extends ORM {

    public string $ref = 'timezone';
    public string $table = "timezones";
    public string $query = "SELECT * FROM `timezones` ORDER BY `timezone` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}