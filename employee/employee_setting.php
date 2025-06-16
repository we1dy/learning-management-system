<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
  // Not logged in
  header("Location: login.php");
  exit();
}

$employee_id = $_SESSION['employee_id']; // Use the correct key

$query = "
    SELECT e.employee_num, e.first_name, e.last_name, e.middle_initial, e.email, 
           CONCAT_WS(' - ', g.group_name, s.segment_name, d.division_name) AS department
    FROM employee e
    LEFT JOIN `group` g ON e.group_id = g.group_id
    LEFT JOIN segment s ON e.segment_id = s.segment_id
    LEFT JOIN division d ON e.division_id = d.division_id
    WHERE e.employee_id = ?
";


$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id); // bind employee_id instead of user_id
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $employee = $result->fetch_assoc();
} else {
  echo "Employee not found.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PBCOM LMS - Account Settings</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
  <!-- Aileron Font -->
  <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/settings.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="stylesheet" href="../assets/css/top_nsidebar.css">
</head>

<body>
  <!-- Toast Notifications Container -->
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="settingsSavedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-success text-white">
        <i class="bi bi-check-circle me-2"></i>
        <strong class="me-auto">Success</strong>
        <small>Just now</small>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Your settings have been saved successfully.
      </div>
    </div>
  </div>

  <div class="wrapper">
    <!-- Header -->
    <?php include 'topbar.php' ?>

    <div class="content-wrapper">
      <!-- Sidebar -->
      <?php include 'sidebar.php' ?>

      <!-- <aside class="sidebar bg-white shadow-sm">
      <div class="p-3">
        <h2 class="fs-5 fw-semibold text-dark mb-4">Employee Portal</h2>

        <div class="mb-4">
          <h3 class="text-uppercase fs-6 text-muted fw-semibold mb-2">MAIN</h3>
          <nav class="nav flex-column">
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-speedometer2 me-2"></i>
              Dashboard
            </a>
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-person me-2"></i>
              Profile
            </a>
          </nav>
        </div>

        <div>
          <h3 class="text-uppercase fs-6 text-muted fw-semibold mb-2">LEARNING</h3>
          <nav class="nav flex-column">
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-book me-2"></i>
              Courses
            </a>
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-bell me-2"></i>
              Announcements
            </a>
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-question-circle me-2"></i>
              Quiz
            </a>
            <a href="#" class="nav-link text-dark py-2 px-3 rounded">
              <i class="bi bi-award me-2"></i>
              Certifications
            </a>
            <a href="#" class="nav-link text-dark py-2 px-3 rounded active">
              <i class="bi bi-gear me-2"></i>
              Settings
            </a>
          </nav>
        </div>
      </div>
    </aside> -->

      <!-- Main Content -->
      <main class="main-content p-4">
        <div class="container-fluid">
          <!-- Header -->
          <div class="d-flex align-items-center mb-4">
            <button class="btn btn-sm btn-outline-secondary me-3">
              <i class="bi bi-arrow-left me-1"></i>
              Back
            </button>
            <div>
              <h1 class="fs-2 fw-bold text-dark mb-0">Account Settings</h1>
              <p class="text-muted mt-1">Manage your learning preferences and account information</p>
            </div>
          </div>

          <!-- Account Overview -->
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h2 class="card-title mb-0 fs-4">
                    <i class="bi bi-person text-danger me-2"></i>
                    Account Overview
                  </h2>
                  <p class="card-text text-muted small">Your PBCOM Learning account details</p>
                </div>
                <span class="badge bg-danger-subtle text-danger">Employee Access</span>
              </div>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-medium text-dark">Employee ID</label>
                  <p class="font-monospace"><?= htmlspecialchars($employee['employee_num']) ?></p>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium text-dark">Department</label>
                  <p><?= htmlspecialchars($employee['department']) ?></p>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium text-dark">Learning Level</label>
                  <p>Intermediate</p>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium text-dark">Enrollment Date</label>
                  <p>January 15, 2024</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Learning Progress -->
          <!-- <div class="card mb-4 shadow-sm">
          <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h2 class="card-title mb-0 fs-4">
                  <i class="bi bi-graph-up text-danger me-2"></i>
                  Learning Progress
                </h2>
                <p class="card-text text-muted small">Track your course completion and certifications</p>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                  <h3 class="fs-5 mb-0">Compliance Training</h3>
                  <span class="badge bg-success ms-2">On Track</span>
                </div>
                <div class="progress mb-2" style="height: 10px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                  <span>75% Complete</span>
                  <span>Due: June 30, 2024</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                  <h3 class="fs-5 mb-0">Professional Development</h3>
                  <span class="badge bg-warning ms-2">In Progress</span>
                </div>
                <div class="progress mb-2" style="height: 10px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                  <span>40% Complete</span>
                  <span>4 of 10 courses</span>
                </div>
              </div>
              <div class="col-12">
                <h3 class="fs-5 mb-3">Recent Certifications</h3>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead class="table-light">
                      <tr>
                        <th>Certification</th>
                        <th>Date Completed</th>
                        <th>Expiry</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Anti-Money Laundering Basics</td>
                        <td>March 15, 2024</td>
                        <td>March 15, 2025</td>
                        <td><span class="badge bg-success">Active</span></td>
                      </tr>
                      <tr>
                        <td>Customer Data Privacy</td>
                        <td>February 10, 2024</td>
                        <td>February 10, 2025</td>
                        <td><span class="badge bg-success">Active</span></td>
                      </tr>
                      <tr>
                        <td>Banking Ethics & Compliance</td>
                        <td>December 5, 2023</td>
                        <td>December 5, 2024</td>
                        <td><span class="badge bg-success">Active</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> -->

          <!-- Notification Settings -->
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
              <h2 class="card-title mb-0 fs-4">
                <i class="bi bi-bell text-danger me-2"></i>
                Notification Preferences
              </h2>
              <p class="card-text text-muted small">Control how you receive updates about courses, deadlines, and
                banking compliance training</p>
            </div>
            <div class="card-body">
              <form id="notificationForm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <label class="form-label fw-medium fs-5 mb-1">Email Notifications</label>
                    <p class="text-muted small">Receive course updates and compliance reminders via email</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                  </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <label class="form-label fw-medium fs-5 mb-1">Push Notifications</label>
                    <p class="text-muted small">Get instant alerts for urgent compliance training and deadlines</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="pushNotifications">
                  </div>
                </div>

                <div class="alert alert-info d-flex align-items-start">
                  <i class="bi bi-info-circle fs-5 me-3 mt-1"></i>
                  <div>
                    <h4 class="alert-heading fs-5">Compliance Training Alerts</h4>
                    <p class="mb-0">Critical banking compliance notifications cannot be disabled and will always be
                      delivered via email.</p>
                  </div>
                </div>

                <div class="mt-4">
                  <h3 class="fs-5 mb-3">Notification Frequency</h3>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="notificationFrequency" id="notifyImmediate"
                      value="immediate" checked>
                    <label class="form-check-label" for="notifyImmediate">
                      Immediate - Send notifications as events occur
                    </label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="notificationFrequency" id="notifyDaily"
                      value="daily">
                    <label class="form-check-label" for="notifyDaily">
                      Daily Digest - Combine notifications into a daily summary
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="notificationFrequency" id="notifyWeekly"
                      value="weekly">
                    <label class="form-check-label" for="notifyWeekly">
                      Weekly Digest - Combine notifications into a weekly summary
                    </label>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Learning Preferences -->
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
              <h2 class="card-title mb-0 fs-4">
                <i class="bi bi-book text-danger me-2"></i>
                Learning Preferences
              </h2>
              <p class="card-text text-muted small">Customize your learning experience for banking and professional
                development courses</p>
            </div>
            <div class="card-body">
              <form id="learningPreferencesForm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <label class="form-label fw-medium fs-5 mb-1">Auto-play Videos</label>
                    <p class="text-muted small">Automatically play training videos when course content is opened</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoplayVideos" checked>
                  </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <label class="form-label fw-medium fs-5 mb-1">Course Preview Auto-play</label>
                    <p class="text-muted small">Auto-play preview videos when browsing course recommendations</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="previewAutoplay" checked>
                  </div>
                </div>

                <hr>

                <div class="mb-4">
                  <label for="learningTrack" class="form-label fw-medium fs-5">Preferred Learning Track</label>
                  <select class="form-select" id="learningTrack">
                    <option value="banking-operations" selected>Banking Operations</option>
                    <option value="compliance-risk">Compliance & Risk Management</option>
                    <option value="customer-service">Customer Service Excellence</option>
                    <option value="digital-banking">Digital Banking & Fintech</option>
                    <option value="leadership">Leadership & Management</option>
                    <option value="technical-skills">Technical Skills</option>
                  </select>
                  <div class="form-text">This helps us recommend relevant courses for your role and career development
                  </div>
                </div>

                <div class="mb-4">
                  <label for="learningPace" class="form-label fw-medium fs-5">Learning Pace</label>
                  <select class="form-select" id="learningPace">
                    <option value="self-paced" selected>Self-paced</option>
                    <option value="structured">Structured Schedule</option>
                    <option value="accelerated">Accelerated</option>
                  </select>
                  <div class="form-text">Choose how you'd like to progress through course materials</div>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-medium fs-5">Content Format Preferences</label>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="formatVideo" checked>
                    <label class="form-check-label" for="formatVideo">Video Lessons</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="formatReading" checked>
                    <label class="form-check-label" for="formatReading">Reading Materials</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="formatInteractive" checked>
                    <label class="form-check-label" for="formatInteractive">Interactive Exercises</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="formatQuizzes" checked>
                    <label class="form-check-label" for="formatQuizzes">Quizzes & Assessments</label>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Language & Accessibility -->
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
              <h2 class="card-title mb-0 fs-4">
                <i class="bi bi-globe text-danger me-2"></i>
                Language & Accessibility
              </h2>
              <p class="card-text text-muted small">Set your preferred language for course content and platform
                interface</p>
            </div>
            <div class="card-body">
              <form id="languageForm">
                <div class="mb-4">
                  <label for="interfaceLanguage" class="form-label fw-medium fs-5">Interface Language</label>
                  <select class="form-select" id="interfaceLanguage">
                    <option value="english" selected>English</option>
                    <option value="filipino">Filipino</option>
                    <option value="cebuano">Cebuano</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label for="contentLanguage" class="form-label fw-medium fs-5">Course Content Language</label>
                  <select class="form-select" id="contentLanguage">
                    <option value="english" selected>English</option>
                    <option value="filipino">Filipino</option>
                    <option value="both">Both Languages (when available)</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-medium fs-5">Accessibility Options</label>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="closedCaptions" checked>
                    <label class="form-check-label" for="closedCaptions">Enable Closed Captions</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="highContrast">
                    <label class="form-check-label" for="highContrast">High Contrast Mode</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="screenReader">
                    <label class="form-check-label" for="screenReader">Screen Reader Optimization</label>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Privacy & Security -->
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
              <h2 class="card-title mb-0 fs-4">
                <i class="bi bi-shield-lock text-danger me-2"></i>
                Privacy & Security
              </h2>
              <p class="card-text text-muted small">Manage your privacy settings and data preferences</p>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-4">
                <div class="d-flex align-items-center">
                  <i class="bi bi-shield-lock fs-5 me-3 text-secondary"></i>
                  <div>
                    <p class="fw-medium mb-0">Advanced Privacy Settings</p>
                    <p class="text-muted small mb-0">Manage data sharing and privacy controls</p>
                  </div>
                </div>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#privacyModal">
                  Manage
                  <i class="bi bi-chevron-right ms-1"></i>
                </button>
              </div>

              <div class="mb-4">
                <h3 class="fs-5 mb-3">Password Management</h3>
                <button class="btn btn-outline-danger mb-3" data-bs-toggle="modal" data-bs-target="#passwordModal">
                  <i class="bi bi-key me-2"></i>Change Password
                </button>

                <div class="d-flex align-items-center mb-2">
                  <div class="me-auto">
                    <label class="form-label fw-medium mb-0">Two-Factor Authentication</label>
                    <p class="text-muted small mb-0">Add an extra layer of security to your account</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <h3 class="fs-5 mb-3">Session Management</h3>
                <div class="d-flex align-items-center mb-3">
                  <div class="me-auto">
                    <label class="form-label fw-medium mb-0">Auto Logout After Inactivity</label>
                    <p class="text-muted small mb-0">Automatically log out after a period of inactivity</p>
                  </div>
                  <select class="form-select w-auto" id="autoLogout">
                    <option value="15">15 minutes</option>
                    <option value="30" selected>30 minutes</option>
                    <option value="60">1 hour</option>
                    <option value="never">Never</option>
                  </select>
                </div>

                <button class="btn btn-outline-secondary btn-sm" id="logoutAllDevices">
                  <i class="bi bi-box-arrow-right me-2"></i>Log out from all devices
                </button>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <div class="d-flex justify-content-end mb-5">
            <button type="button" class="btn btn-danger" id="saveSettings">
              <i class="bi bi-save me-2"></i>Save All Settings
            </button>
          </div>

          <!-- Footer -->
          <footer class="text-center py-4 border-top">
            <div class="d-flex justify-content-center mb-3">
              <a href="#" class="text-decoration-none text-secondary mx-2">Help Center</a>
              <a href="#" class="text-decoration-none text-secondary mx-2">Privacy Policy</a>
              <a href="#" class="text-decoration-none text-secondary mx-2">Terms of Service</a>
            </div>
            <p class="text-muted small">© 2024 PBCOM Universal Bank. All rights reserved.</p>
          </footer>
        </div>
      </main>
    </div>

    <!-- Password Change Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="passwordForm">
              <div class="mb-3">
                <label for="currentPassword" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" required>
              </div>
              <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control" id="newPassword" required>
                <div class="form-text">Password must be at least 8 characters with letters, numbers, and special
                  characters</div>
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" required>
              </div>
            </form>
            <div class="password-strength mt-3">
              <label class="form-label">Password Strength</label>
              <div class="progress">
                <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <small id="passwordFeedback" class="form-text"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="changePasswordBtn">Change Password</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Privacy Settings Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="privacyModalLabel">Advanced Privacy Settings</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-4">
              <h6 class="fw-bold">Data Collection & Usage</h6>
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="collectLearningData" checked>
                <label class="form-check-label" for="collectLearningData">
                  Collect learning progress data to improve course recommendations
                </label>
              </div>
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="collectUsageData" checked>
                <label class="form-check-label" for="collectUsageData">
                  Collect usage data to improve platform experience
                </label>
              </div>
            </div>

            <div class="mb-4">
              <h6 class="fw-bold">Profile Visibility</h6>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityAll" checked>
                <label class="form-check-label" for="visibilityAll">
                  Visible to all PBCOM employees
                </label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityDepartment">
                <label class="form-check-label" for="visibilityDepartment">
                  Visible to my department only
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityPrivate">
                <label class="form-check-label" for="visibilityPrivate">
                  Private (visible only to administrators)
                </label>
              </div>
            </div>

            <div class="mb-4">
              <h6 class="fw-bold">Learning Achievement Sharing</h6>
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="shareCertifications" checked>
                <label class="form-check-label" for="shareCertifications">
                  Share my certifications on internal company directory
                </label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="shareAchievements" checked>
                <label class="form-check-label" for="shareAchievements">
                  Share my learning achievements on leaderboards
                </label>
              </div>
            </div>

            <div class="alert alert-info">
              <i class="bi bi-info-circle me-2"></i>
              Note: Some data collection is required for compliance training and regulatory purposes and cannot be
              disabled.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="savePrivacySettings" data-bs-dismiss="modal">Save
              Changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Header -->
  <!-- <header class="bg-danger text-white shadow-sm">
    <div class="d-flex align-items-center justify-content-between px-4 py-3">
      <div class="d-flex align-items-center">
        <div class="d-flex align-items-center">
          <div class="bg-white text-danger px-3 py-1 rounded fw-bold fs-5">PBCOM</div>
          <span class="ms-2 small opacity-75">UNIVERSAL BANK</span>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <div class="position-relative me-3">
          <input type="search" placeholder="Search..." class="form-control bg-danger text-white border-0 search-input" aria-label="Search">
        </div>
        <div class="d-flex align-items-center">
          <div class="user-avatar">
            <span>LC</span>
          </div>
          <div class="dropdown ms-2">
            <button class="btn btn-danger dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="d-none d-md-inline">John Doe</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header> -->



  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/sidebar.js"></script>

</body>

</html>