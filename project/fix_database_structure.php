<?php
include './config/connection.php';

echo "<h2>🔧 Sửa cấu trúc Database</h2>";

// Kiểm tra và sửa bảng Cart_detail
try {
    // Kiểm tra xem Cart_Item_Id có IDENTITY không
    $sql = "SELECT COLUMN_NAME, IS_IDENTITY 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'Cart_detail' AND COLUMN_NAME = 'Cart_Item_Id'";
    $stmt = $conn->query($sql);
    $columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($columnInfo && $columnInfo['IS_IDENTITY'] == 'NO') {
        echo "<p style='color: orange;'>⚠️ Cart_Item_Id chưa có IDENTITY, đang sửa...</p>";
        
        // Tạo bảng tạm
        $conn->exec("CREATE TABLE Cart_detail_temp (
            Cart_Item_Id INT IDENTITY(1,1) PRIMARY KEY,
            Cart_Id INT NOT NULL,
            Product_Id VARCHAR(100) NOT NULL,
            Quantity INT NOT NULL DEFAULT 1
        )");
        
        // Copy dữ liệu
        $conn->exec("INSERT INTO Cart_detail_temp (Cart_Id, Product_Id, Quantity) 
                     SELECT Cart_Id, Product_Id, Quantity FROM Cart_detail");
        
        // Xóa bảng cũ và đổi tên bảng mới
        $conn->exec("DROP TABLE Cart_detail");
        $conn->exec("EXEC sp_rename 'Cart_detail_temp', 'Cart_detail'");
        
        // Thêm foreign key constraints
        $conn->exec("ALTER TABLE Cart_detail ADD CONSTRAINT FK_Cart_detail_Cart 
                     FOREIGN KEY (Cart_Id) REFERENCES Cart(Cart_Id)");
        $conn->exec("ALTER TABLE Cart_detail ADD CONSTRAINT FK_Cart_detail_Products 
                     FOREIGN KEY (Product_Id) REFERENCES Products(Product_Id)");
        
        echo "<p style='color: green;'>✅ Đã sửa bảng Cart_detail thành công</p>";
    } else {
        echo "<p style='color: green;'>✅ Bảng Cart_detail đã đúng cấu trúc</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi sửa Cart_detail: " . $e->getMessage() . "</p>";
}

// Kiểm tra và sửa bảng Orders
try {
    // Kiểm tra xem Order_Id có IDENTITY không
    $sql = "SELECT COLUMN_NAME, IS_IDENTITY 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'Orders' AND COLUMN_NAME = 'Order_Id'";
    $stmt = $conn->query($sql);
    $columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($columnInfo && $columnInfo['IS_IDENTITY'] == 'NO') {
        echo "<p style='color: orange;'>⚠️ Order_Id chưa có IDENTITY, đang sửa...</p>";
        
        // Tạo bảng tạm
        $conn->exec("CREATE TABLE Orders_temp (
            Order_Id INT IDENTITY(1,1) PRIMARY KEY,
            User_id VARCHAR(100) NOT NULL,
            Order_date DATE NOT NULL,
            Status INT NOT NULL DEFAULT 1
        )");
        
        // Copy dữ liệu
        $conn->exec("INSERT INTO Orders_temp (User_id, Order_date, Status) 
                     SELECT User_id, Order_date, Status FROM Orders");
        
        // Xóa bảng cũ và đổi tên bảng mới
        $conn->exec("DROP TABLE Orders");
        $conn->exec("EXEC sp_rename 'Orders_temp', 'Orders'");
        
        // Thêm foreign key constraint
        $conn->exec("ALTER TABLE Orders ADD CONSTRAINT FK_Orders_Users 
                     FOREIGN KEY (User_id) REFERENCES Users(User_id)");
        
        echo "<p style='color: green;'>✅ Đã sửa bảng Orders thành công</p>";
    } else {
        echo "<p style='color: green;'>✅ Bảng Orders đã đúng cấu trúc</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi sửa Orders: " . $e->getMessage() . "</p>";
}

// Kiểm tra và sửa bảng Cart
try {
    // Kiểm tra xem Cart_Id có IDENTITY không
    $sql = "SELECT COLUMN_NAME, IS_IDENTITY 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'Cart' AND COLUMN_NAME = 'Cart_Id'";
    $stmt = $conn->query($sql);
    $columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($columnInfo && $columnInfo['IS_IDENTITY'] == 'NO') {
        echo "<p style='color: orange;'>⚠️ Cart_Id chưa có IDENTITY, đang sửa...</p>";
        
        // Tạo bảng tạm
        $conn->exec("CREATE TABLE Cart_temp (
            Cart_Id INT IDENTITY(1,1) PRIMARY KEY,
            User_id VARCHAR(100) NOT NULL,
            Create_at DATE NOT NULL,
            Update_at DATE NOT NULL
        )");
        
        // Copy dữ liệu
        $conn->exec("INSERT INTO Cart_temp (User_id, Create_at, Update_at) 
                     SELECT User_id, Create_at, Update_at FROM Cart");
        
        // Xóa bảng cũ và đổi tên bảng mới
        $conn->exec("DROP TABLE Cart");
        $conn->exec("EXEC sp_rename 'Cart_temp', 'Cart'");
        
        // Thêm foreign key constraint
        $conn->exec("ALTER TABLE Cart ADD CONSTRAINT FK_Cart_Users 
                     FOREIGN KEY (User_id) REFERENCES Users(User_id)");
        
        echo "<p style='color: green;'>✅ Đã sửa bảng Cart thành công</p>";
    } else {
        echo "<p style='color: green;'>✅ Bảng Cart đã đúng cấu trúc</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi sửa Cart: " . $e->getMessage() . "</p>";
}

// Hiển thị thống kê sau khi sửa
echo "<h3>📊 Thống kê sau khi sửa:</h3>";

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
echo "<a href='test_add_to_cart.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🧪 Test Cart</a>";
echo "</div>";
?> 