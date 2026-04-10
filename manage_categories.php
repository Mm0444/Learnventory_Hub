<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงหมวดหมู่ทั้งหมด
$sql = "SELECT * FROM Categories";
$categories = $conn->query($sql);

// เพิ่มหมวดหมู่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $c_name = $_POST['c_name'];
    $conn->query("INSERT INTO Categories (c_name) VALUES ('$c_name')");
    header("Location: manage_categories.php");
    exit();
}

// ลบหมวดหมู่
if (isset($_GET['delete'])) {
    $c_ID = $_GET['delete'];
    $conn->query("DELETE FROM Categories WHERE c_ID='$c_ID'");
    header("Location: manage_categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            /* ไล่สี */
        }

        .back-home {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 15px;
            padding: 8px 15px;
            border: 2px solid #0D4C92;
            /* กำหนดกรอบ */
            border-radius: 5px;
            /* ทำให้มุมโค้ง */
            background-color: white;
            /* สีพื้นหลัง */
            color: #0D4C92;
            /* สีตัวอักษร */
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }

        body {
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                text-align: center;
            }


            /* ส่วนหัวข้อ "Manage Categories" */
            h2 {
                text-align: center;
                font-size: 30px;
                margin-top: 50px;
            }

            /* ส่วนฟอร์มเพิ่มหมวดหมู่ใหม่ */
            .form-section {
                margin: 20px;
                padding: -5px;
                text-align: center;
                /* จัดให้อยู่ตรงกลาง */
            }

            .form-section input,
            .form-section button {
                padding: 8px;
                margin: 5px;
            }

            /* กรอบตาราง */
            .table-container {
                background: white;
                width: 90%;
                margin: auto;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-top: 40px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th {
                background: #0D4C92;
                color: white;
                padding: 10px;
            }

            td {
                padding: 10px;
                border: 1px solid #ddd;
            }

            tr:nth-child(even) {
                background: #f9f9f9;
            }

            button {
                background: #0D4C92;
                color: white;
                border: none;
                padding: 8px 12px;
                cursor: pointer;
            }

            button:hover {
                background: #0D4C92;
            }

            td:first-child {
                text-align: center;
                /* จัดให้อยู่ตรงกลาง */
            }

        }
    </style>
</head>

<body>

    <!-- หัวข้อที่ไม่อยู่ในกรอบ -->
    <h2>📂 Manage Categories</h2>
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <!-- ฟอร์มเพิ่มหมวดหมู่ใหม่ที่ไม่อยู่ในกรอบ -->
    <div class="form-section">
        <h3>เพิ่มหมวดหมู่ใหม่</h3>
        <form method="POST">
            <label>ชื่อหมวดหมู่:</label>
            <input type="text" name="c_name" required>
            <button type="submit" name="add_category">เพิ่ม</button>
        </form>
    </div>

    <!-- กรอบตาราง -->
    <div class="table-container">
        <h3>รายการหมวดหมู่</h3>
        <table border="1">
            <tr>
                <th>รหัส</th>
                <th>ชื่อหมวดหมู่</th>
                <th>การจัดการ</th>
            </tr>
            <?php while ($row = $categories->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['c_ID'] ?></td>
                    <td><?= $row['c_name'] ?></td>
                    <td>
                        <a href="manage_categories.php?delete=<?= $row['c_ID'] ?>"
                            onclick="return confirm('ลบหมวดหมู่นี้?')">🗑️ ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>