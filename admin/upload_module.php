<?php
require_once "../db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['module_file'])) {
    $course_id = intval($_POST['course_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $file = $_FILES['module_file'];
    $fileName = basename($file['name']);
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'ppt', 'pptx'];

    if (!in_array($fileExt, $allowed)) {
        die("Invalid file type. Only PDF, PPT, and PPTX allowed.");
    }

    $uploadDir = "../assets/modules/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newFileName = uniqid() . "_" . $fileName;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmp, $destination)) {
        $relativePath = substr($destination, 3); // remove "../" for web path

        $stmt = $conn->prepare("INSERT INTO course_modules (course_id, title, description, file_path) VALUES (?,?, ?, ?)");
        $stmt->bind_param("isss", $course_id, $title, $description, $relativePath);

        if ($stmt->execute()) {
            header("Location: head_view_course.php?course_id=" . $course_id . "&upload=success");
            exit();
        } else {
            echo "Failed to insert module: " . $conn->error;
        }
    } else {
        echo "File upload failed.";
    }
} else {
    echo "Invalid request.";
}
?>
