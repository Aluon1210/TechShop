<?php
// Test Cart System - Kiểm tra hệ thống giỏ hàng
session_start();
include './config/connection.php';

echo "<h2>🧪 Test Hệ Thống Giỏ Hàng TechShop</h2>";

// Tạo user test nếu chưa có
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 'test_user_001';
    $_SESSION['username'] = 'testuser';
    $_SESSION['fullname'] = 'Test User';
    $_SESSION['role'] = 'user';
    echo "<p>✅ Đã tạo session user test: " . $_SESSION['user_id'] . "</p>";
}

echo "<h3>📋 Thông tin User hiện tại:</h3>";
echo "<ul>";
echo "<li><strong>User ID:</strong> " . $_SESSION['user_id'] . "</li>";
echo "<li><strong>Username:</strong> " . $_SESSION['username'] . "</li>";
echo "<li><strong>Full Name:</strong> " . $_SESSION['fullname'] . "</li>";
echo "<li><strong>Role:</strong> " . $_SESSION['role'] . "</li>";
echo "</ul>";

// Test 1: Kiểm tra sản phẩm trong database
echo "<h3>🔍 Test 1: Kiểm tra sản phẩm trong database</h3>";
try {
    $sql = "SELECT TOP 5 Product_Id, Name, Price, Quantity FROM Products";
    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($products)) {
        echo "<p>✅ Tìm thấy " . count($products) . " sản phẩm</p>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Product ID</th><th>Tên</th><th>Giá</th><th>Số lượng</th></tr>";
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['Product_Id']) . "</td>";
            echo "<td>" . htmlspecialchars($product['Name']) . "</td>";
            echo "<td>" . number_format($product['Price']) . " VNĐ</td>";
            echo "<td>" . $product['Quantity'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Lấy sản phẩm đầu tiên để test
        $testProduct = $products[0];
    } else {
        echo "<p>❌ Không tìm thấy sản phẩm nào trong database</p>";
        exit;
    }
} catch (PDOException $e) {
    echo "<p>❌ Lỗi khi truy vấn sản phẩm: " . $e->getMessage() . "</p>";
    exit;
}

// Test 2: Kiểm tra Cart của user hiện tại
echo "<h3>🛒 Test 2: Kiểm tra Cart hiện tại</h3>";
try {
    $sql = "SELECT Cart_Id FROM Cart WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cart) {
        echo "<p>✅ Tìm thấy Cart ID: " . $cart['Cart_Id'] . "</p>";
        
        // Kiểm tra items trong cart
        $sql = "SELECT cd.*, p.Name, p.Price FROM Cart_detail cd 
                JOIN Products p ON cd.Product_Id = p.Product_Id 
                WHERE cd.Cart_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cart['Cart_Id']]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($cartItems)) {
            echo "<p>📦 Có " . count($cartItems) . " sản phẩm trong giỏ hàng:</p>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Cart Item ID</th><th>Product ID</th><th>Tên sản phẩm</th><th>Số lượng</th><th>Giá</th></tr>";
            foreach ($cartItems as $item) {
                echo "<tr>";
                echo "<td>" . $item['Cart_Item_Id'] . "</td>";
                echo "<td>" . $item['Product_Id'] . "</td>";
                echo "<td>" . htmlspecialchars($item['Name']) . "</td>";
                echo "<td>" . $item['Quantity'] . "</td>";
                echo "<td>" . number_format($item['Price']) . " VNĐ</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>📭 Giỏ hàng trống</p>";
        }
    } else {
        echo "<p>📭 Chưa có giỏ hàng cho user này</p>";
    }
} catch (PDOException $e) {
    echo "<p>❌ Lỗi khi kiểm tra cart: " . $e->getMessage() . "</p>";
}

// Test 3: Test thêm sản phẩm vào giỏ hàng
echo "<h3>➕ Test 3: Thêm sản phẩm vào giỏ hàng</h3>";
if (isset($testProduct)) {
    include './controllers/CartController.php';
    $cartController = new CartController($conn);
    
    echo "<p>🔄 Đang thêm sản phẩm: " . htmlspecialchars($testProduct['Name']) . " (ID: " . $testProduct['Product_Id'] . ")</p>";
    
    $result = $cartController->addToCart($testProduct['Product_Id'], 1);
    
    if ($result['success']) {
        echo "<p>✅ " . $result['message'] . "</p>";
    } else {
        echo "<p>❌ " . $result['message'] . "</p>";
    }
} else {
    echo "<p>❌ Không có sản phẩm để test</p>";
}

// Test 4: Kiểm tra giỏ hàng sau khi thêm
echo "<h3>🔍 Test 4: Kiểm tra giỏ hàng sau khi thêm</h3>";
if (isset($cartController)) {
    $cartData = $cartController->getCart();
    
    if ($cartData['success']) {
        echo "<p>✅ Lấy thông tin giỏ hàng thành công</p>";
        echo "<p><strong>Tổng số sản phẩm:</strong> " . $cartData['count'] . "</p>";
        echo "<p><strong>Tổng tiền:</strong> " . number_format($cartData['total']) . " VNĐ</p>";
        
        if (!empty($cartData['items'])) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Tên sản phẩm</th><th>Thương hiệu</th><th>Số lượng</th><th>Giá</th><th>Thành tiền</th></tr>";
            foreach ($cartData['items'] as $item) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['Product_Name']) . "</td>";
                echo "<td>" . htmlspecialchars($item['Brand_Name'] ?? 'N/A') . "</td>";
                echo "<td>" . $item['Quantity'] . "</td>";
                echo "<td>" . number_format($item['Price']) . " VNĐ</td>";
                echo "<td>" . number_format($item['Subtotal']) . " VNĐ</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p>❌ " . $cartData['message'] . "</p>";
    }
}

// Test 5: Test AJAX endpoint
echo "<h3>🌐 Test 5: Test AJAX endpoint</h3>";
echo "<p>Để test AJAX endpoint, bạn có thể sử dụng:</p>";
echo "<pre>";
echo "POST: ?page=ajax\n";
echo "Body: action=add_to_cart&product_id=" . $testProduct['Product_Id'] . "&quantity=1\n";
echo "Response: JSON format với success/error message";
echo "</pre>";

// Test 6: Kiểm tra cấu trúc database
echo "<h3>🗄️ Test 6: Kiểm tra cấu trúc database</h3>";
try {
    // Kiểm tra bảng Cart
    $sql = "SELECT TOP 1 * FROM Cart";
    $stmt = $conn->query($sql);
    $cartStructure = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cartStructure) {
        echo "<p>✅ Bảng Cart có cấu trúc: " . implode(', ', array_keys($cartStructure)) . "</p>";
    }
    
    // Kiểm tra bảng Cart_detail
    $sql = "SELECT TOP 1 * FROM Cart_detail";
    $stmt = $conn->query($sql);
    $cartDetailStructure = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cartDetailStructure) {
        echo "<p>✅ Bảng Cart_detail có cấu trúc: " . implode(', ', array_keys($cartDetailStructure)) . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Lỗi khi kiểm tra cấu trúc database: " . $e->getMessage() . "</p>";
}

echo "<h3>🎉 Kết luận</h3>";
echo "<p>Test hệ thống giỏ hàng đã hoàn thành. Kiểm tra các kết quả ở trên để đảm bảo hệ thống hoạt động đúng.</p>";

echo "<hr>";
echo "<h3>🔧 Debug Information</h3>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</p>";

// CSS cho trang test
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h2, h3 { color: #333; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
th { background: #f4f4f4; }
pre { background: #f8f8f8; padding: 10px; border-radius: 5px; }
p { margin: 8px 0; }
ul { margin: 10px 0; }
li { margin: 5px 0; }
</style>";
?>