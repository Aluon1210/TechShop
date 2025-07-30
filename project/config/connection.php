<?php
include 'config.php';

try {
    $dsn ="sqlsrv:Server=$host,$port;Database=$database; ConnectionPooling=0;";
    $conn = new PDO(
        $dsn, 
        $username, 
        $password,
        array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    // Kết nối thành công, không hiển thị thông báo
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
