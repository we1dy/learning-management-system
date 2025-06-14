<?php require_once "../db.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$employee_id = $_SESSION['employee_id'];
// var_dump($_SESSION);
// $stmt = $conn->prepare("
//   SELECT c.*, ec.last_accessed, ec.status
//   FROM employee_courses ec
//   JOIN course c ON c.course_id = ec.course_id
//   WHERE ec.employee_id = ?
//   ORDER BY ec.last_accessed DESC
//   LIMIT 3
//   ");
// $stmt->bind_param("i", $employee_id);
// $stmt->execute();
// $history_result = $stmt->get_result();

// Query to get course data with category
$query = "SELECT c.*, cc.course_category_name 
          FROM course c 
          INNER JOIN course_category cc ON c.course_category_id = cc.course_category_id
          WHERE cc.course_category_id= 1";
$result = mysqli_query($conn, $query);
$query1 = "SELECT COUNT(*) AS total_courses 
          FROM course 
          WHERE course_category_id = 3";
$result1 = mysqli_query($conn, $query1);
$numCourses = mysqli_fetch_assoc($result1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM | Regulatory Courses</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Logo icon-->
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Custom CSS -->
     <link rel="stylesheet" href="../assets/css/view_courses.css">
  <link rel="stylesheet" href="../assets/css/card_list.css">
  <link rel="stylesheet" href="../assets/css/courses.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">

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
              <h1 class="page-title">Regulatory Courses</h1>
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
        </div>
        <div id="listView" class="d-none">
  <?php mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)): ?>
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
        </div>

            <!-- Anti-Money Laundering -->
            <!-- <div class="col-md-6 col-lg-4">
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
                      Start Course <i class="fas fa-chevron-right ms-1" data-url="anti_money.php?course=aml"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

             Bank Contiinuity Management 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-blue">
                  <div class="course-icon">
                    <i class="fas fa-shield-alt"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Bank Continuity Management</h3>
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

             Information Security Awareness 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-purple">
                  <div class="course-icon">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Information Security Awareness</h3>
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

             Customer Protection 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-green">
                  <div class="course-icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Customer Protection</h3>
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

             Data Privacy Act 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-amber">
                  <div class="course-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Data Privacy Act</h3>
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

             PBCOM Onboarding for New Employee 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-slate">
                  <div class="course-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">PBCOM Onboarding for New Employee</h3>
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

            Information Security Awareness 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-purple">
                  <div class="course-icon">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Information Security Awareness</h3>
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

             Social Media Risk Management Framework 
            <div class="col-md-6 col-lg-4">
              <div class="course-card">
                <div class="course-image bg-gradient-slate">
                  <div class="course-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                </div>
                <div class="course-content">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3 class="course-title">Social Media Risk Management Framework</h3>
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

  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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



  <!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
      

      
    });
  </script> -->

  <!-- Custom JavaScript -->


  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>

</body>

</html>