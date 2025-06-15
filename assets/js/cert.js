// Data
const certificationProviders = [
  { name: "Microsoft", logo: "🏢", color: "bg-primary", courses: 24, category: "cloud" },
  { name: "AWS", logo: "☁️", color: "bg-warning", courses: 18, category: "cloud" },
  { name: "Google Cloud", logo: "🌐", color: "bg-success", courses: 15, category: "cloud" },
  { name: "Cisco", logo: "🔧", color: "bg-info", courses: 12, category: "security" },
  { name: "CompTIA", logo: "💻", color: "bg-danger", courses: 20, category: "security" },
  { name: "PMI", logo: "📊", color: "bg-secondary", courses: 8, category: "management" },
  { name: "Oracle", logo: "🗄️", color: "bg-dark", courses: 16, category: "development" },
  { name: "Salesforce", logo: "⚡", color: "bg-primary", courses: 14, category: "development" },
]

const courses = [
  { title: "Azure Fundamentals", provider: "Microsoft", progress: 85, duration: "4h 30m", rating: 4.8 },
  { title: "AWS Cloud Practitioner", provider: "AWS", progress: 45, duration: "6h 15m", rating: 4.9 },
  { title: "Project Management Basics", provider: "PMI", progress: 100, duration: "3h 45m", rating: 4.7 },
  { title: "Network Security", provider: "Cisco", progress: 30, duration: "8h 20m", rating: 4.6 },
  { title: "CompTIA Security+", provider: "CompTIA", progress: 70, duration: "12h 10m", rating: 4.8 },
]

const achievements = [
  { title: "First Certificate", description: "Complete your first certification", earned: true, date: "2024-01-15" },
  { title: "Learning Streak", description: "7 days of continuous learning", earned: true, date: "2024-02-01" },
  { title: "Expert Level", description: "Complete 5 advanced courses", earned: false, progress: 60 },
  { title: "Team Player", description: "Help 3 colleagues with learning", earned: false, progress: 33 },
  { title: "Speed Learner", description: "Complete a course in under 2 hours", earned: false, progress: 80 },
  { title: "Knowledge Sharer", description: "Share 10 learning resources", earned: false, progress: 20 },
]

// DOM Elements
let sidebarToggle, sidebar, searchInput, notificationBtn, notification, notificationText, loadingSpinner

// Application State
const AppState = {
  currentFilter: "all",
  searchQuery: "",
  userStats: {
    certificates: 3,
    courses: 12,
    learningTime: 48,
    teamRanking: 85,
  },
}

// Initialize Application
document.addEventListener("DOMContentLoaded", () => {
  initializeElements()
  renderProviders()
  renderCourses()
  renderAchievements()
  renderStreakDays()
  setupEventListeners()
  updateStats()
  loadProgress()
})

// Initialize DOM Elements
function initializeElements() {
  sidebarToggle = document.getElementById("sidebarToggle")
  sidebar = document.getElementById("sidebar")
  searchInput = document.getElementById("searchInput")
  notificationBtn = document.getElementById("notificationBtn")
  notification = document.getElementById("notification")
  notificationText = document.getElementById("notificationText")
  loadingSpinner = document.getElementById("loadingSpinner")
}

// Event Listeners Setup
function setupEventListeners() {
  // Sidebar toggle
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", toggleSidebar)
  }

  // Search functionality
  if (searchInput) {
    searchInput.addEventListener("input", debounce(handleSearch, 300))
  }

  // Filter chips
  document.querySelectorAll(".filter-chip").forEach((chip) => {
    chip.addEventListener("click", handleFilterClick)
  })

  // Notification button
  if (notificationBtn) {
    notificationBtn.addEventListener("click", showRandomNotification)
  }

  // Share progress
  const shareBtn = document.getElementById("shareProgress")
  if (shareBtn) {
    shareBtn.addEventListener("click", shareProgress)
  }

  // Download report
  const downloadBtn = document.getElementById("downloadReport")
  if (downloadBtn) {
    downloadBtn.addEventListener("click", downloadReport)
  }

  // Provider cards and course buttons (using event delegation)
  document.addEventListener("click", handleDocumentClick)

  // Close sidebar when clicking outside on mobile
  document.addEventListener("click", handleOutsideClick)
}

// Event Handlers
function toggleSidebar() {
  if (sidebar) {
    sidebar.classList.toggle("show")
  }
}

function handleSearch(e) {
  const query = e.target.value.toLowerCase()
  AppState.searchQuery = query

  const activeTab = document.querySelector(".nav-link.active")?.getAttribute("href")

  if (activeTab === "#certificates") {
    const filteredProviders = certificationProviders.filter((p) => p.name.toLowerCase().includes(query))
    renderFilteredProviders(filteredProviders)
  } else if (activeTab === "#preparation") {
    const filteredCourses = courses.filter(
      (c) => c.title.toLowerCase().includes(query) || c.provider.toLowerCase().includes(query),
    )
    renderFilteredCourses(filteredCourses)
  }
}

function handleFilterClick(e) {
  document.querySelectorAll(".filter-chip").forEach((c) => c.classList.remove("active"))
  e.target.classList.add("active")
  AppState.currentFilter = e.target.dataset.filter
  filterProviders(AppState.currentFilter)
}

function showRandomNotification() {
  const messages = [
    "You have 3 new course recommendations!",
    "Your learning streak is impressive!",
    "New certification available: Docker Fundamentals",
    "Team challenge: Complete 5 courses this month!",
  ]
  const randomMessage = messages[Math.floor(Math.random() * messages.length)]
  showNotification(randomMessage, "info")
}

function handleDocumentClick(e) {
  // Provider card clicks
  if (e.target.closest(".provider-card")) {
    const providerName = e.target.closest(".provider-card").dataset.provider
    showNotification(`Exploring ${providerName} courses...`, "success")
    showLoading()
    setTimeout(hideLoading, 1500)
    return
  }

  // Course continue buttons
  if (e.target.classList.contains("continue-course")) {
    const courseTitle = e.target.dataset.course
    showNotification(`Continuing ${courseTitle}...`, "success")
    updateCourseProgress(courseTitle)
    return
  }
}

function handleOutsideClick(e) {
  if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains("show")) {
    if (!sidebar.contains(e.target) && !sidebarToggle?.contains(e.target)) {
      sidebar.classList.remove("show")
    }
  }
}

// Render Functions
function renderProviders(filter = "all") {
  const container = document.getElementById("providersContainer")
  if (!container) return

  const filteredProviders =
    filter === "all" ? certificationProviders : certificationProviders.filter((p) => p.category === filter)

  container.innerHTML = filteredProviders
    .map(
      (provider, index) => `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="provider-card fade-in" data-provider="${provider.name}" >
                <div class="d-flex align-items-center mb-3">
                    <div class="provider-logo ${provider.color}">
                        ${provider.logo}
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">${provider.name}</h5>
                        <p class="small text-muted mb-0">${provider.courses} courses available</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-dark">${provider.courses} Courses</span>
                    <button class="btn btn-sm btn-primary">Explore</button>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

function renderCourses() {
  const container = document.getElementById("coursesContainer")
  if (!container) return

  container.innerHTML = courses
    .map(
      (course, index) => `
        <div class="course-card fade-in" style="animation-delay: ${index * 0.1}s">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h5 class="fw-semibold mb-2">${course.title}</h5>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <span>${course.provider}</span>
                        <span class="mx-2">•</span>
                        <span>${course.duration}</span>
                        <span class="mx-2">•</span>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star text-warning me-1"></i>
                            ${course.rating}
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Progress</span>
                            <span>${course.progress}%</span>
                        </div>
                        <div class="progress progress-bar">
                            <div class="progress-bar ${course.progress === 100 ? "bg-success" : "bg-primary"}" 
                                 style="width: ${course.progress}%"></div>
                        </div>
                    </div>
                </div>
                <div class="ms-3">
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="shareCourse('${course.title}')">
                        <i class="fas fa-share"></i>
                    </button>
                    <button class="btn btn-primary btn-sm continue-course" data-course="${course.title}">
                        ${course.progress === 100 ? "Review" : "Continue"}
                    </button>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

function renderAchievements() {
  const container = document.getElementById("achievementsContainer")
  if (!container) return

  container.innerHTML = achievements
    .map(
      (achievement, index) => `
        <div class="col-md-6 mb-4">
            <div class="achievement-card ${achievement.earned ? "earned" : ""} fade-in">
                <div class="d-flex align-items-start">
                    <div class="achievement-icon ${achievement.earned ? "earned" : "pending"}">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">${achievement.title}</h6>
                        <p class="small text-muted mb-3">${achievement.description}</p>
                        ${
                          achievement.earned
                            ? `<div class="d-flex align-items-center small text-success">
                                <i class="fas fa-calendar me-1"></i>
                                Earned on ${formatDate(achievement.date)}
                            </div>`
                            : `<div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Progress</span>
                                    <span>${achievement.progress}%</span>
                                </div>
                                <div class="progress progress-bar">
                                    <div class="progress-bar bg-info" style="width: ${achievement.progress}%"></div>
                                </div>
                            </div>`
                        }
                    </div>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

function renderStreakDays() {
  const container = document.getElementById("streakContainer")
  if (!container) return

  const streakDays = 7
  container.innerHTML = Array.from({ length: streakDays }, (_, i) => `<div class="streak-day">✓</div>`).join("")
}

function renderFilteredProviders(providers) {
  const container = document.getElementById("providersContainer")
  if (!container) return

  container.innerHTML = providers
    .map(
      (provider, index) => `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="provider-card fade-in" data-provider="${provider.name}" style="animation-delay: ${index * 0.1}s">
                <div class="d-flex align-items-center mb-3">
                    <div class="provider-logo ${provider.color}">
                        ${provider.logo}
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">${provider.name}</h5>
                        <p class="small text-muted mb-0">${provider.courses} courses available</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-dark">${provider.courses} Courses</span>
                    <button class="btn btn-sm btn-primary">Explore</button>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

function renderFilteredCourses(filteredCourses) {
  const container = document.getElementById("coursesContainer")
  if (!container) return

  container.innerHTML = filteredCourses
    .map(
      (course, index) => `
        <div class="course-card fade-in">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h5 class="fw-semibold mb-2">${course.title}</h5>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <span>${course.provider}</span>
                        <span class="mx-2">•</span>
                        <span>${course.duration}</span>
                        <span class="mx-2">•</span>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star text-warning me-1"></i>
                            ${course.rating}
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Progress</span>
                            <span>${course.progress}%</span>
                        </div>
                        <div class="progress progress-bar">
                            <div class="progress-bar ${course.progress === 100 ? "bg-success" : "bg-primary"}" 
                                 style="width: ${course.progress}%"></div>
                        </div>
                    </div>
                </div>
                <div class="ms-3">
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="shareCourse('${course.title}')">
                        <i class="fas fa-share"></i>
                    </button>
                    <button class="btn btn-primary btn-sm continue-course" data-course="${course.title}">
                        ${course.progress === 100 ? "Review" : "Continue"}
                    </button>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

// Utility Functions
function debounce(func, wait) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}

function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" }
  return new Date(dateString).toLocaleDateString(undefined, options)
}

function filterProviders(category) {
  AppState.currentFilter = category
  renderProviders(category)
}

function showNotification(message, type = "success") {
  if (!notification || !notificationText) return

  notificationText.textContent = message
  notification.classList.add("show")

  setTimeout(() => {
    notification.classList.remove("show")
  }, 3000)
}

function showLoading() {
  if (loadingSpinner) {
    loadingSpinner.style.display = "block"
  }
}

function hideLoading() {
  if (loadingSpinner) {
    loadingSpinner.style.display = "none"
  }
}

function updateStats() {
  // Simulate real-time stats updates
  setInterval(() => {
    const learningTime = document.getElementById("learningTime")
    if (learningTime && Math.random() > 0.7) {
      // 30% chance to update
      const currentHours = Number.parseInt(learningTime.textContent)
      learningTime.textContent = `${currentHours + 1}h`
      AppState.userStats.learningTime = currentHours + 1
    }
  }, 30000) // Update every 30 seconds
}

function updateCourseProgress(courseTitle) {
  const courseIndex = courses.findIndex((c) => c.title === courseTitle)
  if (courseIndex !== -1 && courses[courseIndex].progress < 100) {
    courses[courseIndex].progress = Math.min(100, courses[courseIndex].progress + 5)
    renderCourses()

    if (courses[courseIndex].progress === 100) {
      showNotification(`Congratulations! You completed ${courseTitle}!`, "success")
      // Update certificates earned
      const certificatesEarned = document.getElementById("certificatesEarned")
      if (certificatesEarned) {
        const current = Number.parseInt(certificatesEarned.textContent)
        certificatesEarned.textContent = current + 1
        AppState.userStats.certificates = current + 1
      }
    }

    saveProgress()
  }
}

function shareProgress() {
  if (navigator.share) {
    navigator
      .share({
        title: "My Learning Progress - PBCOM",
        text: "Check out my learning achievements on PBCOM Learning Portal!",
        url: window.location.href,
      })
      .catch((err) => {
        console.log("Error sharing:", err)
        fallbackShare()
      })
  } else {
    fallbackShare()
  }
}

function fallbackShare() {
  const url = window.location.href
  if (navigator.clipboard) {
    navigator.clipboard
      .writeText(url)
      .then(() => {
        showNotification("Progress link copied to clipboard!", "success")
      })
      .catch(() => {
        showNotification("Unable to copy link", "error")
      })
  } else {
    showNotification("Sharing not supported on this browser", "info")
  }
}

function shareCourse(courseTitle) {
  showNotification(`Sharing ${courseTitle} with your network...`, "success")
}

function downloadReport() {
  showLoading()

  // Simulate report generation
  setTimeout(() => {
    hideLoading()
    showNotification("Learning report downloaded successfully!", "success")

    // Create and download a simple report
    const reportData = {
      user: "Learning Candidate",
      generatedAt: new Date().toISOString(),
      stats: AppState.userStats,
      courses: courses.map((c) => ({
        title: c.title,
        provider: c.provider,
        progress: c.progress,
        completed: c.progress === 100,
      })),
      achievements: achievements
        .filter((a) => a.earned)
        .map((a) => ({
          title: a.title,
          earnedDate: a.date,
        })),
    }

    const dataStr = JSON.stringify(reportData, null, 2)
    const dataBlob = new Blob([dataStr], { type: "application/json" })
    const url = URL.createObjectURL(dataBlob)
    const link = document.createElement("a")
    link.href = url
    link.download = `pbcom-learning-report-${new Date().toISOString().split("T")[0]}.json`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    URL.revokeObjectURL(url)
  }, 2000)
}

// Data Persistence Functions
function saveProgress() {
  const progressData = {
    courses: courses,
    achievements: achievements,
    userStats: AppState.userStats,
    lastUpdated: new Date().toISOString(),
  }

  try {
    localStorage.setItem("pbcom-learning-progress", JSON.stringify(progressData))
  } catch (error) {
    console.warn("Unable to save progress to localStorage:", error)
  }
}

function loadProgress() {
  try {
    const saved = localStorage.getItem("pbcom-learning-progress")
    if (saved) {
      const data = JSON.parse(saved)

      // Update courses with saved progress
      if (data.courses) {
        courses.forEach((course, index) => {
          if (data.courses[index]) {
            course.progress = data.courses[index].progress
          }
        })
      }

      // Update user stats
      if (data.userStats) {
        AppState.userStats = { ...AppState.userStats, ...data.userStats }
        updateStatsDisplay()
      }

      // Update achievements
      if (data.achievements) {
        achievements.forEach((achievement, index) => {
          if (data.achievements[index]) {
            achievement.earned = data.achievements[index].earned
            achievement.progress = data.achievements[index].progress
          }
        })
      }
    }
  } catch (error) {
    console.warn("Unable to load progress from localStorage:", error)
  }
}

function updateStatsDisplay() {
  const elements = {
    certificatesEarned: document.getElementById("certificatesEarned"),
    coursesCompleted: document.getElementById("coursesCompleted"),
    learningTime: document.getElementById("learningTime"),
    teamRanking: document.getElementById("teamRanking"),
  }

  if (elements.certificatesEarned) {
    elements.certificatesEarned.textContent = AppState.userStats.certificates
  }
  if (elements.coursesCompleted) {
    elements.coursesCompleted.textContent = AppState.userStats.courses
  }
  if (elements.learningTime) {
    elements.learningTime.textContent = `${AppState.userStats.learningTime}h`
  }
  if (elements.teamRanking) {
    elements.teamRanking.textContent = `${AppState.userStats.teamRanking}%`
  }
}

// Auto-save progress periodically
setInterval(saveProgress, 60000) // Save every minute

// Handle page visibility change to save progress when user leaves
document.addEventListener("visibilitychange", () => {
  if (document.visibilityState === "hidden") {
    saveProgress()
  }
})

// Save progress before page unload
window.addEventListener("beforeunload", saveProgress)
