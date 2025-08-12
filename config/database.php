<?php
class Database {
    private $host = "localhost";
    private $db_name = "polyshop";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Log error thay vì echo trực tiếp
            error_log("Database connection error: " . $exception->getMessage());
            throw $exception; // Re-throw để xử lý ở cấp cao hơn
        }
        return $this->conn;
    }
}
?>
