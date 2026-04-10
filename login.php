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
        $_SESSION['role'] = $user['role']; // บันทึกสิทธิ์การใช้งาน
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
<style>
body {
    background: linear-gradient(to right, #769FCD, #B9D7EA); /* ไล่สี */
 /* background-color:/* #769FCD*/ #D6E6F2;*/
}
/*.center {
 margin: auto;
  width: 60%;
  border: 3px solid #73AD21;
  padding: 10px;
}*/

/*.center {
  display: flex;

  /*this centers the text horizontally*/
 /* justify-content: center;

  /*this centers the text vertically*/
  /*align-items: center;

 /* height: 200px;
  color: #fff;
  font-size: 1.2rem;
  background: #00008b;
}*/


.center{
    margin: auto;
  /*margin: 0;*/
  width: 30%;
  border: 3px solid #769FCD;
  background: #F7FBFC;
  padding: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

div.a {
  text-align: center;
}

h2 {
  font-size: 40px;
}

label{
    font-size: 20px;
}

.submit {
  background-color: #0D4C92;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.box {
  /*background-color: lightgreen;*/
  height: 10px;
  width: 10px;
}
</style>
<title>Login</title>
</head>
<body>

    <div class="center">
         
            
        <div class="a">
          <h2>Login</h2>
       
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="POST">
                <label>Username:</label>
                <input type="text" name="username" required><br>
                <label>Password:</label>
                <input type="password" name="password" required><br>
                <div class="box"></div><br>
                <button class="submit">Login</button>
            </form>
        </div> 
        
    </div>
</body>
</html>
