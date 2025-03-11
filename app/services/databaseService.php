<?php
class DatabaseService {
    public static function init() {
        if ( isset($GLOBALS['db'][$_SERVER['SERVER_NAME']]) ) {
            $db_host = $GLOBALS['db'][$_SERVER['SERVER_NAME']]['host'];
            $db_name = $GLOBALS['db'][$_SERVER['SERVER_NAME']]['name'];
            $db_user = $GLOBALS['db'][$_SERVER['SERVER_NAME']]['user'];
            $db_pass = $GLOBALS['db'][$_SERVER['SERVER_NAME']]['pass'];
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