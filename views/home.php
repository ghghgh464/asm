<?php 
$pageTitle = 'Trang chủ - PolyShop';
include 'includes/header.php'; 
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Chào mừng đến với PolyShop</h1>
                <p class="lead mb-4">
                    Khám phá bộ sưu tập sản phẩm điện tử chất lượng cao với giá cả hợp lý. 
                    Chúng tôi cam kết mang đến trải nghiệm mua sắm tốt nhất cho bạn.
                </p>
                <a href="index.php?action=products" class="btn btn-light btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-placeholder bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <div class="text-center">
                        <i class="fas fa-store fa-5x text-primary mb-3"></i>
                        <h4 class="text-muted">PolyShop</h4>
                        <p class="text-muted">Cửa hàng điện tử uy tín</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Danh mục sản phẩm</h2>
        <div class="row">
            <?php foreach ($categories as $category): ?>
            <div class="col-md-4 col-lg-2 mb-3">
                <a href="index.php?action=products&category=<?php echo $category['id']; ?>" 
                   class="text-decoration-none">
                    <div class="card text-center h-100 category-card">
                        <div class="card-body">
                            <?php
                            $icon = 'fa-box';
                            switch(strtolower($category['name'])) {
                                case 'điện thoại':
                                    $icon = 'fa-mobile-alt';
                                    break;
                                case 'laptop':
                                    $icon = 'fa-laptop';
                                    break;
                                case 'máy tính bảng':
                                    $icon = 'fa-tablet-alt';
                                    break;
                                case 'phụ kiện':
                                    $icon = 'fa-headphones';
                                    break;
                                case 'đồng hồ thông minh':
                                    $icon = 'fa-clock';
                                    break;
                            }
                            ?>
                            <i class="fas <?php echo $icon; ?> fa-3x text-primary mb-3"></i>
                            <h6 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
        <div class="row">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 product-card">
                    <img src="<?php echo $product['image'] ? 'uploads/' . $product['image'] : asset('images/no-image.png'); ?>" 
                         class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                        <p class="card-text text-muted small"><?php echo htmlspecialchars($product['category_name']); ?></p>
                        <div class="mt-auto">
                            <?php if ($product['sale_price']): ?>
                                <span class="text-decoration-line-through text-muted me-2">
                                    <?php echo number_format($product['price']); ?>đ
                                </span>
                                <span class="text-danger fw-bold">
                                    <?php echo number_format($product['sale_price']); ?>đ
                                </span>
                            <?php else: ?>
                                <span class="fw-bold text-primary">
                                    <?php echo number_format($product['price']); ?>đ
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="index.php?action=product&id=<?php echo $product['id']; ?>" 
                           class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="index.php?action=products" class="btn btn-outline-primary">
                Xem tất cả sản phẩm <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="latest-products mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Sản phẩm mới nhất</h2>
        <div class="row">
            <?php foreach ($latestProducts as $product): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 product-card">
                    <img src="<?php echo $product['image'] ? 'uploads/' . $product['image'] : asset('images/no-image.png'); ?>" 
                         class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                        <p class="card-text text-muted small"><?php echo htmlspecialchars($product['category_name']); ?></p>
                        <div class="mt-auto">
                            <?php if ($product['sale_price']): ?>
                                <span class="text-decoration-line-through text-muted me-2">
                                    <?php echo number_format($product['price']); ?>đ
                                </span>
                                <span class="text-danger fw-bold">
                                    <?php echo number_format($product['sale_price']); ?>đ
                                </span>
                            <?php else: ?>
                                <span class="fw-bold text-primary">
                                    <?php echo number_format($product['price']); ?>đ
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="index.php?action=product&id=<?php echo $product['id']; ?>" 
                           class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4">Về PolyShop</h2>
                <p class="lead mb-4">
                    PolyShop là cửa hàng điện tử uy tín, chuyên cung cấp các sản phẩm công nghệ 
                    chất lượng cao từ các thương hiệu nổi tiếng trên thế giới.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sản phẩm chính hãng 100%</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Giá cả cạnh tranh</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Dịch vụ khách hàng 24/7</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Bảo hành chính hãng</li>
                </ul>
                <a href="index.php?action=about" class="btn btn-outline-primary">
                    <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="about-placeholder bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <div class="text-center">
                        <i class="fas fa-info-circle fa-4x text-primary mb-3"></i>
                        <h5 class="text-muted">Thông tin về chúng tôi</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section mb-5">
    <div class="container">
        <div class="text-center">
            <h2 class="mb-4">Liên hệ với chúng tôi</h2>
            <p class="lead mb-4">
                Bạn có câu hỏi hoặc cần hỗ trợ? Hãy liên hệ với chúng tôi để được tư vấn tốt nhất.
            </p>
            <a href="index.php?action=contact" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope me-2"></i>Liên hệ ngay
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
