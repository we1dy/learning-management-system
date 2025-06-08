<?php
header('Content-Type: application/json');
require_once '../db.php';

// ✅ Step 1: Collect POST data
$first_name = $_POST['first_name'];
$middle_initial = $_POST['middle_initial'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$group_id = $_POST['group_id'];
$segment_id = $_POST['segment_id'];
$division_id = $_POST['division_id'];
$user_type_str = $_POST['user_type'];

// ✅ Step 2: Generate employee number
$latest = mysqli_query($conn, "SELECT employee_num FROM employee ORDER BY employee_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($latest);

if ($row) {
    $lastNum = intval(substr($row['employee_num'], 3));
    $newNum = $lastNum + 1;
    $employee_num = "EMP" . str_pad($newNum, 4, "0", STR_PAD_LEFT);
} else {
    $employee_num = "EMP0001";
}

// ✅ Step 3: Check for duplicates
$check = mysqli_query($conn, "SELECT * FROM user_account ua 
JOIN employee e ON ua.user_id = e.user_id 
WHERE ua.username = '$username' OR e.employee_num = '$employee_num' OR e.email = '$email'");

if (mysqli_num_rows($check) > 0) {
    echo json_encode([
        "status" => "duplicate",
        "message" => "Username, employee number, or email already exists!"
    ]);
    exit;
}

// ✅ Step 4: Get user_type_id
$typeQuery = mysqli_query($conn, "SELECT user_type_id FROM user_type WHERE user_type = '$user_type_str'");
if (mysqli_num_rows($typeQuery) === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid user type."]);
    exit;
}
$user_type_row = mysqli_fetch_assoc($typeQuery);
$user_type_id = $user_type_row['user_type_id'];

// ✅ Step 5: Insert into user_account
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insertUser = mysqli_query($conn, "INSERT INTO user_account (username, password, user_type_id) 
VALUES ('$username', '$hashed_password', '$user_type_id')");

if (!$insertUser) {
    echo json_encode(["status" => "error", "message" => "Failed to create user account: " . mysqli_error($conn)]);
    exit;
}

$user_id = mysqli_insert_id($conn);

// ✅ Step 6: Insert into employee
$insertEmployee = mysqli_query($conn, "INSERT INTO employee 
(employee_num, first_name, middle_initial, last_name, email, group_id, segment_id, division_id, user_id) 
VALUES ('$employee_num', '$first_name', '$middle_initial', '$last_name', '$email', '$group_id', '$segment_id', '$division_id', '$user_id')");

if (!$insertEmployee) {
    echo json_encode(["status" => "error", "message" => "Failed to register employee: " . mysqli_error($conn)]);
    exit;
}

// ✅ Step 7: Success
echo json_encode(["status" => "success"]);
exit;
?>