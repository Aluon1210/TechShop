<?php
// LogoutController - Controller cho đăng xuất
class LogoutController {
    public function logout() {
        // Xóa tất cả session variables
        $_SESSION = array();
        
        // Xóa session cookie nếu có
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Hủy session
        session_destroy();
        
        // Chuyển hướng về trang chủ
        header('Location: ?page=home');
        exit;
    }
}

// Khởi tạo và thực hiện logout
$logoutController = new LogoutController();
$logoutController->logout();
?> 