<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM Learning Portal</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Aileron Font -->
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/courses.css">
  <link rel="stylesheet" href="../assets/css/cert.css">

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
        <div class="container-fluid">
          <!-- Page Header -->
          <div class="mb-4">
            <h1 class="display-6 fw-bold text-dark mb-2">Certifications</h1>
            <p class="text-muted">
              Advance your career with professional certifications from leading technology providers and industry
              experts.
            </p>
          </div>

          <!-- Stats Cards -->
          <div class="row mb-4">
            <div class="col-md-3 mb-3">
              <div class="stats-card">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-warning">
                    <i class="fas fa-trophy text-white"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold" id="certificatesEarned">3</div>
                    <div class="small text-muted">Certificates Earned</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="stats-card">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-primary">
                    <i class="fas fa-book-open text-white"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold" id="coursesCompleted">12</div>
                    <div class="small text-muted">Courses Completed</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="stats-card">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-success">
                    <i class="fas fa-clock text-white"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold" id="learningTime">48h</div>
                    <div class="small text-muted">Learning Time</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="stats-card">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-info">
                    <i class="fas fa-users text-white"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold" id="teamRanking">85%</div>
                    <div class="small text-muted">Team Ranking</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabs -->
          <ul class="nav nav-tabs mb-4" id="mainTabs">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tab" href="#certificates">Professional Certificates</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#preparation">Exam Preparation</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#achievements">Achievements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#progress">My Progress</a>
            </li>
          </ul>

          <div class="tab-content">
            <!-- Professional Certificates Tab -->
            <div class="tab-pane fade show active" id="certificates">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-semibold">Professional Certificates</h2>
                <button class="btn btn-outline-secondary">
                  View All <i class="fas fa-chevron-right ms-1"></i>
                </button>
              </div>

              <p class="text-muted mb-4">
                Showcase your skills with professional certificates featuring courses and assessments developed
                with leading brands and organizations.
              </p>

              <!-- Filter Chips -->
              <div class="mb-4">
                <div class="d-flex flex-wrap">
                  <span class="filter-chip active" data-filter="all">All Providers</span>
                  <span class="filter-chip" data-filter="cloud">Core Banking</span>
                  <span class="filter-chip" data-filter="security">Compliance & Risk</span>
                  <span class="filter-chip" data-filter="management">Costumer Service</span>
                  <span class="filter-chip" data-filter="development">Digital Banking</span>
                </div>
              </div>

              <div class="row" id="providersContainer">
                <!-- Provider cards will be populated by JavaScript -->
              </div>
            </div>

            <!-- Exam Preparation Tab -->
            <div class="tab-pane fade" id="preparation">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-semibold">Certification Preparation</h2>
                <button class="btn btn-outline-secondary">
                  View All <i class="fas fa-chevron-right ms-1"></i>
                </button>
              </div>

              <p class="text-muted mb-4">
                Prepare for industry-recognized certification exams with expert-led courses and practice tests.
              </p>

              <div id="coursesContainer">
                <!-- Course cards will be populated by JavaScript -->
              </div>
            </div>

            <!-- Achievements Tab -->
            <div class="tab-pane fade" id="achievements">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-semibold">Your Achievements</h2>
                <button class="btn btn-outline-secondary" id="shareProgress">
                  Share Progress <i class="fas fa-share ms-1"></i>
                </button>
              </div>

              <div class="row" id="achievementsContainer">
                <!-- Achievement cards will be populated by JavaScript -->
              </div>
            </div>

            <!-- Progress Tab -->
            <div class="tab-pane fade" id="progress">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-semibold">Learning Progress</h2>
                <button class="btn btn-outline-secondary" id="downloadReport">
                  Download Report <i class="fas fa-download ms-1"></i>
                </button>
              </div>

              <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="stats-card">
                    <h5 class="fw-semibold mb-2">Monthly Learning Goals</h5>
                    <p class="text-muted small mb-4">Track your learning objectives</p>

                    <div class="mb-3">
                      <div class="d-flex justify-content-between small mb-1">
                        <span>Courses Completed</span>
                        <span>3/5</span>
                      </div>
                      <div class="progress progress-bar">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="d-flex justify-content-between small mb-1">
                        <span>Learning Hours</span>
                        <span>24/40</span>
                      </div>
                      <div class="progress progress-bar">
                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="d-flex justify-content-between small mb-1">
                        <span>Certificates Earned</span>
                        <span>1/2</span>
                      </div>
                      <div class="progress progress-bar">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mb-4">
                  <div class="stats-card text-center">
                    <h5 class="fw-semibold mb-2">Learning Streak</h5>
                    <p class="text-muted small mb-4">Keep up the momentum!</p>

                    <div class="display-4 fw-bold text-success mb-2" id="streakDays">7</div>
                    <div class="small text-muted mb-4">Days in a row</div>

                    <div class="d-flex justify-content-center" id="streakContainer">
                      <!-- Streak days will be populated by JavaScript -->
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

  <!-- Notification -->
  <div class="notification" id="notification">
    <div class="d-flex align-items-center">
      <i class="fas fa-check-circle text-success me-2"></i>
      <span id="notificationText">Notification message</span>
    </div>
  </div>

  <!-- Loading Spinner -->
  <div class="loading-spinner" id="loadingSpinner"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Customm JS -->
  <script src="../assets/js/sidebar.js"></script>
  <script src="../assets/js/cert.js"></script>
</body>

</html>