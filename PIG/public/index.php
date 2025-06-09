<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('VIEW', APP . '/views');
define('MODEL', APP . '/models');
define('CTRL', APP . '/controllers');

spl_autoload_register(function ($class) {
    $paths = [CTRL, MODEL];
    foreach ($paths as $path) {
        $file = "$path/$class.php";
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

require_once ROOT . '/config/database.php';
require_once ROOT . '/routes/web.php';
