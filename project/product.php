<?php
include './config/connection.php';
?>
<form action="insertproduct.php" method="post">
    <label for="username">Tên sản phẩm:</label>
    <input type="text" id="username" name="username" required>
    <br>

    <label for="Brand_Name">Hãng sản phẩm:</label>
    <select name="Brand_Name" id="Brand_Name">
        <?php
        $sql = "SELECT Brand_Name FROM Brands ORDER BY Brand_Id ASC";
        $stmt = $conn->query($sql);
        $hangs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($hangs as $row) {
            echo '<option value="' . htmlspecialchars($row['Brand_Name']) . '">' . htmlspecialchars($row['Brand_Name']) . '</option>';
        }
        ?>
    </select>
    <br>

    <label for="description">Mô tả:</label>
    <input type="text" id="description" name="description">
    <br>

    <label for="Price">Đơn giá:</label>
    <input type="number" name="Price" required>
    <br>

    <label for="Quantity">Số lượng:</label>
    <input type="number" name="Quantity" required>
    <br>

    <label for="image">Ảnh minh họa:</label>
    <textarea id="image" name="image" required></textarea>
    <br>

    <label for="Category_Name">Danh mục:</label>
    <select name="Category_Name" id="Category_Name">
        <?php
        $sql = "SELECT Category_Name FROM Categories ORDER BY Category_Id ASC";
        $stmt = $conn->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $row) {
            echo '<option value="' . htmlspecialchars($row['Category_Name']) . '">' . htmlspecialchars($row['Category_Name']) . '</option>';
        }
        ?>
    </select>
    <br>

    <button type="submit">Thêm sản phẩm</button>
</form>
