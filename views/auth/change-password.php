<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Sidebar profile -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="avatar-placeholder mb-2">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($user['fullname']); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
                            </div>
                            <hr>
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="?action=profile">
                                        <i class="fas fa-user me-2"></i>Thông tin cá nhân
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="?action=change-password">
                                        <i class="fas fa-key me-2"></i>Đổi mật khẩu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="?action=orders">
                                        <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="?action=logout">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </h5>
                        </div>
                        <div class="card-body">
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

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Lưu ý:</strong> Mật khẩu mới phải có ít nhất 8 ký tự và khác với mật khẩu hiện tại.
                            </div>

                            <form method="POST" action="?action=change-password" id="change-password-form">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password" 
                                               name="current_password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye" id="current_password-icon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="current_password-error"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" 
                                               name="new_password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                            <i class="fas fa-eye" id="new_password-icon"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <div class="password-strength mt-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar" id="password-strength-bar" role="progressbar"></div>
                                            </div>
                                            <small class="text-muted" id="password-strength-text">Độ mạnh mật khẩu</small>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" id="new_password-error"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_new_password" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_new_password" 
                                               name="confirm_new_password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_new_password')">
                                            <i class="fas fa-eye" id="confirm_new_password-icon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="confirm_new_password-error"></div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Đổi mật khẩu
                                    </button>
                                    <a href="?action=profile" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </a>
                                </div>
                            </form>

                            <!-- Hướng dẫn bảo mật -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-shield-alt me-2"></i>Hướng dẫn tạo mật khẩu mạnh
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li>Sử dụng ít nhất 8 ký tự</li>
                                        <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                                        <li>Tránh sử dụng thông tin cá nhân (tên, ngày sinh, số điện thoại)</li>
                                        <li>Không sử dụng mật khẩu giống với các tài khoản khác</li>
                                        <li>Thay đổi mật khẩu định kỳ (3-6 tháng một lần)</li>
                                    </ul>
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

// Kiểm tra độ mạnh mật khẩu
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 8) strength += 1;
    if (/[a-z]/.test(password)) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    
    switch (strength) {
        case 0:
        case 1:
            strengthBar.className = 'progress-bar bg-danger';
            strengthBar.style.width = '20%';
            feedback = 'Rất yếu';
            break;
        case 2:
            strengthBar.className = 'progress-bar bg-warning';
            strengthBar.style.width = '40%';
            feedback = 'Yếu';
            break;
        case 3:
            strengthBar.className = 'progress-bar bg-info';
            strengthBar.style.width = '60%';
            feedback = 'Trung bình';
            break;
        case 4:
            strengthBar.className = 'progress-bar bg-primary';
            strengthBar.style.width = '80%';
            feedback = 'Mạnh';
            break;
        case 5:
            strengthBar.className = 'progress-bar bg-success';
            strengthBar.style.width = '100%';
            feedback = 'Rất mạnh';
            break;
    }
    
    strengthText.textContent = feedback;
}

// Validation form
document.getElementById('change-password-form').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(field => {
        field.classList.remove('is-invalid');
    });
    
    // Validate current password
    const currentPassword = document.getElementById('current_password').value;
    if (currentPassword.length < 1) {
        showFieldError('current_password', 'Vui lòng nhập mật khẩu hiện tại');
        isValid = false;
    }
    
    // Validate new password
    const newPassword = document.getElementById('new_password').value;
    if (newPassword.length < 8) {
        showFieldError('new_password', 'Mật khẩu mới phải có ít nhất 8 ký tự');
        isValid = false;
    }
    
    // Validate confirm password
    const confirmPassword = document.getElementById('confirm_new_password').value;
    if (newPassword !== confirmPassword) {
        showFieldError('confirm_new_password', 'Mật khẩu xác nhận không khớp');
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

// Real-time password strength check
document.getElementById('new_password').addEventListener('input', function() {
    checkPasswordStrength(this.value);
    
    if (this.value.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

document.getElementById('confirm_new_password').addEventListener('blur', function() {
    const newPassword = document.getElementById('new_password').value;
    if (this.value === newPassword && newPassword.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
    }
});

// Reset password strength bar when form is reset
document.getElementById('change-password-form').addEventListener('reset', function() {
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    
    strengthBar.className = 'progress-bar';
    strengthBar.style.width = '0%';
    strengthText.textContent = 'Độ mạnh mật khẩu';
});
</script>

<style>
.avatar-placeholder {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.nav-pills .nav-link {
    color: #6c757d;
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

.nav-pills .nav-link:hover:not(.active) {
    background-color: #f8f9fa;
    color: #495057;
}

.password-strength .progress {
    background-color: #e9ecef;
}

.password-strength .progress-bar {
    transition: width 0.3s ease;
}
</style>

<?php include 'includes/footer.php'; ?>
