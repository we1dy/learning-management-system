<?php
include '../db.php';

// Fetch dropdown options
$divisions = mysqli_query($conn, "SELECT * FROM division");
$segments = mysqli_query($conn, "SELECT * FROM segment");
$groups = mysqli_query($conn, "SELECT * FROM `group`");

// Fetch employees with their related data
$employees_query = "
   SELECT 
        e.user_id,
          e.employee_num,
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

                    <h1>Employee List</h1>

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
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['segment']) ?></td>
                                        <td><?= htmlspecialchars($row['group']) ?></td>
                                        <td><?= htmlspecialchars($row['division']) ?></td>
                                        <td><?= htmlspecialchars($row['user_type']) ?></td>
                                        <td>
                                            <span
                                                class="badge 
                                                                                                                                                                                                                                <?php
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
                                        <td><a href="edit.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
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

                // Apply filters
                if (segment) {
                    table.column(2).search('^' + segment + '$', true, false);
                }
                if (group) {
                    table.column(3).search('^' + group + '$', true, false);
                }
                if (division) {
                    table.column(4).search('^' + division + '$', true, false);
                }

                table.draw();
            }

            // Bind filter events
            $('#segment_filter, #group_filter, #division_filter').on('change', filterTable);
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