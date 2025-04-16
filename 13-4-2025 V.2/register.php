<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO Users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register User</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Role:</label>
        <select name="role">
            <option value="staff">Staff</option>
            <option value="admin">Admin</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>