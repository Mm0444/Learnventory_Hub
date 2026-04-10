<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['p_ID'])) {
    header("Location: manage_products.php");
    exit();
}

$p_ID = $_GET['p_ID'];
$product = $conn->query("SELECT * FROM Product WHERE p_ID='$p_ID'")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_detail = $_POST['p_detail'];
    $p_price = $_POST['p_price'];
    $p_total = $_POST['p_total'];

    $sql = "UPDATE Product SET p_name='$p_name', p_detail='$p_detail', p_price='$p_price', p_total='$p_total' WHERE p_ID='$p_ID'";
    $conn->query($sql);
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <h2>Edit Product</h2>
    <a href="manage_products.php">🔙 กลับไปจัดการสินค้า</a>

    <form method="POST">
        <label>ชื่อสินค้า:</label>
        <input type="text" name="p_name" value="<?= $product['p_name'] ?>" required><br>
        <label>รายละเอียด:</label>
        <textarea name="p_detail"><?= $product['p_detail'] ?></textarea><br>
        <label>ราคา:</label>
        <input type="number" name="p_price" step="0.01" value="<?= $product['p_price'] ?>" required><br>
        <label>จำนวน:</label>
        <input type="number" name="p_total" value="<?= $product['p_total'] ?>" required><br>
        <button type="submit">อัปเดตสินค้า</button>
    </form>
</body>

</html>