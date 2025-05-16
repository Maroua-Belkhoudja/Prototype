<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // إنشاء المجلدات إذا لم تكن موجودة
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/website/uploads/certificates/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // معالجة اسم الملف
    $cert_name = basename($_FILES['certificates_path']['name']);
    $cert_tmp = $_FILES['certificates_path']['tmp_name'];
    $cert_target = $upload_dir . $cert_name;

    // التحقق من نوع الملف
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($_FILES['certificates_path']['type'], $allowed_types)) {
        die("نوع الملف غير مسموح به");
    }

    if (move_uploaded_file($cert_tmp, $cert_target)) {
        $stmt = $pdo->prepare("INSERT INTO professional_data 
            (user_id, professional_status, university, speciality, skills, experience, preferences, certificates_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user_id,
            $_POST['professional_status'],
            $_POST['university'],
            $_POST['speciality'],
            $_POST['skills'],
            $_POST['experience'],
            $_POST['preferences'],
            $cert_target
        ]);
        header("Location: ../home2.html");
        exit();
    } else {
        echo "خطأ في رفع الملف: " . $_FILES['certificates_path']['error'];
    }
}
?>
