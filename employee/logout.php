<?php
require_once "../db.php";

$logout_time = date("Y-m-d H:i:s");
$stmt = $conn->prepare("UPDATE user_log SET logout_date = ? WHERE user_id = ? ORDER BY user_log_id DESC LIMIT 1");
$stmt->bind_param("si", $logout_time, $user_id);
$stmt->execute();

session_unset();
session_destroy();


header("Location: ../index.php");
exit();
