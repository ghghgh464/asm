<?php include '../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Thêm danh mục mới</h1>
                <a href="index.php?action=categories" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin danh mục</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="add-category-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo $_POST['name'] ?? ''; ?>" required>
                            <div class="form-text">Tên danh mục phải rõ ràng, dễ hiểu</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả danh mục</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                      placeholder="Nhập mô tả chi tiết về danh mục..."><?php echo $_POST['description'] ?? ''; ?></textarea>
                            <div class="form-text">Mô tả giúp người dùng hiểu rõ hơn về danh mục</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" 
                                       <?php echo isset($_POST['status']) ? 'checked' : 'checked'; ?>>
                                <label class="form-check-label" for="status">
                                    Kích hoạt danh mục
                                </label>
                                <div class="form-text">Danh mục sẽ hiển thị trên website khi được kích hoạt</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary me-md-2">
                                <i class="fas fa-undo me-2"></i>Làm mới
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu danh mục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Hướng dẫn</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <strong>Tên danh mục:</strong> Nhập tên rõ ràng, dễ hiểu
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <strong>Mô tả:</strong> Viết mô tả chi tiết, hấp dẫn
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <strong>Trạng thái:</strong> Chọn để hiển thị hoặc ẩn danh mục
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <strong>Lưu ý:</strong> Danh mục đã có sản phẩm không thể xóa
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('add-category-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            
            if (!name) {
                e.preventDefault();
                alert('Vui lòng nhập tên danh mục!');
                return;
            }
            
            if (name.length < 2) {
                e.preventDefault();
                alert('Tên danh mục phải có ít nhất 2 ký tự!');
                return;
            }
        });
    }
});
</script>

<?php include '../../includes/admin_footer.php'; ?>
