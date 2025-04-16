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
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <!-- โหลด Google Font Bai Jamjuree -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            text-align: center;
            margin: 0;
            padding: 0;
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

        h2 {
            font-size: 30px;
            margin-top: 50px;
        }

        .form-section {
            margin: 20px;
            text-align: center;
        }

        .form-section input,
        .form-section button {
            padding: 8px;
            margin: 5px;
            font-family: 'Bai Jamjuree', sans-serif;
        }

        .table-container {
            background: white;
            width: 90%;
            margin: 40px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            background: #063970;
        }

        td:first-child {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>📂 Manage Categories</h2>
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <div class="form-section">
        <h3>เพิ่มหมวดหมู่ใหม่</h3>
        <form method="POST">
            <label>ชื่อหมวดหมู่:</label>
            <input type="text" name="c_name" required>
            <button type="submit" name="add_category">เพิ่ม</button>
        </form>
    </div>

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
                        <a href="manage_categories.php?delete=<?= $row['c_ID'] ?>" onclick="return confirm('ลบหมวดหมู่นี้?')">🗑️ ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
