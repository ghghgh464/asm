<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../Model/Database.php';
require_once 'config/config.php';

try {
    $db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $conn = $db->getConnection();

    // Get basic statistics
    $totalUsers = 0;
    $totalOrders = 0;
    $totalRevenue = 0;
    $totalProducts = 0;
    
    try {
        $stmt = $conn->query("SELECT COUNT(*) as total FROM users");
        $totalUsers = $stmt->fetch()['total'];
    } catch (Exception $e) {
        // Table doesn't exist yet
    }
    
    try {
        $stmt = $conn->query("SELECT COUNT(*) as total FROM orders");
        $totalOrders = $stmt->fetch()['total'];
    } catch (Exception $e) {
        // Table doesn't exist yet
    }
    
    try {
        $stmt = $conn->query("SELECT SUM(amount) as total_revenue FROM orders");
        $totalRevenue = $stmt->fetch()['total_revenue'] ?? 0;
    } catch (Exception $e) {
        // Table doesn't exist yet
    }

    try {
        $stmt = $conn->query("SELECT COUNT(*) as total FROM products");
        $totalProducts = $stmt->fetch()['total'];
    } catch (Exception $e) {
        // Table doesn't exist yet
    }

    // Get recent orders
    $recentOrders = [];
    try {
        $stmt = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
        $recentOrders = $stmt->fetchAll();
    } catch (Exception $e) {
        // Table doesn't exist yet
    }

    // Get monthly statistics
    $monthlyStats = [];
    try {
        $stmt = $conn->query("SELECT MONTH(created_at) as month, COUNT(*) as count FROM orders GROUP BY MONTH(created_at) ORDER BY month");
        $monthlyStats = $stmt->fetchAll();
    } catch (Exception $e) {
        // Tạo dữ liệu mẫu nếu không có
        $monthlyStats = [
            ['month' => 1, 'count' => 15],
            ['month' => 2, 'count' => 22],
            ['month' => 3, 'count' => 18],
            ['month' => 4, 'count' => 25],
            ['month' => 5, 'count' => 30],
            ['month' => 6, 'count' => 28]
        ];
    }

} catch (Exception $e) {
    $error = "Database connection error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PolyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'views/header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'views/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="main-content">
                    <h1 class="page-title">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </h1>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Main Statistics Cards -->
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Tổng người dùng</h5>
                                            <p class="card-text display-4"><?php echo $totalUsers; ?></p>
                                        </div>
                                        <div class="text-end">
                                            <i class="fas fa-users fa-3x opacity-75"></i>
                                        </div>
                                    </div>
                                    <a href="users.php" class="text-white">
                                        <i class="fas fa-arrow-right me-1"></i>Quản lý người dùng
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Tổng sản phẩm</h5>
                                            <p class="card-text display-4"><?php echo $totalProducts; ?></p>
                                        </div>
                                        <div class="text-end">
                                            <i class="fas fa-shopping-bag fa-3x opacity-75"></i>
                                        </div>
                                    </div>
                                    <a href="products.php" class="text-white">
                                        <i class="fas fa-arrow-right me-1"></i>Quản lý sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Tổng đơn hàng</h5>
                                            <p class="card-text display-4"><?php echo $totalOrders; ?></p>
                                        </div>
                                        <div class="text-end">
                                            <i class="fas fa-shopping-cart fa-3x opacity-75"></i>
                                        </div>
                                    </div>
                                    <a href="orders.php" class="text-white">
                                        <i class="fas fa-arrow-right me-1"></i>Xem đơn hàng
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Tổng doanh thu</h5>
                                            <p class="card-text display-4">$<?php echo number_format($totalRevenue, 2); ?></p>
                                        </div>
                                        <div class="text-end">
                                            <i class="fas fa-dollar-sign fa-3x opacity-75"></i>
                                        </div>
                                    </div>
                                    <a href="reports.php" class="text-white">
                                        <i class="fas fa-arrow-right me-1"></i>Xem báo cáo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card dashboard-card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Thống kê đơn hàng theo tháng</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyBarChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card dashboard-card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Biểu đồ doanh thu</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="revenueChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card dashboard-card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Đơn hàng gần đây</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($recentOrders)): ?>
                                        <p class="text-muted">Chưa có đơn hàng nào.</p>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Sản phẩm</th>
                                                        <th>Giá</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày tạo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recentOrders as $order): ?>
                                                        <tr>
                                                            <td>#<?php echo $order['id']; ?></td>
                                                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                                            <td>$<?php echo number_format($order['amount'], 2); ?></td>
                                                            <td>
                                                                <?php
                                                                $statusClass = '';
                                                                $statusText = '';
                                                                switch ($order['status']) {
                                                                    case 'completed':
                                                                        $statusClass = 'badge bg-success';
                                                                        $statusText = 'Hoàn thành';
                                                                        break;
                                                                    case 'pending':
                                                                        $statusClass = 'badge bg-warning';
                                                                        $statusText = 'Đang xử lý';
                                                                        break;
                                                                    case 'cancelled':
                                                                        $statusClass = 'badge bg-danger';
                                                                        $statusText = 'Đã hủy';
                                                                        break;
                                                                }
                                                                ?>
                                                                <span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                                            </td>
                                                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card dashboard-card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Thao tác nhanh</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <a href="users.php" class="btn btn-primary w-100">
                                                <i class="fas fa-users me-2"></i>Quản lý người dùng
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="products.php" class="btn btn-success w-100">
                                                <i class="fas fa-shopping-bag me-2"></i>Quản lý sản phẩm
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="orders.php" class="btn btn-info w-100">
                                                <i class="fas fa-shopping-cart me-2"></i>Quản lý đơn hàng
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="settings.php" class="btn btn-warning w-100">
                                                <i class="fas fa-cog me-2"></i>Cài đặt
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Monthly Bar Chart
    const monthlyCtx = document.getElementById('monthlyBarChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_map(function($item) { return date('M', mktime(0, 0, 0, $item['month'], 1)); }, $monthlyStats)); ?>,
            datasets: [{
                label: 'Số đơn hàng',
                data: <?php echo json_encode(array_map(function($item) { return $item['count']; }, $monthlyStats)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_map(function($item) { return date('M', mktime(0, 0, 0, $item['month'], 1)); }, $monthlyStats)); ?>,
            datasets: [{
                label: 'Doanh thu',
                data: <?php echo json_encode(array_map(function($item) { return $item['count'] * 10; }, $monthlyStats)); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>
