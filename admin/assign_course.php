<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_ids'], $_POST['course_id'])) {
    $employee_ids = $_POST['employee_ids'];
    $course_id = $_POST['course_id'];
    $assigned_date = date('Y-m-d');

    $successCount = 0;
    $duplicateCount = 0;

    foreach ($employee_ids as $employee_id) {
        // Check if already assigned
        $stmt = $conn->prepare("SELECT id FROM employee_courses WHERE employee_id = ? AND course_id = ?");
        $stmt->bind_param("ii", $employee_id, $course_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Not assigned yet
            $insert = $conn->prepare("INSERT INTO employee_courses (employee_id, course_id, assigned_date, status) VALUES (?, ?, ?, 'Assigned')");
            $insert->bind_param("iis", $employee_id, $course_id, $assigned_date);
            if ($insert->execute()) {
                $successCount++;
            }
        } else {
            $duplicateCount++;
        }
    }

    // Feedback
    header("Location: head_view_course.php?course_id=$course_id&assigned=$successCount&duplicates=$duplicateCount");
    exit;
} else {
    echo "Invalid request.";
}
