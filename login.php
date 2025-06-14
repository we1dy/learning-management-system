<?php
session_start();
include 'db.php'; // Make sure this connects to your DB properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect credentials
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. Fetch user by email (not username if you're using email)
    $query = "SELECT * FROM user_account WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 3. Check user found and password verified
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check account status
        if ($user['account_status'] !== 'Active') {
            $login_error = "Your account is inactive.";
        }
        if ($password === $user['password']) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            $user_id = $user['user_id'];

            // 4. Get employee_id
            $query = "SELECT employee_id FROM employee WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($employee_id);
            $stmt->fetch();
            $stmt->close();


            if (!$employee_id) {
                die('Error: User ID = ' . htmlspecialchars($user_id) . ' not found in the employee database.');
            }

            // 5. Get employee details
            $query = "SELECT last_name, first_name, middle_initial, email, group_id, segment_id, division_id FROM employee WHERE employee_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->bind_result($last_name, $first_name, $middle_initial, $emp_email, $group_id, $segment_id, $division_id);
            $stmt->fetch();
            $stmt->close();

            // 6. Set employee session info
            $_SESSION['employee_id'] = $employee_id;
            $_SESSION['employee_name'] = $first_name;
            // $_SESSION['employee_name'] = $first_name . ' ' . $last_name;


            // 7. Redirect to home
            header("Location: home.php");
            exit();
        } else {
            $login_error = "Invalid password.";
        }
    } else {
        $login_error = "Invalid login credentials.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h4 class="text-center">Employee Login</h4>
                    <?php if (isset($login_error)): ?>
                        <div class="alert alert-danger"><?= $login_error ?></div>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Username</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>