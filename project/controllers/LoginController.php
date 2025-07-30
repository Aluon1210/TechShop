<?php
// LoginController - Controller cho đăng nhập
class LoginController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function login($username, $password) {
        try {
            // Kiểm tra input
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin!'];
            }
            
            // Tìm user theo username
            $sql = "SELECT * FROM Users WHERE UserName = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return ['success' => false, 'message' => 'Tài khoản không tồn tại!'];
            }
            
            // Kiểm tra mật khẩu
            if ($user['PassWord'] !== $password) {
                return ['success' => false, 'message' => 'Mật khẩu không đúng!'];
            }
            
            // Đăng nhập thành công - tạo session
            $_SESSION['user_id'] = $user['User_id'];
            $_SESSION['username'] = $user['UserName'];
            $_SESSION['fullname'] = $user['FullName'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['login_time'] = time();
            
            return ['success' => true, 'user' => $user];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại sau!'];
        }
    }
    
    public function render() {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            $result = $this->login($username, $password);
            
            if ($result['success']) {
                $user = $result['user'];
                
                // Thông báo chào mừng
                if ($user['Role'] === 'admin') {
                    $success = "Chào mừng Admin! Đang chuyển hướng đến trang quản trị...";
                    header('Location: ?page=admin-dashboard');
                } else {
                    $success = "Đăng nhập thành công! Chào mừng " . $user['FullName'];
                    header('Location: ?page=home');
                }
                exit;
            } else {
                $error = $result['message'];
            }
        }
        
        include './views/login.php';
    }
}

// Khởi tạo và render
$loginController = new LoginController($conn);
$loginController->render();
?> 