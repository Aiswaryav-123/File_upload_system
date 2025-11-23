<?php
session_start();
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result();

    if ($data->num_rows == 1) {
        $row = $data->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login</title>
</head>
<body>
    <h2 style="color:blue;">Login</h2>
    <br>
    <div class="login">
        <form method="POST">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
        <br>
        <a href="register.php">Create a new account</a>
    </div>

    <?php if ($message): ?>
        <p style="color:red; text-align:center;"><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
