<?php
require_once "../db.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PBCOM LMS | Message</title>
  <!-- Logo icon-->
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">

  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../assets/css/dashboard.css" />
  <style>
    .messages-container {
      display: flex;
      height: 68vh;
      background: #f5f5f5;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.11);
      border-radius: 10px;
      overflow: hidden;
    }

    .contacts-panel {
      width: 250px;
      background: #e6e6e6;
      padding: 15px;
      border-right: 1px solid #ccc;
    }

    .contact {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .contact .avatar {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .chat-panel {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      padding: 15px;
      background: #f9f9f9;
    }

    .chat-header {
      font-weight: bold;
      margin-bottom: 10px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
    }

    .chat-messages {
      flex-grow: 1;
      overflow-y: auto;
      margin-bottom: 10px;
      padding: 10px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .chat-input {
      display: flex;
      gap: 10px;
    }

    .chat-input input {
      flex-grow: 1;
    }

    .chat-message {
      margin-bottom: 10px;
      display: flex;
    }
    .user-bubble {
      justify-content: flex-end;
    }
    .other-bubble {
      justify-content: flex-start;
    }
    .bubble-content {
      background: #e6e6e6;
      border-radius: 15px;
      padding: 10px 15px;
      max-width: 60%;
      box-shadow: 0 2px 6px rgba(0,0,0,0.07);
      word-break: break-word;
    }
    .user-bubble .bubble-content {
      background: #d1e7dd;
      color: #155724;
      align-self: flex-end;
    }
    .other-bubble .bubble-content {
      background: #f8d7da;
      color: #721c24;
      align-self: flex-start;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Header -->
    <?php include 'topbar.php' ?>
    <div class="content-wrapper">
    
      <!-- Sidebar -->
      <?php include 'sidebar.php' ?>

      <!-- Main Content -->
      <main class="main-content">
        <div class="container-fluid mt-4">
          <h1>Messages</h1>
          &nbsp;
          <div class="messages-container">

            <!-- Contacts Panel -->
            <div class="contacts-panel">
              <input type="text" class="form-control mb-3" placeholder="Search..." />
              <!-- placeholder muna toh ⬇️⬇️⬇️⬇️⬇️⬇️⬇️⬇️ -->
              <div class="contact"><div class="avatar" style="background: pink;"></div>Angeline Bedis</div>
              <div class="contact"><div class="avatar" style="background: #a94442;"></div>Yeye Tirazona</div>
              <div class="contact"><div class="avatar" style="background: #732626;"></div>Louise Majadas</div>
              <!-- placeholder muna toh ⬆️⬆️⬆️⬆️⬆️⬆️⬆️⬆️ -->
            </div>

            <!-- Chat Panel -->
            <div class="chat-panel">
              <div class="chat-header">Name of the person user is currently chatting</div>
              <div id="chat-box" class="chat-messages"></div>
              <div class="chat-input">
                <input type="text" id="message" class="form-control" placeholder="Type a message" />
                <button class="btn btn-danger" onclick="sendMessage()">
                  <i class="bi bi-send"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        &nbsp;
        &nbsp;
        &nbsp;

        <!-- Footer -->
        <?php include '../footer.php' ?>&nbsp;
      </main>
    </div>
  </div>

  <script>
    function sendMessage() {
      const message = document.getElementById("message").value.trim();
      if (!message) {
        alert("Message cannot be empty.");
        return;
      }

      // Show the message immediately as a chat bubble
      const chatBox = document.getElementById("chat-box");
      const now = new Date();
      const time = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
      const msgHTML = `
        <div class='chat-message user-bubble'>
          <div class="bubble-content">
            <strong>You</strong> <small>[${time}]</small><br>
            ${message}
          </div>
        </div>`;
      chatBox.innerHTML += msgHTML;
      chatBox.scrollTop = chatBox.scrollHeight;

      document.getElementById("message").value = "";

      // Send to database
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "employee_sendmesage.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function() {
        if (xhr.responseText.trim() !== "success") {
          alert("Error sending message: " + xhr.responseText);
        }
      };
      xhr.send("message=" + encodeURIComponent(message));
    }

    document.getElementById("message").addEventListener("keydown", function(event) {
      if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebar.js"></script>
</body>

</html>
