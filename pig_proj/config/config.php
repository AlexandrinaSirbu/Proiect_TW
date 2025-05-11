<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_HOST',      'localhost');    
define('DB_NAME',      'pig_db');             
define('DB_USER',      'root');         
define('DB_PASS',      '');             
define('DB_CHARSET',   'utf8mb4');      


if (DB_NAME !== '') {
    define('DB_DSN', "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET);
} else {
    define('DB_DSN', null);
}

define('BASE_URL', '/'); 
define('APP_ENV', 'development'); 
