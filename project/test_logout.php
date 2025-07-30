<?php
session_start();

echo "<h2>🔍 Test Logout Function</h2>";

// Kiểm tra session hiện tại
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✅ Đang đăng nhập với User ID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Username: " . ($_SESSION['username'] ?? 'N/A') . "</p>";
    echo "<p>Role: " . ($_SESSION['role'] ?? 'N/A') . "</p>";
    
    echo "<div style='margin: 20px 0;'>";
    echo "<a href='?page=logout' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>";
    echo "🚪 Test Logout";
    echo "</a>";
    echo "</div>";
} else {
    echo "<p style='color: orange;'>⚠️ Chưa đăng nhập</p>";
    echo "<a href='?page=login' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>";
    echo "🔐 Đăng nhập";
    echo "</a>";
}

echo "<div style='margin: 20px 0;'>";
echo "<a href='?page=home' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>";
echo "🏠 Về trang chủ";
echo "</a>";
echo "<a href='create_admin_simple.php' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>";
echo "🔧 Tạo Admin";
echo "</a>";
echo "</div>";
?> 