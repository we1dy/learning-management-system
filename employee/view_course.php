<?php
require_once "../db.php";
session_start();

if (!isset($_SESSION['employee_id'])) {
  header("Location: login.php");
  exit();
}

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$employee_id = $_SESSION['employee_id'];

// Get course information
$sql = "
    SELECT c.course_name, c.course_desc, ec.status
    FROM employee_courses ec
    JOIN course c ON ec.course_id = c.course_id
    WHERE ec.employee_id = ? AND ec.course_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $employee_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  echo "Unauthorized access or course not found.";
  exit();
}

$course = $result->fetch_assoc();

// Load modules for this course - MOVE THIS TO THE TOP!
$module_query = "SELECT * FROM course_modules WHERE course_id = ?";
$stmt = $conn->prepare($module_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$modules = $stmt->get_result();

// File viewer function for localhost
function getFileViewer($file_path, $base_url = 'http://localhost/')
{
  $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
  $file_name = basename($file_path);

  switch ($file_ext) {
    case 'pdf':
      return '<iframe src="' . htmlspecialchars($file_path) . '#toolbar=0" width="100%" height="700px" frameborder="0" style="border: 1px solid #ddd; border-radius: 8px;"></iframe>';

    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'bmp':
    case 'webp':
      return '<div class="text-center p-3" style="border: 1px solid #ddd; border-radius: 8px;">
                        <img src="' . htmlspecialchars($file_path) . '" class="img-fluid" style="max-height: 600px; border-radius: 4px;" alt="Course Image">
                    </div>';

    case 'pptx':
    case 'ppt':
      return '<div class="alert alert-info text-center" style="min-height: 200px; display: flex; flex-direction: column; justify-content: center;">
                        <i class="bi bi-file-earmark-ppt" style="font-size: 3rem; color: #d63384;"></i>
                        <h5 class="mt-3">PowerPoint Presentation</h5>
                        <p class="mb-3"><strong>' . htmlspecialchars($file_name) . '</strong></p>
                        <p class="text-muted small">PowerPoint files require download to view on localhost</p>
                        <a href="' . htmlspecialchars($file_path) . '" class="btn btn-primary" download>
                            <i class="bi bi-download"></i> Download & Open
                        </a>
                    </div>';

    case 'docx':
    case 'doc':
      return '<div class="alert alert-info text-center" style="min-height: 200px; display: flex; flex-direction: column; justify-content: center;">
                        <i class="bi bi-file-earmark-word" style="font-size: 3rem; color: #0d6efd;"></i>
                        <h5 class="mt-3">Word Document</h5>
                        <p class="mb-3"><strong>' . htmlspecialchars($file_name) . '</strong></p>
                        <p class="text-muted small">Word documents require download to view on localhost</p>
                        <a href="' . htmlspecialchars($file_path) . '" class="btn btn-primary" download>
                            <i class="bi bi-download"></i> Download & Open
                        </a>
                    </div>';

    default:
      return '<div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle"></i>
                        Unsupported file format: ' . strtoupper($file_ext) . '
                        <br><a href="' . htmlspecialchars($file_path) . '" class="btn btn-primary btn-sm mt-2" download>
                            <i class="bi bi-download"></i> Download File
                        </a>
                    </div>';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title><?= htmlspecialchars($course['course_name']) ?> - Course View</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Logo icon -->
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">

  <!-- Aileron Font -->
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="stylesheet" href="../assets/css/view_courses.css">
    <link rel="stylesheet" href="../assets/css/top_nsidebar.css">

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

        <!-- Course Header -->
        <div class="mb-4">
          <div class="breadcrumb-container mb-3">
            <a href="regulatory_courses.php" style="text-decoration: none; color:black"><span>Regulatory</span></a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">Money Laundering</span>
          </div>

          <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
              <h1 class="course-title mb-3">Money Laundering Prevention</h1>
              <div class="d-flex gap-3 mb-4 flex-wrap">
                <span class="badge bg-light-blue">
                  <i class="bi bi-clock"></i>
                  In Progress
                </span>
                <div class="badge-text">
                  <i class="bi bi-shield"></i>
                  <span>Compliance Required</span>
                </div>
                <div class="badge-text">
                  <i class="bi bi-star-fill text-warning"></i>
                  <span>4.8 Rating</span>
                </div>
              </div>
            </div>

            <div class="progress-card">
              <div class="card-header">
                <h5 class="card-title">Course Progress</h5>
              </div>
              <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-2">
                  <span>Completed</span>
                  <span class="fw-medium"><span id="completed-modules">2</span>/6 modules</span>
                </div>
                <div class="progress mb-2">
                  <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <div class="text-muted small">33% complete</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Course Description -->
        <div class="card mb-4 p-2">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bi bi-book"></i>
              Course Overview
            </h5>
          </div>
          <div class="card-body">
            <p class="card-text">
              This comprehensive course provides essential knowledge about money laundering prevention in the banking
              sector. You'll learn to identify suspicious activities, understand regulatory requirements, and master
              proper reporting procedures. The course combines theoretical knowledge with practical case studies to
              ensure you're well-equipped to protect our institution and comply with all relevant regulations.
            </p>
            <div class="row mt-4 pt-3 border-top text-center">
              <div class="col-md-4">
                <div class="stat-value text-primary">6</div>
                <div class="stat-label">Modules</div>
              </div>
              <div class="col-md-4">
                <div class="stat-value text-success">2.5h</div>
                <div class="stat-label">Duration</div>
              </div>
              <div class="col-md-4">
                <div class="stat-value text-purple">95%</div>
                <div class="stat-label">Pass Rate</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Course Modules -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bi bi-mortarboard"></i>
              Course Modules
            </h5>
            <div class="card-subtitle">Complete all modules to earn your certification</div>
          </div>
          <div class="card-body">
            <div class="modules-container">
              <?php if ($modules->num_rows === 0): ?>
                <div class="alert alert-warning">No modules found for this course.</div>
              <?php else: ?>
                <div class="modules-list p-3" style="border: 0.25pt solid #ccc; border-radius: 8px;">
                  <?php while ($mod = $modules->fetch_assoc()): ?>
                    <div class="module-content">
                      <h5><?= htmlspecialchars($mod['title'] ?? 'Module ' . $mod['module_id']) ?></h5>
                      <div class="module-body">
                        <?= getFileViewer($mod['file_path']) ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Your existing hardcoded modules section -->
        <div class="card">
          <div class="card-body">
            <div class="module-list mb-4">

              <!-- Module 1 -->
              <div class="module-item completed mb-3" data-module="1">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-check-circle-fill text-success"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Introduction to Money Laundering</h5>
                      <p class="module-description">Understanding the basics of money laundering and its impact on
                        financial institutions</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          15 min
                        </span>
                        <span class="badge bg-light-green">Completed</span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button class="btn btn-outline-secondary btn-sm">Review</button>
                  </div>
                </div>
              </div>

              <!-- Module 2 -->
              <div class="module-item completed mb-3" data-module="2">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-check-circle-fill text-success"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Legal Framework & Regulations</h5>
                      <p class="module-description">Key laws, regulations, and compliance requirements in the banking
                        sector</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          20 min
                        </span>
                        <span class="badge bg-light-green">Completed</span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button class="btn btn-outline-secondary btn-sm">Review</button>
                  </div>
                </div>
              </div>

              <!-- Module 3 -->
              <div class="module-item current mb-3" data-module="3">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-bullseye text-warning"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Red Flags & Suspicious Activities</h5>
                      <p class="module-description">Identifying warning signs and suspicious transaction patterns</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          25 min
                        </span>
                        <span class="badge bg-light-blue">Current</span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button class="btn btn-primary btn-sm">Continue</button>
                  </div>
                </div>
              </div>

              <!-- Module 4 -->
              <div class="module-item mb-3" data-module="4">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-play-circle text-primary"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Reporting Procedures</h5>
                      <p class="module-description">Step-by-step guide to proper reporting and documentation</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          18 min
                        </span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <i class="bi bi-lock"></i>
                    <button class="btn btn-secondary btn-sm" disabled>Locked</button>
                  </div>
                </div>
              </div>

              <!-- Module 5 -->
              <div class="module-item mb-3" data-module="5">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-people text-info"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Case Studies & Scenarios</h5>
                      <p class="module-description">Real-world examples and practical application exercises</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          30 min
                        </span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <i class="bi bi-lock"></i>
                    <button class="btn btn-secondary btn-sm" disabled>Locked</button>
                  </div>
                </div>
              </div>

              <!-- Module 6 -->
              <div class="module-item mb-3" data-module="6">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex gap-3">
                    <div class="module-icon">
                      <i class="bi bi-trophy text-warning"></i>
                    </div>
                    <div>
                      <h5 class="module-title">Final Assessment</h5>
                      <p class="module-description">Comprehensive evaluation of your understanding</p>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="module-duration">
                          <i class="bi bi-clock"></i>
                          45 min
                        </span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <i class="bi bi-lock"></i>
                    <button class="btn btn-secondary btn-sm" disabled>Locked</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>
</body>

</html>