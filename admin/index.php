<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MMO Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h3><i class="fas fa-user-shield me-2"></i>Admin Panel</h3>
                <p class="mb-0">MMO Services</p>
            </div>
            <div class="login-body">
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger mb-4"><i class="fas fa-exclamation-triangle me-2"></i>' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="controllers/auth.php" method="POST" id="loginForm">
                    <div class="mb-4">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Tên đăng nhập
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-login text-white w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="../" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Quay về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        
        if (!username || !password) {
            e.preventDefault();
            alert('Vui lòng nhập đầy đủ thông tin đăng nhập!');
            return false;
        }
    });
    </script>
</body>
</html>
