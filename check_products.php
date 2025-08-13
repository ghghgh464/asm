<?php
// Kiểm tra sản phẩm hiện tại
echo "<h2>📦 Sản phẩm hiện tại trong database</h2>";

try {
    require_once 'Model/Database.php';
    $db = new Database('localhost', 'polyshop', 'root', '');
    $conn = $db->getConnection();
    
    // Lấy tất cả sản phẩm
    $stmt = $conn->query("SELECT id, name, price, description, image, status, featured FROM products ORDER BY id");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'>";
    echo "<th>ID</th><th>Tên</th><th>Giá</th><th>Ảnh</th><th>Status</th><th>Featured</th><th>Thao tác</th>";
    echo "</tr>";
    
    foreach ($products as $product) {
        echo "<tr>";
        echo "<td>{$product['id']}</td>";
        echo "<td>{$product['name']}</td>";
        echo "<td>{$product['price']} VND</td>";
        echo "<td>{$product['image']}</td>";
        echo "<td>{$product['status']}</td>";
        echo "<td>{$product['featured']}</td>";
        echo "<td>";
        echo "<button onclick='deleteProduct({$product['id']})' style='background: red; color: white; border: none; padding: 5px; cursor: pointer;'>Xóa</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<h3>Xóa sản phẩm không cần thiết:</h3>";
    echo "<p>Click nút 'Xóa' để xóa sản phẩm không muốn giữ lại.</p>";
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
?>

<script>
function deleteProduct(id) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm ID ' + id + '?')) {
        // Tạo form để xóa
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'delete_product.php';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product_id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
