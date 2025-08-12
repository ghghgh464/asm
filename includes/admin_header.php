<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PolyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #4e73df;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            border-radius: 0.35rem;
            margin: 0.2rem 0;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.2);
        }
        .main-content {
            margin-left: 250px;
        }
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .text-gray-300 {
            color: #dddfeb !important;
        }
        .text-gray-800 {
            color: #5a5c69 !important;
        }
        .text-xs {
            font-size: 0.7rem;
        }
        .font-weight-bold {
            font-weight: 700 !important;
        }
        .text-uppercase {
            text-transform: uppercase !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar position-fixed" style="width: 250px;">
        <div class="text-center py-4">
            <h4 class="text-white">
                <i class="fas fa-store me-2"></i>PolyShop Admin
            </h4>
        </div>
        
        <nav class="nav flex-column px-3">
            <a class="nav-link <?php echo ($_GET['action'] ?? 'index') === 'index' ? 'active' : ''; ?>" href="index.php">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'products' ? 'active' : ''; ?>" href="index.php?action=products">
                <i class="fas fa-box me-2"></i>Quản lý sản phẩm
            </a>
            <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'categories' ? 'active' : ''; ?>" href="index.php?action=categories">
                <i class="fas fa-tags me-2"></i>Quản lý danh mục
            </a>
            <a class="nav-link" href="../index.php" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>Xem website
            </a>
            <a class="nav-link" href="../index.php?action=logout">
                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['fullname']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../index.php?action=profile">
                                <i class="fas fa-user-edit me-2"></i>Thông tin cá nhân
                            </a></li>
                            <li><a class="dropdown-item" href="../index.php?action=change-password">
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../index.php?action=logout">
                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid py-4">
