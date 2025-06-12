<?php
require '../db.php'; // or your connection file

$group_id = $_POST['group_id'] ?? '';
$segment_id = $_POST['segment_id'] ?? '';
$division_id = $_POST['division_id'] ?? '';

$conditions = [];
if ($group_id !== '')
    $conditions[] = "group_id = " . intval($group_id);
if ($segment_id !== '')
    $conditions[] = "segment_id = " . intval($segment_id);
if ($division_id !== '')
    $conditions[] = "division_id = " . intval($division_id);

$where = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

$query = "SELECT employee_id, last_name, first_name FROM employee $where ORDER BY last_name";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($emp = $result->fetch_assoc()) {
        $full_name = htmlspecialchars($emp['last_name'] . ', ' . $emp['first_name']);
        echo "<div class='form-check'>
                <input class='form-check-input' type='checkbox' name='employee_ids[]' value='{$emp['employee_id']}' id='emp{$emp['employee_id']}'>
                <label class='form-check-label' for='emp{$emp['employee_id']}'>{$full_name}</label>
              </div>";
    }
} else {
    echo "<div class='text-muted'>No employees found.</div>";
}
?>