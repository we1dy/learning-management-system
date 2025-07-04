<?php require_once "../db.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$employee_id = $_SESSION['employee_id'];
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$query = "SELECT c.*, cc.course_category_name 
          FROM employee_courses ec
          INNER JOIN course c ON ec.course_id = c.course_id
          INNER JOIN course_category cc ON c.course_category_id = cc.course_category_id
          WHERE ec.employee_id = ? AND cc.course_category_id = 4";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$query1 = "SELECT COUNT(*) AS total_courses 
           FROM employee_courses ec
           INNER JOIN course c ON ec.course_id = c.course_id
           WHERE ec.employee_id = ? AND c.course_category_id = 4";

$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $employee_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$numCourses = $result1->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS | Development Program</title>
  <!-- Logo Icon -->
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">

  <!-- Aileron Font -->
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- CSS Custom -->
     <link rel="stylesheet" href="../assets/css/view_courses.css">
  <link rel="stylesheet" href="../assets/css/card_list.css">
  <link rel="stylesheet" href="../assets/css/top_nsidebar.css">
  <link rel="stylesheet" href="../assets/css/courses.css">
  <link rel="stylesheet" href="../assets/css/employee.css">
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">
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
              <h1 class="page-title">Development Program</h1>
              <span class="badge mandatory-badge">Mandatory Training</span>
            </div>
            <p class="text-muted mt-2">
              Complete these required courses to ensure compliance with banking regulations
            </p>
          </div>

         <!-- Course Description -->
          <div class="card mb-3 p-2">
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
                  <div class="stat-value text-primary"><?= htmlspecialchars($numCourses['total_courses']) ?></div>
                <div class="stat-label">Modules</div>
              </div>
              <div class="col-md-4">
                <div class="stat-value text-success">2.5h</div>
                <div class="stat-label">Duration</div>
              </div>
              <div class="col-md-4">
                <div class="stat-value text-purple">95%</div>
                <div class="stat-label">Pass Rate</div>
>>>>>>> bbc0b812c5269a573af50c6593a3a04ed9bcfa5a
              </div>
            </div>
          </div>
        </div>
        
        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-outline-primary me-2" id="toggleCard"><i class="fas fa-th-large"></i> Card View</button>
          <button class="btn btn-outline-secondary" id="toggleList"><i class="fas fa-list"></i> List View</button>
        </div>

         <!-- Course Grid -->
          <div id="cardView" class="row g-4">
            <?php if ($result->num_rows > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <div class="col-md-6 col-lg-4">
                <div class="course-card">
                  <div class="course-image"
                    style="background-image: url('<?= $row['course_image'] ?>'); background-size: cover; background-position: center; height: 200px;">
                  </div>
                  <div class="course-content p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <h5 class="course-title"><?= htmlspecialchars($row['course_name']) ?></h5>
                      <span class="badge bg-primary"><?= htmlspecialchars($row['course_category_name']) ?></span>
                    </div>
                    <p class="course-description"><?= htmlspecialchars($row['course_desc']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="course-duration">Duration: 2 hours</div>
                      <button class="btn btn-outline-primary start-course-btn"
                        data-url="view_course.php?course_id=<?= $row['course_id'] ?>"
                        data-name="<?= htmlspecialchars($row['course_name']) ?>">
                        Start Course <i class="fas fa-chevron-right ms-1"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              No assigned courses available in this category.
              </div>
            </div>
          <?php endif; ?>
            </div>
            
            <!-- List View -->
        <div id="listView" class="d-none">
          <?php if ($result->num_rows > 0): ?>
            <?php mysqli_data_seek($result, 0); // rewind for reuse ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <div
                class="list-course-item d-flex flex-column flex-md-row align-items-md-center justify-content-between p-3 mb-2 border rounded">
                <div class="flex-grow-1 me-md-3">
                  <h5 class="mb-1"><?= htmlspecialchars($row['course_name']) ?></h5>
                  <p class="mb-1 text-muted small"><?= htmlspecialchars($row['course_desc']) ?></p>
                  <span class="text-secondary small">Duration: 2 hours</span>
                </div>
                <div class="mt-2 mt-md-0 text-md-end">
                  <button class="btn btn-outline-primary btn-sm start-course-btn"
                    data-url="view_course.php?course_id=<?= $row['course_id'] ?>"
                    data-name="<?= htmlspecialchars($row['course_name']) ?>">
                    Start Course <i class="fas fa-play ms-1"></i>
                  </button>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              No assigned courses available in this category.
            </div>
          </div>
          <?php endif; ?>
        </div>


          <!-- Strategic Thinking -->
          <!-- <div class="col-md-6 col-lg-4">
            <div class="course-card">
              <div class="course-image bg-gradient-blue">
                <div class="course-icon">
                  <i class="fas fa-shield-alt"></i>
                </div>
              </div>
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="course-title">Strategic Thinking</h3>
                  <span class="badge required-badge">Required</span>
                </div>
                <p class="course-description">
                  Developing long-term business strategies
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="course-duration">Duration: 1.5 hours</div>
                  <button class="btn btn-link start-course-btn">
                    Start Course <i class="fas fa-chevron-right ms-1"></i>
                  </button>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Financial Analysis -->
          <!-- <div class="col-md-6 col-lg-4">
            <div class="course-card">
              <div class="course-image bg-gradient-purple">
                <div class="course-icon">
                  <i class="fas fa-lock"></i>
                </div>
              </div>
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="course-title">Financial Analysis</h3>
                  <span class="badge required-badge">Required</span>
                </div>
                <p class="course-description">
                  Advanced financial statement analysis
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="course-duration">Duration: 1 hour</div>
                  <button class="btn btn-link start-course-btn">
                    Start Course <i class="fas fa-chevron-right ms-1"></i>
                  </button>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Digital Transformation -->
          <!-- <div class="col-md-6 col-lg-4">
            <div class="course-card">
              <div class="course-image bg-gradient-green">
                <div class="course-icon">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="course-title">Leading digital initiatives in banking</h3>
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
          </div> -->

          <!-- Innovation Management -->
          <!-- <div class="col-md-6 col-lg-4">
            <div class="course-card">
              <div class="course-image bg-gradient-amber">
                <div class="course-icon">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
              </div>
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="course-title">Innovation Management</h3>
                  <span class="badge required-badge">Required</span>
                </div>
                <p class="course-description">
                  Fostering innovation in financial services
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="course-duration">Duration: 2 hours</div>
                  <button class="btn btn-link start-course-btn">
                    Start Course <i class="fas fa-chevron-right ms-1"></i>
                  </button>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Executive Presence -->
          <!-- <div class="col-md-6 col-lg-4">
            <div class="course-card">
              <div class="course-image bg-gradient-slate">
                <div class="course-icon">
                  <i class="fas fa-chart-pie"></i>
                </div>
              </div>
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="course-title">Executive Presence</h3>
                  <span class="badge required-badge">Required</span>
                </div>
                <p class="course-description">
                  Developing leadership gravitas
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
        </div> -->

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
        <?php include '../footer.php' ?>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<<<<<<< HEAD
=======

>>>>>>> bbc0b812c5269a573af50c6593a3a04ed9bcfa5a
  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const currentPath = window.location.pathname.split("/").pop();
      const dropdowns = document.querySelectorAll(".nav-dropdown");
      const startButtons = document.querySelectorAll('.start-course-btn');

      // Highlight nav
      dropdowns.forEach(dropdown => {
        const items = dropdown.querySelectorAll(".nav-dropdown-menu");
        items.forEach(item => {
          const href = item.getAttribute("href");
          if (href === currentPath) {
            item.classList.add("active");
            dropdown.classList.add("open");
          }
        });
      });

      // Start course buttons (card + list view)
      startButtons.forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();

          // Get course name directly from data attribute OR fallback to DOM
          const courseName = this.getAttribute('data-name') ||
            this.closest('.course-card, .list-course-item')?.querySelector('.course-title')?.textContent?.trim() ||
            'this course';
          const courseURL = this.getAttribute('data-url');

          Swal.fire({
            title: 'Start Course',
            text: `Are you ready to begin "${courseName}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, start it!',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = courseURL;
            }
          });
        });
      });
    });


  </script>

  <script>

    document.getElementById('toggleCard').addEventListener('click', function () {
      document.getElementById('cardView').classList.remove('d-none');
      document.getElementById('listView').classList.add('d-none');
    });

    document.getElementById('toggleList').addEventListener('click', function () {
      document.getElementById('listView').classList.remove('d-none');
      document.getElementById('cardView').classList.add('d-none');
    });
  </script>



  <!-- Custom JS -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>
</body>

</html>