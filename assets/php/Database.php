<?php

class Database {
    private $host = "localhost";
    private $dbName = "lavacar";
    private $username = "root";
    private $password = "";
    private $conn;
    
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
