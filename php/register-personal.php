<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // تأمين البيانات المدخلة
    $firstname = trim($_POST['firstname']);
    $familyname = trim($_POST['family-name']);
    $dob = $_POST['date-of-birth'];
    $place = trim($_POST['place']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $social = $_POST['social-situation'];

    // تحميل الصورة
    $picture_path = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_tmp = $_FILES['picture']['tmp_name'];
        $file_name = uniqid() . '_' . basename($_FILES['picture']['name']);
        $target_path = $upload_dir . $file_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!in_array($_FILES['picture']['type'], $allowed_types)) {
            die("صيغة الصورة غير مسموحة.");
        }

        if (move_uploaded_file($file_tmp, $target_path)) {
            $picture_path = 'uploads/' . $file_name;
        } else {
            die("فشل في رفع الملف.");
        }
    }

    // إدخال البيانات
    $stmt = $pdo->prepare("INSERT INTO personal_data 
        (user_id, first_name, family_name, date_of_birth, place_of_birth, phone_number, gender, social_situation, picture_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $firstname,
        $familyname,
        $dob,
        $place,
        $phone,
        $gender,
        $social,
        $picture_path
    ]);

    header("Location: ../register-Prof.html");
    exit();
}
?>
