<?php
// Automat detectează unde e plasat proiectul
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim(substr($requestUri, strlen($basePath)), '/');

switch ($route) {
    case '':
        if (isset($_SESSION['user_id'])) {
            (new DashboardController())->index();
        } else {
            header("Location: $basePath/login");
            exit;
        }
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'generate/numbers':
        (new GeneratorController())->numbers();
        break;

    case 'ajax/generate_numbers':
        (new GeneratorController())->numbersAjax();
        break;

    case 'generate/string':
        (new GeneratorController())->string();
        break;

    case 'ajax/generate_string':
        (new GeneratorController())->stringAjax();
        break;

    case 'generate/matrix':
        (new GeneratorController())->matrix();
        break;
    
    case 'ajax/generate_matrix':
        (new GeneratorController())->matrixAjax();
        break;

    case 'generate/graph':
        (new GeneratorController())->graph();
        break;
    
    case 'ajax/generate_graph':
        (new GeneratorController())->graphAjax();
        break;
        
    case 'history':
        if (isset($_SESSION['user_id'])) {
            require_once CTRL . '/DashboardController.php';
            $controller = new DashboardController();
            $controller->history();
        } else {
            header('Location: /login');
            exit;
        }
        break;

    case 'export':
        require_once CTRL . '/ExportController.php';
        $controller = new ExportController();
        $controller->export();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
}
