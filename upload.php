<!DOCTYPE html>
<html>
<body>
<link rel="stylesheet" type="text/css" href="style.css">
</body>
</html>
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must login first!";
    exit;
}

$user_id = $_SESSION['user_id'];
$user_ip = $_SERVER['REMOTE_ADDR'];  

$allowed = ['jpg', 'png', 'pdf', 'docx'];
$max_size = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        echo '<p class="error">No file uploaded!</p>';
        echo "<div class='go-back'><a href='dashboard.php'>Go Back</a></div>";
        exit;
    }

    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $clean_name = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", $file_name);
    $unique_name = time() . "_" . $clean_name;
    $destination = "uploads/" . $unique_name;
    
    if (!in_array($ext, $allowed)) {
        $stmt = $conn->prepare("INSERT INTO logs (user_id, ip_address, file_name, upload_status) VALUES (?, ?, ?, 'REJECTED')");
        $stmt->bind_param("iss", $user_id, $user_ip, $file_name);
        $stmt->execute();

        echo '<p class="error">Invalid file type!</p>';
        echo "<div class='go-back'><a href='dashboard.php'>Go Back</a></div>";
        exit;
    }
    elseif ($file_size > $max_size) {
        $stmt = $conn->prepare("INSERT INTO logs (user_id, ip_address, file_name, upload_status) VALUES (?, ?, ?, 'REJECTED')");
        $stmt->bind_param("iss", $user_id, $user_ip, $file_name);
        $stmt->execute();

        echo '<p class="error">File is too large!</p>';
        echo "<div class='go-back'><a href='dashboard.php'>Go Back</a></div>";
        exit;
    }

    else { 
        if (move_uploaded_file($file_tmp, $destination)) {
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $unique_name);
        $stmt->execute();

        $stmt2 = $conn->prepare("INSERT INTO logs (user_id, ip_address, file_name, upload_status) VALUES (?, ?, ?, 'SUCCESS')");
        $stmt2->bind_param("iss", $user_id, $user_ip, $unique_name,$status);
        $stmt2->execute();

        echo "<h3>File uploaded successfully!</h3>";
        echo "<a href='dashboard.php'>Go Back</a>";
        exit;

        } else {
            echo '<p style="color:blue;" "align:center">Error uploading file! </p>';
            exit;
        }
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>File Upload</h2>
    <input type="file" name="file" required><br><br>
    <button type="submit">Upload</button>
    <br><br>
    <a href="logout.php">Logout</a>
</form>

