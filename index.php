<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $message = trim($_POST["message"]);

    if ($name !== "" && $message !== "") {
        $stmt = $conn->prepare("INSERT INTO messages (name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $message);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT name, message, created_at FROM messages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Guestbook</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Guestbook</h1>

    <form method="POST" action="index.php">
        <input type="text" name="name" placeholder="Your name" required>
        <textarea name="message" placeholder="Your message" required></textarea>
        <button type="submit">Post</button>
    </form>

    <div class="messages">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="message">
                <strong><?php echo htmlspecialchars($row["name"]); ?></strong>
                <span class="date"><?php echo $row["created_at"]; ?></span>
                <p><?php echo nl2br(htmlspecialchars($row["message"])); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
<?php $conn->close(); ?>
