<?php
// InfinityFree DB credentials. Replace with values from your vPanel > MySQL Databases.
$db_host = "sql208.infinityfree.com";
$db_user = "if0_42930881";
$db_pass = "your_actual_password"; // click the eye icon to reveal it
$db_name = "if0_42930881_messages";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
