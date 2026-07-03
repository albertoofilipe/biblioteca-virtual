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

   public function login(){

    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->email) && !empty($data->senha)){

        $usuario = $this->usuario->login($data->email);

        if($usuario && password_verify($data->senha, $usuario["senha"])){

            // CRIAR SESSÃO
            $_SESSION["usuario"] = [
                "id" => $usuario["id"],
                "nome" => $usuario["nome"],
                "email" => $usuario["email"]
            ];

            echo json_encode([
                "mensagem" => "Login realizado"
            ]);

        }else{
            echo json_encode(["mensagem"=>"Email ou senha inválidos"]);
        }

    }else{
        echo json_encode(["mensagem"=>"Dados incompletos"]);
    }
}

    public function me(){

        if(isset($_SESSION["usuario"])){
        echo json_encode($_SESSION["usuario"]);
        }else{
        echo json_encode(["mensagem"=>"Não autenticado"]);
        }
    }

    public function logout(){
    session_destroy();
    echo json_encode(["mensagem"=>"Logout realizado"]);
}

}