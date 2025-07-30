<?php
include './config/connection.php';

try {
    // Tự tạo Product_Id mới
    $stmt = $conn->query("SELECT TOP 1 Product_Id FROM products ORDER BY Product_Id DESC");
    $lastId = $stmt->fetchColumn();
    $newId = $lastId ? $lastId + 1 : 1;

    // Lấy dữ liệu từ form
    $name = $_POST['username'];
    $description = $_POST['description'];
    $Price = $_POST['Price'];
    $Quantity = $_POST['Quantity'];
    $Image = $_POST['image'];
    $Category_Name = $_POST['Category_Name'];
    $Brand_Name = $_POST['Brand_Name'];

    // Lấy Category_Id từ Category_Name
    $stmt = $conn->prepare("SELECT Category_Id FROM Categories WHERE Category_Name = ?");
    $stmt->execute([$Category_Name]);
    $Category_Id = $stmt->fetchColumn();

    // Lấy Brand_Id từ Brand_Name
    $stmt = $conn->prepare("SELECT Brand_Id FROM Brands WHERE Brand_Name = ?");
    $stmt->execute([$Brand_Name]);
    $Brand_Id = $stmt->fetchColumn();

    // Chèn dữ liệu vào bảng Products
    $sql = "INSERT INTO products (Product_Id, name, description, Price, Quantity, Image, Brand_Id ,Category_Id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$newId, $name, $description, $Price, $Quantity, $Image, $Brand_Id, $Category_Id]);

    if ($success) {
        echo "✅ Sản phẩm: $name đã được thêm thành công.";
    } else {
        echo "❌ Thêm sản phẩm thất bại.";
    }

} catch (PDOException $e) {
    echo "❌ Lỗi khi insert: " . $e->getMessage();
}
