<?php
session_start();
include './config/connection.php';

echo "<h2>🔍 Test Cart Simple</h2>";

// Kiểm tra session
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✅ Đang đăng nhập với User ID: " . $_SESSION['user_id'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ Chưa đăng nhập</p>";
    echo "<a href='?page=login'>Đăng nhập</a>";
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

// Kiểm tra sản phẩm
try {
    $products = $conn->query("SELECT TOP 3 Product_Id, Name FROM Products")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h3>📱 Sản phẩm có sẵn:</h3>";
    foreach ($products as $product) {
        echo "<p>ID: " . $product['Product_Id'] . " - " . $product['Name'] . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi kiểm tra sản phẩm: " . $e->getMessage() . "</p>";
}

// Test AJAX endpoint
echo "<h3>🧪 Test AJAX Endpoint:</h3>";
echo "<button onclick='testAjax()'>Test AJAX Add to Cart</button>";
echo "<div id='result'></div>";

?>

<script>
function testAjax() {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = 'Đang test...';
    
    fetch('?page=ajax&action=add_to_cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=1&quantity=1'
    })
    .then(response => response.text())
    .then(data => {
        resultDiv.innerHTML = '<pre>' + data + '</pre>';
    })
    .catch(error => {
        resultDiv.innerHTML = 'Lỗi: ' + error;
    });
}
</script>

<div style='margin: 20px 0;'>
    <a href='?page=home' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Về trang chủ</a>
</div> 