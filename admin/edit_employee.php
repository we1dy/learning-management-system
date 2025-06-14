<?php
// Database connection
include '../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "
        SELECT 
            e.user_id,
            e.employee_num,
            ua.username,
            e.email,
            ut.user_type_id,
            ut.user_type as user_type,
            ua.account_status as status,
            ua.user_type_id,
            s.segment_id,
            s.segment_name,
            g.group_id,
            g.group_name,
            d.division_id,
            d.division_name
        FROM employee e
        LEFT JOIN user_account ua ON e.user_id = ua.user_id
        LEFT JOIN user_type ut ON ua.user_type_id = ut.user_type_id
        LEFT JOIN segment s ON e.segment_id = s.segment_id
        LEFT JOIN `group` g ON e.group_id = g.group_id
        LEFT JOIN division d ON e.division_id = d.division_id
        WHERE e.user_id = $id
        LIMIT 1
    ";
    $result = mysqli_query($conn, $query);
    $employee = mysqli_fetch_assoc($result);
}

$segments = mysqli_query($conn, "SELECT * FROM segment");
$groups = mysqli_query($conn, "SELECT * FROM `group`");
$divisions = mysqli_query($conn, "SELECT * FROM division");
$user_types = mysqli_query($conn, "SELECT * FROM user_type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_num = $_POST['employee_num'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $segment_id = $_POST['segment_id'];
    $group_id = $_POST['group_id'];
    $division_id = $_POST['division_id'];
    $user_type_id = $_POST['user_type_id'];
    $status = $_POST['status'];

    // Update employee table
    $update_employee = "
        UPDATE employee SET 
            employee_num = '$employee_num',
            email = '$email',
            segment_id = $segment_id,
            group_id = $group_id,
            division_id = $division_id
        WHERE user_id = $id
    ";

    // Update user_account table
    $update_user = "
        UPDATE user_account SET 
            username = '$username',
            user_type_id = $user_type_id,
            account_status = '$status'
        WHERE user_id = $id
    ";

    if (mysqli_query($conn, $update_employee) && mysqli_query($conn, $update_user)) {
        echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Updated</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Employee Updated',
                text: 'The employee information has been successfully updated.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'head_register_employee.php';
            });
        };
    </script>
    </body>
    </html>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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

                    <h1>Edit Employee</h1>
                    <form method="post" class="p-4 border rounded shadow bg-white">
                        <!-- Personal Information -->
                        <h5 class="fw-semibold border-bottom pb-2 mb-4">Personal Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee Number</label>
                                <input type="text" class="form-control" name="employee_num"
                                    value="<?= htmlspecialchars($employee['employee_num']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username"
                                    value="<?= htmlspecialchars($employee['username']) ?>" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($employee['email']) ?>" required>
                        </div>

                        <!-- Department Info -->
                        <h5 class="fw-semibold border-bottom pb-2 mb-4">Department Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Segment</label>
                                <select class="form-select" name="segment_id" required>
                                    <?php while ($row = mysqli_fetch_assoc($segments)): ?>
                                        <option value="<?= $row['segment_id'] ?>"
                                            <?= $row['segment_id'] == $employee['segment_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['segment_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Group</label>
                                <select class="form-select" name="group_id" required>
                                    <?php while ($row = mysqli_fetch_assoc($groups)): ?>
                                        <option value="<?= $row['group_id'] ?>" <?= $row['group_id'] == $employee['group_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['group_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Division</label>
                                <select class="form-select" name="division_id" required>
                                    <?php while ($row = mysqli_fetch_assoc($divisions)): ?>
                                        <option value="<?= $row['division_id'] ?>"
                                            <?= $row['division_id'] == $employee['division_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['division_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Access Control -->
                        <h5 class="fw-semibold border-bottom pb-2 mb-4">Access Control</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">User Type</label>
                                <select class="form-select" name="user_type_id" required>
                                    <?php while ($row = mysqli_fetch_assoc($user_types)): ?>
                                        <option value="<?= $row['user_type_id'] ?>"
                                            <?= $row['user_type_id'] == $employee['user_type_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['user_type']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account Status</label>
                                <select class="form-select" name="status">
                                    <option <?= $employee['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option <?= $employee['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option <?= $employee['status'] == 'Suspended' ? 'selected' : '' ?>>Suspended</option>
                                </select>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="#" id="cancelBtn" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>






                </div>

            </main>

        </div>
    </div>

    <script>
    document.getElementById("cancelBtn").addEventListener("click", function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Cancel Editing?",
            text: "Any unsaved changes will be lost.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, go back",
            cancelButtonText: "Stay here"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "head_register_employee.php";
            }
        });
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