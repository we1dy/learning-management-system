<aside id="sidebar" class="sidebar">
  <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
  <?php
  $dropdownPages = [
    'regulatory_courses.php',
    'on_boarding.php',
    'behavioral_management.php',
    'development_program.php',
    'tech_job_specific.php'
  ];
  $isDropdownActive = in_array($currentPage, $dropdownPages);
  ?>



  <div class="sidebar-header">
    <h2>Employee Portal</h2>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">
      <div class="nav-section-title">Main</div>

      <a href="employee_dashboard.php"
        class="nav-link <?= ($currentPage == 'employee_dashboard.php') ? 'active' : '' ?>">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
      </a>

      <a href="employee_profile.php" class="nav-link <?= ($currentPage == 'employee_profile.php') ? 'active' : '' ?>">
        <i class="fas fa-user"></i>
        <span>Profile</span>
      </a>

    </div>

    <div class="nav-section">
      <div class="nav-section-title">Learning</div>
      <div class="nav-dropdown">
        <div class="nav-dropdown <?= $isDropdownActive ? 'open' : '' ?>">
          <a href="#" class="nav-link nav-dropdown-toggle">
            <i class="fas fa-book-open"></i>
            <span>Courses</span>
            <i class="bi bi-chevron-down dropdown-icon"></i>
            </button>
          </a>
          <div class="nav-dropdown-menu">
            <a href="regulatory_courses.php"
              class="nav-dropdown-item <?= ($currentPage == 'regulatory_courses.php') ? 'active' : '' ?>">Regulatory
              Courses</a>
            <a href="on_boarding.php"
              class="nav-dropdown-item <?= ($currentPage == 'on_boarding.php') ? 'active' : '' ?>">On-Boarding
              Orientation</a>
            <a href="behavioral_management.php"
              class="nav-dropdown-item <?= ($currentPage == 'behavioral_management.php') ? 'active' : '' ?>">Behavioral
              and Management</a>
            <a href="development_program.php"
              class="nav-dropdown-item <?= ($currentPage == 'development_program.php') ? 'active' : '' ?>">Development
              Program</a>
            <a href="tech_job_specific.php"
              class="nav-dropdown-item <?= ($currentPage == 'tech_job_specific.php') ? 'active' : '' ?>">Technical/Job
              Specific</a>
          </div>
        </div>
        <a href="employee_announcement.php"
          class="nav-link <?= ($currentPage == 'employee_announcement.php') ? 'active' : '' ?>">
          <i class="fa-solid fa-bullhorn"></i>
          <span>Announcements</span>
        </a>

        <a href="employee_quiz.php" class="nav-link <?= ($currentPage == 'employee_quiz.php') ? 'active' : '' ?>">
          <i class="fas fa-question-circle"></i>
          <span>Quiz</span>
        </a>

        <a href="employee_cert.php" class="nav-link <?= ($currentPage == 'employee_cert.php') ? 'active' : '' ?>">
          <i class="fas fa-award"></i>
          <span>Certifications</span>
        </a>

      </div>
    </div>
  </nav>
</aside>