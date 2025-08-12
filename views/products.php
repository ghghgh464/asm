<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar danh mục -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục sản phẩm</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="?action=products" class="text-decoration-none <?php echo !$category_id ? 'fw-bold text-primary' : ''; ?>">
                                Tất cả sản phẩm
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                        <li class="mb-2">
                            <a href="?action=products&category=<?php echo $cat['id']; ?>" 
                               class="text-decoration-none <?php echo $category_id == $cat['id'] ? 'fw-bold text-primary' : ''; ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <?php if ($category_id && $current_category): ?>
                        <?php echo htmlspecialchars($current_category['name']); ?>
                    <?php else: ?>
                        Tất cả sản phẩm
                    <?php endif; ?>
                </h2>
                <div class="d-flex gap-2">
                    <select class="form-select" id="sort-select">
                        <option value="newest">Mới nhất</option>
                        <option value="price-low">Giá thấp đến cao</option>
                        <option value="price-high">Giá cao đến thấp</option>
                        <option value="name">Tên A-Z</option>
                    </select>
                </div>
            </div>

            <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                <p class="text-muted">Vui lòng thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác.</p>
            </div>
            <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-image-container">
                            <img src="<?php echo $product['image'] ?: asset('images/placeholder.jpg'); ?>" 
                                 class="card-img-top product-image" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                            <div class="sale-badge">Sale</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title product-title">
                                <a href="index.php?action=product&id=<?php echo $product['id']; ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small mb-2">
                                <?php echo htmlspecialchars($product['category_name']); ?>
                            </p>
                            <p class="card-text product-description">
                                <?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?>
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-2">
                                    <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                    <span class="text-decoration-line-through text-muted me-2">
                                        <?php echo format_price($product['price']); ?>
                                    </span>
                                    <span class="text-danger fw-bold">
                                        <?php echo format_price($product['sale_price']); ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="fw-bold text-primary">
                                        <?php echo format_price($product['price']); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="index.php?action=product&id=<?php echo $product['id']; ?>" 
                                       class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                    <button class="btn btn-primary btn-sm" onclick="addToCart(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Phân trang -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Phân trang sản phẩm" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?action=products<?php echo $category_id ? '&category=' . $category_id : ''; ?>&page=<?php echo $current_page - 1; ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?action=products<?php echo $category_id ? '&category=' . $category_id : ''; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?action=products<?php echo $category_id ? '&category=' . $category_id : ''; ?>&page=<?php echo $current_page + 1; ?>">
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
// Xử lý sắp xếp sản phẩm
document.getElementById('sort-select').addEventListener('change', function() {
    const sort = this.value;
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    window.location.href = url.toString();
});

// Thêm vào giỏ hàng (placeholder)
function addToCart(productId) {
    showAlert('Đã thêm sản phẩm vào giỏ hàng!', 'success');
}
</script>

<?php include 'includes/footer.php'; ?>
