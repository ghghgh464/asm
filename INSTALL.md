# Hướng dẫn cài đặt PolyShop

## Yêu cầu hệ thống

- **Web Server**: Apache hoặc Nginx
- **PHP**: 7.4 trở lên
- **MySQL**: 5.7 trở lên hoặc MariaDB 10.2 trở lên
- **XAMPP/Laragon**: Để dễ dàng cài đặt môi trường

## Cài đặt

### Bước 1: Cài đặt môi trường

1. Tải và cài đặt XAMPP từ [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Hoặc tải và cài đặt Laragon từ [https://laragon.org/](https://laragon.org/)

### Bước 2: Clone dự án

```bash
# Clone vào thư mục htdocs của XAMPP
cd C:/xampp/htdocs/
git clone <repository-url> tf

# Hoặc copy thủ công vào thư mục htdocs
```

### Bước 3: Cấu hình database

1. Khởi động XAMPP Control Panel
2. Start Apache và MySQL
3. Mở phpMyAdmin: http://localhost/phpmyadmin
4. Tạo database mới tên `polyshop`
5. Import file `database/polyshop.sql`

### Bước 4: Cấu hình ứng dụng

1. Mở file `config/config.php`
2. Cập nhật thông tin database nếu cần:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'polyshop');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

3. Cập nhật URL ứng dụng:
   ```php
   define('APP_URL', 'http://localhost/tf');
   ```

### Bước 5: Phân quyền thư mục

```bash
# Tạo thư mục uploads và phân quyền ghi
mkdir uploads
chmod 755 uploads  # Linux/Mac
# Windows: Đảm bảo thư mục có quyền ghi
```

### Bước 6: Truy cập website

Mở trình duyệt và truy cập: http://localhost/tf/

## Tài khoản mặc định

- **Admin**: admin@polyshop.com / password
- **User**: Tạo tài khoản mới qua form đăng ký

## Cấu trúc dự án

```
tf/
├── assets/          # CSS, JS, Images
├── config/          # Cấu hình
├── controllers/     # Controllers
├── models/          # Models
├── views/           # Views
├── admin/           # Trang quản trị
├── includes/        # Header, Footer
├── uploads/         # Upload files
├── database/        # SQL files
├── index.php        # Entry point
└── .htaccess        # Apache config
```

## Tính năng chính

### Client (Khách hàng)
- [x] Xem sản phẩm theo danh mục
- [x] Tìm kiếm sản phẩm
- [x] Xem chi tiết sản phẩm
- [x] Đăng ký/Đăng nhập
- [x] Cập nhật thông tin cá nhân
- [x] Đổi mật khẩu
- [x] Bình luận sản phẩm

### Admin (Quản trị viên)
- [ ] Quản lý danh mục
- [ ] Quản lý sản phẩm
- [ ] Quản lý tài khoản
- [ ] Quản lý người dùng
- [ ] Quản lý bình luận

## Phát triển

### Thêm sản phẩm mới

1. Vào trang quản trị
2. Chọn "Quản lý sản phẩm"
3. Click "Thêm sản phẩm mới"
4. Điền thông tin và upload hình ảnh

### Tùy chỉnh giao diện

- CSS: `assets/css/style.css`
- JavaScript: `assets/js/main.js`
- Templates: `views/` và `includes/`

## Troubleshooting

### Lỗi kết nối database
- Kiểm tra MySQL đã start chưa
- Kiểm tra thông tin kết nối trong `config/config.php`
- Kiểm tra database `polyshop` đã tạo chưa

### Lỗi upload file
- Kiểm tra thư mục `uploads/` có quyền ghi không
- Kiểm tra `php.ini` có cho phép upload không
- Kiểm tra `max_file_size` trong cấu hình

### Lỗi 404
- Kiểm tra mod_rewrite đã bật chưa
- Kiểm tra file `.htaccess` có đúng không
- Kiểm tra cấu hình Apache

## Hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra log lỗi trong XAMPP
2. Kiểm tra console trình duyệt
3. Liên hệ hỗ trợ kỹ thuật

## Phiên bản

- **Version**: 1.0.0
- **Ngày phát hành**: 2024
- **Tác giả**: PolyShop Team
- **Framework**: PHP Native (MVC Pattern)
