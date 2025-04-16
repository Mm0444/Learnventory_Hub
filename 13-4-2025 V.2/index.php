<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$role = $_SESSION['role']; // สิทธิ์ของพนักงาน (admin / staff)
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>POS System</title>
  <!-- Google Fonts: Bai Jamjuree -->
  <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #769FCD, #B9D7EA);
      font-family: 'Bai Jamjuree', sans-serif;
      margin: 0;
      padding: 0;
    }

    .center {
      max-width: 1000px;
      margin: auto;
      padding-top: 100px;
      text-align: center;
    }

    h2 {
      font-size: 40px;
      margin-bottom: 10px;
    }

    p {
      font-size: 24px;
      margin-bottom: 30px;
    }

    .button-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .menu-button {
      background-color: #F7FBFC;
      border: 2px solid #0D4C92;
      color: #0D4C92;
      font-size: 20px;
      padding: 25px 20px;
      text-align: center;
      text-decoration: none;
      border-radius: 10px;
      width: 250px;
      box-sizing: border-box;
      transition: background-color 0.3s, transform 0.2s;
    }

    .menu-button:hover {
      background-color: #769FCD;
      color: white;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .menu-button {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="center">
    <h2>🏫 Welcome to the Learnventory Hub system 🛒</h2>
    <p>คุณเข้าสู่ระบบในฐานะ: <strong><?= ucfirst($role) ?></strong></p>

    <div class="button-container">
      <a href="sell.php" class="menu-button">🛒 ขายสินค้า</a>

      <?php if ($role === 'admin') { ?>
        <a href="manage_products.php" class="menu-button">📦 จัดการสินค้า</a>
        <a href="manage_categories.php" class="menu-button">📂 จัดการหมวดหมู่</a>
        <a href="sales_report.php" class="menu-button">📊 ราคาขายต่อใบเสร็จ</a>
      <?php } ?>

      <a href="logout.php" class="menu-button">🚪 ออกจากระบบ</a>
    </div>
  </div>
</body>

</html>