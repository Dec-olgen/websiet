<?php
// Departments: add, rename, delete
include "config.php";
$error = "";
$edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;

// DELETE (blocked if employees still belong to the department)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM employees WHERE department_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if ($count > 0) {
        header("Location: departments.php?msg=" . urlencode("Cannot delete: employees still belong to this department."));
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM departments WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        header("Location: departments.php?msg=" . urlencode("Department deleted."));
    }
    exit;
}

// ADD or RENAME
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if ($name === "") {
        $error = "Department name is required.";
    } else {
        try {
            if ($_POST['action'] === 'update') {
                $id = (int)$_POST['id'];
                $stmt = mysqli_prepare($conn, "UPDATE departments SET name=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "si", $name, $id);
                mysqli_stmt_execute($stmt);
                header("Location: departments.php?msg=" . urlencode("Department updated."));
            } else {
                $stmt = mysqli_prepare($conn, "INSERT INTO departments (name) VALUES (?)");
                mysqli_stmt_bind_param($stmt, "s", $name);
                mysqli_stmt_execute($stmt);
                header("Location: departments.php?msg=" . urlencode("Department added."));
            }
            exit;
        } catch (mysqli_sql_exception $e) {
            $error = "That department name already exists.";
        }
    }
}

$result = mysqli_query($conn, "SELECT d.*, COUNT(e.id) AS total FROM departments d LEFT JOIN employees e ON e.department_id = d.id GROUP BY d.id ORDER BY d.id ASC");
$edit_name = "";
if ($edit_id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT name FROM departments WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $edit_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Departments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Departments</h1>
<nav style="margin-top:8px;"><a href="index.php" style="color:#fff;margin-right:15px;">Employees</a><a href="departments.php" style="color:#fff;">Departments</a></nav>
</header>
<div class="container">
    <?php if (isset($_GET['msg'])): ?>
        <div class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="msg" style="background:#fbe3e0;color:#8a1f13;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <div class="card">
        <form method="post" class="top-bar">
            <input type="hidden" name="action" value="<?php echo $edit_id ? 'update' : 'add'; ?>">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <input type="text" name="name" placeholder="Department name" style="max-width:300px;" value="<?php echo htmlspecialchars($edit_name); ?>" required>
            <span>
                <button class="btn btn-save" type="submit"><?php echo $edit_id ? 'Update' : '+ Add Department'; ?></button>
                <?php if ($edit_id): ?><a class="btn btn-gray" href="departments.php">Cancel</a><?php endif; ?>
            </span>
        </form>
        <div class="table-wrap">
        <table>
            <tr><th>ID</th><th>Department</th><th>Employees</th><th>Actions</th></tr>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['total']; ?></td>
                    <td class="actions">
                        <a class="btn btn-edit" href="departments.php?edit=<?php echo $row['id']; ?>">Edit</a>
                        <a class="btn btn-delete" href="departments.php?delete=<?php echo $row['id']; ?>"
                           onclick="return confirmDelete('<?php echo htmlspecialchars(addslashes($row['name'])); ?>')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No departments yet.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
