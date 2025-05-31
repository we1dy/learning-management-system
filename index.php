<?php
session_start();
include 'db.php';

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS</title>
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

  <div class="container-fluid">
    <div class="row vh-100">
      <div class="col-lg-6 d-flex flex-column justify-content-center left-panel">
        <div class="d-flex align-items-mb-4 flex-wrap">
          <img src="assets/images/header.png" id="welcome-header" class="img-fluid"
            style="max-width: 750px; width: 100%; flex-shrink: 1;">
        </div>
        <br>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Access your accounts securely, manage your
          finances, and enjoy our comprehensive banking services.</p>

        <div class="feature">
          <i class="fa-solid fa-lock"></i>
          <div>
            <div class="feature-title">Bank-grade Security</div>
            <div class="feature-desc">Your financial data is protected with advanced encryption and security protocols.
            </div>
          </div>
        </div>

        <div class="feature">
          <i class="fa-solid fa-shield-halved"></i>
          <div>
            <div class="feature-title">Fraud Protection</div>
            <div class="feature-desc">24/7 monitoring systems to detect and prevent unauthorized activities.</div>
          </div>
        </div>

        <div class="support">
          Need assistance? Contact our customer support:<br>
          +1 (800) 555-0123<br>
          support@PBCOM.com
        </div>
      </div>

      <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center right-panel">
        <div class="form-box">
          <h2>SIGN IN</h2>
          <p>Access your PBCOM account</p>
          <br>
          <div class="text-start w-100">
            <form action="index.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your username" require>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
              </div>

              
              <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>

          </div>
          <br>
          <a href="#">Forgot Password?</a>
        </div>

        <div class="signup-box">
          <h4>New to PBCOM LMS?</h4>
          <p>Sign up now!</p>
          <button>I'm an Employee</button>
          <button>I'm an Admin</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>