<?php
include './config/connection.php';

echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);'>";

echo "<h2 style='color: #333; text-align: center;'><i class='fas fa-cog'></i> Kiểm tra hệ thống Admin</h2>";

try {
    // Kiểm tra kết nối database
    echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
    echo "<strong>✅ Kết nối database thành công!</strong>";
    echo "</div>";
    
    // Kiểm tra bảng Users
    $checkTable = $conn->query("SELECT COUNT(*) FROM Users");
    $userCount = $checkTable->fetchColumn();
    
    echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
    echo "<strong>✅ Bảng Users tồn tại!</strong> Có {$userCount} người dùng trong hệ thống.";
    echo "</div>";
    
    // Kiểm tra tài khoản admin
    $checkAdmin = $conn->query("SELECT * FROM Users WHERE UserName = 'thanhcong' AND Role = 'admin'");
    $admin = $checkAdmin->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
        echo "<strong>✅ Tài khoản Admin đã tồn tại!</strong><br>";
        echo "Username: <strong>thanhcong</strong><br>";
        echo "Password: <strong>admin123</strong><br>";
        echo "Role: <strong>admin</strong><br>";
        echo "Full Name: <strong>" . htmlspecialchars($admin['FullName']) . "</strong>";
        echo "</div>";
    } else {
        echo "<div style='margin: 20px 0; padding: 15px; background: #fff3cd; border-radius: 5px; border-left: 4px solid #ffc107;'>";
        echo "<strong>⚠️ Tài khoản Admin chưa tồn tại!</strong><br>";
        echo "Đang tạo tài khoản admin...";
        echo "</div>";
        
        // Tạo tài khoản admin
        $stmt = $conn->query("SELECT TOP 1 User_id FROM Users ORDER BY User_id DESC");
        $lastId = $stmt->fetchColumn();
        
        if ($lastId) {
            $num = (int)substr($lastId, 2);
            $num++;
            $newId = 'KH' . str_pad($num, 10, '0', STR_PAD_LEFT);
        } else {
            $newId = 'KH0000000001';
        }
        
        $sql = "INSERT INTO Users (User_id, UserName, PassWord, Email, FullName, Phone, Role, Adress) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $newId,
            'thanhcong',
            'admin123',
            'admin@techshop.com',
            'Administrator',
            '0123456789',
            'admin',
            'Hà Nội, Việt Nam'
        ]);
        
        echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
        echo "<strong>✅ Đã tạo tài khoản Admin thành công!</strong><br>";
        echo "Username: <strong>thanhcong</strong><br>";
        echo "Password: <strong>admin123</strong><br>";
        echo "Role: <strong>admin</strong>";
        echo "</div>";
    }
    
    // Kiểm tra các bảng khác
    $tables = ['Products', 'Categories', 'Brands', 'Comments', 'Orders'];
    foreach ($tables as $table) {
        try {
            $count = $conn->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "<div style='margin: 10px 0; padding: 10px; background: #e7f3ff; border-radius: 5px; border-left: 4px solid #007bff;'>";
            echo "<strong>✅ Bảng $table:</strong> $count bản ghi";
            echo "</div>";
        } catch (Exception $e) {
            echo "<div style='margin: 10px 0; padding: 10px; background: #f8d7da; border-radius: 5px; border-left: 4px solid #dc3545;'>";
            echo "<strong>❌ Bảng $table:</strong> Không tồn tại hoặc lỗi";
            echo "</div>";
        }
    }
    
    echo "<div style='margin: 30px 0; text-align: center;'>";
    echo "<a href='?page=login' style='background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;'>";
    echo "<i class='fas fa-sign-in-alt'></i> Đăng nhập ngay";
    echo "</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='margin: 20px 0; padding: 15px; background: #f8d7da; border-radius: 5px; border-left: 4px solid #dc3545;'>";
    echo "<strong>❌ Lỗi:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "</div>";
?> 