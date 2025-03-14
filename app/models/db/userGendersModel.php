<?php
class UserGendersModel extends ORM {
    public string $table = "user_genders";
    public string $query = "SELECT * FROM `user_genders`";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}