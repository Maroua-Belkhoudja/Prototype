<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // تأمين البيانات
    $job_type = trim($_POST['job-type']);
    $job_title = trim($_POST['university']);
    $location = trim($_POST['location']);
    $experience = trim($_POST['experience']);
    $time_period = trim($_POST['time-period']);
    $preferences = trim($_POST['preferences']);
    $others = trim($_POST['others'] ?? '');

    // إدخال البيانات إلى قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO offer_info 
        (user_id, job_type, job_title, location, experience, time_period, preferences, others) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $job_type,
        $job_title,
        $location,
        $experience,
        $time_period,
        $preferences,
        $others
    ]);

    header("Location: ../home2.html"); // أو أي صفحة نهائية
    exit();
}
?>
