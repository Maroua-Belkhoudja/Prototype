<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        
        // Start session after successful registration
        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        
        header('Location: ../qst.html');
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            // Duplicate entry error
            header('Location: ../joinus.html?error=duplicate_entry');
        } else {
            // Other database error
            error_log($e->getMessage());
            header('Location: ../joinus.html?error=registration_failed');
        }
        exit();
    }
}
?>