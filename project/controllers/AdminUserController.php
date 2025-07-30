<?php
// AdminUserController - Controller cho quản lý người dùng admin
class AdminUserController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function checkAdminAccess() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=login');
            exit;
        }
    }
    
    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM Users WHERE Role = 'person' ORDER BY User_id DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function deleteUser($userId) {
        try {
            $sql = "DELETE FROM Users WHERE User_id = ? AND Role = 'person'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function getUserById($userId) {
        try {
            $sql = "SELECT * FROM Users WHERE User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function render() {
        $this->checkAdminAccess();
        
        $message = '';
        $messageType = '';
        $users = $this->getAllUsers();
        
        // Xử lý xóa người dùng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'delete' && isset($_POST['user_id'])) {
                if ($this->deleteUser($_POST['user_id'])) {
                    $message = 'Xóa người dùng thành công!';
                    $messageType = 'success';
                    $users = $this->getAllUsers(); // Refresh danh sách
                } else {
                    $message = 'Có lỗi xảy ra khi xóa người dùng!';
                    $messageType = 'error';
                }
            }
        }
        
        include './views/admin/users.php';
    }
}

// Khởi tạo và render
$adminUserController = new AdminUserController($conn);
$adminUserController->render();
?> 