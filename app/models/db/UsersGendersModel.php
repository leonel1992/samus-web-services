<?php
class UsersGendersModel extends ORM {
    public string $table = "users_genders";
    public string $query = "SELECT * FROM `users_genders`";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}