<?php
// ProductController - Controller cho trang sản phẩm
class ProductController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getProducts($category = null, $brand = null, $search = null) {
        try {
            $sql = "SELECT p.*, c.Category_Name, b.Brand_Name 
                    FROM Products p 
                    LEFT JOIN Categories c ON p.Category_Id = c.Category_Id 
                    LEFT JOIN Brands b ON p.Brand_Id = b.Brand_Id 
                    WHERE 1=1";
            $params = [];
            
            if ($category) {
                $sql .= " AND c.Category_Name = ?";
                $params[] = $category;
            }
            
            if ($brand) {
                $sql .= " AND b.Brand_Name = ?";
                $params[] = $brand;
            }
            
            if ($search) {
                $sql .= " AND (p.Name LIKE ? OR p.Description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            $sql .= " ORDER BY p.Name ASC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
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
    
    public function render() {
        $category = $_GET['category'] ?? null;
        $brand = $_GET['brand'] ?? null;
        $search = $_GET['search'] ?? null;
        
        $products = $this->getProducts($category, $brand, $search);
        $categories = $this->getCategories();
        $brands = $this->getBrands();
        
        include './views/products.php';
    }
}

// Khởi tạo và render
$productController = new ProductController($conn);
$productController->render();
?> 