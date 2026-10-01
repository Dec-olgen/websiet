<?php
// READ: show all employees (with department filter and search)
include "config.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$dept   = isset($_GET['department']) ? (int)$_GET['department'] : 0;
$like   = "%" . $search . "%";
$departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");

$base = "SELECT e.*, d.name AS department FROM employees e LEFT JOIN departments d ON e.department_id = d.id ";
if ($dept > 0) {
    $stmt = mysqli_prepare($conn, $base . "WHERE e.department_id = ? AND (e.first_name LIKE ? OR e.last_name LIKE ? OR e.position LIKE ?) ORDER BY e.id ASC");
    mysqli_stmt_bind_param($stmt, "isss", $dept, $like, $like, $like);
} else {
    $stmt = mysqli_prepare($conn, $base . "WHERE (e.first_name LIKE ? OR e.last_name LIKE ? OR d.name LIKE ? OR e.position LIKE ?) ORDER BY e.id ASC");
    mysqli_stmt_bind_param($stmt, "ssss", $like, $like, $like, $like);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Information Management System</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
<header><h1>Employee Information Management System</h1>
<nav style="margin-top:8px;"><a href="index.php" style="color:#fff;margin-right:15px;">Employees</a><a href="departments.php" style="color:#fff;">Departments</a></nav>
</header>
<div class="container">
    <?php if (isset($_GET['msg'])): ?>
        <div class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="top-bar">
            <form class="search" method="get">
                <select name="department" onchange="this.form.submit()" style="width:auto;">
                    <option value="0">All Departments</option>
                    <?php while ($d = mysqli_fetch_assoc($departments)): ?>
                        <option value="<?php echo $d['id']; ?>" <?php if ($dept === (int)$d['id']) echo "selected"; ?>><?php echo htmlspecialchars($d['name']); ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="text" name="search" placeholder="Search name or position" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-save" type="submit">Search</button>
                <a class="btn btn-gray" href="index.php">Reset</a>
            </form>
            <a class="btn btn-add" href="create.php">+ Add Employee</a>
        </div>
        <div class="table-wrap">
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
                <th>Department</th><th>Position</th><th>Date Hired</th><th>Actions</th>
            </tr>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['department'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                    <td><?php echo $row['date_hired']; ?></td>
                    <td class="actions">
                        <a class="btn btn-edit" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="btn btn-delete" href="delete.php?id=<?php echo $row['id']; ?>"
                           onclick="return confirmDelete('<?php echo htmlspecialchars(addslashes($row['first_name'] . ' ' . $row['last_name'])); ?>')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No employee records found.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
