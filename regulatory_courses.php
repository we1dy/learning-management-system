<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM - Regulatory Courses</title>
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
    <header class="header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-link text-white d-md-none me-2">
              <i class="bi bi-list"></i>
            </button>
            <div class="logo">
              <img src="assets/images/logo.png" width="180px" alt="PBCOM Logo" class="img-fluid">
            </div>
          </div>
          <div class="col d-flex justify-content-end align-items-center">
            <div class="search-container d-none d-md-block me-3">
              <div class="input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search courses...">
              </div>
            </div>
            <div class="d-flex align-items-center">
              <button class="btn btn-icon me-3">
                <i class="fas fa-bell text-light"></i>
              </button>
              <div class="user-info d-flex align-items-center">
                <span class="user-name d-none d-md-block me-2">Lady Arboleda</span>
                <div class="user-avatar">
                  <i class="fas fa-user"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="content-wrapper">
      <!-- Sidebar -->
      <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
          <h2>Employee Portal</h2>
        </div>
        <nav class="sidebar-nav">
          <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="#" class="nav-link active">
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

          <!-- Page Header -->
          <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="page-title">Regulatory Courses</h1>
              <span class="badge mandatory-badge">Mandatory Training</span>
            </div>
            <p class="text-muted mt-2">
              Complete these required courses to ensure compliance with banking regulations
            </p>
          </div>

          <!-- Course Grid -->
          <div class="row g-4">
            <!-- Anti-Money Laundering -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-red">
                  <div class="course-icon">
                    <i class="fas fa-money-bill-wave"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Anti-Money Laundering</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Understanding AML regulations and compliance procedures for financial institutions
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

            <!-- Data Privacy Act -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-blue">
                  <div class="course-icon">
                    <i class="fas fa-shield-alt"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Data Privacy Act</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Compliance with data protection regulations and safeguarding customer information
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

            <!-- Bank Secrecy Law -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-purple">
                  <div class="course-icon">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Bank Secrecy Law</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Understanding confidentiality requirements and legal obligations for banking information
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

            <!-- Consumer Protection -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-green">
                  <div class="course-icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Consumer Protection</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Fair treatment of banking customers and understanding consumer rights protection
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

            <!-- Fraud Prevention -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-amber">
                  <div class="course-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Fraud Prevention</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Identifying and preventing financial fraud through detection techniques and protocols
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

            <!-- Risk Management -->
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-slate">
                  <div class="course-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Risk Management</h3>
                    <span class="badge required-badge">Required</span>
                  </div>
                  <p class="course-description">
                    Fundamentals of banking risk management and mitigation strategies
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
        <footer class="footer">
          <div class="container-fluid">
            <div class="text-center">
              <div class="footer-links">
                <a href="#">Help</a>
                <span>|</span>
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms of Service</a>
              </div>
              <div class="copyright mt-2">
                © 2025 PBCOM Universal Bank. All rights reserved.
              </div>
            </div>
          </div>
        </footer>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="assets/js/script.js"></script>
  <script src="assets/js/sidebar.js"></script>

</body>

</html>