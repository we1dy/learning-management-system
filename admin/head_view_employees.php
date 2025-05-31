<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head Portal</title>
    <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
    <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/head_dashboard.css">
</head>

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

                    <h1>View Enrolled Employee</h1>


                    <div class="table-responsive w-100">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Number</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <!-- <th>Department</th>
                                    <th>Position</th> -->
                                    <th>Username</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="employeeTableBody">
                                <tr>
                                    <td colspan="9" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Optional: Empty state -->
                        <div class="empty-state text-center" style="display: none;">
                            <div class="empty-state-icon mb-2">
                                <i class="far fa-user-slash fa-2x"></i>
                            </div>
                            <h5>No employee records found</h5>
                        </div>
                    </div>



                </div>

            </main>

        </div>
    </div>
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

    <script>
        fetch('fetch_all_employees.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('employeeTableBody');
                const emptyState = document.querySelector('.empty-state');

                if (data.length > 0) {
                    tbody.innerHTML = ''; // Clear loading row
                    data.forEach((emp, index) => {
                        tbody.innerHTML += `
            <tr>
              <td>${index + 1}</td>
              <td>${emp.employee_num}</td>
              <td>${emp.last_name}</td>
              <td>${emp.first_name}</td>
              <td>${emp.email}</td>
              <td>${emp.username}</td>
              <td>
                <span class="badge ${emp.account_status === 'Active' ? 'bg-success' : 'bg-danger'}">
                  ${emp.account_status}
                </span>
              </td>
            </tr>
          `;
                    });
                    emptyState.style.display = "none";
                } else {
                    tbody.innerHTML = "";
                    emptyState.style.display = "block";
                }
            })
            .catch(err => {
                console.error("Failed to fetch employee list:", err);
                document.getElementById('employeeTableBody').innerHTML =
                    "<tr><td colspan='9' class='text-center text-danger'>Error loading employee data</td></tr>";
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
    <script src="assets/js/script.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>

</html>