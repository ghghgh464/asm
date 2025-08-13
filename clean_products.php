<?php
// Xóa sản phẩm điện tử, chỉ giữ sản phẩm gốc
echo "<h2>🧹 Dọn dẹp sản phẩm - PolyShop</h2>";

try {
    require_once 'Model/Database.php';
    $db = new Database('localhost', 'polyshop', 'root', '');
    $conn = $db->getConnection();
    
    // Xóa tất cả sản phẩm điện tử (ID 1-12)
    $stmt = $conn->prepare("DELETE FROM products WHERE id BETWEEN 1 AND 12");
    $result = $stmt->execute();
    
    if ($result) {
        echo "✅ Đã xóa 12 sản phẩm điện tử<br>";
        
        // Kiểm tra sản phẩm còn lại
        $stmt = $conn->query("SELECT COUNT(*) as count FROM products");
        $remainingCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "✅ Sản phẩm còn lại: {$remainingCount}<br>";
        
        // Hiển thị sản phẩm còn lại
        $stmt = $conn->query("SELECT * FROM products ORDER BY id");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($products)) {
            echo "<h3>📦 Sản phẩm còn lại:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'>";
            echo "<th>ID</th><th>Tên</th><th>Giá</th><th>Ảnh</th><th>Status</th><th>Featured</th>";
            echo "</tr>";
            
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>{$product['id']}</td>";
                echo "<td>{$product['name']}</td>";
                echo "<td>{$product['price']} VND</td>";
                echo "<td>{$product['image']}</td>";
                echo "<td>{$product['status']}</td>";
                echo "<td>{$product['featured']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "<hr>";
        echo "<h3 style='color: green;'>🎉 Đã dọn dẹp xong!</h3>";
        echo "<p><strong>Bây giờ hãy:</strong></p>";
        echo "<ol>";
        echo "<li><a href='index.php' target='_blank'>🏠 Xem trang chủ</a> - Chỉ hiển thị sản phẩm gốc</li>";
        echo "<li><a href='admin/' target='_blank'>⚙️ Vào admin panel</a> - Đăng nhập với admin/admin1234</li>";
        echo "</ol>";
        
    } else {
        echo "❌ Lỗi khi xóa sản phẩm";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
?>
