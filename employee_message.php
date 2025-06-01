<?php
require_once "db.php";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Dashboard</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>

  <?php include 'topbar.php' ?>

  <div class="content-wrapper">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
      <div class="sidebar-header">
        <h2>Employee Portal</h2>
      </div>
      <nav class="sidebar-nav">
        <div class="nav-section">
          <div class="nav-section-title">Main</div>
          <a href="home.php" class="nav-link">
            <i class="bi bi-house"></i>
            <span>Home</span>
          </a>
          <a href="employee_dashboard.php" class="nav-link">
            <i class="bi bi-bar-chart"></i>
            <span>Dashboard</span>
          </a>
          <a href="employee_announcement.php" class="nav-link">
            <i class="bi bi-megaphone me-2"></i>
            <span>Announcements</span>
          </a>
          <a href="employee_quiz.php" class="nav-link ">
            <i class="bi bi-journal-check me-2"></i>
            <span>Quiz</span>
          </a>
          </a>
          <a href="employee_quizlog.php" class="nav-link ">
            <i class="bi bi-ui-radios me-2"></i>
            <span>Quiz Log</span>
          </a>
          <a href="employee_message.php" class="nav-link active">
            <i class="bi bi-chat-dots me-2"></i>
            <span>Message</span>
          </a>

        </div>
        <div class="nav-section">
          <div class="nav-section-title">Learning</div>
          <div class="nav-dropdown">
            <button class="nav-dropdown-toggle">
              <i class="bi bi-book"></i>
              <span>Courses</span>
              <i class="bi bi-chevron-down dropdown-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
              <a href="regulatory_courses.php" class="nav-dropdown-item">Regulatory Courses</a>
              <a href="on_boarding.php" class="nav-dropdown-item">On-Boarding Orientation</a>
              <a href="behavioral_management.php" class="nav-dropdown-item">Behavioral and Management</a>
              <a href="development_program.php" class="nav-dropdown-item">Development Program</a>
              <a href="tech_job_specific.php" class="nav-dropdown-item">Technical/Job Specific</a>
            </div>
          </div>
        </div>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div class="card mt-4">
              <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Employee Chat</h5>
              </div>
              <div class="card-body">
                <div id="chat-box" class="border p-3 mb-3"
                  style="height: 300px; overflow-y: scroll; background: #f9f9f9;"></div>

                <div class="mb-2">
                  <input type="text" id="username" class="form-control mb-2" placeholder="Your name">
                  <input type="text" id="message" class="form-control" placeholder="Type a message">
                </div>
                <button class="btn btn-danger" onclick="sendMessage()">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function sendMessage() {
      const username = document.getElementById("username").value.trim();
      const message = document.getElementById("message").value.trim();

      if (!message) {
        alert("Message cannot be empty.");
        return;
      }


      // Immediately show the message on screen
      const chatBox = document.getElementById("chat-box");
      const msgHTML = `
      <div class='chat-message user'>
        <strong>${username}</strong> <small>[Now]</small><br>
        ${message}
      </div>`;
      chatBox.innerHTML += msgHTML;
      chatBox.scrollTop = chatBox.scrollHeight;

      // Clear the input
      document.getElementById("message").value = "";

      // Send to database
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "employee_sendmesage.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        if (xhr.responseText.trim() !== "success") {
          alert("Error sending message: " + xhr.responseText);
        }
      };
      xhr.send("username=" + encodeURIComponent(username) + "&message=" + encodeURIComponent(message));
    }
  </script>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebar.js"></script>

</body>

</html>