# PolyShop - Dự án Website E-commerce

## Mô tả
PolyShop là một website thương mại điện tử được xây dựng bằng PHP theo mô hình MVC, cung cấp giải pháp mua sắm trực tuyến hoàn chỉnh cho khách hàng và hệ thống quản trị cho admin.

## Công nghệ sử dụng
- **Backend**: PHP 7.4+, MySQL
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL với PDO
- **Icons**: Font Awesome
- **Server**: XAMPP/Laragon

## Cấu trúc dự án
```
tf/
├── assets/          # CSS, JS, Images
├── config/          # Cấu hình database và ứng dụng
├── controllers/     # Controllers theo MVC
├── models/          # Models (Connect, Categories, Products, Users, Comments)
├── views/           # Views theo MVC
├── admin/           # Trang quản trị (sẽ tạo)
├── includes/        # Header, Footer, Sidebar
├── uploads/         # Upload hình ảnh
├── database/        # SQL schema và dữ liệu mẫu
└── index.php        # Trang chủ
```

## Giai đoạn phát triển

### Giai đoạn 1: Phân tích và thiết kế ✅
- [x] Nghiên cứu yêu cầu khách hàng
- [x] Phân tích yêu cầu khách hàng
- [x] Thiết kế layout website với Figma
- [x] Thiết kế database (ERD)
- [x] Xây dựng model cơ bản

### Giai đoạn 2: Website hoàn thiện 🚧
- [x] Hoàn thiện website dành cho khách hàng
  - [x] Trang chủ (homepage)
  - [x] Trang danh sách sản phẩm (products)
  - [x] Trang chi tiết sản phẩm (product-detail)
  - [x] Trang tìm kiếm (search)
  - [x] Trang giới thiệu (about)
  - [x] Trang liên hệ (contact)
- [x] Chức năng đăng nhập/đăng ký
- [x] Quản lý thông tin cá nhân
- [x] Đổi mật khẩu
- [x] Chức năng bình luận sản phẩm
- [ ] Trang quản trị admin
  - [ ] Quản lý danh mục
  - [ ] Quản lý sản phẩm
  - [ ] Quản lý tài khoản
  - [ ] Quản lý người dùng
  - [ ] Quản lý bình luận
- [ ] Hoàn thiện document báo cáo dự án
- [ ] Hoàn thiện slide báo cáo dự án

## Tính năng chính

### Khách hàng
- Xem danh sách sản phẩm theo danh mục
- Tìm kiếm sản phẩm
- Xem chi tiết sản phẩm
- Đăng ký và đăng nhập tài khoản
- Cập nhật thông tin cá nhân
- Đổi mật khẩu
- Bình luận và đánh giá sản phẩm
- Giỏ hàng (placeholder)

### Admin (sẽ phát triển)
- Quản lý danh mục sản phẩm
- Quản lý sản phẩm
- Quản lý người dùng
- Quản lý bình luận
- Thống kê bán hàng

## Cài đặt

### Yêu cầu hệ thống
- PHP 7.4 trở lên
- MySQL 5.7 trở lên
- XAMPP hoặc Laragon

### Hướng dẫn cài đặt
1. Clone dự án về máy
2. Import file `database/polyshop.sql` vào MySQL
3. Cấu hình database trong `config/database.php`
4. Khởi động web server
5. Truy cập website

### Tài khoản mặc định
- **Admin**: admin / password
- **Email**: admin@polyshop.com

## Cấu trúc Database

### Bảng chính
- **categories**: Danh mục sản phẩm
- **products**: Sản phẩm
- **users**: Người dùng
- **comments**: Bình luận

### Quan hệ
- Products → Categories (Many-to-One)
- Comments → Products (Many-to-One)
- Comments → Users (Many-to-One)

## Bảo mật
- Sử dụng PDO với prepared statements
- Hash mật khẩu với password_hash()
- CSRF protection
- Input validation và sanitization
- Session management

## Hiệu suất
- Database indexing
- GZIP compression
- Browser caching
- Optimized queries

## Đóng góp
Dự án này được phát triển cho mục đích học tập và nghiên cứu.

## Giấy phép
MIT License
