<?php
echo password_hash("WordP@ss123", PASSWORD_DEFAULT);
    $controller = $_GET['c'] ?? 'auth';
    $action = $_GET['a'] ?? 'loadLogin';

    $controllerName = ucfirst($controller) . 'Controller';
    $controllerFile = '../app/controllers/' . $controllerName . '.php';

    if(!file_exists($controllerFile)) {
        die("Controller no encontrado.");
    }

    require_once $controllerFile;

    $ctrl = new $controllerName();

    if(!method_exists($ctrl, $action)) {
        die("Acción no encontrada.");
    }

    $ctrl->$action();
?>