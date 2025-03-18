<?php
class UsersStatusModel extends ORM {
    public string $table = "users_status";
    public string $query = "SELECT * FROM `users_status` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}