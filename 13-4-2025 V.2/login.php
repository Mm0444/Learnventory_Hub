<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE username='$username'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background: linear-gradient(to right, #769FCD, #B9D7EA);
        }

        .center {
            width: 30%;
            background: #F7FBFC;
            padding: 20px 30px;
            border-radius: 10px;
            border: 3px solid #769FCD;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .center h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        label {
            font-size: 16px;
            width: 90px;
            text-align: right;
        }

        input[type="text"],
        input[type="password"] {
            flex: 1;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit {
            background-color: #0D4C92;
            border: none;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        .submit:hover {
            background-color: #083b73;
        }

        p {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

    <div class="center">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <div class="form-row">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-row">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button class="submit">Login</button>
        </form>
    </div>

</body>
</html>
