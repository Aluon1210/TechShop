<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop - Cửa hàng công nghệ hàng đầu</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // Lấy số lượng sản phẩm trong giỏ hàng
    $cartCount = 0;
    if (isset($_SESSION['user_id'])) {
        try {
            $sql = "SELECT COUNT(*) FROM Cart_detail cd 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE c.User_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            $cartCount = $stmt->fetchColumn();
        } catch (PDOException $e) {
            $cartCount = 0;
        }
    }
    ?>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-laptop"></i> TechShop</h1>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="header-actions">
                    <a href="?page=cart" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo $cartCount; ?></span>
                    </a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="user-menu">
                            <?php if($_SESSION['role'] === 'admin'): ?>
                                <div class="user-info">
                                    <span class="user-name">
                                        <i class="fas fa-crown"></i> <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                                    </span>
                                    <span class="user-role">(Admin)</span>
                                </div>
                                <div class="user-dropdown">
                                    <a href="?page=admin-dashboard" class="dropdown-item">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a href="?page=admin-products" class="dropdown-item">
                                        <i class="fas fa-box"></i> Quản lý sản phẩm
                                    </a>
                                    <a href="?page=admin-comments" class="dropdown-item">
                                        <i class="fas fa-comments"></i> Quản lý bình luận
                                    </a>
                                    <a href="?page=admin-users" class="dropdown-item">
                                        <i class="fas fa-users"></i> Quản lý người dùng
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="?page=home" class="dropdown-item">
                                        <i class="fas fa-home"></i> Về trang chủ
                                    </a>
                                    <a href="?page=logout" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="user-info">
                                    <span class="user-name">
                                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                                    </span>
                                    <span class="user-role">(User)</span>
                                </div>
                                <div class="user-dropdown">
                                    <a href="?page=profile" class="dropdown-item">
                                        <i class="fas fa-user-circle"></i> Thông tin cá nhân
                                    </a>
                                    <a href="?page=cart" class="dropdown-item">
                                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                                        <?php if ($cartCount > 0): ?>
                                            <span style="background: #dc3545; color: white; padding: 2px 6px; border-radius: 10px; font-size: 12px; margin-left: 5px;">
                                                <?php echo $cartCount; ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="?page=logout" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <a href="?page=login" class="login-btn">Đăng nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header> 