<?php
class UserAccountsModel extends ORM {
    public string $table = "user_accounts";
    public string $query = "SELECT * FROM `user_accounts` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}