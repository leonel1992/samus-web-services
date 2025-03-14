<?php
class UserStatusModel extends ORM {
    public string $table = "user_status";
    public string $query = "SELECT * FROM `user_status` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}