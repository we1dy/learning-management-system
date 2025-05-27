document.addEventListener('DOMContentLoaded', function() {
  // Sidebar toggle for mobile
  const sidebarToggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');
  
  sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('show');
    
    // Change icon based on sidebar state
    const icon = sidebarToggle.querySelector('i');
    if (sidebar.classList.contains('show')) {
      icon.classList.remove('bi-list');
      icon.classList.add('bi-x');
    } else {
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    }
  });
  
  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isClickOnToggle = sidebarToggle.contains(event.target);
    
    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
      sidebar.classList.remove('show');
      const icon = sidebarToggle.querySelector('i');
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    }
  });
  
  // Dropdown functionality in sidebar
  const dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');
  
  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
      const dropdown = this.closest('.nav-dropdown');
      dropdown.classList.toggle('open');
    });
  });
  
  // Initialize all tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});