<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงหมวดหมู่ทั้งหมด
$sql_cat = "SELECT * FROM Categories";
$categories = $conn->query($sql_cat);

// ตรวจสอบว่ามีการเลือกหมวดหมู่หรือไม่
$c_ID = isset($_GET['c_ID']) ? $_GET['c_ID'] : '';

// ดึงรายการสินค้าตามหมวดหมู่
$sql = "SELECT * FROM Product WHERE p_total > 0";
if (!empty($c_ID)) {
    $sql .= " AND c_ID = '$c_ID'";
}
$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ขายสินค้า</title>
     <!-- Google Fonts: Bai Jamjuree -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background: linear-gradient(to right, #769FCD, #B9D7EA); /* ไล่สีสวยๆ */
            color: #333;
            margin: 0;
            padding: 0;
}

        h2,
        h3 {
            
            color: #2d2d2d;
        }

        a {
            text-decoration: none;
            color: #2d2d2d;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Layout Container */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
           /* max-width: 1200px;*/
           width: 90%;
            margin: auto;
            
        }

        /* ช่องเลือกหมวดหมู่ และ ค้นหาสินค้า */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-container select,
        .filter-container input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Product List Styles */
        .product-list {
            width: 65%;
            background-color: #F7FBFC;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 430px;
            overflow-y: auto;
        }

        .product-table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        input[type="number"] {
            width: 60px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #0D4C92;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Bai Jamjuree', sans-serif;
        }

        button:hover {
            background-color: #769FCD;
        }

        /* Cart Styles */
        .cart-container {
            width: 30%;
            background-color: #F7FBFC;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 430px;
            overflow-y: auto;
        }

        .cart-table-container {
            margin-top: 20px;
        }

        .cart-container table {
            margin-top: 20px;
        }

        .cart-container th,
        .cart-container td {
            padding: 12px;
        }

        .back-home {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 15px;
            padding: 8px 15px;
            border: 2px solid #0D4C92; /* กำหนดกรอบ */
            border-radius: 5px; /* ทำให้มุมโค้ง */
            background-color: white; /* สีพื้นหลัง */
            color: #0D4C92; /* สีตัวอักษร */
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }


        /* Button Adjustments */
        #payButton {
            display: none;
            margin-top: 20px;
            background-color: #28a745;
            border-radius: 4px;
            padding: 10px;
            width: 100%;
        }

        #payButton:hover {
            background-color: #218838;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .product-list,
            .cart-container {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>

<h2 style="text-align: center; padding-top: 20px; font-size: 35px; font-weight: bold;">✿ ขายสินค้า ✏️</h2>
    <div style="text-align: center;">
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>
    </div>

    
    <div class="filter-container">
        <!-- Dropdown เลือกหมวดหมู่ -->
        <form method="GET">
            <select name="c_ID" onchange="this.form.submit()">
                <option value="">-- เลือกหมวดหมู่ --</option>
                <?php while ($row = $categories->fetch_assoc()) { ?>
                    <option value="<?= $row['c_ID'] ?>" <?= ($c_ID == $row['c_ID']) ? 'selected' : '' ?>>
                        <?= $row['c_name'] ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <!-- ช่องค้นหาสินค้า -->
        <input type="text" id="searchProduct" placeholder="🔍 ค้นหาสินค้า...">
    </div>

    <div class="container">
        <!-- รายการสินค้า -->
        <div class="product-list">
            <h2>เลือกสินค้า</h2>
            <div class="product-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>เพิ่ม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $products->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['p_name'] ?></td>
                                <td><?= number_format($row['p_price'], 2) ?></td>
                                <td><input type="number" id="qty_<?= $row['p_ID'] ?>" value="1" min="1" max="<?= $row['p_total'] ?>"></td>
                                <td><button onclick="addToCart(<?= $row['p_ID'] ?>, '<?= $row['p_name'] ?>', <?= $row['p_price'] ?>, <?= $row['p_total'] ?>)">เพิ่ม</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ตะกร้าสินค้า -->
        <div class="cart-container">
            <h2>🛒 ตะกร้าสินค้า</h2>
            <div class="cart-table-container">
                <table id="cart">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคารวม</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <h3>ราคารวมทั้งหมด: <span id="total_price">0</span> บาท</h3>
            <button onclick="confirmCheckout()">✅ ยืนยันก่อนชำระเงิน</button>
            <button id="payButton" onclick="checkout()">💰 ชำระเงิน</button>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // ค้นหาสินค้าตามคำที่พิมพ์
            $("#searchProduct").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".product-table-container tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

        let cart = [];

        function addToCart(id, name, price, stock) {
            let qty = parseInt(document.getElementById('qty_' + id).value);

            if (qty > stock) {
                alert("สินค้าคงเหลือไม่เพียงพอ!");
                return;
            }

            let item = cart.find(item => item.id === id);
            if (item) {
                if (item.qty + qty > stock) {
                    alert("สินค้าเกินสต็อกที่มี!");
                    return;
                }
                item.qty += qty;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    qty
                });
            }

            updateCart();
        }

        function updateCart() {
            let cartTable = document.getElementById('cart');
            cartTable.innerHTML = `
        <tr>
            <th>ชื่อสินค้า</th>
            <th>จำนวน</th>
            <th>ราคารวม</th>
            <th>ลบ</th>
        </tr>
    `;

            let total = 0;
            cart.forEach((item, index) => {
                let totalItemPrice = item.price * item.qty;
                total += totalItemPrice;

                cartTable.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>${totalItemPrice}</td>
                <td><button onclick="removeFromCart(${index})">❌</button></td>
            </tr>
        `;
            });

            document.getElementById('total_price').innerText = total;
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function confirmCheckout() {
            if (cart.length === 0) {
                alert("กรุณาเลือกสินค้าก่อนทำการชำระเงิน!");
                return;
            }

            let confirmPayment = confirm("คุณต้องการยืนยันการสั่งซื้อหรือไม่?");
            if (confirmPayment) {
                document.getElementById("payButton").style.display = "block";
            }
        }

        function checkout() {
            $.ajax({
                url: "process_payment.php",
                method: "POST",
                data: {
                    cart: JSON.stringify(cart)
                },
                success: function(response) {
                    alert("ชำระเงินสำเร็จ!");
                    cart = [];
                    updateCart();
                    document.getElementById("payButton").style.display = "none";
                }
            });
        }
    </script>

</body>

</html>