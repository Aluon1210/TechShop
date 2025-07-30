<?php
// AdminDashboardController - Controller cho trang dashboard admin
class AdminDashboardController {
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
    
    public function getDashboardStats() {
        try {
            // Tổng số sản phẩm
            $productCount = $this->conn->query("SELECT COUNT(*) FROM Products")->fetchColumn();
            
            // Tổng số người dùng
            $userCount = $this->conn->query("SELECT COUNT(*) FROM Users WHERE Role = 'person'")->fetchColumn();
            
            // Tổng số comment
            $commentCount = $this->conn->query("SELECT COUNT(*) FROM Comments")->fetchColumn();
            
            // Tổng số đơn hàng
            $orderCount = $this->conn->query("SELECT COUNT(*) FROM Orders")->fetchColumn();
            
            return [
                'products' => $productCount,
                'users' => $userCount,
                'comments' => $commentCount,
                'orders' => $orderCount
            ];
        } catch (PDOException $e) {
            return [
                'products' => 0,
                'users' => 0,
                'comments' => 0,
                'orders' => 0
            ];
        }
    }
    
    public function render() {
        $this->checkAdminAccess();
        $stats = $this->getDashboardStats();
        include './views/admin/dashboard.php';
    }
}

// Khởi tạo và render
$adminDashboardController = new AdminDashboardController($conn);
$adminDashboardController->render();
?> 