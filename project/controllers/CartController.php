<?php
// CartController - Controller cho giỏ hàng
class CartController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($productId, $quantity = 1) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!'];
        }
        
        try {
            // Kiểm tra sản phẩm tồn tại
            $sql = "SELECT * FROM Products WHERE Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$product) {
                return ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];
            }
            
            // Kiểm tra số lượng tồn kho
            if ($product['Quantity'] < $quantity) {
                return ['success' => false, 'message' => 'Số lượng sản phẩm trong kho không đủ!'];
            }
            
            // Tìm hoặc tạo giỏ hàng cho user
            $cartId = $this->getOrCreateCart($_SESSION['user_id']);
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $sql = "SELECT * FROM Cart_detail WHERE Cart_Id = ? AND Product_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartId, $productId]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingItem) {
                // Cập nhật số lượng
                $newQuantity = $existingItem['Quantity'] + $quantity;
                if ($newQuantity > $product['Quantity']) {
                    return ['success' => false, 'message' => 'Số lượng vượt quá tồn kho!'];
                }
                
                $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newQuantity, $existingItem['Cart_Item_Id']]);
            } else {
                // Thêm mới vào giỏ hàng
                $sql = "INSERT INTO Cart_detail (Cart_Id, Product_Id, Quantity) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$cartId, $productId, $quantity]);
            }
            
            return ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng!'];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Lấy hoặc tạo giỏ hàng cho user
    private function getOrCreateCart($userId) {
        // Tìm giỏ hàng hiện tại
        $sql = "SELECT Cart_Id FROM Cart WHERE User_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cart) {
            return $cart['Cart_Id'];
        }
        
        // Tạo giỏ hàng mới (Cart_Id có IDENTITY)
        $sql = "INSERT INTO Cart (User_id, Create_at, Update_at) VALUES (?, GETDATE(), GETDATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        
        // Lấy Cart_Id vừa tạo
        $cartId = $this->conn->lastInsertId();
        return $cartId;
    }
    
    // Tạo ID giỏ hàng (không cần vì Cart_Id có IDENTITY)
    private function generateCartId() {
        // Không cần generate ID vì Cart_Id có IDENTITY(1,1)
        return null;
    }
    
    // Lấy thông tin giỏ hàng
    public function getCart() {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!', 'items' => []];
        }
        
        try {
            $sql = "SELECT cd.*, p.Name, p.Price, p.Image, p.Quantity as StockQuantity 
                    FROM Cart_detail cd 
                    JOIN Products p ON cd.Product_Id = p.Product_Id 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE c.User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $total = 0;
            foreach ($items as &$item) {
                $item['Subtotal'] = $item['Price'] * $item['Quantity'];
                $total += $item['Subtotal'];
            }
            
            return [
                'success' => true, 
                'items' => $items, 
                'total' => $total,
                'count' => count($items)
            ];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage(), 'items' => []];
        }
    }
    
    // Cập nhật số lượng sản phẩm
    public function updateQuantity($cartItemId, $quantity) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }
        
        try {
            if ($quantity <= 0) {
                return $this->removeFromCart($cartItemId);
            }
            
            // Kiểm tra quyền sở hữu và số lượng tồn kho
            $sql = "SELECT cd.*, p.Quantity as StockQuantity 
                    FROM Cart_detail cd 
                    JOIN Products p ON cd.Product_Id = p.Product_Id 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE cd.Cart_Item_Id = ? AND c.User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartItemId, $_SESSION['user_id']]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$item) {
                return ['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'];
            }
            
            if ($quantity > $item['StockQuantity']) {
                return ['success' => false, 'message' => 'Số lượng vượt quá tồn kho!'];
            }
            
            $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$quantity, $cartItemId]);
            
            return ['success' => true, 'message' => 'Đã cập nhật số lượng!'];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($cartItemId) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }
        
        try {
            // Kiểm tra quyền sở hữu
            $sql = "SELECT cd.Cart_Item_Id 
                    FROM Cart_detail cd 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE cd.Cart_Item_Id = ? AND c.User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartItemId, $_SESSION['user_id']]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$item) {
                return ['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'];
            }
            
            $sql = "DELETE FROM Cart_detail WHERE Cart_Item_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartItemId]);
            
            return ['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!'];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Thanh toán
    public function checkout($shippingAddress, $phone) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }
        
        try {
            $cartData = $this->getCart();
            if (!$cartData['success'] || empty($cartData['items'])) {
                return ['success' => false, 'message' => 'Giỏ hàng trống!'];
            }
            
            // Tạo đơn hàng
            $orderId = $this->generateOrderId();
            $sql = "INSERT INTO Orders (Order_Id, User_id, Order_date, Status) VALUES (?, ?, GETDATE(), 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$orderId, $_SESSION['user_id']]);
            
            // Thêm chi tiết đơn hàng
            foreach ($cartData['items'] as $item) {
                $sql = "INSERT INTO Order_detail (Order_Id, Product_Id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$orderId, $item['Product_Id'], $item['Quantity'], $item['Price']]);
                
                // Cập nhật số lượng tồn kho
                $newStock = $item['StockQuantity'] - $item['Quantity'];
                $sql = "UPDATE Products SET Quantity = ? WHERE Product_Id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newStock, $item['Product_Id']]);
            }
            
            // Xóa giỏ hàng
            $sql = "DELETE FROM Cart_detail WHERE Cart_Id IN (SELECT Cart_Id FROM Cart WHERE User_id = ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            
            $sql = "DELETE FROM Cart WHERE User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            
            return ['success' => true, 'message' => 'Đặt hàng thành công! Mã đơn hàng: ' . $orderId];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Tạo ID đơn hàng
    private function generateOrderId() {
        $sql = "SELECT TOP 1 Order_Id FROM Orders ORDER BY Order_Id DESC";
        $stmt = $this->conn->query($sql);
        $lastId = $stmt->fetchColumn();
        
        if ($lastId) {
            return $lastId + 1;
        }
        return 1;
    }
    
    // Lấy số lượng sản phẩm trong giỏ hàng (cho header)
    public function getCartCount() {
        if (!isset($_SESSION['user_id'])) {
            return 0;
        }
        
        try {
            $sql = "SELECT COUNT(*) FROM Cart_detail cd 
                    JOIN Cart c ON cd.Cart_Id = c.Cart_Id 
                    WHERE c.User_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    public function render() {
        $message = '';
        $cartData = ['items' => [], 'total' => 0, 'count' => 0];
        
        // Xử lý các action
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'add':
                        if (isset($_POST['product_id'])) {
                            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
                            $result = $this->addToCart($_POST['product_id'], $quantity);
                            $message = $result['message'];
                        }
                        break;
                        
                    case 'update':
                        if (isset($_POST['cart_item_id']) && isset($_POST['quantity'])) {
                            $result = $this->updateQuantity($_POST['cart_item_id'], (int)$_POST['quantity']);
                            $message = $result['message'];
                        }
                        break;
                        
                    case 'remove':
                        if (isset($_POST['cart_item_id'])) {
                            $result = $this->removeFromCart($_POST['cart_item_id']);
                            $message = $result['message'];
                        }
                        break;
                        
                                            case 'checkout':
                        if (isset($_POST['shipping_address']) && isset($_POST['phone'])) {
                            $result = $this->checkout($_POST['shipping_address'], $_POST['phone']);
                            $message = $result['message'];
                            if ($result['success']) {
                                // Lấy order ID từ message
                                preg_match('/Mã đơn hàng: (\d+)/', $result['message'], $matches);
                                $orderId = $matches[1] ?? '';
                                header('Location: ?page=success&order_id=' . $orderId);
                                exit;
                            }
                        }
                        break;
                }
            }
        }
        
        // Lấy thông tin giỏ hàng
        $cartData = $this->getCart();
        
        include './views/cart.php';
    }
}

// Khởi tạo và render
$cartController = new CartController($conn);
$cartController->render();
?> 