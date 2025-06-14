<?php
require_once "../db.php";
session_start();

// if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'head'])) {
//     die("Unauthorized access.");
// }

$module_id = intval($_GET['id']);
$course_id = intval($_GET['course_id']);

// Fetch file path to delete
$stmt = $conn->prepare("SELECT file_path FROM course_modules WHERE id = ?");
$stmt->bind_param("i", $module_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Module not found.");
}

$module = $result->fetch_assoc();
$file_path = $module['file_path'];

// Delete from database
$delete_stmt = $conn->prepare("DELETE FROM course_modules WHERE id = ?");
$delete_stmt->bind_param("i", $module_id);
$delete_stmt->execute();

// Remove file
if (file_exists($file_path)) {
    unlink($file_path);
}

header("Location: head_view_course.php?course_id=$course_id&deleted=1");
exit;
