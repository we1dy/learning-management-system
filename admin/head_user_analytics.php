<?php
require_once "../db.php";
// Example: Total employees
$result = $conn->query("SELECT COUNT(*) AS total FROM employee");
$row = $result->fetch_assoc();
$totalEmployees = $row['total'];


// Completion stats
$result = $conn->query("SELECT 
  COUNT(*) AS total, 
  SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed,
  SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) AS inprogress
FROM employee_courses");
$stats = $result->fetch_assoc();


// Monthly completions
$monthly = [];
$months = [];
$monthlyCounts = [];

$result = $conn->query("SELECT 
  MONTHNAME(completed_at) AS month, 
  COUNT(*) AS count
FROM employee_courses
WHERE status = 'Completed' AND completed_at IS NOT NULL
GROUP BY MONTH(completed_at)
ORDER BY MONTH(completed_at)");

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $monthlyCounts[] = $row['count'];
}


// Convert to arrays for JS
$months = array_column($monthly, 'month');
$monthlyCounts = array_column($monthly, 'count');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBCOM Learning</title>
    <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
    <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/head_dashboard.css">
</head>
<style>
    .block {
        background: url("../images/pixel-60fff.png") repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
        border: 1px solid #ccc;
        background: white;
        margin: 1em 0em;
        border-top: none;
        -webkit-box-shadow: 2px 2px 5px rgba(0, 0, 6, 0.75);
        -moz-box-shadow: 2px 2px 5px rgba(0, 0, 6, 0.75);
        box-shadow: 2px 2px 5px rgba(0, 0, 6, 0.75);
    }

    .block-content {
        margin: 1em;
        min-height: .25em;
    }
</style>

<body>

    <div class="wrapper">
        <!-- Header -->
        <?php include 'topbar.php' ?>

        <div class="content-wrapper">
            <!-- Sidebar -->
            <?php include 'head_sidebar.php' ?>

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

                    <h1>User Data Analytics</h1>

                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">




                                <!-- <div>
                                    <p class="text-muted mb-1">Completed Courses</p>
                                    <div id="completed_courses_card">
                                        <h3 class="mb-0">Loading...</h3>
                                    </div>
                                </div>
                                <div class="stat-icon bg-success-light text-success">
                                    <i class="bi bi-award"></i>
                                </div>
                            </div> -->
                            </div>
                        </div>
                        <div class="card">Total Employees: <?= $totalEmployees ?></div>
                        <div class="card">Courses Completed: <?= $stats['completed'] ?></div>
                        <div class="card">In Progress: <?= $stats['inprogress'] ?></div>
                    
                       
                    </div>

            </main>

        </div>
    </div>
    <canvas id="courseCompletionChart"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = <?= json_encode($months) ?>;
        const counts = <?= json_encode($monthlyCounts) ?>;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Courses Completed',
                    data: <?= json_encode($monthlyCounts) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const currentPath = window.location.pathname.split("/").pop(); // get current filename
            const dropdowns = document.querySelectorAll(".nav-dropdown");

            dropdowns.forEach(dropdown => {
                const items = dropdown.querySelectorAll(".nav-dropdown-item");

                items.forEach(item => {
                    const href = item.getAttribute("href");

                    if (href === currentPath) {
                        item.classList.add("active");                 // highlight item
                        dropdown.classList.add("open");               // keep dropdown open
                    }
                });
            });
        });
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