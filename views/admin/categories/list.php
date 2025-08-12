<?php include '../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Quản lý danh mục</h1>
                <a href="index.php?action=categories&subaction=add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm danh mục mới
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>Danh mục đã được xóa thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra khi xóa danh mục!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Danh sách danh mục (<?php echo count($categories); ?> danh mục)</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm danh mục..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($categories)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có danh mục nào</h5>
                    <p class="text-muted">Hãy thêm danh mục đầu tiên để bắt đầu!</p>
                    <a href="index.php?action=categories&subaction=add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm danh mục
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Số sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td>
                                        <div>
                                            <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo htmlspecialchars(substr($category['description'] ?? '', 0, 100)); ?>
                                            <?php if (strlen($category['description'] ?? '') > 100): ?>...<?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo $category['product_count'] ?? 0; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo ($category['status'] ?? 1) ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ($category['status'] ?? 1) ? 'Kích hoạt' : 'Ẩn'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('d/m/Y', strtotime($category['created_at'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="index.php?action=categories&subaction=edit&id=<?php echo $category['id']; ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete(<?php echo $category['id']; ?>)" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(categoryId) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác!')) {
        window.location.href = 'index.php?action=categories&subaction=delete&id=' + categoryId;
    }
}

// Search functionality
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchInput').value.trim();
    if (searchTerm) {
        // Filter table rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const description = row.cells[2].textContent.toLowerCase();
            if (name.includes(searchTerm.toLowerCase()) || description.includes(searchTerm.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    } else {
        // Show all rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => row.style.display = '');
    }
});

document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('searchBtn').click();
    }
});
</script>

<?php include '../../includes/admin_footer.php'; ?>
