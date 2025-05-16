<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ../home2.html');
            exit();
        } else {
            // Invalid credentials
            header('Location: joinus.html?error=invalid_credentials');
            exit();
        }
    } catch (PDOException $e) {
        // Database error
        error_log($e->getMessage());
        header('Location: joinus.html?error=database_error');
        exit();
    }
}
?>
