<?php
// UPDATE: edit an existing employee
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int)$_POST['id'];
    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dept  = trim($_POST['department']);
    $pos   = trim($_POST['position']);
    $date  = $_POST['date_hired'];

    $stmt = mysqli_prepare($conn, "UPDATE employees SET first_name=?, last_name=?, email=?, phone=?, department=?, position=?, date_hired=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssssi", $first, $last, $email, $phone, $dept, $pos, $date, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=" . urlencode("Employee updated successfully."));
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
$stmt = mysqli_prepare($conn, "SELECT * FROM employees WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$emp = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$emp) { die("Employee not found."); }
$depts = ["Human Resources", "Finance", "IT", "Marketing", "Operations", "Sales"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Edit Employee</h1></header>
<div class="container"><div class="card">
    <?php if (isset($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $emp['id']; ?>">
        <label>First Name</label><input type="text" name="first_name" value="<?php echo htmlspecialchars($emp['first_name']); ?>" required>
        <label>Last Name</label><input type="text" name="last_name" value="<?php echo htmlspecialchars($emp['last_name']); ?>" required>
        <label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($emp['email']); ?>" required>
        <label>Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($emp['phone']); ?>">
        <label>Department</label>
        <select name="department" required>
            <?php foreach ($depts as $d): ?>
                <option <?php if ($emp['department'] === $d) echo "selected"; ?>><?php echo $d; ?></option>
            <?php endforeach; ?>
        </select>
        <label>Position</label><input type="text" name="position" value="<?php echo htmlspecialchars($emp['position']); ?>" required>
        <label>Date Hired</label><input type="date" name="date_hired" value="<?php echo $emp['date_hired']; ?>" required>
        <br><br>
        <button class="btn btn-save" type="submit">Update</button>
        <a class="btn btn-gray" href="index.php">Cancel</a>
    </form>
</div></div>
</body>
</html>
