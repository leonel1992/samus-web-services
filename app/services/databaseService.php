<?php
class DatabaseService {
    public static function init(?string $db = null) {
        $db ??= $_SERVER['SERVER_NAME'];

        if ( isset($GLOBALS['db'][$db]) ) {
            $db_host = $GLOBALS['db'][$db]['host'];
            $db_name = $GLOBALS['db'][$db]['name'];
            $db_user = $GLOBALS['db'][$db]['user'];
            $db_pass = $GLOBALS['db'][$db]['pass'];
        } else {
            $db_host = $GLOBALS['db']['default']['host'];
            $db_name = $GLOBALS['db']['default']['name'];
            $db_user = $GLOBALS['db']['default']['user'];
            $db_pass = $GLOBALS['db']['default']['pass'];
        }

        $db_opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
            $connection = new PDO($dsn, $db_user, $db_pass, $db_opt);
            $connection->exec("SET NAMES 'utf8mb4'");
            return $connection;
        } catch (PDOException $e) {
            return null;
        }
        
    }
}   