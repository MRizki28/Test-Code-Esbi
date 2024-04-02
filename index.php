<?php

use Controllers\UserController;
use Controllers\ViewController;

require_once 'vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
$viewController = new ViewController();
$userController = new UserController();

if (preg_match('/^\/delete\/(\d+)$/', $requestUri, $matches)) {
    $id = $matches[1]; 
    echo $userController->deleteData($id);
}elseif (preg_match('/^\/get\/(\d+)$/', $requestUri, $matches)) {
    $id = $matches[1]; 
    echo $userController->getDataById($id);
}elseif (preg_match('/^\/update\/(\d+)$/', $requestUri, $matches)) {
    $id = $matches[1]; 
    echo $userController->updateData($id);
}elseif (preg_match('/^\/resetpassword\/(\d+)$/', $requestUri, $matches)) {
    $id = $matches[1]; 
    echo $userController->resetPassword($id);
} else {
    switch ($requestUri) {
        case '/user':
            echo $userController->getAllData();
            break;
        case '/register':
            echo $userController->register();
            break;
        case '/usermanagement':
            echo $viewController->usermanagement();
            break;
        default:
            $viewController->sigup();
            break;
    }
}
