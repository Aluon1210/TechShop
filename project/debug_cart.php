<?php
session_start();
include './config/connection.php';

echo "<h2>🔍 Debug Cart Function</h2>";

// Kiểm tra session
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✅ Đang đăng nhập với User ID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Username: " . ($_SESSION['username'] ?? 'N/A') . "</p>";
    echo "<p>Role: " . ($_SESSION['role'] ?? 'N/A') . "</p>";
} else {
    echo "<p style='color: red;'>❌ Chưa đăng nhập</p>";
    exit;
}

// Kiểm tra bảng Cart
try {
    $cartCount = $conn->query("SELECT COUNT(*) FROM Cart")->fetchColumn();
    echo "<p>📦 Bảng Cart: $cartCount bản ghi</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi bảng Cart: " . $e->getMessage() . "</p>";
}

// Kiểm tra bảng Cart_detail
try {
    $cartDetailCount = $conn->query("SELECT COUNT(*) FROM Cart_detail")->fetchColumn();
    echo "<p>🛒 Bảng Cart_detail: $cartDetailCount bản ghi</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi bảng Cart_detail: " . $e->getMessage() . "</p>";
}

// Kiểm tra giỏ hàng của user hiện tại
try {
    $sql = "SELECT c.Cart_Id, COUNT(cd.Cart_Item_Id) as item_count 
            FROM Cart c 
            LEFT JOIN Cart_detail cd ON c.Cart_Id = cd.Cart_Id 
            WHERE c.User_id = ? 
            GROUP BY c.Cart_Id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    $userCart = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($userCart) {
        echo "<p>🛒 Giỏ hàng hiện tại: Cart ID " . $userCart['Cart_Id'] . " với " . $userCart['item_count'] . " sản phẩm</p>";
    } else {
        echo "<p>🛒 Chưa có giỏ hàng</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi kiểm tra giỏ hàng: " . $e->getMessage() . "</p>";
}

// Kiểm tra sản phẩm
try {
    $products = $conn->query("SELECT TOP 5 Product_Id, Name, Quantity FROM Products")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h3>📱 Sản phẩm có sẵn:</h3>";
    foreach ($products as $product) {
        echo "<p>ID: " . $product['Product_Id'] . " - " . $product['Name'] . " (Còn: " . $product['Quantity'] . ")</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi kiểm tra sản phẩm: " . $e->getMessage() . "</p>";
}

// Test thêm sản phẩm vào giỏ hàng
if (isset($_GET['test_add'])) {
    $productId = $_GET['test_add'];
    echo "<h3>🧪 Test thêm sản phẩm ID: $productId</h3>";
    
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
                echo "<p>✅ Đã cập nhật số lượng: $newQuantity</p>";
            } else {
                // Thêm mới
                $sql = "INSERT INTO Cart_detail (Cart_Id, Product_Id, Quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$cartId, $productId, 1]);
                echo "<p>✅ Đã thêm sản phẩm vào giỏ hàng!</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
    }
}

echo "<div style='margin: 20px 0;'>";
echo "<a href='?page=home' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>";
echo "🏠 Về trang chủ";
echo "</a>";

if (isset($products[0])) {
    echo "<a href='debug_cart.php?test_add=" . $products[0]['Product_Id'] . "' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>";
    echo "🧪 Test thêm sản phẩm đầu tiên";
    echo "</a>";
}
echo "</div>";
?> 