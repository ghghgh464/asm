<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    
    try {
        require_once 'Model/Database.php';
        $db = new Database('localhost', 'polyshop', 'root', '');
        $conn = $db->getConnection();
        
        // Xóa sản phẩm
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $result = $stmt->execute([$productId]);
        
        if ($result) {
            echo "<script>alert('Đã xóa sản phẩm ID: $productId'); window.location.href='check_products.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa sản phẩm'); window.location.href='check_products.php';</script>";
        }
        
    } catch (Exception $e) {
        echo "<script>alert('Lỗi: " . $e->getMessage() . "'); window.location.href='check_products.php';</script>";
    }
} else {
    header('Location: check_products.php');
    exit;
}
?>
