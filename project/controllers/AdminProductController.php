<?php
// AdminProductController - Controller cho quản lý sản phẩm admin
class AdminProductController {
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
    
    public function getAllProducts() {
        try {
            $sql = "SELECT p.*, c.Category_Name, b.Brand_Name 
                    FROM Products p
                    LEFT JOIN Categories c ON p.Category_Id = c.Category_Id
                    LEFT JOIN Brands b ON p.Brand_Id = b.Brand_Id
                    ORDER BY p.Product_Id DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function getCategories() {
        try {
            $sql = "SELECT * FROM Categories ORDER BY Category_Name";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function getBrands() {
        try {
            $sql = "SELECT * FROM Brands ORDER BY Brand_Name";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function addProduct($productData) {
        try {
            // Tạo Product_Id mới
            $stmt = $this->conn->query("SELECT TOP 1 Product_Id FROM Products ORDER BY Product_Id DESC");
            $lastId = $stmt->fetchColumn();
            
            if ($lastId) {
                $num = (int)substr($lastId, 2);
                $num++;
                $newId = 'SP' . str_pad($num, 10, '0', STR_PAD_LEFT);
            } else {
                $newId = 'SP0000000001';
            }
            
            $sql = "INSERT INTO Products (Product_Id, Name, Price, Description, Image, Quantity, View, Brand_Id, Category_Id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $newId,
                $productData['Name'],
                $productData['Price'],
                $productData['Description'],
                $productData['Image'],
                $productData['Quantity'],
                0, // View mặc định
                $productData['Brand_Id'],
                $productData['Category_Id']
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function updateProduct($productId, $productData) {
        try {
            $sql = "UPDATE Products SET Name = ?, Price = ?, Description = ?, Image = ?, 
                    Quantity = ?, Brand_Id = ?, Category_Id = ? WHERE Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $productData['Name'],
                $productData['Price'],
                $productData['Description'],
                $productData['Image'],
                $productData['Quantity'],
                $productData['Brand_Id'],
                $productData['Category_Id'],
                $productId
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function deleteProduct($productId) {
        try {
            $sql = "DELETE FROM Products WHERE Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function getProductById($productId) {
        try {
            $sql = "SELECT * FROM Products WHERE Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function render() {
        $this->checkAdminAccess();
        
        $message = '';
        $messageType = '';
        $products = $this->getAllProducts();
        $categories = $this->getCategories();
        $brands = $this->getBrands();
        
        // Xử lý thêm sản phẩm
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'add') {
                $productData = [
                    'Name' => $_POST['Name'] ?? '',
                    'Price' => $_POST['Price'] ?? 0,
                    'Description' => $_POST['Description'] ?? '',
                    'Image' => $_POST['Image'] ?? '',
                    'Quantity' => $_POST['Quantity'] ?? 0,
                    'Brand_Id' => $_POST['Brand_Id'] ?? 1,
                    'Category_Id' => $_POST['Category_Id'] ?? 1
                ];
                
                if ($this->addProduct($productData)) {
                    $message = 'Thêm sản phẩm thành công!';
                    $messageType = 'success';
                    $products = $this->getAllProducts(); // Refresh danh sách
                } else {
                    $message = 'Có lỗi xảy ra khi thêm sản phẩm!';
                    $messageType = 'error';
                }
            }
            
            // Xử lý xóa sản phẩm
            if ($_POST['action'] === 'delete' && isset($_POST['product_id'])) {
                if ($this->deleteProduct($_POST['product_id'])) {
                    $message = 'Xóa sản phẩm thành công!';
                    $messageType = 'success';
                    $products = $this->getAllProducts(); // Refresh danh sách
                } else {
                    $message = 'Có lỗi xảy ra khi xóa sản phẩm!';
                    $messageType = 'error';
                }
            }
        }
        
        include './views/admin/products.php';
    }
}

// Khởi tạo và render
$adminProductController = new AdminProductController($conn);
$adminProductController->render();
?> 