<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=home">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="index.php?action=products">Sản phẩm</a></li>
            <?php if ($product['category_name']): ?>
            <li class="breadcrumb-item">
                <a href="index.php?action=products&category=<?php echo $product['category_id']; ?>">
                    <?php echo htmlspecialchars($product['category_name']); ?>
                </a>
            </li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo htmlspecialchars($product['name']); ?>
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-lg-6">
            <div class="product-image-container">
                <img src="<?php echo $product['image'] ?: asset('images/placeholder.jpg'); ?>" 
                     class="img-fluid rounded product-detail-image" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                <div class="sale-badge-large">Sale</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-lg-6">
            <h1 class="h2 mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="mb-3">
                <span class="text-muted">Danh mục: </span>
                <a href="index.php?action=products&category=<?php echo $product['category_id']; ?>" 
                   class="text-decoration-none">
                    <?php echo htmlspecialchars($product['category_name']); ?>
                </a>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                    <span class="text-decoration-line-through text-muted me-3 fs-5">
                        <?php echo format_price($product['price']); ?>
                    </span>
                    <span class="text-danger fw-bold fs-3">
                        <?php echo format_price($product['sale_price']); ?>
                    </span>
                    <?php else: ?>
                    <span class="fw-bold text-primary fs-3">
                        <?php echo format_price($product['price']); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-muted mb-2">Tình trạng: 
                    <?php if ($product['stock'] > 0): ?>
                    <span class="text-success">Còn hàng (<?php echo $product['stock']; ?> sản phẩm)</span>
                    <?php else: ?>
                    <span class="text-danger">Hết hàng</span>
                    <?php endif; ?>
                </p>
            </div>

            <div class="mb-4">
                <h5>Mô tả sản phẩm:</h5>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <?php if ($product['stock'] > 0): ?>
            <div class="d-flex gap-3 mb-4">
                <div class="input-group" style="max-width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                </div>
                <button class="btn btn-primary btn-lg px-4" onclick="addToCart(<?php echo $product['id']; ?>)">
                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                </button>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Sản phẩm hiện tại đang hết hàng. Vui lòng liên hệ để được thông báo khi có hàng.
            </div>
            <?php endif; ?>

            <!-- Thông tin bổ sung -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">Thông tin bổ sung</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-tag me-2 text-muted"></i>
                            Mã sản phẩm: <strong><?php echo $product['id']; ?></strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar me-2 text-muted"></i>
                            Ngày tạo: <?php echo format_date($product['created_at']); ?>
                        </li>
                        <?php if ($product['featured']): ?>
                        <li class="mb-2">
                            <i class="fas fa-star me-2 text-warning"></i>
                            Sản phẩm nổi bật
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần bình luận -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Đánh giá & Bình luận</h3>
            
            <?php if (is_logged_in()): ?>
            <!-- Form bình luận -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Viết bình luận</h5>
                    <form id="comment-form">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Đánh giá:</label>
                            <div class="rating-input">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>">
                                <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="comment-content" class="form-label">Nội dung bình luận:</label>
                            <textarea class="form-control" id="comment-content" name="content" rows="3" 
                                      placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Gửi bình luận
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Vui lòng <a href="?action=login" class="alert-link">đăng nhập</a> để viết bình luận.
            </div>
            <?php endif; ?>

            <!-- Danh sách bình luận -->
            <div id="comments-section">
                <?php if (empty($comments)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có bình luận nào</h5>
                    <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                </div>
                <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($comment['user_fullname']); ?></h6>
                                <div class="rating-display">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo $i <= $comment['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <small class="text-muted">
                                <?php echo format_date($comment['created_at']); ?>
                            </small>
                        </div>
                        <p class="card-text mb-0"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Xử lý số lượng sản phẩm
function decreaseQuantity() {
    const input = document.getElementById('quantity');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    if (input.value < <?php echo $product['stock']; ?>) {
        input.value = parseInt(input.value) + 1;
    }
}

// Thêm vào giỏ hàng
function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    showAlert('Đã thêm ' + quantity + ' sản phẩm vào giỏ hàng!', 'success');
}

// Xử lý form bình luận
document.getElementById('comment-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Gửi bình luận bằng AJAX (placeholder)
    showAlert('Bình luận đã được gửi và đang chờ duyệt!', 'success');
    this.reset();
});

// Hiệu ứng hover cho rating
document.querySelectorAll('.rating-input label').forEach(label => {
    label.addEventListener('mouseenter', function() {
        const stars = this.parentElement.querySelectorAll('label');
        const currentStar = this;
        stars.forEach(star => {
            if (star === currentStar || star.previousElementSibling.checked) {
                star.querySelector('i').classList.add('text-warning');
            } else {
                star.querySelector('i').classList.remove('text-warning');
            }
        });
    });
});

document.querySelector('.rating-input').addEventListener('mouseleave', function() {
    const stars = this.querySelectorAll('label i');
    const checkedRating = this.querySelector('input:checked')?.value || 0;
    
    stars.forEach((star, index) => {
        if (index < checkedRating) {
            star.classList.add('text-warning');
        } else {
            star.classList.remove('text-warning');
        }
    });
});
</script>

<style>
.product-detail-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.sale-badge-large {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #dc3545;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
}

.rating-input {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input label {
    cursor: pointer;
    font-size: 24px;
    color: #ddd;
}

.rating-input label:hover,
.rating-input label:hover ~ label,
.rating-input input[type="radio"]:checked ~ label {
    color: #ffc107;
}

.rating-display {
    font-size: 14px;
}
</style>

<?php include 'includes/footer.php'; ?>
