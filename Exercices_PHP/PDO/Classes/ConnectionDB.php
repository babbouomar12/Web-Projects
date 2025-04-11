<?php

class ConnectionDB {
    public $debugMode = true;
    private const LOG_FILE = 'session_logs.log';
    private static $_dbname = "managementdb";
    private static $_host = "localhost";
    private static $_user = "root";
    private static $_password = "";
    private static $_db = null;
    private static $_PORT = 3306;

    private function __construct() {
        try {
            $host = 'mysql:host=' . self::$_host . ';dbname=' . self::$_dbname . ';port=' . self::$_PORT;
            $username = self::$_user;
            $password = self::$_password;
        
            self::$_db = new PDO($host, $username, $password);
            
            if ($this->debugMode) {
                $log = "[INFO]: Connected to the database successfully!\n";
                file_put_contents(ConnectionDB::LOG_FILE, $log, FILE_APPEND);
            }
        } catch (PDOException $e) {
            if ($this->debugMode) {
                $log = "[ERROR]: Connection failed: " . $e->getMessage() . "\n";
                file_put_contents(ConnectionDB::LOG_FILE, $log, FILE_APPEND);
            }
        }
    }

    public static function getInstance() {
        if (!self::$_db) {
            new ConnectionDB();
        }
        return self::$_db;
    }
}

?>