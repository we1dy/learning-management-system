<?php
require_once "db.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "No employee logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Step 1: Get employee_id
$query = "SELECT employee_id FROM employee WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($employee_id);
$stmt->fetch();
$stmt->close();

$response = ["in_progress_count" => 0];

if ($employee_id) {
    // Step 2: Count in-progress courses
    $query_count = "
        SELECT COUNT(*) 
        FROM employee_courses 
        WHERE employee_id = ? AND status = 'In Progress'
    ";

    $stmt = $conn->prepare($query_count);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $response['in_progress_count'] = $count;
}

echo json_encode($response);
