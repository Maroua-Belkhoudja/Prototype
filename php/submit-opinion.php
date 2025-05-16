<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $opinion = trim($_POST['opinion'] ?? '');

    if (!empty($name) && !empty($email) && !empty($opinion)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO opinions (name, email, opinion) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $opinion]);
            echo "success";
        } catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    } else {
        echo "error: Please fill in all fields.";
    }
} else {
    echo "error: Invalid request.";
}
?>
