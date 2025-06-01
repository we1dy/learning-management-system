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

$response = ["completion_rate" => 0];

if ($employee_id) {
    // Step 2: Get total and completed course counts
    $query = "
        SELECT 
            SUM(status = 'Completed') AS completed_count,
            COUNT(*) AS total_count
        FROM employee_courses 
        WHERE employee_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->bind_result($completed, $total);
    $stmt->fetch();
    $stmt->close();

    if ($total > 0) {
        $rate = ($completed / $total) * 100;
        $response['completion_rate'] = round($rate, 1); // Round to 1 decimal place
    }
}

echo json_encode($response);
