<?php
// AdminCommentController - Controller cho quản lý bình luận admin
class AdminCommentController {
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
    
    public function getAllComments() {
        try {
            $sql = "SELECT c.*, p.Name as Product_Name, u.FullName as User_Name, u.UserName
                    FROM Comments c
                    LEFT JOIN Products p ON c.Product_Id = p.Product_Id
                    LEFT JOIN Users u ON c.User_id = u.User_id
                    ORDER BY c.Create_at DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function deleteComment($commentId) {
        try {
            $sql = "DELETE FROM Comments WHERE Comment_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$commentId]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function getCommentsByProduct($productId) {
        try {
            $sql = "SELECT c.*, u.FullName as User_Name, u.UserName
                    FROM Comments c
                    LEFT JOIN Users u ON c.User_id = u.User_id
                    WHERE c.Product_Id = ?
                    ORDER BY c.Create_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function render() {
        $this->checkAdminAccess();
        
        $message = '';
        $messageType = '';
        $comments = $this->getAllComments();
        
        // Xử lý xóa bình luận
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'delete' && isset($_POST['comment_id'])) {
                if ($this->deleteComment($_POST['comment_id'])) {
                    $message = 'Xóa bình luận thành công!';
                    $messageType = 'success';
                    $comments = $this->getAllComments(); // Refresh danh sách
                } else {
                    $message = 'Có lỗi xảy ra khi xóa bình luận!';
                    $messageType = 'error';
                }
            }
        }
        
        include './views/admin/comments.php';
    }
}

// Khởi tạo và render
$adminCommentController = new AdminCommentController($conn);
$adminCommentController->render();
?> 