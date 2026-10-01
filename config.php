<?php
$host = "sql112.infinityfree.com";
$user = "if0_42928598";
$pass = "kupalsiara213";
$db   = "if0_42928598_employeedb";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
