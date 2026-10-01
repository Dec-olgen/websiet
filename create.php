<?php
// CREATE: add a new employee
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dept  = trim($_POST['department']);
    $pos   = trim($_POST['position']);
    $date  = $_POST['date_hired'];

    $stmt = mysqli_prepare($conn, "INSERT INTO employees (first_name, last_name, email, phone, department, position, date_hired) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $first, $last, $email, $phone, $dept, $pos, $date);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=" . urlencode("Employee added successfully."));
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Add Employee</h1></header>
<div class="container"><div class="card">
    <?php if (isset($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="post">
        <label>First Name</label><input type="text" name="first_name" required>
        <label>Last Name</label><input type="text" name="last_name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Phone</label><input type="text" name="phone">
        <label>Department</label>
        <select name="department" required>
            <option value="">-- Select --</option>
            <option>Human Resources</option><option>Finance</option><option>IT</option>
            <option>Marketing</option><option>Operations</option><option>Sales</option>
        </select>
        <label>Position</label><input type="text" name="position" required>
        <label>Date Hired</label><input type="date" name="date_hired" required>
        <br><br>
        <button class="btn btn-save" type="submit">Save</button>
        <a class="btn btn-gray" href="index.php">Cancel</a>
    </form>
</div></div>
</body>
</html>
