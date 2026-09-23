<?php
// InfinityFree DB credentials. Replace with values from your vPanel > MySQL Databases.
$db_host = "sql208.infinityfree.com"; // InfinityFree MySQL hostname
$db_user = "if0_42930881";             // InfinityFree DB username
$db_pass = "hipos213";           // InfinityFree DB password
$db_name = "if0_42930881_XXX";   // InfinityFree DB name

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
