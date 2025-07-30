<?php
include './config/connection.php';

echo "<h2>🔧 Tạo tài khoản Admin</h2>";

try {
    // Thông tin admin cố định
    $adminUsername = 'thanhcong';
    $adminPassword = 'admin123';
    $adminEmail = 'admin@techshop.com';
    $adminFullName = 'Administrator';
    $adminPhone = '0123456789';
    $adminRole = 'admin';
    $adminAddress = 'Hà Nội, Việt Nam';
    
    // Kiểm tra admin đã tồn tại chưa
    $checkSql = "SELECT * FROM Users WHERE UserName = ? AND Role = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([$adminUsername, $adminRole]);
    $existingAdmin = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingAdmin) {
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3 style='color: #155724;'>✅ Tài khoản Admin đã tồn tại!</h3>";
        echo "<p><strong>Username:</strong> $adminUsername</p>";
        echo "<p><strong>Password:</strong> $adminPassword</p>";
        echo "<p><strong>Role:</strong> $adminRole</p>";
        echo "<p><strong>Full Name:</strong> " . $existingAdmin['FullName'] . "</p>";
        echo "</div>";
    } else {
        // Tạo User_id mới
        $idStmt = $conn->query("SELECT TOP 1 User_id FROM Users ORDER BY User_id DESC");
        $lastId = $idStmt->fetchColumn();
        
        if ($lastId) {
            $num = (int)substr($lastId, 2);
            $num++;
            $newId = 'KH' . str_pad($num, 10, '0', STR_PAD_LEFT);
        } else {
            $newId = 'KH0000000001';
        }
        
        // Tạo tài khoản admin
        $insertSql = "INSERT INTO Users (User_id, UserName, PassWord, Email, FullName, Phone, Role, Adress) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $result = $insertStmt->execute([
            $newId,
            $adminUsername,
            $adminPassword,
            $adminEmail,
            $adminFullName,
            $adminPhone,
            $adminRole,
            $adminAddress
        ]);
        
        if ($result) {
            echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<h3 style='color: #155724;'>✅ Đã tạo tài khoản Admin thành công!</h3>";
            echo "<p><strong>User ID:</strong> $newId</p>";
            echo "<p><strong>Username:</strong> $adminUsername</p>";
            echo "<p><strong>Password:</strong> $adminPassword</p>";
            echo "<p><strong>Role:</strong> $adminRole</p>";
            echo "<p><strong>Full Name:</strong> $adminFullName</p>";
            echo "<p><strong>Email:</strong> $adminEmail</p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<h3 style='color: #721c24;'>❌ Lỗi khi tạo tài khoản Admin!</h3>";
            echo "</div>";
        }
    }
    
    echo "<div style='margin: 20px 0; padding: 15px; background: #e7f3ff; border-radius: 5px;'>";
    echo "<h3>📋 Thông tin đăng nhập Admin:</h3>";
    echo "<p><strong>Username:</strong> $adminUsername</p>";
    echo "<p><strong>Password:</strong> $adminPassword</p>";
    echo "<p><strong>Role:</strong> $adminRole</p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 20px 0;'>";
    echo "<a href='?page=login' style='background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 10px;'>";
    echo "🔐 Đăng nhập ngay";
    echo "</a>";
    echo "<a href='?page=home' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 10px;'>";
    echo "🏠 Về trang chủ";
    echo "</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3 style='color: #721c24;'>❌ Lỗi Database:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?> 