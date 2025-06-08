<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Cookie for "remember me"
  if (isset($_POST['remember_me'])) {
    setcookie('remember_username', $username, time() + (86400 * 30), "/"); // 30 days
  } else {
    setcookie('remember_username', '', time() - 3600, "/"); // Remove cookie
  }

  $query = "SELECT * FROM user_account WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($user['account_status'] !== 'Active') {
      $login_error = "Your account is inactive.";
    } elseif (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['user_type_id'] = $user['user_type_id'];

      if ($user['user_type_id'] == 1 || $user['user_type_id'] == 2) {
        header("Location: admin/index.php");
        exit();
      } elseif ($user['user_type_id'] == 3) {
        $user_id = $user['user_id'];
        $stmt = $conn->prepare("SELECT employee_id FROM employee WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($employee_id);
        $stmt->fetch();
        $stmt->close();

        if (!$employee_id) {
          die('Error: No employee record for user ID ' . htmlspecialchars($user_id));
        }

        $stmt = $conn->prepare("SELECT last_name, first_name, middle_initial, email, group_id, segment_id, division_id FROM employee WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $stmt->bind_result($last_name, $first_name, $middle_initial, $emp_email, $group_id, $segment_id, $division_id);
        $stmt->fetch();
        $stmt->close();

        $_SESSION['employee_id'] = $employee_id;
        $_SESSION['employee_name'] = $first_name;

        header("Location: home.php");
        exit();
      } else {
        $login_error = "Invalid user role.";
      }
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
            <?php if (isset($login_error)): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>

            <form action="index.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username"
                  value="<?php echo isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : ''; ?>" required>
              </div>

              <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password-field" class="form-control"
                  placeholder="Enter your password" required>
                <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;"
                  onclick="togglePassword()">
                  <i id="toggleIcon" class="fa-solid fa-eye"></i>
                </span>
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me" <?php echo isset($_COOKIE['remember_username']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="rememberMe">Remember me</label>
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


  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password-field');
      const toggleIcon = document.getElementById('toggleIcon');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>