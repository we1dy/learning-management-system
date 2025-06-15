<?php
$course = $_GET['course'] ?? 'unknown';

echo "<h1>Welcome to the $course course page!</h1>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Anti-Money Laundering </title>
  <!-- Aileron Font -->
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/view_courses.css">
  <link rel="stylesheet" href="../assets/css/card_list.css">
  <link rel="stylesheet" href="../assets/css/courses.css">
  <link rel="stylesheet" href="../assets/css/top_nsidebar.css">
</head>

<body>
  <div class="wrapper">
    <!-- Header -->
    <?php include '../topbar.php' ?>

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
              <span>Hone</span>
            </a>
            <a href="employee_dashboard.php" class="nav-link">
              <i class="bi bi-bar-chart"></i>
              <span>Dashboard</span>
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

          <h1>Anti-Money Laundering</h1>
          <a href="employee_dashboard.php">back</a>

          </section>
        </div>
      </main>
    </div>
  </div>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const currentPath = window.location.pathname.split("/").pop(); // get current filename
      const dropdowns = document.querySelectorAll(".nav-dropdown");

      dropdowns.forEach(dropdown => {
        const items = dropdown.querySelectorAll(".nav-dropdown-item");

        items.forEach(item => {
          const href = item.getAttribute("href");

          if (href === currentPath) {
            item.classList.add("active");                 // highlight item
            dropdown.classList.add("open");               // keep dropdown open
          }
        });
      });
    });
  </script>

  <script src="../assets/js/sidebar.js"></script>
</body>

</html>