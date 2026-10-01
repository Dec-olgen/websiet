<?php
// DELETE: remove an employee
include "config.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = mysqli_prepare($conn, "DELETE FROM employees WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
header("Location: index.php?msg=" . urlencode("Employee deleted successfully."));
exit;
