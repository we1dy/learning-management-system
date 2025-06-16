<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
  // Not logged in
  header("Location: login.php");
  exit();
}

$employee_id = $_SESSION['employee_id']; // Use the correct key

$query = "
    SELECT e.employee_num, 
    CONCAT(e.first_name, '  ', e.middle_initial, '  ', e.last_name) AS employee_name, 
    e.email, e.birthdate, e.profile_image,
           CONCAT_WS(' - ', g.group_name, s.segment_name, d.division_name) AS department
    
    FROM employee e
    LEFT JOIN `group` g ON e.group_id = g.group_id
    LEFT JOIN segment s ON e.segment_id = s.segment_id
    LEFT JOIN division d ON e.division_id = d.division_id
    LEFT JOIN user_account ua ON ua.user_id = e.user_id
    WHERE e.employee_id = ?
";


$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id); // bind employee_id instead of user_id
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $employee = $result->fetch_assoc();
} else {
  echo "Employee not found.";
  exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id']; // use this for user_log

// Query first and last access
$logQuery = "
  SELECT 
    MIN(login_date) AS first_access, 
    MAX(login_date) AS last_access 
  FROM user_log 
  WHERE user_id = ?
";
$stmt = $conn->prepare($logQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$logResult = $stmt->get_result();
$logRow = $logResult->fetch_assoc();

// Format dates (if they exist)
$first_access = $logRow['first_access'] ? date("l, j F Y, g:i A", strtotime($logRow['first_access'])) : 'N/A';
$last_access = $logRow['last_access'] ? date("l, j F Y, g:i A", strtotime($logRow['last_access'])) : 'N/A';



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">
  <title>PBCOM LMS | Profile</title>
  <!-- Aileron Font -->

  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- CSS Custom -->
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="stylesheet" href="../assets/css/employee_profile.css">
  <style>

  </style>
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
          &nbsp;
          &nbsp;
          &nbsp;
          <h1 class="mb-3">Profile</h1>
          <div class="my-4"></div>

          <!-- Profile Display -->
          <div class="profile-header mb-4">
            <div class="image-wrapper">
              <?php
              $profile_img = $employee['profile_image'] ? "../" . $employee['profile_image'] : "../assets/images/profile_icon.png";
              ?>
              <img src="<?= htmlspecialchars($profile_img) ?>" alt="Profile Image" class="avatar img-fluid">

            </div>
            <div>
              <div class="profile-title"><?= htmlspecialchars($employee['employee_name']) ?></div>
              <!-- <div class="profile-role">Chief Information Officer</div> -->
            </div>
          </div>


          <div class="row g-4">
            <!-- Personal Information -->
            <div class="col-md-4">
              <div class="info-box">
                <h5>Personal Information</h5>
                <ul class="list-unstyled">
                  <li><strong>Email Address:</strong> <?= htmlspecialchars($employee['email']) ?></li>
                  <li><strong>Employee Number:</strong> <?= htmlspecialchars($employee['employee_num']) ?></li>
                  <li><strong>Birthdate:</strong> <?= htmlspecialchars($employee['birthdate']) ?></li>
                  <!-- <li><strong>Country:</strong> Philippines</li>
                                                                                                                                                                                                                                                                                                                                    <li><strong>City/Town:</strong> Makati City</li> -->
                </ul>
              </div>
            </div>

            <!-- Course Details -->
            <div class="col-md-4">
              <div class="info-box">
                <h5>Course Details</h5>
                <ul>
                  <li>Financial Consumer Protection</li>
                  <li>Customer Protection</li>
                  <li>Anti-Money Laundering</li>
                  <li>Workplace Policies</li>
                  <li>Leadership Fundamentals</li>
                  <li>Time Management</li>
                  <li>Core Banking System</li>
                  <li>Data Analytics Tools</li>
                </ul>
              </div>
            </div>

            <!-- Login Activity -->
            <div class="col-md-4">
              <div class="info-box">
                <h5>Login Activity</h5>
                <ul class="list-unstyled">
                  <li><strong>First access to site:</strong><br><?= htmlspecialchars($first_access) ?></li>
                  <li class="mt-2"><strong>Last access to site:</strong><br><?= htmlspecialchars($last_access) ?></li>

                </ul>
              </div>
            </div>
          </div>
        </div>
        &nbsp;
        &nbsp;
        &nbsp;
        <!-- Footer -->
        <?php include '../footer.php' ?>
      </main>
    </div>
  </div>

  <!-- SweetAlert 2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/sidebar.js"></script>
</body>

</html>