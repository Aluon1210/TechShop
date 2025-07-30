<?php


try {
    // Lấy mã ID cuối cùng để tự tăng tiếp
    $stmt = $conn->query("SELECT TOP 1 User_id FROM Users ORDER BY User_id DESC");
    $lastId = $stmt->fetchColumn();

    if ($lastId) {
        $num = (int)substr($lastId, 2); // Bỏ 'KH'
        $num++;
        $newId = 'KH' . str_pad($num, 10, '0', STR_PAD_LEFT);
    } else {
        $newId = 'KH0000000001';
    }

    // Lấy dữ liệu từ form
    $User_Id = $newId;
    $UserName = $_POST['UserName'];
    $PassWord = $_POST['PassWord'];
    $Email = $_POST['Email'];
    $FullName = $_POST['FullName'];
    $Phone = $_POST['Phone'];
    $Role = $_POST['Role'];
    $Adress = $_POST['Adress'];

    // Chuẩn bị SQL
    $sql = "INSERT INTO Users (User_id, UserName, PassWord, Email, FullName, Phone, Role, Adress)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$User_Id, $UserName, $PassWord, $Email, $FullName, $Phone, $Role, $Adress]);

    echo "✅ Thêm người dùng thành công với mã: $User_Id";
} catch (PDOException $e) {
    echo "❌ Lỗi khi insert: " . $e->getMessage();
}
?>
