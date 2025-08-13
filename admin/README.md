# Admin Panel - MMO Services

## Mô tả
Admin Panel được thiết kế với theme hiện đại, phù hợp với giao diện trang chủ MMO Services. Bao gồm các tính năng quản lý sản phẩm, đơn hàng, người dùng và thống kê chi tiết.

## Tính năng chính

### 🎨 Giao diện
- Theme hiện đại với gradient màu sắc
- Responsive design cho mọi thiết bị
- Icon FontAwesome đẹp mắt
- Sidebar navigation thông minh

### 📊 Dashboard
- Thống kê tổng quan (sản phẩm, đơn hàng, người dùng, doanh thu)
- Biểu đồ tròn phân bố danh mục sản phẩm
- Biểu đồ cột đơn hàng theo tháng
- Bảng thống kê chi tiết với phần trăm và xu hướng
- Danh sách sản phẩm hàng đầu theo tồn kho

### 🔐 Bảo mật
- Hệ thống đăng nhập an toàn
- Session management
- Password hashing với bcrypt

## Cài đặt

### 1. Database Setup
Chạy file SQL để thiết lập database:
```sql
-- Import file: admin/setup_admin.sql
```

### 2. Cấu hình Database
Chỉnh sửa file `admin/config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mmo');        // Tên database của bạn
define('DB_USER', 'root');       // Username database
define('DB_PASS', '');           // Password database
```

### 3. Tài khoản mặc định
- **Username:** `admin`
- **Password:** `admin1234`

## Cấu trúc thư mục

```
admin/
├── assets/
│   └── css/
│       └── admin-style.css     # CSS chính cho admin
├── config/
│   └── config.php              # Cấu hình database
├── controllers/
│   ├── auth.php                # Xử lý đăng nhập
│   └── logout.php              # Xử lý đăng xuất
├── views/
│   ├── header.php              # Header admin
│   └── sidebar.php             # Sidebar navigation
├── dashboard.php               # Trang chính dashboard
├── products.php                # Quản lý sản phẩm
├── index.php                   # Trang đăng nhập
└── README.md                   # Hướng dẫn này
```

## Sử dụng

### Đăng nhập
1. Truy cập: `http://your-domain/admin/`
2. Sử dụng tài khoản mặc định hoặc tạo mới
3. Sau khi đăng nhập thành công, chuyển đến dashboard

### Dashboard
- **Thống kê tổng quan:** Xem số liệu cơ bản
- **Biểu đồ:** Phân tích dữ liệu trực quan
- **Thao tác nhanh:** Truy cập nhanh các chức năng chính
- **Thông tin hệ thống:** Theo dõi trạng thái hệ thống

### Quản lý sản phẩm
- Xem danh sách sản phẩm
- Thêm/sửa/xóa sản phẩm
- Quản lý tồn kho
- Phân loại danh mục

## Tùy chỉnh

### Thay đổi màu sắc
Chỉnh sửa file `admin/assets/css/admin-style.css`:
```css
:root {
    --primary-color: #1db954;      /* Màu chính */
    --secondary-color: #1ed760;    /* Màu phụ */
    --dark-color: #333;            /* Màu tối */
}
```

### Thêm biểu đồ mới
Sử dụng Chart.js để tạo biểu đồ mới trong dashboard:
```javascript
new Chart(ctx, {
    type: 'line', // hoặc 'bar', 'pie', 'doughnut'
    data: { /* dữ liệu */ },
    options: { /* tùy chọn */ }
});
```

## Bảo mật

### Khuyến nghị
- Thay đổi password mặc định ngay sau khi cài đặt
- Sử dụng HTTPS trong production
- Giới hạn quyền truy cập database
- Backup dữ liệu thường xuyên

### Session Security
- Session timeout tự động
- CSRF protection
- Input validation và sanitization

## Hỗ trợ

Nếu gặp vấn đề:
1. Kiểm tra log PHP error
2. Xác nhận cấu hình database
3. Kiểm tra quyền truy cập file
4. Đảm bảo PHP version >= 7.4

## Phiên bản
- **Version:** 1.0
- **Cập nhật:** <?php echo date('d/m/Y'); ?>
- **Tương thích:** PHP 7.4+, MySQL 5.7+
