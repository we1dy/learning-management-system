<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $message = trim($_POST['message']);

    if (!empty($username) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO em_messages (username, message, sent_at) VALUES (?, ?, NOW())");

        if ($stmt) {
            $stmt->bind_param("ss", $username, $message);
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
