<?php
// RegisterController - Controller cho đăng ký
class RegisterController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function register($userData) {
        try {
            // Kiểm tra username đã tồn tại chưa
            $checkSql = "SELECT User_id FROM Users WHERE UserName = ?";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([$userData['UserName']]);
            
            if ($checkStmt->fetch()) {
                return ['success' => false, 'message' => 'Tên đăng nhập đã tồn tại!'];
            }
            
            // Tạo User_id mới
            $stmt = $this->conn->query("SELECT TOP 1 User_id FROM Users ORDER BY User_id DESC");
            $lastId = $stmt->fetchColumn();
            
            if ($lastId) {
                $num = (int)substr($lastId, 2);
                $num++;
                $newId = 'KH' . str_pad($num, 10, '0', STR_PAD_LEFT);
            } else {
                $newId = 'KH0000000001';
            }
            
            // Thêm user mới
            $sql = "INSERT INTO Users (User_id, UserName, PassWord, Email, FullName, Phone, Role, Adress) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $newId,
                $userData['UserName'],
                $userData['PassWord'],
                $userData['Email'],
                $userData['FullName'],
                $userData['Phone'],
                $userData['Role'],
                $userData['Adress']
            ]);
            
            return ['success' => true, 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi khi đăng ký: ' . $e->getMessage()];
        }
    }
    
    public function render() {
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'UserName' => $_POST['UserName'] ?? '',
                'PassWord' => $_POST['PassWord'] ?? '',
                'Email' => $_POST['Email'] ?? '',
                'FullName' => $_POST['FullName'] ?? '',
                'Phone' => $_POST['Phone'] ?? '',
                'Role' => 'person',
                'Adress' => $_POST['Adress'] ?? ''
            ];
            
            $result = $this->register($userData);
            $message = $result['message'];
            $messageType = $result['success'] ? 'success' : 'error';
        }
        
        include './views/register.php';
    }
}

// Khởi tạo và render
$registerController = new RegisterController($conn);
$registerController->render();
?> 