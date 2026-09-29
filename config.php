<?php
// InfinityFree DB credentials. Replace with values from your vPanel > MySQL Databases.
$db_host = "sql207.thsite.top";
$db_user = "thsi_43043581";
$db_pass = "9U!2?AK?"; // click the eye icon to reveal it
$db_name = "thsi_43043581_MAAMAAAA";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
