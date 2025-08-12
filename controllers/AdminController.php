<?php
class AdminController {
    private $productsModel;
    private $categoriesModel;
    private $usersModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ../index.php');
            exit;
        }
        
        // Đảm bảo các model được load
        if (!class_exists('Products')) {
            require_once __DIR__ . '/../models/Products.php';
        }
        if (!class_exists('Categories')) {
            require_once __DIR__ . '/../models/Categories.php';
        }
        if (!class_exists('Users')) {
            require_once __DIR__ . '/../models/Users.php';
        }
        
        $this->productsModel = new Products();
        $this->categoriesModel = new Categories();
        $this->usersModel = new Users();
    }

    public function index() {
        // Dashboard
        $totalProducts = $this->productsModel->getProductCount();
        $totalCategories = $this->categoriesModel->getCategoryCount();
        $totalUsers = $this->usersModel->getUserCount();
        
        include '../views/admin/dashboard.php';
    }

    public function products() {
        $action = $_GET['subaction'] ?? 'list';
        
        switch ($action) {
            case 'add':
                $this->addProduct();
                break;
            case 'edit':
                $this->editProduct();
                break;
            case 'delete':
                $this->deleteProduct();
                break;
            default:
                $this->listProducts();
                break;
        }
    }

    public function categories() {
        $action = $_GET['subaction'] ?? 'list';
        
        switch ($action) {
            case 'add':
                $this->addCategory();
                break;
            case 'edit':
                $this->editCategory();
                break;
            case 'delete':
                $this->deleteCategory();
                break;
            default:
                $this->listCategories();
                break;
        }
    }

    private function listProducts() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $products = $this->productsModel->getAllProducts($limit, $offset);
        $totalProducts = $this->productsModel->getProductCount();
        $totalPages = ceil($totalProducts / $limit);
        
        include '../views/admin/products/list.php';
    }

    private function addProduct() {
        $categories = $this->categoriesModel->getActiveCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $sale_price = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
            $category_id = (int)($_POST['category_id'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $status = isset($_POST['status']) ? 1 : 0;
            
            // Validate
            if (empty($name) || $price <= 0 || $category_id <= 0) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc';
            } else {
                // Handle image upload
                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $fileInfo = pathinfo($_FILES['image']['name']);
                    $extension = strtolower($fileInfo['extension']);
                    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $filename = uniqid() . '.' . $extension;
                        $uploadPath = $uploadDir . $filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                            $image = 'uploads/products/' . $filename;
                        }
                    }
                }
                
                $productData = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'sale_price' => $sale_price,
                    'category_id' => $category_id,
                    'stock' => $stock,
                    'featured' => $featured,
                    'status' => $status,
                    'image' => $image
                ];
                
                if ($this->productsModel->addProduct($productData)) {
                    $success = 'Thêm sản phẩm thành công!';
                    $_POST = []; // Reset form
                } else {
                    $error = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }
        
        include '../views/admin/products/add.php';
    }

    private function editProduct() {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: index.php?action=products');
            exit;
        }
        
        $product = $this->productsModel->getProductById($id);
        if (!$product) {
            header('Location: index.php?action=products');
            exit;
        }
        
        $categories = $this->categoriesModel->getActiveCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $sale_price = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
            $category_id = (int)($_POST['category_id'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $status = isset($_POST['status']) ? 1 : 0;
            
            if (empty($name) || $price <= 0 || $category_id <= 0) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc';
            } else {
                $productData = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'sale_price' => $sale_price,
                    'category_id' => $category_id,
                    'stock' => $stock,
                    'featured' => $featured,
                    'status' => $status
                ];
                
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $fileInfo = pathinfo($_FILES['image']['name']);
                    $extension = strtolower($fileInfo['extension']);
                    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $filename = uniqid() . '.' . $extension;
                        $uploadPath = $uploadDir . $filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                            $productData['image'] = 'uploads/products/' . $filename;
                            
                            // Delete old image
                            if ($product['image'] && file_exists('../' . $product['image'])) {
                                unlink('../' . $product['image']);
                            }
                        }
                    }
                }
                
                if ($this->productsModel->updateProduct($id, $productData)) {
                    $success = 'Cập nhật sản phẩm thành công!';
                    $product = $this->productsModel->getProductById($id);
                } else {
                    $error = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }
        
        include '../views/admin/products/edit.php';
    }

    private function deleteProduct() {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: index.php?action=products');
            exit;
        }
        
        if ($this->productsModel->deleteProduct($id)) {
            header('Location: index.php?action=products&success=deleted');
        } else {
            header('Location: index.php?action=products&error=delete_failed');
        }
        exit;
    }

    private function listCategories() {
        $categories = $this->categoriesModel->getAllCategories();
        include '../views/admin/categories/list.php';
    }

    private function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = isset($_POST['status']) ? 1 : 0;
            
            if (empty($name)) {
                $error = 'Vui lòng nhập tên danh mục';
            } else {
                $categoryData = [
                    'name' => $name,
                    'description' => $description,
                    'status' => $status
                ];
                
                if ($this->categoriesModel->addCategory($categoryData)) {
                    $success = 'Thêm danh mục thành công!';
                    $_POST = [];
                } else {
                    $error = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }
        
        include '../views/admin/categories/add.php';
    }

    private function editCategory() {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: index.php?action=categories');
            exit;
        }
        
        $category = $this->categoriesModel->getCategoryById($id);
        if (!$category) {
            header('Location: index.php?action=categories');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = isset($_POST['status']) ? 1 : 0;
            
            if (empty($name)) {
                $error = 'Vui lòng nhập tên danh mục';
            } else {
                $categoryData = [
                    'name' => $name,
                    'description' => $description,
                    'status' => $status
                ];
                
                if ($this->categoriesModel->updateCategory($id, $categoryData)) {
                    $success = 'Cập nhật danh mục thành công!';
                    $category = $this->categoriesModel->getCategoryById($id);
                } else {
                    $error = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }
        
        include '../views/admin/categories/edit.php';
    }

    private function deleteCategory() {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: index.php?action=categories');
            exit;
        }
        
        if ($this->categoriesModel->deleteCategory($id)) {
            header('Location: index.php?action=categories&success=deleted');
        } else {
            header('Location: index.php?action=categories&error=delete_failed');
        }
        exit;
    }
}
?>
