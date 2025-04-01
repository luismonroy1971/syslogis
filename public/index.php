<?php

require_once dirname(__DIR__) . '/config/app.php';

session_start();

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/core/Model.php';
require_once dirname(__DIR__) . '/core/View.php';
require_once dirname(__DIR__) . '/core/Controller.php';

// Autoload de clases
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        APP_PATH . '/core/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    return false;
});

// Enrutamiento mejorado
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Normalizar la ruta
if (empty($uri)) {
    $controller = 'HomeController';
    $action = 'index';
} else {
    $parts = explode('/', $uri);
    $controllerName = ucfirst(strtolower($parts[0]));
    $controller = $controllerName . 'Controller';
    $action = isset($parts[1]) ? strtolower($parts[1]) : 'index';
}

// Verificar si el archivo del controlador existe
$controllerFile = APP_PATH . '/controllers/' . $controller . '.php';
if (!file_exists($controllerFile)) {
    header('HTTP/1.0 404 Not Found');
    include APP_PATH . '/views/errors/404.php';
    exit;
}

// Verificar y ejecutar el controlador
if (class_exists($controller)) {
    $controllerInstance = new $controller();
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
        $controllerInstance->sendResponse();
    } else {
        header('HTTP/1.0 404 Not Found');
        echo '404 - Acción no encontrada';
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo '404 - Controlador no encontrado';
}