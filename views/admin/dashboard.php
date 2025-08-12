<?php include '../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4">Dashboard</h1>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalProducts; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Danh mục</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCategories; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalUsers; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="index.php?action=products&subaction=add" class="btn btn-primary btn-block">
                                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="index.php?action=categories&subaction=add" class="btn btn-success btn-block">
                                <i class="fas fa-tag me-2"></i>Thêm danh mục
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="index.php?action=products" class="btn btn-info btn-block">
                                <i class="fas fa-list me-2"></i>Quản lý sản phẩm
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="index.php?action=categories" class="btn btn-warning btn-block">
                                <i class="fas fa-tags me-2"></i>Quản lý danh mục
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin hệ thống</h6>
                </div>
                <div class="card-body">
                    <p><strong>Phiên bản:</strong> PolyShop v1.0.0</p>
                    <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
                    <p><strong>Database:</strong> MySQL</p>
                    <p><strong>Thời gian:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
