# 🛍️ TechShop - Hệ thống bán hàng trực tuyến

## 📋 Mô tả
TechShop là một website bán hàng trực tuyến được xây dựng bằng PHP với kiến trúc MVC, sử dụng SQL Server làm cơ sở dữ liệu. Hệ thống hỗ trợ đầy đủ chức năng cho cả người dùng và quản trị viên.

## 🚀 Tính năng chính

### 👤 Người dùng thường
- Xem danh sách sản phẩm
- Xem chi tiết sản phẩm
- Thêm sản phẩm vào giỏ hàng (AJAX)
- Quản lý giỏ hàng (cập nhật số lượng, xóa sản phẩm)
- Thanh toán và đặt hàng
- Đăng ký tài khoản mới
- Cập nhật thông tin cá nhân
- Bình luận sản phẩm

### 👑 Quản trị viên (Admin)
- Dashboard với thống kê tổng quan
- Quản lý sản phẩm (thêm, xem, xóa)
- Quản lý bình luận người dùng
- Quản lý người dùng
- Xem thống kê hệ thống

## 🔧 Cài đặt và sử dụng

### 1. Yêu cầu hệ thống
- PHP 7.4 trở lên
- SQL Server
- Web server (Apache/Nginx)

### 2. Cấu hình database
Chỉnh sửa file `config/config.php`:
```php
$host = 'localhost';
$port = '1433';
$database = 'Techshop';
$username = 'thanhcong';
$password = 'thanhcong';
```

### 3. Tạo tài khoản admin
Truy cập: `http://your-domain/check_admin.php`
Hoặc chạy file `create_admin.php`

### 4. Thông tin đăng nhập
**Admin:**
- Username: `thanhcong`
- Password: `admin123`
- Role: `admin`

**User thường:**
- Đăng ký tài khoản mới qua form đăng ký

## 📁 Cấu trúc thư mục

```
TechShop/
├── config/
│   ├── config.php          # Cấu hình database
│   └── connection.php      # Kết nối database
├── controllers/            # Controllers (MVC)
│   ├── HomeController.php
│   ├── LoginController.php
│   ├── CartController.php
│   ├── AjaxController.php
│   ├── AdminDashboardController.php
│   ├── AdminProductController.php
│   ├── AdminCommentController.php
│   ├── AdminUserController.php
│   └── ProfileController.php
├── views/                  # Views (MVC)
│   ├── header.php
│   ├── navigation.php
│   ├── footer.php
│   ├── home.php
│   ├── login.php
│   ├── profile.php
│   ├── cart.php
│   ├── success.php
│   └── admin/
│       ├── dashboard.php
│       ├── products.php
│       ├── comments.php
│       └── users.php
├── assets/
│   ├── css/
│   │   └── style.css       # Stylesheet chính
│   └── images/
├── index.php              # Entry point
├── create_admin.php       # Tạo tài khoản admin
├── check_admin.php        # Kiểm tra hệ thống
└── README.md
```

## 🔐 Bảo mật

### Phân quyền người dùng
- **Admin**: Có quyền truy cập tất cả chức năng quản trị
- **User**: Chỉ có quyền xem sản phẩm và quản lý thông tin cá nhân

### Session Management
- Sử dụng PHP Session để quản lý đăng nhập
- Tự động chuyển hướng dựa trên role người dùng
- Bảo vệ các trang admin khỏi truy cập trái phép

## 🎨 Giao diện

### Responsive Design
- Tương thích với mọi thiết bị (desktop, tablet, mobile)
- Sử dụng CSS Grid và Flexbox
- Animation và hiệu ứng mượt mà

### UI/UX
- Giao diện hiện đại với gradient colors
- Dropdown menu cho người dùng đã đăng nhập
- Thông báo lỗi và thành công rõ ràng
- Loading states và hover effects

## 🛠️ Chức năng chi tiết

### Quản lý sản phẩm
- ✅ Thêm sản phẩm mới
- ✅ Xem danh sách sản phẩm
- ✅ Xóa sản phẩm
- ⏳ Sửa sản phẩm (đang phát triển)

### Giỏ hàng và thanh toán
- ✅ Thêm sản phẩm vào giỏ hàng (AJAX)
- ✅ Xem giỏ hàng chi tiết
- ✅ Cập nhật số lượng sản phẩm
- ✅ Xóa sản phẩm khỏi giỏ hàng
- ✅ Thanh toán và đặt hàng
- ✅ Trang thành công sau thanh toán

### Quản lý bình luận
- ✅ Xem tất cả bình luận
- ✅ Xem bình luận theo sản phẩm
- ✅ Xóa bình luận không phù hợp

### Quản lý người dùng
- ✅ Xem danh sách người dùng
- ✅ Xóa người dùng
- ⏳ Xem chi tiết người dùng (đang phát triển)

## 🔄 Cập nhật và bảo trì

### Phiên bản hiện tại: v1.1
- Hệ thống đăng nhập hoàn chỉnh
- Phân quyền rõ ràng
- Giao diện responsive
- Quản lý sản phẩm cơ bản
- Giỏ hàng và thanh toán hoàn chỉnh
- AJAX cho trải nghiệm người dùng tốt hơn

### Kế hoạch phát triển
- [ ] Chức năng sửa sản phẩm
- [ ] Chức năng xem chi tiết người dùng
- [ ] Quản lý đơn hàng (admin)
- [ ] Thống kê báo cáo nâng cao
- [ ] Upload hình ảnh sản phẩm
- [ ] Tìm kiếm và lọc sản phẩm
- [ ] Thanh toán online (VNPay, Momo)
- [ ] Email thông báo đơn hàng

## 📞 Hỗ trợ

Nếu gặp vấn đề hoặc cần hỗ trợ, vui lòng:
1. Kiểm tra file `check_admin.php` để xác định lỗi
2. Đảm bảo cấu hình database chính xác
3. Kiểm tra quyền truy cập file và thư mục

## 📄 License

Dự án này được phát triển cho mục đích học tập và thương mại.

---

**TechShop** - Cửa hàng công nghệ hàng đầu! 🚀 