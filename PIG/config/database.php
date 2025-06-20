<?php

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            $host = 'localhost';
            $dbname = 'pig';
            $username = 'root';
            $password = '1234'; 

            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Conexiune eșuată: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
