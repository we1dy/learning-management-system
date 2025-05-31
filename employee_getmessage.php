<?php
include 'db.php';

$sql = "SELECT username, message, sent_at FROM em_messages ORDER BY sent_at ASC";
$result = $conn->query($sql);

$currentUser = isset($_POST['currentUser']) ? $_POST['currentUser'] : '';

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $time = date("H:i", strtotime($row['sent_at']));
    $isUser = ($row['username'] === $currentUser);
    $class = $isUser ? 'user' : 'other';

    echo "<div class='chat-message $class'>
            <strong>" . htmlspecialchars($row['username']) . "</strong> <small>[$time]</small><br>
            " . htmlspecialchars($row['message']) . "
          </div>";
  }
} else {
  echo "No messages";
}

$conn->close();
?>
