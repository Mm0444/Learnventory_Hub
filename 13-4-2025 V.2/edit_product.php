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
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <!-- Google Font Bai Jamjuree -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background: linear-gradient(to right, #769FCD, #B9D7EA); /* ไล่สี */
            padding: 0;
            margin: 0;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            background: #F7FBFC;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 60px;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #0D4C92;
        }

        a {
            display: block;
            text-align: center;
            font-size: 16px;
            color: #0D4C92;
            margin-bottom: 20px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        label {
            font-size: 18px;
            margin-bottom: 5px;
            display: inline-block;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #0D4C92;
            color: white;
            padding: 10px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-family: 'Bai Jamjuree', sans-serif;
        }

        button:hover {
            background-color: #083b73;
        }

        textarea {
            height: 100px;
        }

        .back-home {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 15px;
            padding: 8px 15px;
            border: 2px solid #0D4C92;
            border-radius: 5px;
            background-color: white;
            color: #0D4C92;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }

    </style>
</head>

<body>

    <div class="container">
        <h2>แก้ไขข้อมูลสินค้า</h2>
        <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

        <form method="POST">
            <label for="p_name">ชื่อสินค้า:</label>
            <input type="text" name="p_name" id="p_name" value="<?= $product['p_name'] ?>" required>

            <label for="p_detail">รายละเอียด:</label>
            <textarea name="p_detail" id="p_detail"><?= $product['p_detail'] ?></textarea>

            <label for="p_price">ราคา:</label>
            <input type="number" name="p_price" id="p_price" value="<?= $product['p_price'] ?>" step="0.01" required>

            <label for="p_total">จำนวน:</label>
            <input type="number" name="p_total" id="p_total" value="<?= $product['p_total'] ?>" required>

            <button type="submit">อัปเดตสินค้า</button>
        </form>
    </div>

</body>

</html>
