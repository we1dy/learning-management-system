<?php
require_once "db.php";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
  ?>
          <!DOCTYPE html>
          <html>

          <head>
            <title>Redirecting...</title>
            <!-- SweetAlert2 CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
              <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
          </head>

          <body>
            <script>
              Swal.fire({
                icon: 'warning',
                title: 'Unauthorized Access',
                text: 'You must be logged in to continue. Redirecting in 5 seconds.',
                confirmButtonText: 'Go to Login',
                allowOutsideClick: false
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'index.php';
                }
              });

              // Auto-redirect after 5 seconds (optional fallback)
              setTimeout(() => {
                window.location.href = 'index.php';
              }, 5000);
            </script>
          </body>

          </html>
          <?php
          exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Home</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- CSS Custom -->
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
  <div class="wrapper">
    <!-- Header -->
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
            <a href="home.php" class="nav-link active">
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
            <a href="employee_message.php" class="nav-link">
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
                <a href="behavioral_management.php" class="nav-dropdown-item">Behavioral and
                  Management</a>
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
          <!-- Mobile Search -->
          <div class="mobile-search d-md-none mb-3">
            <div class="position-relative">
              <i class="bi bi-search search-icon"></i>
              <input type="text" class="form-control" placeholder="Search...">
            </div>
          </div>

          <h1>home</h1>
          <a href="employee_dashboard.php">back</a>

          </section>
        </div>

        <!-- Footer -->
        <?php include 'footer.php' ?>
      </main>
    </div>
  </div>

  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>
</body>

</html>