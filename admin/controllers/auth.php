<?php
session_start();
require_once '../../Model/Database.php';
require_once '../config/config.php';

class AdminAuth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        try {
            $conn = $this->db->getConnection();
            
            // Kiểm tra trong bảng users với role = 'admin'
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createAdminUser() {
        try {
            $conn = $this->db->getConnection();
            
            // Kiểm tra xem đã có admin user chưa
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                // Tạo admin user mới
                $hashedPassword = password_hash('admin1234', PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, 'admin', NOW())");
                $stmt->execute(['admin', $hashedPassword, 'admin@polyshop.com']);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $db->connect();
    $auth = new AdminAuth($db);
    
    // Tạo admin user nếu chưa có
    $auth->createAdminUser();
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($username, $password)) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
        header('Location: ../index.php');
        exit;
    }
}
?>
