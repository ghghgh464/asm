<?php
$pageTitle = 'Thêm sản phẩm mới';
include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/header.php';
?>
<div class="container mt-5">
    <h2 class="mb-4">Thêm sản phẩm mới</h2>
    <form method="POST" action="?action=add-product" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/tf/includes/footer.php'; ?>
