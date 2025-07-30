<?php
session_start();
include './config/connection.php';

// Router đơn giản
$page = $_GET['page'] ?? 'home';

// Xử lý logout trước khi include header và navigation
if ($page === 'logout') {
    include './controllers/LogoutController.php';
    exit; // Dừng thực thi để tránh include các file khác
}

// Header
include './views/header.php';

// Navigation
include './views/navigation.php';

// Main content dựa trên page
switch($page) {
    case 'home':
        include './controllers/HomeController.php';
        break;
    case 'products':
        include './controllers/ProductController.php';
        break;
    case 'product-detail':
        include './controllers/ProductDetailController.php';
        break;
    case 'cart':
        include './controllers/CartController.php';
        break;
    case 'login':
        include './controllers/LoginController.php';
        break;
    case 'register':
        include './controllers/RegisterController.php';
        break;
    case 'profile':
        include './controllers/ProfileController.php';
        break;
    case 'admin-dashboard':
        include './controllers/AdminDashboardController.php';
        break;
    case 'admin-products':
        include './controllers/AdminProductController.php';
        break;
    case 'admin-comments':
        include './controllers/AdminCommentController.php';
        break;
    case 'admin-users':
        include './controllers/AdminUserController.php';
        break;
    case 'ajax':
        include './controllers/AjaxController.php';
        break;
    case 'success':
        include './views/success.php';
        break;
    default:
        include './controllers/HomeController.php';
}

// Footer
include './views/footer.php';
?> 