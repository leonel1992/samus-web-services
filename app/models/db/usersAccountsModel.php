<?php
class UsersAccountsModel extends ORM {
    public string $table = "users_accounts";
    public string $query = "SELECT * FROM `users_accounts` ORDER BY `name` ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn, $this->table);
    }
}