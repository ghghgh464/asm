<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMO Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['admin_logged_in']);
    $userType = '';
    $userName = '';
    
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        $userType = 'admin';
        $userName = $_SESSION['admin_username'] ?? 'Admin';
    } elseif (isset($_SESSION['user_id'])) {
        $userType = 'user';
        $userName = $_SESSION['username'] ?? 'User';
    }
    ?>
    
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="?page=home">MMO Services</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?page=home">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=product">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Tính năng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Liên hệ</a>
                        </li>
                    </ul>
                    <form class="d-flex me-3" id="searchForm">
                        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" id="searchInput">
                        <button class="btn btn-outline-light" type="submit">Tìm</button>
                    </form>
                    <div class="d-flex align-items-center">
                        <div class="theme-switch me-3" onclick="toggleTheme()">
                            <i class="fas fa-moon"></i>
                        </div>
                        <a href="?page=cart" class="btn btn-outline-light cart-badge me-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count" id="cartCount">0</span>
                        </a>
                        
                        <?php if ($isLoggedIn): ?>
                            <!-- Hiển thị thông tin người dùng đã đăng nhập -->
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>
                                    <?php echo htmlspecialchars($userName); ?>
                                    <?php if ($userType === 'admin'): ?>
                                        <span class="badge bg-danger ms-1">Admin</span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <?php if ($userType === 'admin'): ?>
                                        <li><a class="dropdown-item" href="admin/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="?page=profile"><i class="fas fa-user-edit me-2"></i>Hồ sơ</a></li>
                                    <li><a class="dropdown-item" href="?page=orders"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <!-- Hiển thị nút đăng nhập/đăng ký khi chưa đăng nhập -->
                            <a href="?page=login" class="btn btn-outline-light me-2">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                            <a href="?page=register" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Đăng ký
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    $('#searchForm').on('submit', function(e){
        e.preventDefault(); // Prevent default form submission
        var searchTerm = $('#searchInput').val();
        // Redirect to the search page with the search term
        window.location.href = '?page=search&term=' + encodeURIComponent(searchTerm);
    });
});
</script>
