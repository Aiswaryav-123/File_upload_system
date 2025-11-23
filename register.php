<?php
require 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
     
        $message = "Username already taken. Please choose another.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt2->bind_param("ss", $username, $hashedPassword);

        if ($stmt2->execute()) {
            $message = "Registration successful. You can now login.";
        } else {
            $message = "Error: " . $stmt2->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<p style="color:green"><?php echo $message; ?></p>
<link rel="stylesheet" type="text/css" href="style.css">
<div class=login>
<form method="POST" action="">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
    <br><br>
    <a href="index.php">Already have account? Login</a>
</form>
</div>
<br>
</body>
</html>
