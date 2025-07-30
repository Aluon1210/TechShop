<?php
session_start();
include './config/connection.php';

echo "<h2>🧪 Test Add to Cart</h2>";

// Kiểm tra session
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✅ Đang đăng nhập với User ID: " . $_SESSION['user_id'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ Chưa đăng nhập</p>";
    echo "<a href='?page=login'>Đăng nhập</a>";
    exit;
}

// Lấy sản phẩm đầu tiên để test
try {
    $products = $conn->query("SELECT TOP 1 Product_Id, Name, Quantity FROM Products")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($products)) {
        echo "<p style='color: red;'>❌ Không có sản phẩm nào trong database</p>";
        exit;
    }
    
    $product = $products[0];
    echo "<p>📱 Sản phẩm test: " . $product['Name'] . " (ID: " . $product['Product_Id'] . ")</p>";
    echo "<p>📦 Số lượng tồn kho: " . $product['Quantity'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi lấy sản phẩm: " . $e->getMessage() . "</p>";
    exit;
}

// Test thêm vào giỏ hàng
if (isset($_GET['test_add'])) {
    $productId = $product['Product_Id'];
    echo "<h3>🧪 Đang test thêm sản phẩm ID: $productId</h3>";
    
    try {
        // Kiểm tra sản phẩm tồn tại
        $sql = "SELECT * FROM Products WHERE Product_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            echo "<p style='color: red;'>❌ Sản phẩm không tồn tại!</p>";
        } else {
            echo "<p>✅ Sản phẩm: " . $product['Name'] . "</p>";
            
            // Tìm hoặc tạo giỏ hàng
            $sql = "SELECT Cart_Id FROM Cart WHERE User_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$cart) {
                // Tạo giỏ hàng mới (Cart_Id có IDENTITY)
                $sql = "INSERT INTO Cart (User_id, Create_at, Update_at) VALUES (?, GETDATE(), GETDATE())";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$_SESSION['user_id']]);
                $newCartId = $conn->lastInsertId();
                echo "<p>✅ Đã tạo giỏ hàng mới: $newCartId</p>";
                $cartId = $newCartId;
            } else {
                $cartId = $cart['Cart_Id'];
                echo "<p>✅ Sử dụng giỏ hàng hiện tại: $cartId</p>";
            }
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $sql = "SELECT * FROM Cart_detail WHERE Cart_Id = ? AND Product_Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$cartId, $productId]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingItem) {
                // Cập nhật số lượng
                $newQuantity = $existingItem['Quantity'] + 1;
                $sql = "UPDATE Cart_detail SET Quantity = ? WHERE Cart_Item_Id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$newQuantity, $existingItem['Cart_Item_Id']]);
                echo "<p style='color: green;'>✅ Đã cập nhật số lượng: $newQuantity</p>";
            } else {
                // Thêm mới
                $sql = "INSERT INTO Cart_detail (Cart_Id, Product_Id, Quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$cartId, $productId, 1]);
                echo "<p style='color: green;'>✅ Đã thêm sản phẩm vào giỏ hàng!</p>";
            }
            
            // Hiển thị giỏ hàng hiện tại
            $sql = "SELECT cd.*, p.Name, p.Price 
                    FROM Cart_detail cd 
                    JOIN Products p ON cd.Product_Id = p.Product_Id 
                    WHERE cd.Cart_Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$cartId]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<h4>🛒 Giỏ hàng hiện tại:</h4>";
            if ($cartItems) {
                foreach ($cartItems as $item) {
                    echo "<p>- " . $item['Name'] . " x" . $item['Quantity'] . " (" . number_format($item['Price']) . " VNĐ)</p>";
                }
            } else {
                echo "<p>Giỏ hàng trống</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
    }
}

echo "<div style='margin: 20px 0;'>";
echo "<a href='test_add_to_cart.php?test_add=1' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🧪 Test Thêm vào giỏ hàng</a>";
echo "<a href='?page=home' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Về trang chủ</a>";
echo "</div>";
?> 