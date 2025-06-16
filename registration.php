<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <!-- Logo icon-->
  <link rel="icon" type="image/x-icon" href="../assets/images/pbcom.jpg">
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/registration.css">
</head>

<body>

  <div class="container-fluid">
    <div class="row vh-100">
      <div class="col-lg-5 d-flex flex-column justify-content-center left-panel">
        <div class="d-flex align-items-mb-4 flex-wrap">
          <img src="assets/images/header2.png" id="welcome-header" class="img-fluid"
            style="max-width: 600px; width: 100%; flex-shrink: 1;">
        </div>
      </div>

      <div class="col-lg-7 d-flex flex-column justify-content-center align-items-center right-panel">
        <div class="form-box">
          <h2>SIGN UP</h2>
          <p>Create your PBCOM Account</p>
          <br>
          <div class="text-start w-100">
            <?php if (isset($login_error)): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>

            <form action="index.php" method="POST">
              <div class="mb-4">
                <label class="form-label">Name</label>
                <div class="row">
                  <div class="col">
                    <input type="text" name="fname" class="form-control" placeholder="First Name">
                  </div>
                  <div class="col">
                    <input type="text" name="lname" class="form-control" placeholder="Last Name">
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label">Email Address</label>
                <input type="text" name="emailadd" class="form-control" placeholder="Email Address">
              </div>
              <div class="mb-4">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
              </div>
              <div class="mb-4 position-relative">
                <div class="row">
                  <div class="col">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password-field" class="form-control"
                      placeholder="Enter your password" required>
                    <span class="password translate-middle-y " onclick="togglePassword()">
                      <i id="toggleIcon" class="fa-solid fa-eye"></i>
                    </span>
                  </div>
                  <div class="col">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password" id="password-field" class="form-control"
                      placeholder="Enter your password" required>
                    <span class="password translate-middle-y " onclick="togglePassword()">
                      <i id="toggleIcon" class="fa-solid fa-eye"></i>
                    </span>
                  </div>
                </div>
              </div>
              &nbsp;
              &nbsp;
              <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>

          </div>
          <br>
          <a href="index.php">Already have an account?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom JS -->
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