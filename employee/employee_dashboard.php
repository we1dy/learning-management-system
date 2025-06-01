<?php require_once "../db.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$employee_id = $_SESSION['employee_id'];
// var_dump($_SESSION);
$stmt = $conn->prepare("
  SELECT c.*, ec.last_accessed, ec.status
  FROM employee_courses ec
  JOIN course c ON c.course_id = ec.course_id
  WHERE ec.employee_id = ?
  ORDER BY ec.last_accessed DESC
  LIMIT 3
  ");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$history_result = $stmt->get_result();



// Get completed courses
$completed_stmt = $conn->prepare("
  SELECT c.*, ec.completed_at, ec.status
  FROM employee_courses ec
  JOIN course c ON c.course_id = ec.course_id
  WHERE ec.employee_id = ? AND ec.status = 'completed'
  ORDER BY ec.completed_at DESC
  ");

$completed_stmt->bind_param("i", $employee_id);
$completed_stmt->execute();
$completed_result = $completed_stmt->get_result();



// In Progress courses query (prepared)
$in_progress_stmt = $conn->prepare("
  SELECT c.*, ec.status, ec.due_date, ec.last_accessed
  FROM employee_courses ec
  JOIN course c ON c.course_id = ec.course_id
  WHERE ec.employee_id = ? AND ec.status = 'In Progress'
  ORDER BY ec.last_accessed DESC
  ");
$in_progress_stmt->bind_param("i", $employee_id);
$in_progress_stmt->execute();
$in_progress_result = $in_progress_stmt->get_result();



$statusClass = [
  "Assigned" => "warning",
  "In Progress" => "primary",
  "Completed" => "success"
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Dashboard</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="icon" type="image/x-icon" href="assets/images/pbcom.jpg">
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

          <!-- History Section -->
          <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">HISTORY</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <?php while ($row = mysqli_fetch_assoc($history_result)): ?>
                <div class="col-md-4 mb-3">
                  <div class="card course-card">
                    <div class="course-image">
                      <img src="<?php echo htmlspecialchars($row['course_image'] ?? 'images/placeholder.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($row['course_name']); ?>"
                        style="width: 100%; height: 150px; object-fit: cover;">
                      <span class="badge bg-<?= $statusClass[$row['status']] ?>"><?= $row['status'] ?></span>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <?php echo htmlspecialchars($row['course_name']); ?>
                      </h5>
                      <p class="card-text text-muted">Last accessed on
                        <?php echo date('m/d/Y', strtotime($row['last_accessed'])); ?>
                      </p>
                      <div class="progress mt-2">
                        <div class="progress-bar bg-danger" style="width: 100%"></div>
                      </div>
                      <br>
                      <a href="view_course.php?course_id=<?= $row['course_id'] ?>" class="btn btn-primary">Go to
                        Course</a>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </section>

          <!-- Course Card 2 -->

          <!-- Course Card 3 -->
          <!-- <div class="col-md-4 mb-3">
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
                </div> -->
          <!-- </div>
          </section> -->

          <!-- Completed Section -->
          <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">COMPLETED</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <!-- Course Card A -->
              <?php while ($row = mysqli_fetch_assoc($completed_result)): ?>
                <div class="col-md-4 mb-3">
                  <div class="card course-card">
                    <div class="course-image">
                      <img src="<?php echo htmlspecialchars($row['course_image'] ?? 'images/placeholder.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($row['course_name']); ?>"
                        style="width: 100%; height: 150px; object-fit: cover;">
                      <span class="badge bg-<?= $statusClass[$row['status']] ?>"><?= $row['status'] ?></span>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
                      <p class="card-text text-muted">Completed on
                        <?php echo date('m/d/Y', strtotime($row['completed_at'])); ?>
                      </p>
                      <div class="progress mt-2">
                        <div class="progress-bar bg-danger" style="width: 100%"></div>
                      </div>
                      <br>
                      <a href="view_course.php?course_id=<?= $row['course_id'] ?>" class="btn btn-primary">Go to
                        Course</a>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
              <!-- Course Card B -->
              <!-- <div class="col-md-4 mb-3">
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
              </div> -->
              <!-- Course Card C -->


            </div>
          </section>

          <!-- Ongoing Section -->
          <section>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="section-title">ONGOING</h2>
              <button class="btn btn-outline-secondary btn-sm">View All</button>
            </div>
            <div class="row">
              <?php if ($in_progress_result->num_rows > 0): ?>
                <?php while ($row = $in_progress_result->fetch_assoc()): ?>
                  <div class="col-md-4 mb-3">
                    <div class="card course-card">
                      <div class="course-image">
                        <img src="<?php echo htmlspecialchars($row['course_image'] ?? 'images/placeholder.jpg'); ?>"
                          alt="<?php echo htmlspecialchars($row['course_name']); ?>"
                          style="width: 100%; height: 150px; object-fit: cover;">
                        <span class="badge bg-<?= $statusClass[$row['status']] ?>"><?= $row['status'] ?></span>
                      </div>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['course_name']); ?></h5>
                        <p class="card-text text-muted">Due
                          <?php echo !empty($row['due_date']) ? date("m/d/Y", strtotime($row['due_date'])) : 'No due date'; ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                          <small class="text-muted">
                            <?php echo isset($row['progress']) ? htmlspecialchars($row['progress']) . '% Complete' : 'Ongoing'; ?>
                          </small>
                          <br>
                          <a href="view_course.php?course_id=<?= $row['course_id'] ?>" class="btn btn-primary">Go to
                            Course</a>
                        </div>
                        <?php if (isset($row['progress'])): ?>
                          <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar"
                              style="width: <?php echo (int) $row['progress']; ?>%"
                              aria-valuenow="<?php echo (int) $row['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                            </div>

                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              <?php else: ?>
                <div class="col-12">
                  <p class="text-muted">No ongoing courses at the moment.</p>
                </div>
              <?php endif; ?>
            </div>
          </section>

        </div>
      </main>
    </div>
  </div>

  <script>
    function fetchCourses() {
      fetch('fetch_courses.php')
        .then(response => response.json())
        .then(data => {
          const card = document.getElementById("completed_courses_card");
          card.innerHTML = `<h3 class="mb-0">${data.completed_count}</h3>`;
        })
        .catch(err => console.error("Failed to fetch completed course count:", err));

    }
    fetch('fetch_inprogress_courses.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById("in_progress_courses_card").innerHTML =
          `<h3 class="mb-0">${data.in_progress_count}</h3>`;
      })
      .catch(err => console.error("Failed to fetch in-progress course count:", err));


    fetch('fetch_completion_rate.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById("completion_rate_card").innerHTML =
          `<h3 class="mb-0">${data.completion_rate}%</h3>`;
      })
      .catch(err => console.error("Failed to fetch completion rate:", err));


    // You should call this on page load or where appropriate
    fetchCourses();


    function formatDate(dateStr) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateStr).toLocaleDateString(undefined, options);
    }


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