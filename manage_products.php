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
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT Product.*, Categories.c_name FROM Product LEFT JOIN Categories ON Product.c_ID = Categories.c_ID";
$conditions = [];
if ($filter_c_ID != '') {
    $conditions[] = "Product.c_ID = '$filter_c_ID'";
}
if ($search != '') {
    $conditions[] = "Product.p_name LIKE '%$search%'";
}
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$products = $conn->query($sql);

// ดึงหมวดหมู่สำหรับ dropdown ฟอร์มเพิ่ม
$sql_cat2 = "SELECT * FROM Categories";
$categories_form = $conn->query($sql_cat2);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background: linear-gradient(135deg, #769FCD 0%, #B9D7EA 50%, #D6EAF8 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        /* ปุ่มกลับหน้าหลัก */
        .back-home {
            position: fixed;
            top: 18px;
            right: 24px;
            font-size: 14px;
            padding: 8px 18px;
            border: 2px solid #0D4C92;
            border-radius: 8px;
            background-color: white;
            color: #0D4C92;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }

        /* หัวข้อ */
        .page-title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 22px;
            letter-spacing: 0.3px;
        }

        /* แถบกรอง + ค้นหา */
        .filter-bar {
            background: white;
            border-radius: 12px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            width: fit-content;
            margin: 0 auto 20px auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .filter-bar label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-bar select {
            border: 1.5px solid #dde3ed;
            border-radius: 7px;
            padding: 7px 12px;
            font-size: 14px;
            font-family: 'Sarabun', sans-serif;
            color: #444;
            background: #f9fbfd;
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .filter-bar select:focus {
            border-color: #769FCD;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 10px;
            color: #aaa;
            font-size: 15px;
        }

        .search-wrapper input {
            border: 1.5px solid #dde3ed;
            border-radius: 7px;
            padding: 7px 12px 7px 32px;
            font-size: 14px;
            font-family: 'Sarabun', sans-serif;
            color: #444;
            background: #f9fbfd;
            outline: none;
            width: 220px;
            transition: border-color 0.2s;
        }

        .search-wrapper input:focus {
            border-color: #769FCD;
        }

        /* Layout หลัก */
        .main-layout {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* ตารางสินค้า */
        .table-card {
            flex: 1;
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-card-header {
            padding: 16px 20px 12px 20px;
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 1px solid #eef2f7;
        }

        .table-scroll {
            max-height: 520px;
            overflow-y: auto;
        }

        .table-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background-color: #b0c4de;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #0D4C92;
            color: white;
            padding: 10px 14px;
            font-size: 13.5px;
            font-weight: 600;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tbody tr {
            border-bottom: 1px solid #f0f4f8;
            transition: background 0.15s;
        }

        tbody tr:hover {
            background-color: #f0f6ff;
        }

        tbody td {
            padding: 9px 14px;
            font-size: 13.5px;
            color: #333;
        }

        .action-links a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 3px 6px;
            border-radius: 5px;
            transition: background 0.15s;
        }

        .action-links a:first-child {
            color: #2563EB;
        }

        .action-links a:first-child:hover {
            background: #dbeafe;
        }

        .action-links a:last-child {
            color: #dc2626;
        }

        .action-links a:last-child:hover {
            background: #fee2e2;
        }

        .sep {
            color: #ccc;
            margin: 0 2px;
        }

        /* ฟอร์มเพิ่มสินค้า */
        .add-card {
            width: 280px;
            flex-shrink: 0;
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .add-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 13px;
        }

        .form-group label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            border: 1.5px solid #dde3ed;
            border-radius: 7px;
            padding: 8px 11px;
            font-size: 13.5px;
            font-family: 'Sarabun', sans-serif;
            color: #333;
            background: #f9fbfd;
            outline: none;
            transition: border-color 0.2s;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #769FCD;
            background: white;
        }

        .form-group textarea {
            height: 60px;
        }

        .btn-add {
            width: 100%;
            background: #0D4C92;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-size: 14.5px;
            font-family: 'Sarabun', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 4px;
        }

        .btn-add:hover {
            background: #0a3d78;
        }

        .btn-add:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <div class="page-title">📦 Manage Products</div>

    <!-- แถบกรอง -->
    <form method="GET" id="filterForm">
        <div class="filter-bar">
            <label>🏷️ เลือกหมวดหมู่:</label>
            <select name="filter_c_ID" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- แสดงทั้งหมด --</option>
                <?php while ($row = $categories->fetch_assoc()) { ?>
                    <option value="<?= $row['c_ID'] ?>" <?= ($filter_c_ID == $row['c_ID']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['c_name']) ?>
                    </option>
                <?php } ?>
            </select>

            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" placeholder="ค้นหาสินค้า..." value="<?= htmlspecialchars($search) ?>"
                    onchange="document.getElementById('filterForm').submit()">
            </div>
        </div>
    </form>

    <!-- Layout หลัก -->
    <div class="main-layout">

        <!-- ตารางสินค้า -->
        <div class="table-card">
            <div class="table-card-header">รายการสินค้า</div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>ชื่อสินค้า</th>
                            <th>รายละเอียด</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>หมวดหมู่</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $products->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['p_ID'] ?></td>
                                <td><?= htmlspecialchars($row['p_name']) ?></td>
                                <td><?= htmlspecialchars($row['p_detail']) ?></td>
                                <td><?= number_format($row['p_price'], 2) ?> บาท</td>
                                <td><?= $row['p_total'] ?></td>
                                <td><?= htmlspecialchars($row['c_name']) ?></td>
                                <td class="action-links">
                                    <a href="edit_product.php?p_ID=<?= $row['p_ID'] ?>">✏️ แก้ไข</a>
                                    <span class="sep">|</span>
                                    <a href="manage_products.php?delete=<?= $row['p_ID'] ?>"
                                        onclick="return confirm('ลบสินค้านี้?')">🗑️ ลบ</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ฟอร์มเพิ่มสินค้า -->
        <div class="add-card">
            <h3>เพิ่มสินค้าใหม่</h3>
            <form method="POST">
                <div class="form-group">
                    <label>ชื่อสินค้า:</label>
                    <input type="text" name="p_name" required>
                </div>
                <div class="form-group">
                    <label>รายละเอียด:</label>
                    <textarea name="p_detail"></textarea>
                </div>
                <div class="form-group">
                    <label>ราคา:</label>
                    <input type="number" name="p_price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>จำนวน:</label>
                    <input type="number" name="p_total" required>
                </div>
                <div class="form-group">
                    <label>หมวดหมู่:</label>
                    <select name="c_ID">
                        <?php while ($row = $categories_form->fetch_assoc()) { ?>
                            <option value="<?= $row['c_ID'] ?>"><?= htmlspecialchars($row['c_name']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" name="add_product" class="btn-add">เพิ่มสินค้า</button>
            </form>
        </div>

    </div>

</body>

</html>