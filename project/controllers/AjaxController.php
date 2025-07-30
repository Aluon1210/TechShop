<?php
// AjaxController - Controller cho các request AJAX
class AjaxController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Thêm sản phẩm vào giỏ hàng qua AJAX
    public function addToCart() {
        // Đảm bảo session được start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Debug logging
        error_log("AJAX Cart Debug - Session status: " . session_status());
        error_log("AJAX Cart Debug - User ID: " . ($_SESSION['user_id'] ?? 'NOT SET'));
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            error_log("AJAX Cart Error - User not logged in");
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("AJAX Cart Error - Invalid method: " . $_SERVER['REQUEST_METHOD']);
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
            return;
        }
        
        $productId = $_POST['product_id'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        error_log("AJAX Cart Debug - Product ID: $productId, Quantity: $quantity");
        
        if (empty($productId)) {
            error_log("AJAX Cart Error - Empty product ID");
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm!']);
            return;
        }
        
        if ($quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Số lượng phải lớn hơn 0!']);
            return;
        }
        
        try {
            // Kiểm tra sản phẩm tồn tại
            $sql = "SELECT * FROM Products WHERE Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$product) {
                error_log("AJAX Cart Error - Product not found: $productId");
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại!']);
                return;
            }
            
            error_log("AJAX Cart Debug - Product found: " . $product['Name']);
            
            // Kiểm tra số lượng tồn kho
            if ($product['Quantity'] < $quantity) {
                error_log("AJAX Cart Error - Insufficient stock");
                echo json_encode(['success' => false, 'message' => 'Số lượng sản phẩm trong kho không đủ!']);
                return;
            }
            
            // Tìm hoặc tạo giỏ hàng cho user
            $cartId = $this->getOrCreateCart($_SESSION['user_id']);
            error_log("AJAX Cart Debug - Cart ID: $cartId");
            
            if (!$cartId) {
                echo json_encode(['success' => false, 'message' => 'Không thể tạo giỏ hàng!']);
                return;
            }
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $sql = "SELECT * FROM Cart_detail WHERE Cart_Id = ? AND Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartId, $productId]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingItem) {
                // Cập nhật số lượng
                $newQuantity = $existingItem['Quantity'] + $quantity;
                if ($newQuantity > $product['Quantity']) {
                    error_log("AJAX Cart Error - Quantity exceeds stock");
                    echo json_encode(['success' => false, 'message' => 'Số lượng vượt quá tồn kho!']);
                    return;
                }
                
                $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newQuantity, $existingItem['Cart_Item_Id']]);
                error_log("AJAX Cart Debug - Updated quantity to: $newQuantity");
            } else {
                // Tạo Cart_Item_Id mới
                $cartItemId = $this->generateCartItemId();
                
                // Thêm mới vào giỏ hàng
                $sql = "INSERT INTO Cart_detail (Cart_Item_Id, Cart_Id, Product_Id, Quantity) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$cartItemId, $cartId, $productId, $quantity]);
                error_log("AJAX Cart Debug - Added new item to cart with ID: $cartItemId");
            }
            
            // Lấy số lượng sản phẩm trong giỏ hàng
            $cartCount = $this->getCartCount($_SESSION['user_id']);
            error_log("AJAX Cart Debug - Total cart count: $cartCount");
            
            echo json_encode([
                'success' => true, 
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartCount' => $cartCount
            ]);
            
        } catch (PDOException $e) {
            error_log("AJAX Cart PDO Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại sau!']);
        } catch (Exception $e) {
            error_log("AJAX Cart General Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
    }
    
    // Lấy hoặc tạo giỏ hàng cho user
    private function getOrCreateCart($userId) {
        try {
            // Tìm giỏ hàng hiện tại
            $sql = "SELECT Cart_Id FROM Cart WHERE User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($cart) {
                error_log("AJAX Cart Debug - Found existing cart: " . $cart['Cart_Id']);
                return $cart['Cart_Id'];
            }
            
            // Tạo Cart_Id mới
            $cartId = $this->generateCartId();
            
            // Tạo giỏ hàng mới
            $sql = "INSERT INTO Cart (Cart_Id, User_id, Create_at, Update_at) VALUES (?, ?, GETDATE(), GETDATE())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartId, $userId]);
            
            error_log("AJAX Cart Debug - Created new cart: $cartId");
            return $cartId;
            
        } catch (PDOException $e) {
            error_log("AJAX Cart Error creating cart: " . $e->getMessage());
            return null;
        }
    }
    
    // Tạo ID giỏ hàng
    private function generateCartId() {
        try {
            // Lấy Cart_Id lớn nhất hiện tại
            $sql = "SELECT ISNULL(MAX(Cart_Id), 0) + 1 as next_id FROM Cart";
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['next_id'];
        } catch (PDOException $e) {
            error_log("Error generating Cart_Id: " . $e->getMessage());
            return rand(1000, 9999); // Fallback random ID
        }
    }
    
    // Tạo Cart_Item_Id
    private function generateCartItemId() {
        try {
            // Lấy Cart_Item_Id lớn nhất hiện tại
            $sql = "SELECT ISNULL(MAX(Cart_Item_Id), 0) + 1 as next_id FROM Cart_detail";
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['next_id'];
        } catch (PDOException $e) {
            error_log("Error generating Cart_Item_Id: " . $e->getMessage());
            return rand(1000, 9999); // Fallback random ID
        }
    }
    
    // Lấy số lượng sản phẩm trong giỏ hàng
    private function getCartCount($userId) {
        try {
            $sql = "SELECT COUNT(*) FROM Cart_detail cd 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE c.User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("AJAX Cart Count Error: " . $e->getMessage());
            return 0;
        }
    }
    
    // Lấy thông tin giỏ hàng qua AJAX
    public function getCartInfo() {
        // Đảm bảo session được start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            return;
        }
        
        try {
            $cartCount = $this->getCartCount($_SESSION['user_id']);
            echo json_encode(['success' => true, 'count' => $cartCount]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống!']);
        }
    }
    
    // Cập nhật số lượng giỏ hàng trong header
    public function updateCartCount() {
        // Đảm bảo session được start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'count' => 0]);
            return;
        }
        
        $cartCount = $this->getCartCount($_SESSION['user_id']);
        echo json_encode(['success' => true, 'count' => $cartCount]);
    }
    
    public function render() {
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        
        switch ($action) {
            case 'add_to_cart':
                $this->addToCart();
                break;
            case 'get_cart_count':
                $this->getCartInfo();
                break;
            case 'update_cart_count':
                $this->updateCartCount();
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                echo json_encode(['success' => false, 'message' => 'Action không tồn tại!']);
                break;
        }
    }
}

// Khởi tạo và render
$ajaxController = new AjaxController($conn);
$ajaxController->render();
?> 