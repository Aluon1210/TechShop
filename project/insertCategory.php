<?php
include './config/connection.php';

try {

    


    $Category_Name = $_POST['Category_Name'] ?? null;
    

    // Kiểm tra dữ liệu
    if ( empty($Category_Name)) {
        throw new Exception("Vui lòng nhập đầy đủ Mã và Tên danh mục.");
    }

    // Chuẩn bị SQL
    $sql = "INSERT INTO Categories (Category_Name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$Category_Name]);

    echo "✅ Thêm danh mục thành công với mã: $Category_Name";
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage();
} catch (PDOException $e) {
    echo "❌ Lỗi khi insert vào CSDL: " . $e->getMessage();
}
