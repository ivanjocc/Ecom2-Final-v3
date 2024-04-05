<?php
    class connexionDB {
        private static $dbHost = "localhost";
        private static $dbName = "petshop";
        private static $dbUsername = "root";
        private static $dbUserPassword = "";

        private static $connection = null;

        public static function getConnection() {
            if (null == self::$connection) {
                try {
                    self::$connection = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
                    self::$connection->exec("set names utf8");
                } catch (PDOException $exception) {
                    die($exception->getMessage());
                }
            }
            return self::$connection;
        }

        public static function disconnect() {
            self::$connection = null;
        }
    }

?>
