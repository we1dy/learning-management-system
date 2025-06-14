<?php
require_once "../db.php";

// Get filter parameters
$group_id = isset($_POST['group_id']) && $_POST['group_id'] !== '' ? intval($_POST['group_id']) : null;
$segment_id = isset($_POST['segment_id']) && $_POST['segment_id'] !== '' ? intval($_POST['segment_id']) : null;
$division_id = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? intval($_POST['division_id']) : null;
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$course_id = isset($_POST['course_id']) && $_POST['course_id'] !== '' ? intval($_POST['course_id']) : null;

// Build the SQL query
$sql = "SELECT employee_id, employee_num, last_name, first_name, middle_initial, email 
        FROM employee 
        WHERE 1=1";

$params = [];
$types = "";

// Exclude already assigned employees
if ($course_id !== null) {
    $sql .= " AND employee_id NOT IN (SELECT employee_id FROM employee_courses WHERE course_id = ?)";
    $params[] = $course_id;
    $types .= "i";
}

// Add filters
if ($group_id !== null) {
    $sql .= " AND group_id = ?";
    $params[] = $group_id;
    $types .= "i";
}

if ($segment_id !== null) {
    $sql .= " AND segment_id = ?";
    $params[] = $segment_id;
    $types .= "i";
}

if ($division_id !== null) {
    $sql .= " AND division_id = ?";
    $params[] = $division_id;
    $types .= "i";
}

// Add search functionality
if (!empty($search)) {
    $sql .= " AND (employee_num LIKE ? OR last_name LIKE ? OR first_name LIKE ? OR email LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ssss";
}

$sql .= " ORDER BY last_name, first_name";

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo '<div class="text-danger">Database error: ' . htmlspecialchars($conn->error) . '</div>';
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Generate the HTML output
if ($result->num_rows === 0) {
    echo '<div class="text-muted p-3">No employees found matching your criteria.</div>';
} else {
    // Header row
    echo '<div class="d-flex fw-bold border-bottom pb-2 mb-2" style="font-size: 16px;">
            <div style="width: 30px;"></div>
            <div style="width: 100px;">Employee #</div>
            <div style="width: 150px;">Last Name</div>
            <div style="width: 150px;">First Name</div>
            <div style="width: 100px;">M.I.</div>
            <div style="width: 150px;">Email</div>
          </div>';

    while ($employee = $result->fetch_assoc()) {
        echo '<div class="d-flex align-items-center mb-1 p-1" style="font-size: 16px;">';
        echo '<div class="me-2" style="width: 30px;">';
        echo '<input type="checkbox" name="employee_ids[]" value="' . htmlspecialchars($employee['employee_id']) . '" class="form-check-input">';
        echo '</div>';
        echo '<div style="width: 100px;">' . htmlspecialchars($employee['employee_num']) . '</div>';
        echo '<div style="width: 150px;">' . htmlspecialchars($employee['last_name']) . '</div>';
        echo '<div style="width: 150px;">' . htmlspecialchars($employee['first_name']) . '</div>';
        echo '<div style="width: 100px;">' . htmlspecialchars($employee['middle_initial'] ?? '') . '</div>';
        echo '<div style="width: 150px;">' . htmlspecialchars($employee['email']) . '</div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>