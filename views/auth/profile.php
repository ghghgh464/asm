<?php include 'includes/header.php'; ?>

<div class="container mt-4">
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
                            <a class="nav-link active" href="?action=profile">
                                <i class="fas fa-user me-2"></i>Thông tin cá nhân
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=change-password">
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
                        <i class="fas fa-user-edit me-2"></i>Thông tin cá nhân
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

                    <form method="POST" action="?action=profile" id="profile-form">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" 
                                       value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>" required>
                                <div class="invalid-feedback" id="firstname-error"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" 
                                       value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>" required>
                                <div class="invalid-feedback" id="lastname-error"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                            <div class="form-text">Tên đăng nhập không thể thay đổi</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="0123456789">
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Nhập địa chỉ của bạn"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            <div class="invalid-feedback" id="address-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="birthday" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" 
                                   value="<?php echo $user['birthday'] ?? ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giới tính</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-male" 
                                           value="male" <?php echo ($user['gender'] ?? '') === 'male' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="gender-male">Nam</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-female" 
                                           value="female" <?php echo ($user['gender'] ?? '') === 'female' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="gender-female">Nữ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-other" 
                                           value="other" <?php echo ($user['gender'] ?? '') === 'other' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="gender-other">Khác</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật thông tin
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-2"></i>Khôi phục
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin bổ sung</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Ngày tham gia:</strong> 
                                <?php echo format_date($user['created_at']); ?>
                            </p>
                            <p class="mb-2">
                                <strong>Lần cập nhật cuối:</strong> 
                                <?php echo $user['updated_at'] ? format_date($user['updated_at']) : 'Chưa cập nhật'; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Trạng thái:</strong> 
                                <?php if ($user['status'] === 'active'): ?>
                                <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                <span class="badge bg-warning">Chờ kích hoạt</span>
                                <?php endif; ?>
                            </p>
                            <p class="mb-2">
                                <strong>Vai trò:</strong> 
                                <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge bg-danger">Quản trị viên</span>
                                <?php else: ?>
                                <span class="badge bg-primary">Người dùng</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation form
document.getElementById('profile-form').addEventListener('submit', function(e) {
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
</style>

<?php include 'includes/footer.php'; ?>
