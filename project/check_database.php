<?php
include './config/connection.php';

echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);'>";

echo "<h2 style='color: #333; text-align: center;'>🔍 Kiểm tra Database và Tài khoản Admin</h2>";

try {
    // Kiểm tra kết nối database
    echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
    echo "<strong>✅ Kết nối database thành công!</strong>";
    echo "</div>";
    
    // Kiểm tra bảng Users
    $userCount = $conn->query("SELECT COUNT(*) FROM Users")->fetchColumn();
    echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
    echo "<strong>✅ Bảng Users:</strong> Có $userCount người dùng";
    echo "</div>";
    
    // Kiểm tra tài khoản admin
    $adminSql = "SELECT * FROM Users WHERE UserName = 'thanhcong' AND Role = 'admin'";
    $adminStmt = $conn->prepare($adminSql);
    $adminStmt->execute();
    $admin = $adminStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "<div style='margin: 20px 0; padding: 15px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;'>";
        echo "<strong>✅ Tài khoản Admin tồn tại!</strong><br>";
        echo "User ID: <strong>" . $admin['User_id'] . "</strong><br>";
        echo "Username: <strong>thanhcong</strong><br>";
        echo "Password: <strong>admin123</strong><br>";
        echo "Role: <strong>admin</strong><br>";
        echo "Full Name: <strong>" . htmlspecialchars($admin['FullName']) . "</strong><br>";
        echo "Email: <strong>" . htmlspecialchars($admin['Email']) . "</strong>";
        echo "</div>";
    } else {
        echo "<div style='margin: 20px 0; padding: 15px; background: #fff3cd; border-radius: 5px; border-left: 4px solid #ffc107;'>";
        echo "<strong>⚠️ Tài khoản Admin chưa tồn tại!</strong><br>";
        echo "Vui lòng chạy file create_admin_simple.php để tạo tài khoản admin.";
        echo "</div>";
    }
    
    // Kiểm tra các bảng khác
    $tables = ['Products', 'Cart', 'Cart_detail', 'Orders', 'Order_detail'];
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
    
    // Hiển thị tất cả users
    echo "<div style='margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px;'>";
    echo "<h3>👥 Danh sách tất cả Users:</h3>";
    $users = $conn->query("SELECT User_id, UserName, FullName, Role, Email FROM Users ORDER BY User_id")->fetchAll(PDO::FETCH_ASSOC);
    
    if ($users) {
        echo "<table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>";
        echo "<tr style='background: #e9ecef;'>";
        echo "<th style='padding: 8px; border: 1px solid #ddd; text-align: left;'>User ID</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd; text-align: left;'>Username</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd; text-align: left;'>Full Name</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd; text-align: left;'>Role</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd; text-align: left;'>Email</th>";
        echo "</tr>";
        
        foreach ($users as $user) {
            $roleColor = $user['Role'] === 'admin' ? '#dc3545' : '#28a745';
            echo "<tr>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($user['User_id']) . "</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($user['UserName']) . "</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($user['FullName']) . "</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd; color: $roleColor; font-weight: bold;'>" . htmlspecialchars($user['Role']) . "</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($user['Email']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Không có user nào trong database.</p>";
    }
    echo "</div>";
    
    echo "<div style='margin: 30px 0; text-align: center;'>";
    echo "<a href='create_admin_simple.php' style='background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 10px;'>";
    echo "🔧 Tạo Admin";
    echo "</a>";
    echo "<a href='?page=login' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 10px;'>";
    echo "🔐 Đăng nhập";
    echo "</a>";
    echo "<a href='?page=home' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 10px;'>";
    echo "🏠 Trang chủ";
    echo "</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='margin: 20px 0; padding: 15px; background: #f8d7da; border-radius: 5px; border-left: 4px solid #dc3545;'>";
    echo "<strong>❌ Lỗi Database:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "</div>";
?> 