<?php

require_once __DIR__ . "/../models/Usuario.php";

class UsuarioController {

    private $usuario;

    public function __construct($db){
        $this->usuario = new Usuario($db);
    }

    public function criar(){

        $data = json_decode(file_get_contents("php://input"));

        if(
            !empty($data->nome) &&
            !empty($data->email) &&
            !empty($data->senha)
        ){

            $this->usuario->nome = $data->nome;
            $this->usuario->email = $data->email;
            $this->usuario->senha = $data->senha;

            if($this->usuario->criar()){
                echo json_encode(["mensagem"=>"Usuário criado"]);
            } else {
                echo json_encode(["mensagem"=>"Erro ao criar"]);
            }

        } else {
            echo json_encode(["mensagem"=>"Dados incompletos"]);
        }
    }

    public function login() {

    $database = new Database();
    $db = $database->connect();

    $data = json_decode(file_get_contents("php://input"));

    $usuarioModel = new Usuario($db);

    $usuario = $usuarioModel->login($data->email);

    if (!$usuario || !password_verify($data->senha, $usuario["senha"])) {
        http_response_code(401);
        echo json_encode(["erro" => "Email ou senha inválidos"]);
        return;
    }

    //salva usuário na sessão
    $_SESSION["usuario"] = [
        "id" => $usuario["id"],
        "nome" => $usuario["nome"],
        "email" => $usuario["email"]
    ];

    echo json_encode([
        "mensagem" => "Login realizado com sucesso"
    ]);
}
}