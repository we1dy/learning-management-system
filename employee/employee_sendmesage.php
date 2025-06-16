<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // For testing: always use employee_id 1
    $user_id = 1;
    $message = trim($_POST['message'] ?? '');

    // Get employee full name (for testing, always employee_id 1)
    $stmt = $conn->prepare("SELECT first_name, last_name FROM employee WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstname, $lastname);
    $full_name = '';
    if ($stmt->fetch()) {
        $full_name = $firstname . ' ' . $lastname;
    }
    $stmt->close();

    if (!empty($full_name) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO em_messages (username, message, sent_at) VALUES (?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("ss", $full_name, $message);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "❌ Execute error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Prepare error: " . $conn->error;
        }
    } else {
        echo "❌ Missing username or message";
    }
} else {
    echo "❌ Invalid request";
}

$conn->close();

//send message
