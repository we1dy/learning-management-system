<?php
require_once "../db.php";
session_start();

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

$sql = "SELECT * FROM course WHERE course_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Unauthorized access or course not found.";
    exit();
}

$course = $result->fetch_assoc();
// Load modules for this course
$module_query = "SELECT * FROM course_modules WHERE course_id = ?";
$stmt = $conn->prepare($module_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$modules = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
    <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="../assets/css/head_dashboard.css"> -->
    <title><?= htmlspecialchars($course['course_name']) ?> - Course View</title>
</head>

<body>
    <div class="container mt-4">
        <h2><?= htmlspecialchars($course['course_name']) ?></h2>

        <div class="card mb-3">
            <div class="card-body">
                <h2>Course Description</h2>
                <hr>
                <p><?= nl2br(htmlspecialchars($course['course_desc'])) ?></p>
            </div>
        </div>

        <hr>


        <!-- Button to trigger upload form -->
        <button class="btn btn-primary mb-3" data-bs-toggle="collapse" data-bs-target="#uploadForm">
            Add New Module (PDF/PPT)
        </button>

        <!-- Upload form (initially collapsed) -->
        <div class="collapse mb-3" id="uploadForm">
            <form action="upload_module.php" method="post" enctype="multipart/form-data" class="border rounded p-3">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">

                <div class="mb-3">
                    <label for="title" class="form-label">Module Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Module Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>

                <div class="mb-3">
                    <label for="module_file" class="form-label">Select PDF or PPT File</label>
                    <input type="file" class="form-control" id="module_file" name="module_file" accept=".pdf,.ppt,.pptx"
                        required>
                </div>

                <button type="submit" class="btn btn-success">Upload Module</button>
            </form>
        </div>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#assignCourseModal">
            Assign Course to Employees
        </button>

        <h4 class="mt-4">Course Modules</h4>

        <?php if ($modules->num_rows === 0): ?>
            <div class="alert alert-warning">No modules found for this course.</div>
        <?php else: ?>
            <ul class="list-group mb-3">
                <?php while ($mod = $modules->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <strong><?= htmlspecialchars($mod['title']) ?></strong><br>
                                <?php if (!empty($mod['description'])): ?>
                                    <small class="text-muted"><?= htmlspecialchars($mod['description']) ?></small><br>
                                <?php endif; ?>
                                <a href="<?= htmlspecialchars($mod['file_path']) ?>" target="_blank">Download Module</a>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                                    data-bs-target="#editModuleModal<?= $mod['id'] ?>">
                                    Edit
                                </button>
                                <a href="delete_module.php?id=<?= $mod['id'] ?>&course_id=<?= $course_id ?>"
                                    onclick="return confirm('Are you sure you want to delete this module?')"
                                    class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        </li>
                        <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        
                        <!-- Edit Module Modals (outside the loop) -->
                        <?php
                        // Reset the result pointer to create modals
                        $stmt->execute();
                        $modules = $stmt->get_result();
                        while ($mod = $modules->fetch_assoc()):
                            ?>
                            <div class="modal fade" id="editModuleModal<?= $mod['id'] ?>" tabindex="-1" aria-labelledby="editLabel<?= $mod['id'] ?>"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="edit_module.php" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLabel<?= $mod['id'] ?>">Edit Module</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="module_id" value="<?= $mod['id'] ?>">
                                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Module Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                        value="<?= htmlspecialchars($mod['title']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Module Description</label>
                                                    <input type="text" class="form-control" name="description"
                                                        value="<?= htmlspecialchars($mod['description'] ?? '') ?>">
                                            </div>

                                <div class="mb-3">
                                    <label class="form-label">Current File</label>
                                    <p class="form-text"><?= basename($mod['file_path']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Upload New File (PDF/PPT) - Optional</label>
                                    <input type="file" class="form-control" name="new_module_file" accept=".pdf,.ppt,.pptx">
                                    <small class="form-text text-muted">Leave empty to keep current file</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
                                <!-- Assign Course Modal -->
                                <div class="modal fade" id="assignCourseModal" tabindex="-1" aria-labelledby="assignCourseModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form action="assign_course.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assignCourseModalLabel">Assign Course to Employees</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                
                                                <div class="modal-body">
                                                    <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                                
                                                    <!-- Filter controls -->
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label class="form-label">Group</label>
                                                            <select id="filterGroup" class="form-select">
                                                                <option value="">All</option>
                                                                <?php
                                                                $groups = $conn->query("SELECT * FROM `group`");
                                                                while ($g = $groups->fetch_assoc()):
                                                                    ?>
                                                                    <option value="<?= $g['group_id'] ?>"><?= htmlspecialchars($g['group_name']) ?>
                                                                    </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <label class="form-label">Segment</label>
                                                            <select id="filterSegment" class="form-select">
                                                                <option value="">All</option>
                                                                <?php
                                                                $segments = $conn->query("SELECT * FROM segment");
                                                                while ($s = $segments->fetch_assoc()):
                                                                    ?>
                                                                    <option value="<?= $s['segment_id'] ?>">
                                                                        <?= htmlspecialchars($s['segment_name']) ?>
                                                                    </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <label class="form-label">Division</label>
                                                            <select id="filterDivision" class="form-select">
                                                                <option value="">All</option>
                                                                <?php
                                                                $divisions = $conn->query("SELECT * FROM division");
                                                                while ($d = $divisions->fetch_assoc()):
                                                                    ?>
                                                                    <option value="<?= $d['division_id'] ?>">
                                                                        <?= htmlspecialchars($d['division_name']) ?>
                                                                    </option>
                                                                <?php endwhile; ?>
                                        </select>
                                        </div>
                                        </div>
                                        
                                        <!-- Employee list -->
                                        <div class="mb-3">
                                            <label class="form-label">Select Employees</label>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                        
                                                <button type="button" class="btn btn-sm btn-primary" id="toggleSelectAll">Select
                                                    All</button>
                                            </div>
                                            <div id="employeeCheckboxList" class="border p-2" style="max-height: 250px; overflow-y: auto;">
                                                <!-- Checkboxes will be populated here -->
                                            </div>
                                            <small class="text-muted">You can select multiple employees by checking the
                                                boxes.</small>
                                        
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Assign</button>
                                        </div>
                                        </form>
                                        </div>
                                        </div>
                                        </div>
                                        
                                        
                                        <a href="head_manage_courses.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
                                        </div>
                                        <?php if (isset($_GET['deleted'])): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Module deleted successfully.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($_GET['uploaded'])): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Module uploaded successfully.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>

    <?php if (isset($_GET['assigned'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Course assigned successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['assigned'])): ?>
        <div class="alert alert-success">
            <?= $_GET['assigned'] ?> course(s) assigned.
            <?php if ($_GET['duplicates'] > 0): ?>
                <?= $_GET['duplicates'] ?> duplicate(s) skipped.
            <?php endif; ?>
    </div>
    <?php endif; ?>
    
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const groupFilter = document.getElementById('filterGroup');
            const segmentFilter = document.getElementById('filterSegment');
            const divisionFilter = document.getElementById('filterDivision');
            const checkboxContainer = document.getElementById('employeeCheckboxList');
            const toggleBtn = document.getElementById('toggleSelectAll');

            let allSelected = false;

            function fetchEmployees() {
                const group = groupFilter.value;
                const segment = segmentFilter.value;
                const division = divisionFilter.value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'fetch_employees.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        checkboxContainer.innerHTML = this.responseText;
                        allSelected = false; // Reset select all state
                        toggleBtn.textContent = 'Select All';
                    }
                };
                xhr.send(`group_id=${group}&segment_id=${segment}&division_id=${division}`);
            }

            // Filters trigger
            groupFilter.addEventListener('change', fetchEmployees);
            segmentFilter.addEventListener('change', fetchEmployees);
            divisionFilter.addEventListener('change', fetchEmployees);

    // Select All / Deselect All toggle
    toggleBtn.addEventListener('click', () => {
        const checkboxes = checkboxContainer.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = !allSelected);
        allSelected = !allSelected;
        toggleBtn.textContent = allSelected ? 'Deselect All' : 'Select All';
    });

            // Initial load
            fetchEmployees();
        });
    </script>
    <!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('upload_module.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status,
            title: data.status === 'success' ? 'Success' : 'Error',
            text: data.message
        }).then(() => {
            if (data.status === 'success') {
                window.location.href = 'head_view_course.php?course_id=' + form.course_id.value;
            }
        });
    })
    .catch(err => {
        console.error('Error:', err);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong with the request.'
        });
    });
});
</script>

</body>

</html>