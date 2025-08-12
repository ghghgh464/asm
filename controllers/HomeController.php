<?php
// Models sẽ được autoload từ config.php

class HomeController {
    private $productsModel;
    private $categoriesModel;
    private $commentsModel;

    public function __construct() {
        $this->productsModel = new Products();
        $this->categoriesModel = new Categories();
        $this->commentsModel = new Comments();
    }

    public function index() {
        // Lấy sản phẩm nổi bật
        $featuredProducts = $this->productsModel->getFeaturedProducts(8);
        
        // Lấy danh mục
        $categories = $this->categoriesModel->getActiveCategories();
        
        // Lấy sản phẩm mới nhất
        $latestProducts = $this->productsModel->getAllProducts(8);
        
        // Đảm bảo có dữ liệu
        if (!$featuredProducts) $featuredProducts = [];
        if (!$categories) $categories = [];
        if (!$latestProducts) $latestProducts = [];
        
        // Hiển thị trang chủ
        include 'views/home.php';
    }

    public function products($category_id = null, $page = 1) {
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Lấy category_id từ URL nếu có
        if (!$category_id && isset($_GET['category'])) {
            $category_id = (int)$_GET['category'];
        }
        
        // Lấy page từ URL nếu có
        if ($page == 1 && isset($_GET['page'])) {
            $page = (int)$_GET['page'];
        }
        
        // Cập nhật offset nếu page thay đổi
        $offset = ($page - 1) * $limit;
        
        // Đảm bảo page và offset hợp lệ
        if ($page < 1) $page = 1;
        if ($offset < 0) $offset = 0;
        
        if ($category_id) {
            $products = $this->productsModel->getProductsByCategory($category_id, $limit, $offset);
            $current_category = $this->categoriesModel->getCategoryById($category_id);
            $total_products = $this->productsModel->countProductsByCategory($category_id);
        } else {
            $products = $this->productsModel->getAllProducts($limit, $offset);
            $current_category = null;
            $total_products = $this->productsModel->countAllProducts();
        }
        
        $categories = $this->categoriesModel->getActiveCategories();
        
        // Đảm bảo có dữ liệu
        if (!$products) $products = [];
        if (!$categories) $categories = [];
        if (!$current_category && $category_id) $current_category = null;
        
        // Tính toán phân trang
        $total_pages = ceil($total_products / $limit);
        $current_page = $page;
        
        include 'views/products.php';
    }

    public function productDetail($id) {
        $product = $this->productsModel->getProductById($id);
        if (!$product) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy bình luận của sản phẩm
        $comments = $this->commentsModel->getCommentsByProduct($id, 'approved');
        
        // Lấy sản phẩm liên quan (loại trừ sản phẩm hiện tại)
        $relatedProducts = $this->productsModel->getProductsByCategory($product['category_id'], 4);
        if ($relatedProducts) {
            $relatedProducts = array_filter($relatedProducts, function($item) use ($product) {
                return $item['id'] != $product['id'];
            });
            $relatedProducts = array_slice($relatedProducts, 0, 4);
        }
        $categories = $this->categoriesModel->getActiveCategories();
        
        // Đảm bảo có dữ liệu
        if (!$comments) $comments = [];
        if (!$relatedProducts) $relatedProducts = [];
        if (!$categories) $categories = [];
        
        include 'views/product-detail.php';
    }

    public function search() {
        $search_query = $_GET['q'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        $products = [];
        $total_results = 0;
        
        if (!empty($search_query)) {
            $products = $this->productsModel->searchProducts($search_query, $limit, $offset);
            $total_results = $this->productsModel->countSearchResults($search_query);
        } else {
            // Nếu không có search query, chuyển hướng về trang chủ
            header('Location: index.php');
            exit;
        }
        
        $categories = $this->categoriesModel->getActiveCategories();
        
        // Đảm bảo có dữ liệu
        if (!$products) $products = [];
        if (!$categories) $categories = [];
        
        // Tính toán phân trang
        $total_pages = ceil($total_results / $limit);
        $current_page = $page;
        
        // Đảm bảo page và offset hợp lệ
        if ($page < 1) $page = 1;
        if ($offset < 0) $offset = 0;
        
        // Lấy danh mục gợi ý
        $suggested_categories = array_slice($categories, 0, 5);
        
        include 'views/search.php';
    }

    public function about() {
        include 'views/about.php';
    }

    public function contact() {
        $success = '';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'])) {
                $error = 'Token bảo mật không hợp lệ. Vui lòng thử lại.';
            } else {
                // Validate input
                $firstname = trim($_POST['firstname'] ?? '');
                $lastname = trim($_POST['lastname'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $subject = trim($_POST['subject'] ?? '');
                $message = trim($_POST['message'] ?? '');
                
                if (empty($firstname) || empty($lastname) || empty($email) || empty($subject) || empty($message)) {
                    $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Email không hợp lệ.';
                } elseif (strlen($message) < 10) {
                    $error = 'Nội dung tin nhắn phải có ít nhất 10 ký tự.';
                } else {
                    // TODO: Lưu tin nhắn vào database hoặc gửi email
                    $success = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.';
                    
                    // Reset form
                    $_POST = [];
                }
            }
        }
        
        include 'views/contact.php';
    }
}
?>
