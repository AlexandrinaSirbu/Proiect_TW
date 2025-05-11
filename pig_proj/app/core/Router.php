<?php
class Router {
    protected $routes = [
        '/'           => ['HomeController', 'index'],
        '/login'      => ['AuthController', 'showLogin'],
        '/login-post' => ['AuthController', 'login'],
        '/register'   => ['AuthController', 'showRegister'],
        '/register-post' => ['AuthController', 'register'],
        '/logout'     => ['AuthController', 'logout'],
        '/pig' => ['PigController', 'index'],
        '/verify' => ['AuthController', 'verify'],

        // adaugă şi altele după nevoie
    ];

    public function dispatch(string $uri){

        $path = parse_url($uri, PHP_URL_PATH);
    
        $base = '/pig_proj/public';      
        if (strpos($path, $base) === 0) {
            $path = substr($path, strlen($base));
            if ($path === '' || $path === false) {
                $path = '/';
            }
        }
    
        if (isset($this->routes[$path])) {
            [$ctrl, $method] = $this->routes[$path];
            $c = new $ctrl();
            $c->$method();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 – Pagina nu a fost găsită";
        }
    }
    
    
}
