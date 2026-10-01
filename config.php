<?php
// Change these 4 values depending on where the app runs.
// LOCALHOST (XAMPP):
$host = "localhost";
$user = "root";
$pass = "";
$db   = "employee_db";

// INFINITYFREE: replace with the values from your hosting control panel (MySQL Databases)
// $host = "sqlXXX.infinityfree.com";
// $user = "if0_XXXXXXXX";
// $pass = "your_password";
// $db   = "if0_XXXXXXXX_employee_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
