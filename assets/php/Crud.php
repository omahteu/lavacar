<?php
require_once 'Database.php';

class CRUD {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Método para executar INSERT, UPDATE ou DELETE
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount(); // Retorna o número de linhas afetadas
        } catch (PDOException $e) {
            die("Erro ao executar a query: " . $e->getMessage());
        }
    }

    // Método para SELECT
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os resultados como array associativo
        } catch (PDOException $e) {
            die("Erro ao executar a query: " . $e->getMessage());
        }
    }
}
?>
