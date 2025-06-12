<?php
require_once "../db.php";
session_start();

if (!isset($_POST['module_id'], $_POST['title']) || !isset($_FILES['new_module_file'])) {
    die("Invalid submission.");
}

$module_id = intval($_POST['module_id']);
$title = $_POST['title'];

// Fetch current file
$stmt = $conn->prepare("SELECT file_path FROM course_modules WHERE id = ?");
$stmt->bind_param("i", $module_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Module not found.");
}
$module = $result->fetch_assoc();
$old_file = $module['file_path'];

// Upload new file
$upload_dir = "../assets/modules/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$ext = pathinfo($_FILES['new_module_file']['name'], PATHINFO_EXTENSION);
$new_filename = uniqid($title) . '_.' . $ext;
$new_path = $upload_dir . $new_filename;

if (!move_uploaded_file($_FILES['new_module_file']['tmp_name'], $new_path)) {
    die("File upload failed.");
}

// Delete old file
if (file_exists($old_file)) {
    unlink($old_file);
}

// Update DB
$update = $conn->prepare("UPDATE course_modules SET title = ?, file_path = ? WHERE id = ?");
$update->bind_param("ssi", $title, $new_path, $module_id);
$update->execute();

header("Location: head_view_course.php?course_id=" . $_POST['course_id'] . "&updated=1");
exit;
