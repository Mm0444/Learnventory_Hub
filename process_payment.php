<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// รับข้อมูลจาก AJAX
$cart = json_decode($_POST['cart'], true);

foreach ($cart as $item) {
    $p_ID = $item['id'];
    $quantity = $item['qty'];
    $total_price = $item['price'] * $quantity;

    // บันทึกข้อมูลการขาย
    $sql = "INSERT INTO Sales (user_id, p_ID, quantity, total_price) VALUES ('$user_id', '$p_ID', '$quantity', '$total_price')";
    $conn->query($sql);

    // อัปเดตสต็อกสินค้า
    $conn->query("UPDATE Product SET p_total = p_total - $quantity WHERE p_ID = '$p_ID'");
}

// ส่งสถานะกลับ
echo "success";
