<?php

session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/UsuarioController.php";
require_once __DIR__ . "/../middlewares/AuthMiddleware.php";

$database = new Database();
$db = $database->conectar();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if($uri == "/biblioteca-virtual/backend/usuarios" && $method == "POST"){

    AuthMiddleware::verificar();

    $controller = new UsuarioController($db);
    $controller->criar();
}

if($uri == "/biblioteca-virtual/backend/login" && $method == "POST"){
    $controller = new UsuarioController($db);
    $controller->login();
}

if($uri == "/biblioteca-virtual/backend/me" && $method == "GET"){

    AuthMiddleware::verificar();

    $controller = new UsuarioController($db);
    $controller->me();
}

if($uri == "/biblioteca-virtual/backend/logout" && $method == "POST"){

    AuthMiddleware::verificar();

    $controller = new UsuarioController($db);
    $controller->logout();
}