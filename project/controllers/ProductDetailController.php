<?php
// ProductDetailController - Controller cho chi tiết sản phẩm
class ProductDetailController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getProduct($productId) {
        try {
            $sql = "SELECT p.*, c.Category_Name, b.Brand_Name 
                    FROM Products p 
                    LEFT JOIN Categories c ON p.Category_Id = c.Category_Id 
                    LEFT JOIN Brands b ON p.Brand_Id = b.Brand_Id 
                    WHERE p.Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function render() {
        $productId = $_GET['id'] ?? null;
        
        if (!$productId) {
            header('Location: ?page=products');
            exit;
        }
        
        $product = $this->getProduct($productId);
        
        if (!$product) {
            header('Location: ?page=products');
            exit;
        }
        
        include './views/product-detail.php';
    }
}

// Khởi tạo và render
$productDetailController = new ProductDetailController($conn);
$productDetailController->render();
?> 