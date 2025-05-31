<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Behavioral and Management</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/courses.css">
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
            <a href="home.php" class="nav-link">
              <i class="bi bi-house"></i>
              <span>Home</span>
            </a>
            <a href="employee_dashboard.php" class="nav-link ">
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
              <div class="nav-dropdown-menu active">
                <a href="regulatory_courses.php" class="nav-dropdown-item active">Regulatory Courses</a>
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
          <!-- Mobile Search -->
          <div class="mobile-search d-md-none mb-4">
            <div class="input-group">
              <span class="input-group-text bg-transparent">
                <i class="fas fa-search"></i>
              </span>
              <input type="text" class="form-control" placeholder="Search courses...">
            </div>
          </div>
          &nbsp;
          &nbsp;
          &nbsp;
          <!-- Page Header -->
          <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="page-title">Behavioural and Management Training</h1>
              <span class="badge mandatory-badge">Mandatory Training</span>
            </div>
            <p class="text-muted mt-2">
              Complete these required courses to ensure compliance with banking regulations
            </p>
          </div>

          <!-- Course Grid -->
          <div class="row g-4">
            <!-- Leadership Fundamentals -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-red">
                  <div class="course-icon">
                    <i class="fas fa-money-bill-wave"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Leadership Fundamentals</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Essential skills for new managers
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 2 hours</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Effective Communication -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-blue">
                  <div class="course-icon">
                    <i class="fas fa-shield-alt"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Effective Communication</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Improving workplace communication
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 1.5 hours</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Team Building -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-purple">
                  <div class="course-icon">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Team Building</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Creating high-performance teams
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 1 hour</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Conflict Resolution -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-green">
                  <div class="course-icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Conflict Resolution</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Managing workplace conflicts effectively
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 1.5 hours</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Time Management -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-amber">
                  <div class="course-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Time Management</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Maximizing productivity at work
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 2 hours</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Emotional Intelligence-->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-slate">
                  <div class="course-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Emotiioiinal Intelligence</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Developing EQ for workplace success
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="course-duration">Duration: 2.5 hours</div>
                    <button class="btn btn-link start-course-btn">
                      Start Course <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="pagination-container mt-5">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">
                    <i class="fas fa-chevron-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <!-- Footer -->
        <<?php include 'footer.php' ?>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom JS -->
  <script src="assets/js/script.js"></script>
  <script src="assets/js/sidebar.js"></script>
</body>

</html>