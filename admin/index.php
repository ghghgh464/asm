<?php
// Load configuration và helper functions
require_once '../config/config.php';

// Load models trước khi load controller
require_once '../models/Connect.php';
require_once '../models/Products.php';
require_once '../models/Categories.php';
require_once '../models/Users.php';

session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Xử lý routing
$action = $_GET['action'] ?? 'index';

// Khởi tạo controller tương ứng
switch ($action) {
    case 'index':
        require_once '../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;
        
    case 'products':
        require_once '../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->products();
        break;
        
    case 'categories':
        require_once '../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->categories();
        break;
        
    default:
        // Mặc định hiển thị dashboard
        require_once '../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;
}
?>
