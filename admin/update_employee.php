<?php
include '../db.php';

$id = intval($_POST['user_id']);
$employee_num = $_POST['employee_num'];
$username = $_POST['username'];
$email = $_POST['email'];
$segment_id = $_POST['segment_id'];
$group_id = $_POST['group_id'];
$division_id = $_POST['division_id'];
$user_type_id = $_POST['user_type_id'];
$status = $_POST['status'];

$update_employee = "
    UPDATE employee SET 
        employee_num = '$employee_num',
        email = '$email',
        segment_id = $segment_id,
        group_id = $group_id,
        division_id = $division_id
    WHERE user_id = $id";

$update_user = "
    UPDATE user_account SET 
        username = '$username',
        user_type_id = $user_type_id,
        account_status = '$status'
    WHERE user_id = $id";

if (mysqli_query($conn, $update_employee) && mysqli_query($conn, $update_user)) {
    echo "success";
} else {
    http_response_code(500);
    echo "Update failed: " . mysqli_error($conn);
}
?>