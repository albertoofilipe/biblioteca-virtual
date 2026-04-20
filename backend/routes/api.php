<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/UsuarioController.php";

$database = new Database();
$db = $database->conectar();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if($uri == "/biblioteca-virtual/backend/usuarios" && $method == "POST"){

    $controller = new UsuarioController($db);
    $controller->criar();

}

if ($uri === "/biblioteca-virtual/backend/login" && $method == "POST") {

    $controller = new UsuarioController();
    $controller->login();

}