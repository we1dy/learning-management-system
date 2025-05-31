<?php
require_once "../db.php";
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$employee_id = $_SESSION['employee_id'];
$sql = "
    SELECT c.course_name, c.course_desc, ec.status
    FROM employee_courses ec
    JOIN course c ON ec.course_id = c.course_id
    WHERE ec.employee_id = ? AND ec.course_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $employee_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Unauthorized access or course not found.";
    exit();
}


$course = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= htmlspecialchars($course['course_name']) ?> - Course View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2><?= htmlspecialchars($course['course_name']) ?></h2>
        <p class="text-muted">Status: <strong><?= $course['status'] ?></strong></p>
        <div class="card mb-3">
            <div class="card-body">
                <h2>Course Description</h2>
                <hr>
                <p><?= nl2br(htmlspecialchars($course['course_desc'])) ?></p>
            </div>
        </div>

        <!-- Optional: Mark progress -->

        <!-- <?php if ($course['status'] !== 'Completed'): ?>
            <form method="post" action="update_course_status.php">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                <button name="status" value="In Progress" class="btn btn-info">Mark as In Progress</button>
                <button name="status" value="Completed" class="btn btn-success">Mark as Completed</button>
            </form>
        <?php endif; ?> -->
        <hr>
        <?php
        // Load modules for this course
        $module_query = "SELECT * FROM course_modules WHERE course_id = ?";
        $stmt = $conn->prepare($module_query);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $modules = $stmt->get_result();
        ?>

        <h4 class="mt-4">Course Modules</h4>

        <?php if ($modules->num_rows === 0): ?>
            <div class="alert alert-warning">No modules found for this course.</div>
        <?php else: ?>
            <ul class="list-group mb-3">
                <?php while ($mod = $modules->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                     
                            <iframe src="<?= htmlspecialchars($mod['file_path']) ?>#toolbar=0" width="100%" height="600px"
                                style="border:1px solid #ccc;"></iframe>
                        


                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <a href="employee_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>




</body>

</html>