<?php
$pageTitle = 'Sửa sản phẩm';
include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/header.php';
?>
<div class="container mt-5">
    <h2 class="mb-4">Sửa sản phẩm</h2>
    <form method="POST" action="?action=edit-product&id=<?php echo $product['id']; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="/tf/uploads/<?php echo $product['image']; ?>" width="80" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/footer.php'; ?>
