<?php
require_once "../db.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pagination settings
$limit = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get filter - make sure it's properly sanitized
$filter = null;
if (isset($_GET['category_filter']) && $_GET['category_filter'] !== '' && is_numeric($_GET['category_filter'])) {
    $filter = intval($_GET['category_filter']);
}

// Build the WHERE clause
$where_clause = "";
$count_where = "";
if ($filter) {
    $where_clause = " AND course.course_category_id = " . $filter;
    $count_where = " AND course_category_id = " . $filter;
}

// 1. Count total courses
$count_sql = "SELECT COUNT(*) as total FROM course WHERE 1=1" . $count_where;
$count_result = $conn->query($count_sql);

if (!$count_result) {
    die("Count query failed: " . $conn->error);
}

$total_courses = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_courses / $limit);

// 2. Get the courses for current page
$main_sql = "
    SELECT course.*, course_category.course_category_name 
    FROM course 
    LEFT JOIN course_category ON course.course_category_id = course_category.course_category_id
    WHERE 1=1" . $where_clause . "
    LIMIT " . $limit . " OFFSET " . $offset;

$all_course_result = $conn->query($main_sql);

if (!$all_course_result) {
    die("Main query failed: " . $conn->error);
}

// Fetch categories for dropdown
$category_query = "SELECT * FROM course_category ORDER BY course_category_name";
$category_result = $conn->query($category_query);

// Status color class map
$statusClass = [
    'Not Started' => 'secondary',
    'Ongoing' => 'primary',
    'Completed' => 'success',
    'Overdue' => 'danger',
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
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

                    <h1>Manage Courses</h1>

                    <!-- Add New Course Button -->
                    <button class="btn btn-primary mb-2" type="button" onclick="toggleNewCourse()">
                        <i class="bi bi-plus-circle me-2"></i> Add New Course
                    </button>

                    <!-- Collapsible Panel -->
                    <div id="newCoursePanel" class="card p-3 mb-3" style="display: none;">
                        <h5 class="card-title">New Course Form</h5>
                        <form method="POST" enctype="multipart/form-data" action="head_adding_courses.php">
    <div class="mb-3">
        <label for="courseTitle" class="form-label">Course Title</label>
        <input type="text" class="form-control" id="courseTitle" name="courseTitle" required>
    </div>

    <div class="mb-3">
        <label for="courseCategory" class="form-label">Category</label>
        <select class="form-select" id="courseCategory" name="courseCategory" required>
            <option selected disabled>Select course category</option>
            <?php
                                    if ($category_result && $category_result->num_rows > 0) {
                                        $category_result->data_seek(0);
                                        while ($category = $category_result->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($category['course_category_id']) ?>">
                                                <?= htmlspecialchars($category['course_category_name']) ?>
                                            </option>
                                        <?php endwhile;
                                    } ?>
                                </select>
                            </div>
                        
                            <div class="mb-3">
                                <label for="courseDescription" class="form-label">Course Description</label>
                                <textarea class="form-control" id="courseDescription" name="courseDescription" rows="3" required></textarea>
                            </div>
                        
                            <div class="mb-3">
                                <label for="courseImage" class="form-label">Course Image</label>
                                <input type="file" class="form-control" id="courseImage" name="courseImage" accept="image/*">
                            </div>
                        
                            <button type="submit" class="btn btn-success">Save Course</button>
                        </form>

                    </div>

                    <section>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="section-title">ALL COURSES</h2>
                        </div>
                        
                        <!-- Filter Form -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select" name="category_filter" onchange="this.form.submit()">
                                        <option value="">All Categories</option>
                                        <?php
                                        // Fresh query for filter dropdown
                                        $cat_query = "SELECT * FROM course_category ORDER BY course_category_name";
                                        $cat_result = $conn->query($cat_query);
                                        if ($cat_result) {
                                            while ($cat = $cat_result->fetch_assoc()):
                                        ?>
                                            <option value="<?= htmlspecialchars($cat['course_category_id']) ?>"
                                                <?= ($filter && $filter == $cat['course_category_id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['course_category_name']) ?>
                                            </option>
                                        <?php 
                                            endwhile; 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>

                        

                        <!-- Courses Display -->
                        <div class="row">
                            <?php if ($all_course_result && $all_course_result->num_rows > 0): ?>
                                <?php while ($row = $all_course_result->fetch_assoc()): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card course-card">
                                            <div class="course-image">
                                                <img src="../<?= htmlspecialchars($row['course_image'] ?? 'images/placeholder.jpg') ?>"
                                                    alt="<?= htmlspecialchars($row['course_name']) ?>"
                                                    style="width: 100%; height: 150px; object-fit: cover;">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($row['course_name']) ?></h5>
                                                <p class="card-subtitle text-muted mb-2">
                                                    <?= htmlspecialchars($row['course_category_name'] ?? 'No Category') ?>
                                                </p>
                                                <p class="card-text text-muted">Due
                                                    <?= !empty($row['due_date']) ? date("m/d/Y", strtotime($row['due_date'])) : 'No due date' ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                                                    <small class="text-muted">
                                                        <?= isset($row['progress']) ? htmlspecialchars($row['progress']) . '% Complete' : 'No Progress' ?>
                                                    </small>
                                                    <a href="head_view_course.php?course_id=<?= $row['course_id'] ?>"
                                                        class="btn btn-primary btn-sm">Go to Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="alert alert-warning">No courses found.</div>
                                </div>
                            <?php endif; ?>
                        </div>

                     

                    </section>
                    
                </div>
                   <!-- Pagination -->
                      <?php if ($total_pages > 1): ?>
                    <nav aria-label="Course pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= ($page - 1) ?><?= $filter ? '&category_filter=' . $filter : '' ?>">
                                        &laquo; Previous
                                    </a>
                                </li>
                            <?php endif; ?>
                
                            <!-- Page Numbers -->
                            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $p ?><?= $filter ? '&category_filter=' . $filter : '' ?>">
                                        <?= $p ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                
                            <!-- Next Button -->
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= ($page + 1) ?><?= $filter ? '&category_filter=' . $filter : '' ?>">
                                        Next &raquo;
                                    </a>
                                </li>
                            <?php endif; ?>
                    </ul>
                </nav>
                
                <!-- Manual Test Links (remove in production) -->
                <!-- <div class="text-center mt-3">
                                            <small class="text-muted">Test Links: </small>
                                            <a href="?page=1" class="btn btn-sm btn-outline-secondary">Page 1</a>
                                            <a href="?page=2" class="btn btn-sm btn-outline-secondary">Page 2</a>
                                        </div> -->
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script>
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

        function toggleNewCourse() {
            const panel = document.getElementById('newCoursePanel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebar.js"></script>
</body>

</html>