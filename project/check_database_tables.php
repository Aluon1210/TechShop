<?php
include './config/connection.php';

echo "<h2>🔍 Kiểm tra Database Tables</h2>";

// Kiểm tra và tạo bảng Cart nếu chưa có
try {
    $conn->query("SELECT COUNT(*) FROM Cart");
    echo "<p style='color: green;'>✅ Bảng Cart đã tồn tại</p>";
} catch (Exception $e) {
    echo "<p style='color: orange;'>⚠️ Bảng Cart chưa tồn tại, đang tạo...</p>";
    
                    $sql = "CREATE TABLE Cart (
                    Cart_Id INT IDENTITY(1,1) PRIMARY KEY,
                    User_id VARCHAR(100) NOT NULL,
                    Create_at DATE NOT NULL,
                    Update_at DATE NOT NULL,
                    FOREIGN KEY (User_id) REFERENCES Users(User_id)
                )";
    
    try {
        $conn->exec($sql);
        echo "<p style='color: green;'>✅ Đã tạo bảng Cart thành công</p>";
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Lỗi tạo bảng Cart: " . $e2->getMessage() . "</p>";
    }
}

// Kiểm tra và tạo bảng Cart_detail nếu chưa có
try {
    $conn->query("SELECT COUNT(*) FROM Cart_detail");
    echo "<p style='color: green;'>✅ Bảng Cart_detail đã tồn tại</p>";
} catch (Exception $e) {
    echo "<p style='color: orange;'>⚠️ Bảng Cart_detail chưa tồn tại, đang tạo...</p>";
    
                    $sql = "CREATE TABLE Cart_detail (
                    Cart_Item_Id INT IDENTITY(1,1) PRIMARY KEY,
                    Cart_Id INT NOT NULL,
                    Product_Id VARCHAR(100) NOT NULL,
                    Quantity INT NOT NULL DEFAULT 1,
                    FOREIGN KEY (Cart_Id) REFERENCES Cart(Cart_Id),
                    FOREIGN KEY (Product_Id) REFERENCES Products(Product_Id)
                )";
    
    try {
        $conn->exec($sql);
        echo "<p style='color: green;'>✅ Đã tạo bảng Cart_detail thành công</p>";
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Lỗi tạo bảng Cart_detail: " . $e2->getMessage() . "</p>";
    }
}

// Kiểm tra và tạo bảng Orders nếu chưa có
try {
    $conn->query("SELECT COUNT(*) FROM Orders");
    echo "<p style='color: green;'>✅ Bảng Orders đã tồn tại</p>";
} catch (Exception $e) {
    echo "<p style='color: orange;'>⚠️ Bảng Orders chưa tồn tại, đang tạo...</p>";
    
                    $sql = "CREATE TABLE Orders (
                    Order_Id INT IDENTITY(1,1) PRIMARY KEY,
                    User_id VARCHAR(100) NOT NULL,
                    Order_date DATE NOT NULL,
                    Status INT NOT NULL DEFAULT 1,
                    FOREIGN KEY (User_id) REFERENCES Users(User_id)
                )";
    
    try {
        $conn->exec($sql);
        echo "<p style='color: green;'>✅ Đã tạo bảng Orders thành công</p>";
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Lỗi tạo bảng Orders: " . $e2->getMessage() . "</p>";
    }
}

// Kiểm tra và tạo bảng Order_detail nếu chưa có
try {
    $conn->query("SELECT COUNT(*) FROM Order_detail");
    echo "<p style='color: green;'>✅ Bảng Order_detail đã tồn tại</p>";
} catch (Exception $e) {
    echo "<p style='color: orange;'>⚠️ Bảng Order_detail chưa tồn tại, đang tạo...</p>";
    
                    $sql = "CREATE TABLE Order_detail (
                    Order_Detail_Id INT IDENTITY(1,1) PRIMARY KEY,
                    Order_Id INT NOT NULL,
                    Product_Id VARCHAR(100) NOT NULL,
                    quantity INT NOT NULL,
                    price INT NOT NULL,
                    FOREIGN KEY (Order_Id) REFERENCES Orders(Order_Id),
                    FOREIGN KEY (Product_Id) REFERENCES Products(Product_Id)
                )";
    
    try {
        $conn->exec($sql);
        echo "<p style='color: green;'>✅ Đã tạo bảng Order_detail thành công</p>";
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Lỗi tạo bảng Order_detail: " . $e2->getMessage() . "</p>";
    }
}

// Hiển thị thống kê
echo "<h3>📊 Thống kê Database:</h3>";

try {
    $userCount = $conn->query("SELECT COUNT(*) FROM Users")->fetchColumn();
    echo "<p>👥 Users: $userCount</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi đếm Users</p>";
}

try {
    $productCount = $conn->query("SELECT COUNT(*) FROM Products")->fetchColumn();
    echo "<p>📱 Products: $productCount</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi đếm Products</p>";
}

try {
    $cartCount = $conn->query("SELECT COUNT(*) FROM Cart")->fetchColumn();
    echo "<p>🛒 Cart: $cartCount</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi đếm Cart</p>";
}

try {
    $cartDetailCount = $conn->query("SELECT COUNT(*) FROM Cart_detail")->fetchColumn();
    echo "<p>📦 Cart_detail: $cartDetailCount</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi đếm Cart_detail</p>";
}

echo "<div style='margin: 20px 0;'>";
echo "<a href='?page=home' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🏠 Về trang chủ</a>";
echo "<a href='test_cart_simple.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🧪 Test Cart</a>";
echo "</div>";
?> 