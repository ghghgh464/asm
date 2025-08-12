<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-search me-2"></i>
                Kết quả tìm kiếm: "<?php echo htmlspecialchars($search_query); ?>"
            </h2>
            
            <div class="mb-4">
                <p class="text-muted">
                    Tìm thấy <strong><?php echo $total_results; ?></strong> kết quả 
                    trong <strong><?php echo $total_pages; ?></strong> trang
                </p>
            </div>

            <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                <p class="text-muted">
                    Không có sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($search_query); ?>"
                </p>
                <div class="mt-3">
                    <a href="?action=home" class="btn btn-primary me-2">
                        <i class="fas fa-home me-2"></i>Về trang chủ
                    </a>
                    <a href="?action=products" class="btn btn-outline-primary">
                        <i class="fas fa-th-large me-2"></i>Xem tất cả sản phẩm
                    </a>
                </div>
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
            <nav aria-label="Phân trang kết quả tìm kiếm" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?action=search&q=<?php echo urlencode($search_query); ?>&page=<?php echo $current_page - 1; ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?action=search&q=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?action=search&q=<?php echo urlencode($search_query); ?>&page=<?php echo $current_page + 1; ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>

            <!-- Gợi ý tìm kiếm -->
            <div class="mt-5">
                <h5>Gợi ý tìm kiếm:</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="index.php?action=products" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-th-large me-1"></i>Tất cả sản phẩm
                    </a>
                    <?php foreach ($suggested_categories ?? [] as $category): ?>
                    <a href="index.php?action=products&category=<?php echo $category['id']; ?>" 
                       class="btn btn-outline-secondary btn-sm">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Thêm vào giỏ hàng (placeholder)
function addToCart(productId) {
    showAlert('Đã thêm sản phẩm vào giỏ hàng!', 'success');
}
</script>

<?php include 'includes/footer.php'; ?>
