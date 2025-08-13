<?php
// Kiểm tra session và redirect TRƯỚC KHI có bất kỳ output nào
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu đã đăng nhập thì chuyển về trang chủ
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../Model/Database.php';
    
    try {
        $db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $conn = $db->getConnection();
        
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ thông tin!';
        } else {
            // Kiểm tra đăng nhập admin trước
            $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND is_active = 1");
            $stmt->execute([$username]);
            $adminUser = $stmt->fetch();
            
            if ($adminUser && password_verify($password, $adminUser['password'])) {
                // Đăng nhập admin
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $adminUser['id'];
                $_SESSION['admin_username'] = $adminUser['username'];
                header('Location: ../admin/dashboard.php');
                exit;
            } else {
                // Kiểm tra đăng nhập user thường
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Đăng nhập user
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
                }
            }
        }
    } catch (Exception $e) {
        $error = 'Có lỗi xảy ra, vui lòng thử lại!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - MMO Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1db954, #1ed760);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, #1db954, #1ed760);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h3 {
            margin: 0;
            font-weight: bold;
        }
        
        .login-body {
            padding: 40px;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-control:focus {
            border-color: #1db954;
            box-shadow: 0 0 0 0.2rem rgba(29, 185, 84, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1db954, #1ed760);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(29, 185, 84, 0.3);
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
        
        .password-field {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h3><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</h3>
                <p class="mb-0">MMO Services</p>
            </div>
            <div class="login-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="loginForm">
                    <div class="mb-4">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Tên đăng nhập
                        </label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu
                        </label>
                        <div class="password-field">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login text-white w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                </form>
                
                <div class="text-center">
                    <p class="mb-2">Chưa có tài khoản? 
                        <a href="?page=register" class="text-decoration-none fw-bold" style="color: #1db954;">
                            Đăng ký ngay
                        </a>
                    </p>
                    <a href="index.php" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Quay về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
    
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
