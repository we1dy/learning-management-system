<aside id="sidebar" class="sidebar">
  <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

  <div class="sidebar-header">
    <h2>Employee Portal</h2>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">
      <div class="nav-section-title">Main</div>

      <a href="home.php" class="nav-link <?= ($currentPage == 'home.php') ? 'active' : '' ?>">
        <i class="bi bi-house"></i>
        <span>Home</span>
      </a>

      <a href="employee_dashboard.php" class="nav-link <?= ($currentPage == 'employee_dashboard.php') ? 'active' : '' ?>">
        <i class="bi bi-bar-chart"></i>
        <span>Dashboard</span>
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-title">Learning</div>
      <div class="nav-dropdown">
        <button class="nav-dropdown-toggle">
          <i class="bi bi-book"></i>
          <span>Courses</span>
          <i class="bi bi-chevron-down dropdown-icon"></i>
        </button>

        <div class="nav-dropdown-menu">
          <a href="regulatory_courses.php" class="nav-dropdown-item <?= ($currentPage == 'regulatory_courses.php') ? 'active' : '' ?>">Regulatory Courses</a>
          <a href="on_boarding.php" class="nav-dropdown-item <?= ($currentPage == 'on_boarding.php') ? 'active' : '' ?>">On-Boarding Orientation</a>
          <a href="behavioral_management.php" class="nav-dropdown-item <?= ($currentPage == 'behavioral_management.php') ? 'active' : '' ?>">Behavioral and Management</a>
          <a href="development_program.php" class="nav-dropdown-item <?= ($currentPage == 'development_program.php') ? 'active' : '' ?>">Development Program</a>
          <a href="tech_job_specific.php" class="nav-dropdown-item <?= ($currentPage == 'tech_job_specific.php') ? 'active' : '' ?>">Technical/Job Specific</a>
        </div>

        <a href="employee_announcement.php" class="nav-link <?= ($currentPage == 'employee_announcement.php') ? 'active' : '' ?>">
          <i class="bi bi-megaphone me-2"></i>
          <span>Announcements</span>
        </a>

        <a href="employee_quiz.php" class="nav-link <?= ($currentPage == 'employee_quiz.php') ? 'active' : '' ?>">
          <i class="bi bi-journal-check me-2"></i>
          <span>Quiz</span>
        </a>

        <a href="employee_quizlog.php" class="nav-link <?= ($currentPage == 'employee_quizlog.php') ? 'active' : '' ?>">
          <i class="bi bi-ui-radios me-2"></i>
          <span>Quiz Log</span>
        </a>
      </div>
    </div>
  </nav>
</aside>
