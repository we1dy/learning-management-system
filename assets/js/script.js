// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
  // Mobile menu toggle functionality
  const toggleMobileMenu = () => {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
      sidebar.classList.toggle('show');
    }
  };

  // Add hover effect to course cards
  const courseCards = document.querySelectorAll('.course-card');
  courseCards.forEach(card => {
    card.addEventListener('mouseenter', function () {
      this.style.transform = 'translateY(-5px)';
      this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
    });

    card.addEventListener('mouseleave', function () {
      this.style.transform = 'translateY(0)';
    });
  });

  // Start course button click handler
  const startButtons = document.querySelectorAll('.start-course-btn');
  // startButtons.forEach(button => {
  //   button.addEventListener('click', function (e) {
  //     e.preventDefault();
  //     const courseName = this.closest('.course-card').querySelector('.course-title').textContent;
  //     alert(`Starting course: ${courseName}`);
  //     // In a real application, this would navigate to the course page
  //   });
  // });

  // Start course button click handler
  startButtons.forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      const courseCard = this.closest('.course-card');
      const courseName = courseCard.querySelector('.course-title').textContent;
      const courseURL = this.getAttribute('data-url') || '#'; // Change this if needed

      Swal.fire({
        title: 'Start Course',
        text: `Are you ready to begin "${courseName}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, start it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect after confirmation
          window.location.href = courseURL;
        }
      });
    });
  });

  // Search functionality
  const searchInputs = document.querySelectorAll('input[type="text"]');
  searchInputs.forEach(input => {
    input.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') {
        const searchTerm = this.value.toLowerCase();
        if (searchTerm.trim() !== '') {
          filterCourses(searchTerm);
        } else {
          // If search is empty, show all courses
          courseCards.forEach(card => {
            card.closest('.col-md-6').style.display = 'block';
          });
        }
      }
    });
  });

  // Filter courses based on search term
  function filterCourses(term) {
    courseCards.forEach(card => {
      const title = card.querySelector('.course-title').textContent.toLowerCase();
      const description = card.querySelector('.course-description').textContent.toLowerCase();

      if (title.includes(term) || description.includes(term)) {
        card.closest('.col-md-6').style.display = 'block';
      } else {
        card.closest('.col-md-6').style.display = 'none';
      }
    });
  }

  // Pagination functionality (simplified for demo)
  const paginationLinks = document.querySelectorAll('.pagination .page-link');
  paginationLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      // Remove active class from all pagination items
      document.querySelectorAll('.pagination .page-item').forEach(item => {
        item.classList.remove('active');
      });

      // Add active class to clicked pagination item
      if (this.textContent !== '›') {
        this.closest('.page-item').classList.add('active');
      }

      // In a real application, this would load the next page of courses
      // if (this.textContent === '2' || this.innerHTML.includes('chevron-right')) {
      //   alert('Loading page 2 of courses...');
      // }
    });
  });
  
});