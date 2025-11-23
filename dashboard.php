<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<body>
<link rel="stylesheet" type="text/css" href="style.css">
<h3 style="color:blue;">Welcome! Upload your file</h3>
<div class=login>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <br>
    <input type="file" name="file" required><br><br>
    <button type="submit">Upload</button>
</form>
<br>
<a href="logout.php">Logout</a><br><br>
</div>
</body>
</html>