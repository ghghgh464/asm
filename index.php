<?php
// Load configuration và helper functions
require_once 'config/config.php';

session_start();

// Xử lý routing
$action = $_GET['action'] ?? 'home';
$id = $_GET['id'] ?? null;
$page = $_GET['page'] ?? 1;

// Khởi tạo controller tương ứng
switch ($action) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'products':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->products($id, $page);
        break;
        
    case 'product':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->productDetail($id);
        break;
        
    case 'search':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->search();
        break;
        
    case 'about':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->about();
        break;
        
    case 'contact':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->contact();
        break;
        
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'profile':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->profile();
        break;
        
    case 'change-password':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->changePassword();
        break;
        
    case 'admin':
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        // Chuyển hướng đến admin panel
        header('Location: admin/index.php');
        exit;
        break;
        
    case 'admin-products':
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        header('Location: admin/index.php?action=products');
        exit;
        break;
    case 'add-product':
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        header('Location: admin/index.php?action=products&subaction=add');
        exit;
        break;
    case 'edit-product':
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        $id = $_GET['id'] ?? '';
        header('Location: admin/index.php?action=products&subaction=edit&id=' . $id);
        exit;
        break;
    case 'delete-product':
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        $id = $_GET['id'] ?? '';
        header('Location: admin/index.php?action=products&subaction=delete&id=' . $id);
        exit;
        break;
    default:
        // Mặc định hiển thị trang chủ
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
?>
