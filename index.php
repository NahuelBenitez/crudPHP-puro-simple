<?php

require_once './config/database.php';
require_once './controller/userController.php';

// Verificar si se solicita alguna acción
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Enrutamiento de acciones
switch ($action) {
    case 'index':
        $controller = new UserController();
        $controller->index();
        break;
    case 'create':
        $controller = new UserController();
        $controller->create();
        break;
    case 'store':
        $controller = new UserController();
        $controller->store();
        break;
    case 'edit':
        $controller = new UserController();
        $controller->edit();
        break;
    case 'update':
        $controller = new UserController();
        $controller->update();
        break;
    case 'delete':
        $controller = new UserController();
        $controller->delete();
        break;
    default:
        echo "Acción no válida";
}
