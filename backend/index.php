<?php

header("Content-Type: application/json");

require_once "config/database.php";

$database = new Database();
$conn = $database->conectar();

if($conn){
    echo json_encode([
        "status" => "API Biblioteca funcionando 🚀"
    ]);
}