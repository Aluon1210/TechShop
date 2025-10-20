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
        
        if ($quantity <= 0) {
            return ['success' => false, 'message' => 'Số lượng phải lớn hơn 0!'];
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
            
            if (!$cartId) {
                return ['success' => false, 'message' => 'Không thể tạo giỏ hàng!'];
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
                    return ['success' => false, 'message' => 'Số lượng vượt quá tồn kho!'];
                }
                
                $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newQuantity, $existingItem['Cart_Item_Id']]);
            } else {
                // Tạo Cart_Item_Id mới
                $cartItemId = $this->generateCartItemId();
                
                // Thêm mới vào giỏ hàng
                $sql = "INSERT INTO Cart_detail (Cart_Item_Id, Cart_Id, Product_Id, Quantity) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$cartItemId, $cartId, $productId, $quantity]);
            }
            
            return ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng!'];
            
        } catch (PDOException $e) {
            error_log("Cart Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
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
                return $cart['Cart_Id'];
            }
            
            // Tạo Cart_Id mới
            $cartId = $this->generateCartId();
            
            // Tạo giỏ hàng mới
            $sql = "INSERT INTO Cart (Cart_Id, User_id, Create_at, Update_at) VALUES (?, ?, GETDATE(), GETDATE())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartId, $userId]);
            
            return $cartId;
            
        } catch (PDOException $e) {
            error_log("Error creating cart: " . $e->getMessage());
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
    
    // Lấy thông tin giỏ hàng
    public function getCart() {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!', 'items' => []];
        }
        
        try {
            // Truy vấn lấy thông tin giỏ hàng với thông tin sản phẩm, brand và category
            $sql = "SELECT 
                        cd.Cart_Item_Id,
                        cd.Cart_Id, 
                        cd.Product_Id,
                        cd.Quantity,
                        p.Name as Product_Name, 
                        p.Price, 
                        p.Image, 
                        p.Description,
                        p.Quantity as StockQuantity,
                        b.Brand_Name,
                        c.Category_Name
                    FROM Cart_detail cd 
                    JOIN Products p ON cd.Product_Id = p.Product_Id 
                    LEFT JOIN Brands b ON p.Brand_Id = b.Brand_Id
                    LEFT JOIN Categories c ON p.Category_Id = c.Category_Id
                    JOIN Cart cart ON cd.Cart_Id = cart.Cart_Id 
                    WHERE cart.User_id = ?
                    ORDER BY cd.Cart_Item_Id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $total = 0;
            $totalItems = 0;
            
            foreach ($items as &$item) {
                $item['Subtotal'] = $item['Price'] * $item['Quantity'];
                $total += $item['Subtotal'];
                $totalItems += $item['Quantity'];
                
                // Đảm bảo có image mặc định
                if (empty($item['Image'])) {
                    $item['Image'] = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=300&h=300&fit=crop';
                }
            }
            
            return [
                'success' => true, 
                'items' => $items, 
                'total' => $total,
                'count' => count($items),
                'totalItems' => $totalItems
            ];
            
        } catch (PDOException $e) {
            error_log("Get cart error: " . $e->getMessage());
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
            $sql = "SELECT cd.*, p.Quantity as StockQuantity, p.Name as Product_Name
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
                return ['success' => false, 'message' => 'Số lượng vượt quá tồn kho! Còn lại: ' . $item['StockQuantity']];
            }
            
            $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$quantity, $cartItemId]);
            
            return ['success' => true, 'message' => 'Đã cập nhật số lượng sản phẩm "' . $item['Product_Name'] . '"!'];
            
        } catch (PDOException $e) {
            error_log("Update quantity error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($cartItemId) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }
        
        try {
            // Kiểm tra quyền sở hữu và lấy tên sản phẩm
            $sql = "SELECT cd.Cart_Item_Id, p.Name as Product_Name
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
            
            $sql = "DELETE FROM Cart_detail WHERE Cart_Item_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cartItemId]);
            
            return ['success' => true, 'message' => 'Đã xóa sản phẩm "' . $item['Product_Name'] . '" khỏi giỏ hàng!'];
            
        } catch (PDOException $e) {
            error_log("Remove from cart error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Thanh toán
    public function checkout($shippingAddress, $phone) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }
        
        if (empty($shippingAddress) || empty($phone)) {
            return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin giao hàng!'];
        }
        
        try {
            $cartData = $this->getCart();
            if (!$cartData['success'] || empty($cartData['items'])) {
                return ['success' => false, 'message' => 'Giỏ hàng trống!'];
            }
            
            // Kiểm tra tồn kho trước khi đặt hàng
            foreach ($cartData['items'] as $item) {
                if ($item['Quantity'] > $item['StockQuantity']) {
                    return ['success' => false, 'message' => 'Sản phẩm "' . $item['Product_Name'] . '" không đủ số lượng trong kho!'];
                }
            }
            
            // Bắt đầu transaction
            $this->conn->beginTransaction();
            
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
            
            // Commit transaction
            $this->conn->commit();
            
            return ['success' => true, 'message' => 'Đặt hàng thành công! Mã đơn hàng: ' . $orderId, 'order_id' => $orderId];
            
        } catch (PDOException $e) {
            // Rollback transaction
            $this->conn->rollback();
            error_log("Checkout error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    // Tạo ID đơn hàng
    private function generateOrderId() {
        try {
            $sql = "SELECT ISNULL(MAX(Order_Id), 0) + 1 as next_id FROM Orders";
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['next_id'];
        } catch (PDOException $e) {
            error_log("Error generating Order_Id: " . $e->getMessage());
            return rand(10000, 99999); // Fallback random ID
        }
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
            error_log("Get cart count error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function render() {
        $message = '';
        $messageType = 'info';
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
                            $messageType = $result['success'] ? 'success' : 'error';
                        }
                        break;
                        
                    case 'update':
                        if (isset($_POST['cart_item_id']) && isset($_POST['quantity'])) {
                            $result = $this->updateQuantity($_POST['cart_item_id'], (int)$_POST['quantity']);
                            $message = $result['message'];
                            $messageType = $result['success'] ? 'success' : 'error';
                        }
                        break;
                        
                    case 'remove':
                        if (isset($_POST['cart_item_id'])) {
                            $result = $this->removeFromCart($_POST['cart_item_id']);
                            $message = $result['message'];
                            $messageType = $result['success'] ? 'success' : 'error';
                        }
                        break;
                        
                    case 'checkout':
                        if (isset($_POST['shipping_address']) && isset($_POST['phone'])) {
                            $result = $this->checkout($_POST['shipping_address'], $_POST['phone']);
                            $message = $result['message'];
                            $messageType = $result['success'] ? 'success' : 'error';
                            if ($result['success']) {
                                header('Location: ?page=success&order_id=' . $result['order_id']);
                                exit;
                            }
                        }
                        break;
                }
            }
        }
        
        // Lấy thông tin giỏ hàng
        $cartData = $this->getCart();
        if (!$cartData['success'] && empty($message)) {
            $message = $cartData['message'];
            $messageType = 'error';
        }
        
        include './views/cart.php';
    }
}

// Khởi tạo và render
$cartController = new CartController($conn);
$cartController->render();
?> 