<?php
// HomeController - Controller cho trang chủ
class HomeController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Lấy sản phẩm nổi bật
    public function getFeaturedProducts($limit = 8) {
        try {
            $sql = "SELECT TOP $limit 
                        p.Product_Id, 
                        p.Name, 
                        p.Description, 
                        p.Price, 
                        p.Quantity, 
                        p.View, 
                        p.Image,
                        b.Brand_Name,
                        c.Category_Name
                    FROM Products p
                    LEFT JOIN Brands b ON p.Brand_Id = b.Brand_Id
                    LEFT JOIN Categories c ON p.Category_Id = c.Category_Id
                    WHERE p.Quantity > 0
                    ORDER BY p.View DESC, p.Product_Id DESC";
            
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error getting featured products: " . $e->getMessage());
            return [];
        }
    }
    
    // Lấy danh mục sản phẩm
    public function getCategories($limit = 6) {
        try {
            $sql = "SELECT TOP $limit 
                        c.Category_Id, 
                        c.Category_Name,
                        COUNT(p.Product_Id) as Product_Count
                    FROM Categories c
                    LEFT JOIN Products p ON c.Category_Id = p.Category_Id
                    GROUP BY c.Category_Id, c.Category_Name
                    ORDER BY Product_Count DESC";
            
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return [];
        }
    }
    
    // Lấy thương hiệu
    public function getBrands($limit = 6) {
        try {
            $sql = "SELECT TOP $limit 
                        b.Brand_Id, 
                        b.Brand_Name,
                        COUNT(p.Product_Id) as Product_Count
                    FROM Brands b
                    LEFT JOIN Products p ON b.Brand_Id = p.Brand_Id
                    GROUP BY b.Brand_Id, b.Brand_Name
                    ORDER BY Product_Count DESC";
            
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error getting brands: " . $e->getMessage());
            return [];
        }
    }
    
    public function render() {
        // Lấy dữ liệu cho trang chủ
        $featuredProducts = $this->getFeaturedProducts(8);
        $categories = $this->getCategories(4);
        $brands = $this->getBrands(6);
        
        // Debug: Log số lượng sản phẩm
        error_log("HomeController: Found " . count($featuredProducts) . " featured products");
        
        // Include view
        include './views/home.php';
    }
}

// Khởi tạo và render
$homeController = new HomeController($conn);
$homeController->render();
?>