<?php
include '../db.php';

// Fetch dropdown options
$divisions = mysqli_query($conn, "SELECT * FROM division");
$segments = mysqli_query($conn, "SELECT * FROM segment");
$groups = mysqli_query($conn, "SELECT * FROM `group`");

// Fetch dropdown options for modal
$groupResult = mysqli_query($conn, "SELECT group_id, group_name FROM `group`");
$segmentResult = mysqli_query($conn, "SELECT segment_id, segment_name FROM segment");
$divisionResult = mysqli_query($conn, "SELECT division_id, division_name FROM division");

// Fetch employees with their related data
$employees_query = "
   SELECT 
        e.user_id,
        e.employee_num,
     CONCAT(e.first_name, ' ', e.last_name) AS full_name,

        ua.username,
        e.email,
        ut.user_type as user_type,
        ua.account_status as status,
        s.segment_name as segment,
        g.group_name as `group`,
        d.division_name as division
    FROM employee e
    LEFT JOIN user_account ua ON e.user_id = ua.user_id
    LEFT JOIN user_type ut ON ua.user_type_id = ut.user_type_id
    LEFT JOIN segment s ON e.segment_id = s.segment_id
    LEFT JOIN `group` g ON e.group_id = g.group_id
    LEFT JOIN division d ON e.division_id = d.division_id
    ORDER BY ua.username ASC
";
$employees = mysqli_query($conn, $employees_query);


$latest = mysqli_query($conn, "SELECT employee_num FROM employee ORDER BY employee_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($latest);

if ($row) {
    // Remove prefix and increment number
    $lastNum = intval(substr($row['employee_num'], 3)); // Remove "EMP"
    $newNum = $lastNum + 1;
    $employeeNum = "EMP" . str_pad($newNum, 4, "0", STR_PAD_LEFT); // e.g., EMP0001
} else {
    $employeeNum = "EMP0001"; // First record
}

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1>Employee List</h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addEmployeeModal">
                            <i class="bi bi-plus-circle me-2"></i>Add New Employee
                        </button>
                    </div>

                    <div class="container mt-4">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="segment_filter">Segment:</label>
                                <select id="segment_filter" class="form-select">
                                    <option value="">All Segments</option>
                                    <?php
                                    mysqli_data_seek($segments, 0); // Reset pointer
                                    while ($row = mysqli_fetch_assoc($segments)): ?>
                                        <option value="<?= htmlspecialchars($row['segment_name']) ?>">
                                            <?= htmlspecialchars($row['segment_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="group_filter">Group:</label>
                                <select id="group_filter" class="form-select">
                                    <option value="">All Groups</option>
                                    <?php
                                    mysqli_data_seek($groups, 0); // Reset pointer
                                    while ($row = mysqli_fetch_assoc($groups)): ?>
                                        <option value="<?= htmlspecialchars($row['group_name']) ?>">
                                            <?= htmlspecialchars($row['group_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="division_filter">Division:</label>
                                <select id="division_filter" class="form-select">
                                    <option value="">All Divisions</option>
                                    <?php
                                    mysqli_data_seek($divisions, 0); // Reset pointer
                                    while ($row = mysqli_fetch_assoc($divisions)): ?>
                                        <option value="<?= htmlspecialchars($row['division_name']) ?>">
                                            <?= htmlspecialchars($row['division_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    
                        <table id="employeeTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Num</th>
                                    <th>Name</th>
                                    <th>NT Username</th>
                                    <th>Email</th>
                                    <th>Segment</th>
                                    <th>Group</th>
                                    <th>Division</th>
                                    <th>User Type</th>
                                    <th>Account Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($employees)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['employee_num']) ?></td>
                                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['segment']) ?></td>
                                        <td><?= htmlspecialchars($row['group']) ?></td>
                                        <td><?= htmlspecialchars($row['division']) ?></td>
                                        <td><?= htmlspecialchars($row['user_type']) ?></td>
                                        <td>
                                            <span class="badge <?php
                                            if ($row['status'] === 'Active') {
                                                echo 'bg-success';
                                            } elseif ($row['status'] === 'Inactive') {
                                                echo 'bg-secondary';
                                            } elseif ($row['status'] === 'Suspended') {
                                                echo 'bg-warning';
                                            } else {
                                                echo 'bg-danger';
                                            }
                                            ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </span>
                                        </td>
                                        <td><a href="edit_employee.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    
                    <!-- Add Employee Modal -->
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
                                        <div class="mb-3 col-md-3">
                                            <label for="employeeNum" class="form-label">Employee #:</label>
                                            <input type="text" class="form-control" id="employeeNum" name="employee_num"
                                                value="<?= $employeeNum ?>" disabled>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="firstName" class="form-label">First Name:</label>
                                            <input type="text" class="form-control" id="firstName" name="first_name"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="middleInitial" class="form-label">Middle Initial:</label>
                                            <input type="text" class="form-control" id="middleInitial"
                                                name="middle_initial" required>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="lastName" class="form-label">Last Name:</label>
                                            <input type="text" class="form-control" id="lastName" name="last_name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="username" class="form-label">Username:</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="mb-3 col-md-4">
                                            <label for="group" class="form-label">Group</label>
                                            <select class="form-select" id="group" name="group_id" required>
                                                <option value="" selected disabled>Select Group</option>
                                                <?php while ($row = mysqli_fetch_assoc($groupResult)) {
                                                    echo "<option value='{$row['group_id']}'>{$row['group_name']}</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="segment" class="form-label">Segment</label>
                                            <select class="form-select" id="segment" name="segment_id" required>
                                                <option value="" selected disabled>Select Segment</option>
                                                <?php while ($row = mysqli_fetch_assoc($segmentResult)) {
                                                    echo "<option value='{$row['segment_id']}'>{$row['segment_name']}</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="division" class="form-label">Division</label>
                                            <select class="form-select" id="division" name="division_id" required>
                                                <option value="" selected disabled>Select Division</option>
                                                <?php while ($row = mysqli_fetch_assoc($divisionResult)) {
                                                    echo "<option value='{$row['division_id']}'>{$row['division_name']}</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="user_type" class="form-label">User Type:</label>
                                            <select name="user_type" class="form-select" required>
                                                <option value="" selected disabled>Select User Type</option>
                                                <option value="Employee">Employee</option>
                                                <option value="Head">Head</option>
                                                <option value="Super Admin">Super Admin</option>

                                            </select>
                                        </div>
                                    </div>
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

    <!-- jQuery (full version needed for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert 2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#employeeTable').DataTable({
                "pageLength": 25,
                "responsive": true
            });

            // Custom filtering function
            function filterTable() {
                var segment = $('#segment_filter').val();
                var group = $('#group_filter').val();
                var division = $('#division_filter').val();

                // Clear previous search
                table.search('').columns().search('').draw();

                // Apply filters - Updated column indices for new table structure
                if (segment) {
                    table.column(3).search('^' + segment + '$', true, false);
                }
                if (group) {
                    table.column(4).search('^' + group + '$', true, false);
                }
                if (division) {
                    table.column(5).search('^' + division + '$', true, false);
                }

                table.draw();
            }

            // Bind filter events
            $('#segment_filter, #group_filter, #division_filter').on('change', filterTable);
        });

        // Add Employee Form Submit
        document.getElementById('addEmployeeForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('process_add_employee.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "duplicate") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicate Entry',
                            text: data.message
                        });
                    } else if (data.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Employee Added',
                            text: 'New employee successfully registered!'
                        }).then(() => location.reload());
                    } else {
                        console.error(data); // Debug output
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An unexpected error occurred.'
                        });
                    }

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to process request.'
                    });
                });
        });

        // Navigation dropdown active state
        document.addEventListener("DOMContentLoaded", function () {
            const currentPath = window.location.pathname.split("/").pop();
            const dropdowns = document.querySelectorAll(".nav-dropdown");

            dropdowns.forEach(dropdown => {
                const items = dropdown.querySelectorAll(".nav-dropdown-item");

                items.forEach(item => {
                    const href = item.getAttribute("href");

                    if (href === currentPath) {
                        item.classList.add("active");
                        dropdown.classList.add("open");
                    }
                });
            });
        });
    </script>

    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/sidebar.js"></script>
</body>

</html>