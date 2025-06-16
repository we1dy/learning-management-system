<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "
    SELECT e.employee_num, e.first_name, e.last_name, e.middle_initial, e.email, 
           g.group_name, s.segment_name, d.division_name
    FROM employee e
    LEFT JOIN `group` g ON e.group_id = g.group_id
    LEFT JOIN segment s ON e.segment_id = s.segment_id
    LEFT JOIN division d ON e.division_id = d.division_id
    WHERE e.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $employee = $result->fetch_assoc();
} else {
    echo "Employee not found.";
    exit();
}
?>