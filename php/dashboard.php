<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/joinus.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <a href="logout.php" class="btn">Logout</a>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>