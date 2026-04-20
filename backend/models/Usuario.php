<?php

class Usuario {

    private $conn;
    private $table = "usuarios";

    public $nome;
    public $email;
    public $senha;

    public function __construct($db){
        $this->conn = $db;
    }

    public function criar(){

        $query = "INSERT INTO " . $this->table . "
        SET nome=:nome, email=:email, senha=:senha";

        $stmt = $this->conn->prepare($query);

        $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $senhaHash);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}