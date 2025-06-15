<?php require_once "../db.php"; ?>
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
  <link rel="stylesheet" href="../assets/css/top_nsidebar.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
  <div class="wrapper">
    <?php include 'topbar.php' ?>

    <div class="content-wrapper">
      <!-- Sidebar -->
      <?php include 'sidebar.php' ?>


      <div class="main-content">

        <div class="container-fluid">
          <!-- Mobile Search -->
          <div class="mobile-search d-md-none mb-3">
            <div class="position-relative">
              <i class="bi bi-search search-icon"></i>
              <input type="text" class="form-control" placeholder="Search...">
            </div>
          </div>


          <h1>Announcements</h1>

          <section class="mb-5">

            <div class="d-flex justify-content-between align-items-center mb-3">

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
                    <div class=" card-body">
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
        </div>
      </div>
    </div>
  </div>
</body>

</html>