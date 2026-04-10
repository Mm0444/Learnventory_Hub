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
    <style>
        body {
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            /* สีพื้นหลัง */
        }
        


        /
        .table-container {
            /*max-height: 250px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 5px;
            border: none;

            
            padding: 20px;
            border-radius: 8px;
            border-radius: 8px;
            margin-top: 10px;
            background-color: #F7FBFC;
            width: 95%;
            /* กำหนดความกว้าง */
            margin: auto;*/

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

       /* th,
        td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #0D4C92;
            color: white;
        }*/

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
        
    </style>


    
</head>
<body>
    <h2 style="text-align: center; padding-top: 20px; font-size: 35px; font-weight: bold;">📊 ราคาขายต่อใบเสร็จ</h2>
    <div style="text-align: center;">
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <table border="1">
        <tr>
            <th>วันที่ขาย</th>
            <th>สินค้า</th>
            <th>จำนวนรวม</th>
            <th>ราคารวม</th>
            <th>พนักงาน</th>
        </tr>
        <?php while ($row = $sales->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['sale_date'] ?></td>
            <td><?= $row['products'] ?></td>
            <td><?= $row['total_quantity'] ?></td>
            <td><?= number_format($row['total_price'], 2) ?> บาท</td>
            <td><?= $row['username'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
