<?php
require_once "../db.php";

header('Content-Type: application/json');

$query = "
SELECT 
    e.employee_id, 
    e.employee_num,
    e.last_name, 
    e.first_name, 
    e.middle_initial,
    e.email,  
    ua.username, 
    ua.account_status
FROM employee e
LEFT JOIN user_account ua ON e.user_id = ua.user_id
ORDER BY e.last_name ASC

";

$result = $conn->query($query);
$employees = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

echo json_encode($employees);
