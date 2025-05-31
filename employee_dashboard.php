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
            <!-- <a href="home.php" class="nav-link">
              <i class="bi bi-house"></i>
              <span>Home</span>
            </a> -->
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
              <div class="nav-dropdown-menu">
                <a href="regulatory_courses.php" class="nav-dropdown-item">Regulatory Courses</a>
                <a href="on_boarding.php" class="nav-dropdown-item">On-Boarding Orientation</a>
                <a href="behavioral_management.php" class="nav-dropdown-item">Behavioral and Management</a>
                <a href="development_program.php" class="nav-dropdown-item">Development Program</a>
                <a href="tech_job_specific.php" class="nav-dropdown-item">Technical/Job Specific</a>
              </div>

              <a href="employee_quiz.php" class="nav-link ">
                <i class="bi bi-journal-check me-2"></i>
                <span>Quiz</span>
              </a>
              </a>
              <a href="" class="nav-link">
                <i class="bi bi-ui-radios me-2"></i>
                <span>Certificate</span>
              </a>
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

          <!-- Stats Cards -->
          <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1">Completed Courses</p>
                      <h3 class="mb-0">6</h3>
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
                      <h3 class="mb-0">3</h3>
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
                      <h3 class="mb-0">67%</h3>
                    </div>
                    <div class="stat-icon bg-warning-light text-warning">
                      <i class="bi bi-bar-chart"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- History Section -->
          <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">HISTORY</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <!-- Course Card 1 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name 1">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name 1</h5>
                    <p class="card-text text-muted">Completed on 05/10/2023</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Course Card 2 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name 2">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name 2</h5>
                    <p class="card-text text-muted">Completed on 04/25/2023</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Course Card 3 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name 3">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name 3</h5>
                    <p class="card-text text-muted">Completed on 03/15/2023</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Completed Section -->
          <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">COMPLETED</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <!-- Course Card A -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name A">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name A</h5>
                    <p class="card-text text-muted">Completed on 02/28/2023</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Course Card B -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name B">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name B</h5>
                    <p class="card-text text-muted">Completed on 01/15/2023</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Course Card C -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Course Name C">
                    <span class="badge bg-success">Completed</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Course Name C</h5>
                    <p class="card-text text-muted">Completed on 12/20/2022</p>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Ongoing Section -->
          <section>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">ONGOING</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <!-- Ongoing Course 1 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Financial Regulations">
                    <span class="badge bg-primary">In Progress</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Financial Regulations</h5>
                    <p class="card-text text-muted">Due 06/15/2023</p>
                    <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                      <small class="text-muted">45% Complete</small>
                      <button class="btn btn-sm btn-link text-danger p-0">Continue</button>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Ongoing Course 2 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Customer Service Excellence">
                    <span class="badge bg-primary">In Progress</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Customer Service Excellence</h5>
                    <p class="card-text text-muted">Due 06/30/2023</p>
                    <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                      <small class="text-muted">20% Complete</small>
                      <button class="btn btn-sm btn-link text-danger p-0">Continue</button>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Ongoing Course 3 -->
              <div class="col-md-4 mb-3">
                <div class="card course-card">
                  <div class="course-image">
                    <img src="https://via.placeholder.com/300x150" alt="Digital Banking Solutions">
                    <span class="badge bg-primary">In Progress</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Digital Banking Solutions</h5>
                    <p class="card-text text-muted">Due 07/15/2023</p>
                    <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                      <small class="text-muted">10% Complete</small>
                      <button class="btn btn-sm btn-link text-danger p-0">Continue</button>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>


  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/script.js"></script>
  <script src="assets/js/sidebar.js"></script>
</body>

</html>