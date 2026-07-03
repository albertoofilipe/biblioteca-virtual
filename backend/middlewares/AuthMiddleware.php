<?php

class AuthMiddleware {

    public static function verificar(){

        if(!isset($_SESSION["usuario"])){
            http_response_code(401);

            echo json_encode([
                "mensagem" => "Acesso não autorizado"
            ]);

            exit;
        }

    }

}