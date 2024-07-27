<?php
class Database {
    private $host = "localhost";
    private $db_name = "saf"; // Nome do seu banco de dados
    private $username = "root"; // Seu usuário do banco de dados (altere conforme necessário)
    private $password = ""; // Deixe vazio se não houver senha
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
