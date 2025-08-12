<?php include '../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Chỉnh sửa sản phẩm</h1>
                <a href="index.php?action=products" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin sản phẩm</h5>
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

                    <form method="POST" enctype="multipart/form-data" id="edit-product-form">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" 
                                                <?php echo $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?php echo $product['price']; ?>" min="0" step="1000" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sale_price" class="form-label">Giá khuyến mãi (VNĐ)</label>
                                <input type="number" class="form-control" id="sale_price" name="sale_price" 
                                       value="<?php echo $product['sale_price'] ?? ''; ?>" min="0" step="1000">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Số lượng tồn kho</label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       value="<?php echo $product['stock']; ?>" min="0">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/*">
                                <div class="form-text">Hỗ trợ: JPG, JPEG, PNG, GIF, WEBP. Tối đa 5MB</div>
                                <?php if ($product['image']): ?>
                                    <div class="mt-2">
                                        <img src="../<?php echo $product['image']; ?>" 
                                             alt="Hình ảnh hiện tại" class="img-thumbnail" style="width: 100px;">
                                        <small class="text-muted d-block">Hình ảnh hiện tại</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                      placeholder="Nhập mô tả chi tiết về sản phẩm..."><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                           <?php echo $product['featured'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="featured">
                                        Sản phẩm nổi bật
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" 
                                           <?php echo $product['status'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="status">
                                        Kích hoạt sản phẩm
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary me-md-2">
                                <i class="fas fa-undo me-2"></i>Làm mới
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin bổ sung</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar text-info me-2"></i>
                            <strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($product['created_at'])); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-edit text-info me-2"></i>
                            <strong>Cập nhật lần cuối:</strong> 
                            <?php echo $product['updated_at'] ? date('d/m/Y H:i', strtotime($product['updated_at'])) : 'Chưa cập nhật'; ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-eye text-info me-2"></i>
                            <strong>Lượt xem:</strong> <?php echo $product['views'] ?? 0; ?>
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
    const form = document.getElementById('edit-product-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const category = document.getElementById('category_id').value;
            const price = document.getElementById('price').value;
            const salePrice = document.getElementById('sale_price').value;
            
            if (!name || !category || !price) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return;
            }
            
            if (parseFloat(price) <= 0) {
                e.preventDefault();
                alert('Giá sản phẩm phải lớn hơn 0!');
                return;
            }
            
            if (salePrice && parseFloat(salePrice) >= parseFloat(price)) {
                e.preventDefault();
                alert('Giá khuyến mãi phải nhỏ hơn giá gốc!');
                return;
            }
        });
    }
    
    // Price formatting
    const priceInputs = document.querySelectorAll('input[type="number"]');
    priceInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                this.value = parseInt(this.value);
            }
        });
    });
});
</script>

<?php include '../../includes/admin_footer.php'; ?>
