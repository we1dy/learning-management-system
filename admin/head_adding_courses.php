<?php
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['courseTitle'];
    $category = $_POST['courseCategory'];
    $description = $_POST['courseDescription'];
    $imagePath = null;

    // Handle image upload if file is provided
    if (!empty($_FILES['courseImage']['name'])) {
        $targetDir = "../assets/images/courses/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = basename($_FILES["courseImage"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName;

        if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Prepare and execute SQL insert
    $stmt = $conn->prepare("INSERT INTO course (course_category_id, course_name, course_desc, course_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $category, $title, $description, $imagePath);

    if ($stmt->execute()) {
        echo "
        <!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>Registration</title>
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
    
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Course added successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'head_manage_courses.php';
        });
    </script>
    </body>
</html>";
        exit();
    } else {
        echo "
        <!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>Registration</title>
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
   
    <script>
        Swal.fire({
            title: 'Error!',
            text: '" . addslashes($stmt->error) . "',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    </body>
</html>";
    }


    $stmt->close();
}
?>