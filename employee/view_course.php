<?php
require_once "../db.php";
session_start();
if (!isset($_SESSION['employee_id'])) {
  header("Location: login.php");
  exit();
}
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$employee_id = $_SESSION['employee_id'];
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
?>

<!DOCTYPE html>
<html>

<head>
  <title><?= htmlspecialchars($course['course_name']) ?> - Course View</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">
</head>

<body>

  <div class="d-flex">
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
            <!-- <i class="bi bi-chevron-right"></i>
            <a href="employee_dashboard.php"><span>Compliance Training</span></a> -->
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
              <?php
              // Load modules for this course
              $module_query = "SELECT * FROM course_modules WHERE course_id = ?";
              $stmt = $conn->prepare($module_query);
              $stmt->bind_param("i", $course_id);
              $stmt->execute();
              $modules = $stmt->get_result();
              ?>

              <!-- <h4 class="mt-4">Course Modules</h4> -->

              <?php if ($modules->num_rows === 0): ?>
                <div class="alert alert-warning">No modules found for this course.</div>
              <?php else: ?>
                <ul class="list-group mb-3">
                  <?php while ($mod = $modules->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                      <iframe src="<?= htmlspecialchars($mod['file_path']) ?>#toolbar=0" width="100%" height="600px"
                        style="border:1px solid #ccc;"></iframe>



                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
              <!-- Module 1 -->
              <div class="module-item completed" data-module="1">
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
              <div class="module-item completed" data-module="2">
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
              <div class="module-item current" data-module="3">
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
              <div class="module-item" data-module="4">
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
              <div class="module-item" data-module="5">
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
              <div class="module-item" data-module="6">
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="script.js"></script>
</body>

</html>


<body>
  <div class="wrapper">
    <!-- Header -->
    <?php include 'topbar.php' ?>

    <div class="content-wrapper">
      <!-- Sidebar -->
      <?php include 'sidebar.php' ?>

      <!-- <div class="container mt-4">
        <h2><?= htmlspecialchars($course['course_name']) ?></h2>
        <p class="text-muted">Status: <strong><?= $course['status'] ?></strong></p>
        <div class="card mb-3">
          <div class="card-body">
            <h2>Course Description</h2>
            <hr>
            <p><?= nl2br(htmlspecialchars($course['course_desc'])) ?></p>
          </div>
        </div>
 -->
        <!-- Optional: Mark progress -->

        <!-- <?php if ($course['status'] !== 'Completed'): ?>
            <form method="post" action="update_course_status.php">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                <button name="status" value="In Progress" class="btn btn-info">Mark as In Progress</button>
                <button name="status" value="Completed" class="btn btn-success">Mark as Completed</button>
            </form>
        <?php endif; ?> -->
        <hr>


        <!-- <a href="employee_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a> -->
      </div>
    </div>
  </div>



</body>

</html>