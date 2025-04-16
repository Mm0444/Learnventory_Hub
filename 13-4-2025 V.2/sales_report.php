<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงข้อมูลการขายทั้งหมดและจัดกลุ่มตามวันที่ขาย
$sql = "SELECT Sales.sale_date, Sales.user_id, Users.username, 
        GROUP_CONCAT(Product.p_name SEPARATOR ', ') AS products,
        SUM(Sales.quantity) AS total_quantity,
        SUM(Sales.total_price) AS total_price
        FROM Sales 
        JOIN Users ON Sales.user_id = Users.user_id
        JOIN Product ON Sales.p_ID = Product.p_ID
        GROUP BY Sales.sale_date, Sales.user_id
        ORDER BY Sales.sale_date DESC";

$sales = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <!-- โหลด Google Font Bai Jamjuree -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            margin: 0;
            padding: 0;
        }

        .holding-container {
            margin: auto;
            width: 90%;
            background-color: #F7FBFC;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 380px;
            overflow-y: auto;
        }

        .table-container {
            background-color: #F7FBFC;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 430px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #F7FBFC;
            font-size: 16px;
        }

        thead {
            background-color: #0D4C92;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #0D4C92 !important;
            color: white !important;
            font-weight: bold;
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

        h2 {
            text-align: center;
            padding-top: 20px;
            font-size: 35px;
            font-weight: bold;
            color:rgb(0, 0, 0);
        }

        h3 {
            text-align: center;
            padding-top: 1px;
            font-size: 20px;
            font-weight: bold;
            color:rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    <h2>📊 Sales Report</h2>
    <h3>ราคาขายต่อใบเสร็จ</h3>
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <div class="holding-container">
        <table>
            <thead>
                <tr>
                    <th>วันที่ขาย</th>
                    <th>สินค้า</th>
                    <th>จำนวนรวม</th>
                    <th>ราคารวม</th>
                    <th>พนักงาน</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $sales->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['sale_date'] ?></td>
                    <td><?= $row['products'] ?></td>
                    <td><?= $row['total_quantity'] ?></td>
                    <td><?= number_format($row['total_price'], 2) ?> บาท</td>
                    <td><?= $row['username'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
