<?php
session_start();
include './config/connection.php';

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>TechShop - Demo System</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .demo-section { background: white; margin: 20px 0; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .demo-title { color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; margin-bottom: 20px; }
        .demo-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .demo-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; }
        .demo-card h3 { color: #333; margin-bottom: 10px; }
        .demo-card p { color: #666; margin-bottom: 15px; }
        .demo-btn { display: inline-block; background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: background 0.3s; }
        .demo-btn:hover { background: #5a6fd8; }
        .status { padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .status-success { background: #d4edda; color: #155724; }
        .status-warning { background: #fff3cd; color: #856404; }
        .status-error { background: #f8d7da; color: #721c24; }
        .feature-list { list-style: none; padding: 0; }
        .feature-list li { padding: 8px 0; border-bottom: 1px solid #eee; }
        .feature-list li:before { content: '✅ '; margin-right: 10px; }
        .feature-list li.pending:before { content: '⏳ '; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='demo-section'>
            <h1 class='demo-title'><i class='fas fa-rocket'></i> TechShop - Demo System</h1>
            <p>Chào mừng đến với hệ thống TechShop! Dưới đây là các chức năng có sẵn để test.</p>
        </div>

        <div class='demo-section'>
            <h2 class='demo-title'><i class='fas fa-users'></i> Tài khoản Demo</h2>
            <div class='demo-grid'>
                <div class='demo-card'>
                    <h3><i class='fas fa-crown'></i> Admin Account</h3>
                    <p><strong>Username:</strong> thanhcong</p>
                    <p><strong>Password:</strong> admin123</p>
                    <p><strong>Role:</strong> <span class='status status-success'>Admin</span></p>
                    <p><strong>Quyền:</strong> Quản lý toàn bộ hệ thống</p>
                    <a href='?page=login' class='demo-btn'>Đăng nhập Admin</a>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-user'></i> User Account</h3>
                    <p><strong>Trạng thái:</strong> <span class='status status-warning'>Cần đăng ký</span></p>
                    <p><strong>Role:</strong> <span class='status status-success'>User</span></p>
                    <p><strong>Quyền:</strong> Xem sản phẩm, quản lý thông tin cá nhân</p>
                    <a href='?page=register' class='demo-btn'>Đăng ký User</a>
                </div>
            </div>
        </div>

        <div class='demo-section'>
            <h2 class='demo-title'><i class='fas fa-cogs'></i> Chức năng hệ thống</h2>
            <div class='demo-grid'>
                <div class='demo-card'>
                    <h3><i class='fas fa-home'></i> Trang chủ</h3>
                    <ul class='feature-list'>
                        <li>Hiển thị tất cả sản phẩm</li>
                        <li>Giao diện responsive</li>
                        <li>Thêm vào giỏ hàng</li>
                    </ul>
                    <a href='?page=home' class='demo-btn'>Xem trang chủ</a>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-tachometer-alt'></i> Admin Dashboard</h3>
                    <ul class='feature-list'>
                        <li>Thống kê tổng quan</li>
                        <li>Quản lý sản phẩm</li>
                        <li>Quản lý bình luận</li>
                        <li>Quản lý người dùng</li>
                    </ul>
                    <a href='?page=admin-dashboard' class='demo-btn'>Vào Dashboard</a>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-user-circle'></i> User Profile</h3>
                    <ul class='feature-list'>
                        <li>Xem thông tin cá nhân</li>
                        <li>Cập nhật thông tin</li>
                        <li>Quản lý tài khoản</li>
                    </ul>
                    <a href='?page=profile' class='demo-btn'>Xem Profile</a>
                </div>
            </div>
        </div>

        <div class='demo-section'>
            <h2 class='demo-title'><i class='fas fa-tools'></i> Công cụ hệ thống</h2>
            <div class='demo-grid'>
                <div class='demo-card'>
                    <h3><i class='fas fa-check-circle'></i> Kiểm tra hệ thống</h3>
                    <p>Kiểm tra kết nối database, tài khoản admin và các bảng dữ liệu.</p>
                    <a href='check_admin.php' class='demo-btn'>Kiểm tra ngay</a>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-plus-circle'></i> Tạo Admin</h3>
                    <p>Tạo tài khoản admin mới nếu chưa có.</p>
                    <a href='create_admin.php' class='demo-btn'>Tạo Admin</a>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-book'></i> Hướng dẫn</h3>
                    <p>Xem hướng dẫn chi tiết về cách sử dụng hệ thống.</p>
                    <a href='README.md' class='demo-btn'>Xem README</a>
                </div>
            </div>
        </div>

        <div class='demo-section'>
            <h2 class='demo-title'><i class='fas fa-info-circle'></i> Thông tin kỹ thuật</h2>
            <div class='demo-grid'>
                <div class='demo-card'>
                    <h3><i class='fas fa-code'></i> Công nghệ sử dụng</h3>
                    <ul class='feature-list'>
                        <li>PHP 7.4+</li>
                        <li>SQL Server</li>
                        <li>MVC Architecture</li>
                        <li>Responsive CSS</li>
                        <li>Font Awesome Icons</li>
                    </ul>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-shield-alt'></i> Bảo mật</h3>
                    <ul class='feature-list'>
                        <li>Session Management</li>
                        <li>Role-based Access Control</li>
                        <li>SQL Injection Prevention</li>
                        <li>Input Validation</li>
                        <li>XSS Protection</li>
                    </ul>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-mobile-alt'></i> Responsive Design</h3>
                    <ul class='feature-list'>
                        <li>Desktop (>768px)</li>
                        <li>Tablet (768px-480px)</li>
                        <li>Mobile (<480px)</li>
                        <li>Touch-friendly</li>
                        <li>Fast loading</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class='demo-section'>
            <h2 class='demo-title'><i class='fas fa-road'></i> Roadmap</h2>
            <div class='demo-grid'>
                <div class='demo-card'>
                    <h3><i class='fas fa-check'></i> Đã hoàn thành</h3>
                    <ul class='feature-list'>
                        <li>Hệ thống đăng nhập</li>
                        <li>Phân quyền Admin/User</li>
                        <li>Quản lý sản phẩm (CRUD cơ bản)</li>
                        <li>Quản lý bình luận</li>
                        <li>User Profile</li>
                        <li>Responsive Design</li>
                    </ul>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-clock'></i> Đang phát triển</h3>
                    <ul class='feature-list'>
                        <li class='pending'>Sửa sản phẩm</li>
                        <li class='pending'>Xem chi tiết người dùng</li>
                        <li class='pending'>Quản lý đơn hàng</li>
                        <li class='pending'>Upload hình ảnh</li>
                        <li class='pending'>Tìm kiếm nâng cao</li>
                    </ul>
                </div>
                <div class='demo-card'>
                    <h3><i class='fas fa-lightbulb'></i> Kế hoạch tương lai</h3>
                    <ul class='feature-list'>
                        <li class='pending'>Thanh toán online</li>
                        <li class='pending'>Email notifications</li>
                        <li class='pending'>API RESTful</li>
                        <li class='pending'>Multi-language</li>
                        <li class='pending'>Advanced analytics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>";
?> 