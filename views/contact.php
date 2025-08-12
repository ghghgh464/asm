<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3">Liên hệ với chúng tôi</h1>
                <p class="lead text-muted">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin liên hệ -->
        <div class="col-lg-4 mb-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Thông tin liên hệ</h4>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Địa chỉ</h6>
                                <p class="text-muted mb-0">
                                    123 Đường ABC, Quận 1<br>
                                    Thành phố Hồ Chí Minh, Việt Nam
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone fa-2x text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Điện thoại</h6>
                                <p class="text-muted mb-0">
                                    <a href="tel:+84123456789" class="text-decoration-none">+84 123 456 789</a><br>
                                    <a href="tel:+84987654321" class="text-decoration-none">+84 987 654 321</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope fa-2x text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">
                                    <a href="mailto:info@polyshop.com" class="text-decoration-none">info@polyshop.com</a><br>
                                    <a href="mailto:support@polyshop.com" class="text-decoration-none">support@polyshop.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Giờ làm việc</h6>
                                <p class="text-muted mb-0">
                                    Thứ 2 - Thứ 6: 8:00 - 18:00<br>
                                    Thứ 7: 8:00 - 12:00<br>
                                    Chủ nhật: Nghỉ
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-globe fa-2x text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Website</h6>
                                <p class="text-muted mb-0">
                                    <a href="https://polyshop.com" class="text-decoration-none" target="_blank">www.polyshop.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form liên hệ -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Gửi tin nhắn cho chúng tôi</h4>
                    
                    <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="?action=contact" id="contact-form">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" 
                                       value="<?php echo old('firstname'); ?>" required>
                                <div class="invalid-feedback" id="firstname-error"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" 
                                       value="<?php echo old('lastname'); ?>" required>
                                <div class="invalid-feedback" id="lastname-error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo old('email'); ?>" required>
                                <div class="invalid-feedback" id="email-error"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo old('phone'); ?>" placeholder="0123456789">
                                <div class="invalid-feedback" id="phone-error"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Chọn chủ đề</option>
                                <option value="general" <?php echo old('subject') === 'general' ? 'selected' : ''; ?>>Thông tin chung</option>
                                <option value="product" <?php echo old('subject') === 'product' ? 'selected' : ''; ?>>Thông tin sản phẩm</option>
                                <option value="order" <?php echo old('subject') === 'order' ? 'selected' : ''; ?>>Đơn hàng</option>
                                <option value="support" <?php echo old('subject') === 'support' ? 'selected' : ''; ?>>Hỗ trợ kỹ thuật</option>
                                <option value="complaint" <?php echo old('subject') === 'complaint' ? 'selected' : ''; ?>>Khiếu nại</option>
                                <option value="other" <?php echo old('subject') === 'other' ? 'selected' : ''; ?>>Khác</option>
                            </select>
                            <div class="invalid-feedback" id="subject-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Nhập nội dung tin nhắn của bạn..." required><?php echo old('message'); ?></textarea>
                            <div class="invalid-feedback" id="message-error"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree_contact" name="agree_contact" required>
                                <label class="form-check-label" for="agree_contact">
                                    Tôi đồng ý với <a href="#" class="text-decoration-none">Chính sách bảo mật</a> 
                                    và cho phép PolyShop liên hệ lại <span class="text-danger">*</span>
                                </label>
                                <div class="invalid-feedback" id="agree_contact-error"></div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bản đồ và thông tin bổ sung -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Vị trí của chúng tôi</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="map-placeholder mb-3">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center">
                                        <i class="fas fa-map fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Bản đồ sẽ được hiển thị ở đây</h5>
                                        <p class="text-muted">Tích hợp Google Maps hoặc OpenStreetMap</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h6>Hướng dẫn đường đi:</h6>
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2">
                                    <i class="fas fa-car me-2"></i>
                                    Từ trung tâm thành phố: 15 phút
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-bus me-2"></i>
                                    Xe buýt: Tuyến 01, 02, 03
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-subway me-2"></i>
                                    Metro: Ga A, Ga B
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-taxi me-2"></i>
                                    Taxi: Có sẵn 24/7
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Câu hỏi thường gặp</h4>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    Làm thế nào để đặt hàng trực tuyến?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể đặt hàng trực tuyến bằng cách chọn sản phẩm, thêm vào giỏ hàng và thanh toán. 
                                    Chúng tôi hỗ trợ nhiều phương thức thanh toán khác nhau.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    Thời gian giao hàng là bao lâu?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Thời gian giao hàng phụ thuộc vào địa điểm và phương thức vận chuyển. 
                                    Thông thường từ 1-3 ngày làm việc trong nội thành.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    Có thể đổi trả sản phẩm không?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, chúng tôi chấp nhận đổi trả sản phẩm trong vòng 30 ngày kể từ ngày mua 
                                    với điều kiện sản phẩm còn nguyên vẹn và đầy đủ phụ kiện.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation form
document.getElementById('contact-form').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(field => {
        field.classList.remove('is-invalid');
    });
    
    // Validate firstname
    const firstname = document.getElementById('firstname').value.trim();
    if (firstname.length < 2) {
        showFieldError('firstname', 'Họ phải có ít nhất 2 ký tự');
        isValid = false;
    }
    
    // Validate lastname
    const lastname = document.getElementById('lastname').value.trim();
    if (lastname.length < 2) {
        showFieldError('lastname', 'Tên phải có ít nhất 2 ký tự');
        isValid = false;
    }
    
    // Validate email
    const email = document.getElementById('email').value.trim();
    if (!isValidEmail(email)) {
        showFieldError('email', 'Email không hợp lệ');
        isValid = false;
    }
    
    // Validate phone
    const phone = document.getElementById('phone').value.trim();
    if (phone && !/^[0-9]{10,11}$/.test(phone)) {
        showFieldError('phone', 'Số điện thoại không hợp lệ');
        isValid = false;
    }
    
    // Validate subject
    const subject = document.getElementById('subject').value;
    if (!subject) {
        showFieldError('subject', 'Vui lòng chọn chủ đề');
        isValid = false;
    }
    
    // Validate message
    const message = document.getElementById('message').value.trim();
    if (message.length < 10) {
        showFieldError('message', 'Nội dung tin nhắn phải có ít nhất 10 ký tự');
        isValid = false;
    }
    
    // Validate terms
    if (!document.getElementById('agree_contact').checked) {
        showFieldError('agree_contact', 'Bạn phải đồng ý với chính sách bảo mật');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    } else {
        // Disable submit button to prevent double submission
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('submit-btn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
    }
});

// Hiển thị lỗi cho field
function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + '-error');
    
    field.classList.add('is-invalid');
    if (errorDiv) {
        errorDiv.textContent = message;
    }
}

// Kiểm tra email hợp lệ
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Real-time validation
document.getElementById('firstname').addEventListener('blur', function() {
    if (this.value.trim().length >= 2) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('lastname').addEventListener('blur', function() {
    if (this.value.trim().length >= 2) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('email').addEventListener('blur', function() {
    if (isValidEmail(this.value.trim())) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('phone').addEventListener('blur', function() {
    const phone = this.value.trim();
    if (!phone || /^[0-9]{10,11}$/.test(phone)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('message').addEventListener('blur', function() {
    if (this.value.trim().length >= 10) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});
</script>

<style>
.contact-icon {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.contact-item {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.contact-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.map-placeholder {
    width: 100%;
    height: 300px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 2px dashed #dee2e6;
}

.accordion-button:not(.collapsed) {
    background-color: #e7f1ff;
    color: #0d6efd;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<?php include 'includes/footer.php'; ?>
