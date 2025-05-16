<?php
session_start();


require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // تأمين البيانات وتنظيفها
    $name = trim($_POST['names']);
    $founder = trim($_POST['founder']);
    $speciality = trim($_POST['speciality']);
    $creation_date = $_POST['date'];
    $location = trim($_POST['location']);
    $branches = trim($_POST['Branches']);
    $comercial = trim($_POST['comercial']);

    // تحميل صورة الشركة (إجباري)
    $picture_path = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $tmp = $_FILES['picture']['tmp_name'];
        $name_file = uniqid() . '_' . basename($_FILES['picture']['name']);
        $path = $upload_dir . $name_file;

        if (move_uploaded_file($tmp, $path)) {
            $picture_path = 'uploads/' . $name_file;
        } else {
            die("فشل في رفع صورة الشركة.");
        }
    } else {
        die("يجب رفع صورة الشركة.");
    }

    

    // حفظ البيانات في قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO employer_info 
        (user_id, enterprise_name, founder, speciality, creation_date, location, branches, comercial, picture_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $name,
        $founder,
        $speciality,
        $creation_date,
        $location,
        $branches,
        $comercial,
        $picture_path
    ]);

    header("Location: ../register-off.html");
    exit();
}
?>
