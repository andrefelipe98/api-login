<?php
class LoginUsuario {
    private $conn;
    private $table_name = "usuario";

    public $codusuario;
    public $login;
    public $senha;
    public $tipo_usuario;
    public $ativo;
    public $codfilial;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
        $query = "SELECT codusuario, login, senha, tipo_usuario, ativo, codfilial FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET login=:login, senha=:senha, tipo_usuario=:tipo_usuario, ativo=:ativo, codfilial=:codfilial";
        
        $stmt = $this->conn->prepare($query);

        $this->login=htmlspecialchars(strip_tags($this->login));
        $this->senha=htmlspecialchars(strip_tags($this->senha));
        $this->tipo_usuario=htmlspecialchars(strip_tags($this->tipo_usuario));
        $this->ativo=htmlspecialchars(strip_tags($this->ativo));
        $this->codfilial=htmlspecialchars(strip_tags($this->codfilial));

        $stmt->bindParam(":login", $this->login);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);
        $stmt->bindParam(":ativo", $this->ativo);
        $stmt->bindParam(":codfilial", $this->codfilial);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
