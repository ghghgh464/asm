<?php include '../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Quản lý sản phẩm</h1>
                <a href="index.php?action=products&subaction=add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>Sản phẩm đã được xóa thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra khi xóa sản phẩm!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Danh sách sản phẩm (<?php echo $totalProducts; ?> sản phẩm)</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có sản phẩm nào</h5>
                    <p class="text-muted">Hãy thêm sản phẩm đầu tiên để bắt đầu!</p>
                    <a href="index.php?action=products&subaction=add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Tồn kho</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td>
                                        <?php if ($product['image']): ?>
                                            <img src="../<?php echo $product['image']; ?>" 
                                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                            <?php if ($product['featured']): ?>
                                                <span class="badge bg-warning ms-2">Nổi bật</span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>
                                            <?php if (strlen($product['description']) > 100): ?>...<?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php 
                                        // Lấy tên danh mục từ category_id
                                        $category = $this->categoriesModel->getCategoryById($product['category_id']);
                                        echo $category ? htmlspecialchars($category['name']) : 'N/A';
                                        ?>
                                    </td>
                                    <td>
                                        <div>
                                            <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                                <span class="text-decoration-line-through text-muted">
                                                    <?php echo number_format($product['price'], 0, ',', '.'); ?>đ
                                                </span><br>
                                                <span class="text-danger fw-bold">
                                                    <?php echo number_format($product['sale_price'], 0, ',', '.'); ?>đ
                                                </span>
                                            <?php else: ?>
                                                <span class="fw-bold">
                                                    <?php echo number_format($product['price'], 0, ',', '.'); ?>đ
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $product['stock'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $product['stock']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $product['status'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $product['status'] ? 'Kích hoạt' : 'Ẩn'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="../index.php?action=product&id=<?php echo $product['id']; ?>" 
                                               class="btn btn-sm btn-outline-info" target="_blank" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?action=products&subaction=edit&id=<?php echo $product['id']; ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete(<?php echo $product['id']; ?>)" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=products&page=<?php echo $page - 1; ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?action=products&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=products&page=<?php echo $page + 1; ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(productId) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác!')) {
        window.location.href = 'index.php?action=products&subaction=delete&id=' + productId;
    }
}

// Search functionality
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchInput').value.trim();
    if (searchTerm) {
        window.location.href = '../index.php?action=search&q=' + encodeURIComponent(searchTerm);
    }
});

document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('searchBtn').click();
    }
});
</script>

<?php include '../../includes/admin_footer.php'; ?>
