<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงรายการหมวดหมู่
$sql_cat = "SELECT * FROM Categories";
$categories = $conn->query($sql_cat);

// กรองสินค้าตามหมวดหมู่
$filter_c_ID = isset($_GET['filter_c_ID']) ? $_GET['filter_c_ID'] : '';
$sql = "SELECT Product.*, Categories.c_name FROM Product LEFT JOIN Categories ON Product.c_ID = Categories.c_ID";
if ($filter_c_ID != '') {
    $sql .= " WHERE Product.c_ID = '$filter_c_ID'";
}
$products = $conn->query($sql);

// เพิ่มสินค้า
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_detail = $_POST['p_detail'];
    $p_price = $_POST['p_price'];
    $p_total = $_POST['p_total'];
    $c_ID = $_POST['c_ID'];

    $sql = "INSERT INTO Product (p_name, p_detail, p_price, p_total, c_ID) VALUES ('$p_name', '$p_detail', '$p_price', '$p_total', '$c_ID')";
    $conn->query($sql);
    header("Location: manage_products.php");
    exit();
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $p_ID = $_GET['delete'];
    $conn->query("DELETE FROM Product WHERE p_ID='$p_ID'");
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>

    <!-- Google Fonts: Bai Jamjuree -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            font-family: 'Bai Jamjuree', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
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
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }

        .filter-form {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 25px;
            margin-bottom: 20px;
            background-color: #ffffffcc;
            border-radius: 8px;
            font-weight: bold;
            gap: 10px;
            width: fit-content;
            margin: auto;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-form label {
            color: #0D4C92;
            font-size: 15px;
        }

        .filter-form select {
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f5faff;
            color: #333;
        }

        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            margin: 20px auto;
            width: 95%; 
}

.table-container {
    flex: 2; 
    min-width: 600px;
    max-width: 1200px;
    max-height: 700px; 
    overflow-y: auto;
    background-color: #F7FBFC;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.15);
}

        .table-container::-webkit-scrollbar {
            width: 6px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
            
        }

        th {
            background-color: #0D4C92;
            color: white;
        }

        .add-form {
    flex: 1; /* ลดขนาดฟอร์ม */
    min-width: 250px;
    max-width: 300px;
    background-color: #ffffffcc;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
}

        .add-form h3 {
            margin-top: 0;
        }

        .add-form input,
        .add-form textarea,
        .add-form select {
            width: 100%;
            margin-bottom: 10px;
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: 'Bai Jamjuree', sans-serif;
        }

        .add-form button {
            width: 100%;
            background-color: #0D4C92;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Bai Jamjuree', sans-serif;
        }

        .add-form button:hover {
            background-color: #063970;
        }

        a {
            font-family: 'Bai Jamjuree', sans-serif;
        }
    </style>
</head>

<body>
    <h2>📦 Manage Products</h2>
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <form method="GET" class="filter-form">
        <label for="filter_c_ID">🗂️ เลือกหมวดหมู่:</label>
        <select name="filter_c_ID" id="filter_c_ID" onchange="this.form.submit()">
            <option value="">-- แสดงทั้งหมด --</option>
            <?php while ($row = $categories->fetch_assoc()) { ?>
                <option value="<?= $row['c_ID'] ?>" <?= ($filter_c_ID == $row['c_ID']) ? 'selected' : '' ?>>
                    <?= $row['c_name'] ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <div class="content-wrapper">
        <div class="table-container">
            <h3>รายการสินค้า</h3>
            <table>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อสินค้า</th>
                    <th>รายละเอียด</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>หมวดหมู่</th>
                    <th>การจัดการ</th>
                </tr>
                <?php while ($row = $products->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['p_ID'] ?></td>
                        <td><?= $row['p_name'] ?></td>
                        <td><?= $row['p_detail'] ?></td>
                        <td><?= number_format($row['p_price'], 2) ?> บาท</td>
                        <td><?= $row['p_total'] ?></td>
                        <td><?= $row['c_name'] ?></td>
                        <td>
                            <a href="edit_product.php?p_ID=<?= $row['p_ID'] ?>">✏️ แก้ไข</a> |
                            <a href="manage_products.php?delete=<?= $row['p_ID'] ?>" onclick="return confirm('ลบสินค้านี้?')">🗑️ ลบ</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <form method="POST" class="add-form">
            <h3>เพิ่มสินค้าใหม่</h3>
            <label>ชื่อสินค้า:</label>
            <input type="text" name="p_name" required>
            <label>รายละเอียด:</label>
            <textarea name="p_detail"></textarea>
            <label>ราคา:</label>
            <input type="number" name="p_price" step="0.01" required>
            <label>จำนวน:</label>
            <input type="number" name="p_total" required>
            <label>หมวดหมู่:</label>
            <select name="c_ID" required>
                <?php
                $categories->data_seek(0);
                while ($row = $categories->fetch_assoc()) {
                    echo "<option value='{$row['c_ID']}'>{$row['c_name']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="add_product">เพิ่มสินค้า</button>
        </form>
    </div>
</body>

</html>
