<?php
// Database class sẽ được autoload từ config.php
require_once __DIR__ . '/../config/database.php';

class Connect {
    private $conn;
    private $table_name = "";

    public function __construct($table_name = "") {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Không thể kết nối đến database");
            }
            $this->table_name = $table_name;
        } catch (Exception $e) {
            error_log("Connect constructor error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            // Log error thay vì echo trực tiếp
            error_log("Database query error: " . $e->getMessage());
            return false;
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if ($stmt) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function insert($data) {
        if (empty($this->table_name)) {
            return false;
        }
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table_name} ({$columns}) VALUES ({$placeholders})";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            // Log error thay vì echo trực tiếp
            error_log("Database insert error: " . $e->getMessage());
            return false;
        }
    }

    public function update($data, $where, $where_params = []) {
        if (empty($this->table_name)) {
            return false;
        }
        
        $set_clause = [];
        foreach (array_keys($data) as $column) {
            $set_clause[] = "{$column} = :{$column}";
        }
        
        $sql = "UPDATE {$this->table_name} SET " . implode(', ', $set_clause) . " WHERE {$where}";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array_merge($data, $where_params));
            return $stmt->rowCount();
        } catch(PDOException $e) {
            // Log error thay vì echo trực tiếp
            error_log("Database update error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($where, $params = []) {
        if (empty($this->table_name)) {
            return false;
        }
        
        $sql = "DELETE FROM {$this->table_name} WHERE {$where}";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch(PDOException $e) {
            // Log error thay vì echo trực tiếp
            error_log("Database delete error: " . $e->getMessage());
            return false;
        }
    }
}
?>
