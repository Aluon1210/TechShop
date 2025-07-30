<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form thêm người dùng</title>
</head>
<body>
    <h2>Thêm người dùng mới</h2>
    <form action="insert.php" method="post">
        <label for="UserName">Tên đăng nhập:</label><br>
        <input type="text" name="UserName" required><br><br>

        <label for="PassWord">Mật khẩu:</label><br>
        <input type="password" name="PassWord" required><br><br>

        <label for="Email">Email:</label><br>
        <input type="email" name="Email" required><br><br>

        <label for="FullName">Họ và tên:</label><br>
        <input type="text" name="FullName" required><br><br>

        <label for="Phone">Số điện thoại:</label><br>
        <input type="text" name="Phone" required><br><br>

        <input type="hidden" name="Role" value="person">

        <label for="Adress">Địa chỉ:</label><br>
        <textarea name="Adress" rows="3" required></textarea><br><br>

        <button type="submit">Thêm người dùng</button>
    </form>
</body>
</html>
