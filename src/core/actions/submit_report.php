<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php?page=reports");
    exit;
}

require_once dirname(__DIR__) . '/init.php'; 
require_once dirname(__DIR__) . '/connection.php';

$user_id = $_SESSION['user_id'];
$title = htmlspecialchars(trim($_POST['title']));
$category = htmlspecialchars(trim($_POST['category']));
$priority = htmlspecialchars(trim($_POST['priority']));
$location = htmlspecialchars(trim($_POST['location'])); 

if ($priority === 'Med') $priority = 'Medium';

$uploadDir = dirname(dirname(__DIR__)) . '/assets/images/uploads/reports/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileError = $_FILES['evidence']['error'];
$imagePath = '';

if ($fileError === 0) {
    $fileName = $_FILES['evidence']['name'];
    $fileTmpName = $_FILES['evidence']['tmp_name'];
    $fileSize = $_FILES['evidence']['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExt, $allowed)) {
        if ($fileSize < 2097152) { // < 2MB
            $newFileName = 'report_' . $user_id . '_' . time() . '.' . $fileExt;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpName, $destination)) {
                $imagePath = './assets/images/uploads/reports/' . $newFileName;
            } else {
                header("Location: ../../index.php?page=reports&error=upload_failed");
                exit;
            }
        } else {
            header("Location: ../../index.php?page=reports&error=file_too_large");
            exit;
        }
    } else {
        header("Location: ../../index.php?page=reports&error=invalid_file_type");
        exit;
    }
} else {
    header("Location: ../../index.php?page=reports&error=no_file_uploaded");
    exit;
}

$sql = "INSERT INTO reports (user_id, title, category, priority, location, map_link, image_path, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Open')";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("issssss", $user_id, $title, $category, $priority, $location, $location, $imagePath);
    
    if ($stmt->execute()) {
        header("Location: ../../index.php?page=reports&success=report_created");
    } else {
        header("Location: ../../index.php?page=reports&error=db_error");
    }
    $stmt->close();
} else {
    header("Location: ../../index.php?page=reports&error=stmt_error");
}

$conn->close();
exit;
?>