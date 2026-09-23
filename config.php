<?php
// InfinityFree DB credentials. Replace with values from your vPanel > MySQL Databases.
$db_host = "sqlXXX.infinityfree.com"; // InfinityFree MySQL hostname
$db_user = "if0_XXXXXXX";             // InfinityFree DB username
$db_pass = "your_password";           // InfinityFree DB password
$db_name = "if0_XXXXXXX_guestbook";   // InfinityFree DB name

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
