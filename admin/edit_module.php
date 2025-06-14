<?php
require_once "../db.php";
session_start();

header('Content-Type: application/json');

if (!isset($_POST['module_id'], $_POST['title']) || !isset($_FILES['new_module_file'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid submission.']);
    exit;
}

$module_id = intval($_POST['module_id']);
$title = mysqli_real_escape_string($conn, $_POST['title']);
$course_id = intval($_POST['course_id'] ?? 0);

// Fetch current file
$stmt = $conn->prepare("SELECT file_path FROM course_modules WHERE id = ?");
$stmt->bind_param("i", $module_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode(['status' => 'error', 'message' => 'Module not found.']);
    exit;
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
    echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
    exit;
}

// Delete old file if it exists
if (file_exists($old_file)) {
    unlink($old_file);
}

// Update DB
$relativePath = substr($new_path, 3); // remove "../"
$update = $conn->prepare("UPDATE course_modules SET title = ?, file_path = ? WHERE id = ?");
$update->bind_param("ssi", $title, $relativePath, $module_id);

if ($update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Module updated successfully.', 'course_id' => $course_id]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update module.']);
}
?>
