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
              <img src="../assets/images/profile_icon.png" alt="Profile Image" class="avatar img-fluid">
            </div>
            <div>
              <div class="profile-title">LADY CHRISTINE ABOLEDA</div>
              <div class="profile-role">Chief Information Officer</div>
            </div>
          </div>


          <div class="row g-4">
            <!-- Personal Information -->
            <div class="col-md-4">
              <div class="info-box">
                <h5>Personal Information</h5>
                <ul class="list-unstyled">
                  <li><strong>Email Address:</strong> ladyarboleda26@gmail.com</li>
                  <li><strong>Employee Number:</strong> A1274929302</li>
                  <li><strong>Birthdate:</strong> 12/26/2003</li>
                  <li><strong>Country:</strong> Philippines</li>
                  <li><strong>City/Town:</strong> Makati City</li>
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
                  <li><strong>First access to site:</strong><br>Monday, 22 August 2022, 6:05 AM</li>
                  <li class="mt-2"><strong>Last access to site:</strong><br>Sunday, 1 June 2025, 9:20 PM</li>
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
<<<<<<< HEAD
</body>

</html>
=======
</body>
>>>>>>> bbc0b812c5269a573af50c6593a3a04ed9bcfa5a
