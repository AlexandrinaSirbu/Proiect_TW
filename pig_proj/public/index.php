<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Router.php';

spl_autoload_register(function($class){
    $paths = ['app/core/', 'app/controllers/', 'app/models/'];
    foreach($paths as $p){
        $file = __DIR__ . '/../' . $p . $class . '.php';
        if(file_exists($file)) { require_once $file; return; }
    }
});

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
