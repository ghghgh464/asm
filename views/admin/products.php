<?php
$pageTitle = 'Quản lý sản phẩm';
include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/header.php';
?>
<div class="container mt-5">
    <h2 class="mb-4">Quản lý sản phẩm</h2>
    <a href="?action=add-product" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hình ảnh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo number_format($product['price']); ?> đ</td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td><img src="/tf/uploads/<?php echo $product['image']; ?>" width="60"></td>
                <td>
                    <a href="?action=edit-product&id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                    <a href="?action=delete-product&id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"><i class="fas fa-trash"></i> Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/footer.php'; ?>
