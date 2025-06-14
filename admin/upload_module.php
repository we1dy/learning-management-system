<?php
require_once "../db.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['module_file'])) {
    $course_id = intval($_POST['course_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    $file = $_FILES['module_file'];
    $fileName = basename($file['name']);
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'ppt', 'pptx'];

    if (!in_array($fileExt, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only PDF, PPT, and PPTX allowed.']);
        exit;
    }

    $uploadDir = "../assets/modules/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newFileName = uniqid() . "_" . $fileName;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmp, $destination)) {
        $relativePath = substr($destination, 3); // remove "../" for web path

        $stmt = $conn->prepare("INSERT INTO course_modules (course_id, title, description, file_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $course_id, $title, $description, $relativePath);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Module uploaded successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert module: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>