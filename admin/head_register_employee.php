<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

                    <h1 class="mb-4">Register Employees</h1>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addEmployeeModal">
                        <i class="bi bi-plus-circle me-2"></i>Add New Employee
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="addEmployeeForm" action="process_add_employee.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEmployeeModalLabel">Register New Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-3">
                                        <div class="mb-3 col-md-2">
                                            <label for="employeeNumber" class="form-label">Employee #:</label>
                                            <input type="text" class="form-control" id="employeeNumber" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="first_name" class="form-label">First Name:</label>
                                            <input type="text" class="form-control" id="employeeName" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeName" class="form-label">Middle Initial:</label>
                                            <input type="text" class="form-control" id="employeeName" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeName" class="form-label">Last Name:</label>
                                            <input type="text" class="form-control" id="employeeName" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeEmail" class="form-label">Email:</label>
                                            <input type="email" class="form-control" id="employeeEmail" name="email"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="employeeName" class="form-label">Username:</label>
                                            <input type="text" class="form-control" id="employeeName" name="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">

                                        <div class="mb-3 col-md-3">
                                            <label for="employeePosition" class="form-label">Segment:</label>
                                            <input type="text" class="form-control" id="employeePosition"
                                                name="position">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeGroup" class="form-label">Group:</label>
                                            <input type="text" class="form-control" id="employeePosition"
                                                name="position">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeDivision" class="form-label">Division:</label>
                                            <input type="text" class="form-control" id="employeePosition"
                                                name="position">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="user_type" class="form-label">User Type:</label>
                                            <select name="user_type" id="userType" class="form-select" required>
                                                <option value="Employee">Employee</option>
                                                <option value="Head">Head</option>
                                                <option value="Employee">sample</option>

                                            </select>
                                        </div>

                                    </div>
                                    <!-- <div class="mb-3">
                                        <label for="assignedCourses" class="form-label">Assign Courses</label>
                                        <select name="courses[]" id="assignedCourses" class="form-select" multiple required>
                                            <option value="1">Introduction to Company</option>
                                            <option value="2">Safety Training</option>
                                            <option value="3">Technical Skills</option>
                                            <option value="4">Customer Service</option>
                                            <option value="5">Leadership Development</option>
                                        </select>
                                        <small class="text-muted">Hold Ctrl (Windows) / Cmd (Mac) to select multiple</small>
                                    </div> -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Register Employee</button>
                                </div>
                            </div>
                        </form>
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
        document.getElementById("addEmployeeForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const name = document.getElementById("employeeName").value;
            const email = document.getElementById("employeeEmail").value;
            const role = document.getElementById("employeeRole").value;
            const courses = Array.from(document.getElementById("assignedCourses").selectedOptions).map(option => option.value);

            console.log("Adding employee:", { name, email, role, courses });

            // TODO: Send via AJAX or form submission to backend PHP

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addEmployeeModal'));
            modal.hide();

            // Optional: Show success alert
            Swal.fire("Success!", "Employee has been added.", "success");
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>


    <!-- SweetAlert 2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/sidebar.js"></script>
</body>

</html>