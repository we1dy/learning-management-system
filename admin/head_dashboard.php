<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM | Head Dashboard</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/head_dashboard.css">
</head>

<body>

  <div class="wrapper">
    <!-- Header -->
    <?php include 'topbar.php' ?>

    <div class="content-wrapper">
      <!-- Sidebar -->

      <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
          <h2>Head Portal</h2>
        </div>
        <nav class="sidebar-nav">
          <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="head_dashboard.php" class="nav-link active">
              <i class="bi bi-house"></i>
              <span>Dashboard</span>
            </a>

            <!-- <div class="nav-section-title">Employee Management</div> -->
            <div class="nav-dropdown">
              <button class="nav-dropdown-toggle">
                <i class="bi bi-people"></i>
                <span>Employee Management</span>
                <i class="bi bi-chevron-down dropdown-icon"></i>
              </button>
              <div class="nav-dropdown-menu">
                <a href="head_register_employee.php" class="nav-dropdown-item">Register Employee</a>
                <!-- <a href="on_boarding.php" class="nav-dropdown-item">View/Reset Password</a> -->
                <!-- <a href="head_view_employees.php" class="nav-dropdown-item">View Enrolled
                  Employees</a>
                <a href="head_manage_details.php" class="nav-dropdown-item">Manage Details & Segments</a> -->
              </div>
            </div>
            <!-- <a href="#" class="nav-link active">
                            <i class="bi bi-bar-chart"></i>
                            <span>Register Employee</span>
                        </a>
                        <a href="employee_announcement.php" class="nav-link ">
                            <i class="bi bi-megaphone me-2"></i>
                            <span>View/Reset Passwords</span>
                        </a>
                        </a>
                        <a href="employee_quiz.php" class="nav-link ">
                            <i class="bi bi-journal-check me-2"></i>
                            <span>View Enrolled Employees</span>
                        </a>
                        <a href="employee_quiz.php" class="nav-link ">
                            <i class="bi bi-journal-check me-2"></i>
                            <span>Manage Details & Segments</span>
                        </a> -->
            <!-- <div class="nav-section-title">Course & Content</div> -->
            <div class="nav-dropdown">
              <button class="nav-dropdown-toggle">
                <i class="bi bi-book"></i>
                <span>Course & Content</span>
                <i class="bi bi-chevron-down dropdown-icon"></i>
              </button>
              <div class="nav-dropdown-menu">
                <a href="head_manage_courses.php" class="nav-dropdown-item">Manage Courses</a>
                <!-- <a href="head_manage_courses.php" class="nav-dropdown-item"> dasd</a> -->
                <a href="head_upload_certs.php" class="nav-dropdown-item">Upload Certifications</a>
                <a href="head_add_quiz.php" class="nav-dropdown-item">Add/Edit Test</a>
                <a href="head_quiz_records.php" class="nav-dropdown-item">View Quiz Records</a>
              </div>
            </div>
            <!-- </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Add Course Material (PDF/PPT)</span>
                        </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Manage Courses</span>
                        </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Upload Certifications</span>
                        </a>

                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Add/Edit Test</span>
                        </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>View Test Records</span>
                        </a> -->

            <!-- <div class="nav-section-title">Analytics</div> -->
            <div class="nav-dropdown">
              <button class="nav-dropdown-toggle">
                <i class="bi bi-clipboard2-data"></i>
                <span>Analytics</span>
                <i class="bi bi-chevron-down dropdown-icon"></i>
              </button>
              <div class="nav-dropdown-menu">
                <a href="head_user_analytics.php" class="nav-dropdown-item">User Data Analytics</a>
                <a href="head_quiz_analytics.php" class="nav-dropdown-item">Test Data Analytics</a>
                <a href="head_audit_log.php" class="nav-dropdown-item">Audit Log</a>

              </div>
            </div>
            <!-- <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>User Data Analytics</span>
                        </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Test Data Analytics</span>
                        </a>
                        <a href="employee_quizlog.php" class="nav-link ">
                            <i class="bi bi-ui-radios me-2"></i>
                            <span>Audit Log</span>
                        </a> -->
            <br>
            <div class="nav-section-title">Help & Settings</div>
            <a href="head_help_page.php" class="nav-link">
              <i class="bi bi-chat-dots me-2"></i>
              <span>Manage Help Page</span>
            </a>


          </div>
          <!-- <div class="nav-section">
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
                    </div> -->
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

          <!-- Stats Cards -->
          <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1">Completed Courses</p>
                      <div id="completed_courses_card">
                        <h3 class="mb-0">Loading...</h3>
                      </div>
                    </div>
                    <div class="stat-icon bg-success-light text-success">
                      <i class="bi bi-award"></i>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-4 mb-3 mb-md-0">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1">In Progress</p>
                      <div id="in_progress_courses_card">
                        <h3 class="mb-0">Loading...</h3>
                      </div>
                    </div>
                    <div class="stat-icon bg-primary-light text-primary">
                      <i class="bi bi-clock"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1">Completion Rate</p>
                      <div id="completion_rate_card">
                        <h3 class="mb-0">Loading...</h3>
                      </div>
                    </div>
                    <div class="stat-icon bg-warning-light text-warning">
                      <i class="bi bi-bar-chart"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>

      </main>

    </div>
  </div>
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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>


  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>
</body>

</html>