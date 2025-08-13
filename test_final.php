<?php
// Test cuối cùng - PolyShop
echo "<h2>🧪 Test Cuối Cùng - PolyShop</h2>";

try {
    // 1. Test database connection
    require_once 'Model/Database.php';
    $db = new Database('localhost', 'polyshop', 'root', '');
    $conn = $db->getConnection();
    echo "✅ Database: OK<br>";
    
    // 2. Test sản phẩm
    $stmt = $conn->query("SELECT COUNT(*) as count FROM products WHERE status = 1 AND featured = 1");
    $featuredCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "✅ Sản phẩm nổi bật: {$featuredCount}<br>";
    
    // 3. Test ảnh
    $stmt = $conn->query("SELECT COUNT(*) as count FROM products WHERE image IS NOT NULL AND image != ''");
    $imageCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "✅ Sản phẩm có ảnh: {$imageCount}<br>";
    
    // 4. Test admin user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->execute(['admin', 'admin']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin && password_verify('admin1234', $admin['password'])) {
        echo "✅ Admin user: OK (admin/admin1234)<br>";
    } else {
        echo "❌ Admin user: Lỗi<br>";
    }
    
    // 5. Test categories
    $stmt = $conn->query("SELECT COUNT(*) as count FROM categories WHERE status = 1");
    $catCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "✅ Categories: {$catCount}<br>";
    
    // 6. Test file ảnh
    if (is_dir('uploads')) {
        $imageFiles = glob('uploads/*.jpg');
        echo "✅ File ảnh: " . count($imageFiles) . " files<br>";
    } else {
        echo "❌ Thư mục uploads: Không tồn tại<br>";
    }
    
    echo "<hr>";
    
    if ($featuredCount > 0 && $imageCount > 0 && $admin) {
        echo "<h3 style='color: green;'>🎉 TẤT CẢ ĐÃ HOẠT ĐỘNG!</h3>";
        echo "<p><strong>Bây giờ hãy:</strong></p>";
        echo "<ol>";
        echo "<li><a href='index.php' target='_blank'>🏠 Xem trang chủ</a> - Sẽ hiển thị sản phẩm với ảnh</li>";
        echo "<li><a href='admin/' target='_blank'>⚙️ Vào admin panel</a> - Đăng nhập với admin/admin1234</li>";
        echo "<li><a href='admin/dashboard.php' target='_blank'>📊 Xem dashboard</a> - Thống kê và biểu đồ</li>";
        echo "</ol>";
        
        echo "<p><strong>Thông tin đăng nhập:</strong></p>";
        echo "<ul>";
        echo "<li><strong>Username:</strong> admin</li>";
        echo "<li><strong>Password:</strong> admin1234</li>";
        echo "<li><strong>Role:</strong> admin</li>";
        echo "</ul>";
        
        echo "<p><strong>Xóa file này sau khi kiểm tra xong!</strong></p>";
        
    } else {
        echo "<h3 style='color: red;'>❌ VẪN CÓ VẤN ĐỀ!</h3>";
        echo "<p>Hãy kiểm tra lại database và file cấu hình.</p>";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
?>
