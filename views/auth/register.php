<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Đăng ký tài khoản
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="?action=register" id="register-form">
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

                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo old('username'); ?>" required>
                            <div class="form-text">Tên đăng nhập phải từ 3-20 ký tự, chỉ chứa chữ cái, số và dấu gạch dưới</div>
                            <div class="invalid-feedback" id="username-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo old('email'); ?>" required>
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo old('phone'); ?>" placeholder="0123456789">
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="2" 
                                      placeholder="Nhập địa chỉ của bạn"><?php echo old('address'); ?></textarea>
                            <div class="invalid-feedback" id="address-error"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự</div>
                                <div class="invalid-feedback" id="password-error"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                        <i class="fas fa-eye" id="confirm_password-icon"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="confirm_password-error"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và 
                                    <a href="#" class="text-decoration-none">Chính sách bảo mật</a> <span class="text-danger">*</span>
                                </label>
                                <div class="invalid-feedback" id="agree_terms-error"></div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="register-btn">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Đã có tài khoản? 
                                <a href="?action=login" class="text-decoration-none">Đăng nhập ngay</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle hiển thị mật khẩu
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validation form
document.getElementById('register-form').addEventListener('submit', function(e) {
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
    
    // Validate username
    const username = document.getElementById('username').value.trim();
    if (username.length < 3 || username.length > 20) {
        showFieldError('username', 'Tên đăng nhập phải từ 3-20 ký tự');
        isValid = false;
    } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        showFieldError('username', 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới');
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
    
    // Validate password
    const password = document.getElementById('password').value;
    if (password.length < 8) {
        showFieldError('password', 'Mật khẩu phải có ít nhất 8 ký tự');
        isValid = false;
    }
    
    // Validate confirm password
    const confirmPassword = document.getElementById('confirm_password').value;
    if (password !== confirmPassword) {
        showFieldError('confirm_password', 'Mật khẩu xác nhận không khớp');
        isValid = false;
    }
    
    // Validate terms
    if (!document.getElementById('agree_terms').checked) {
        showFieldError('agree_terms', 'Bạn phải đồng ý với điều khoản sử dụng');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
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
document.getElementById('username').addEventListener('blur', function() {
    const username = this.value.trim();
    if (username.length >= 3 && username.length <= 20 && /^[a-zA-Z0-9_]+$/.test(username)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('email').addEventListener('blur', function() {
    const email = this.value.trim();
    if (isValidEmail(email)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('password').addEventListener('blur', function() {
    if (this.value.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('confirm_password').addEventListener('blur', function() {
    const password = document.getElementById('password').value;
    if (this.value === password && password.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
