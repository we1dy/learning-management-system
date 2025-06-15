document.addEventListener("DOMContentLoaded", () => {
  // Initialize tooltips and popovers
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))

  // Load saved settings from localStorage
  loadSavedSettings()

  // Save settings button click handler
  document.getElementById("saveSettings").addEventListener("click", () => {
    saveAllSettings()

    // Show success toast
    const toast = new bootstrap.Toast(document.getElementById("settingsSavedToast"))
    toast.show()
  })

  // Password strength meter
  const newPasswordInput = document.getElementById("newPassword")
  const confirmPasswordInput = document.getElementById("confirmPassword")
  const passwordStrength = document.getElementById("passwordStrength")
  const passwordFeedback = document.getElementById("passwordFeedback")

  if (newPasswordInput) {
    newPasswordInput.addEventListener("input", function () {
      updatePasswordStrength(this.value)
      validatePasswordMatch()
    })
  }

  if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener("input", validatePasswordMatch)
  }

  // Change password button handler
  const changePasswordBtn = document.getElementById("changePasswordBtn")
  if (changePasswordBtn) {
    changePasswordBtn.addEventListener("click", () => {
      const currentPassword = document.getElementById("currentPassword").value
      const newPassword = document.getElementById("newPassword").value
      const confirmPassword = document.getElementById("confirmPassword").value

      if (!currentPassword || !newPassword || !confirmPassword) {
        alert("Please fill in all password fields")
        return
      }

      if (newPassword !== confirmPassword) {
        alert("New passwords do not match")
        return
      }

      // Simulate password change
      alert("Password changed successfully!")

      // Close modal
      const passwordModal = bootstrap.Modal.getInstance(document.getElementById("passwordModal"))
      passwordModal.hide()

      // Reset form
      document.getElementById("passwordForm").reset()
      passwordStrength.style.width = "0%"
      passwordStrength.className = "progress-bar"
      passwordFeedback.textContent = ""
    })
  }

  // Logout from all devices button handler
  const logoutAllDevicesBtn = document.getElementById("logoutAllDevices")
  if (logoutAllDevicesBtn) {
    logoutAllDevicesBtn.addEventListener("click", () => {
      if (confirm("Are you sure you want to log out from all devices?")) {
        alert("You have been logged out from all devices")
      }
    })
  }

  // Save privacy settings button handler
  const savePrivacySettingsBtn = document.getElementById("savePrivacySettings")
  if (savePrivacySettingsBtn) {
    savePrivacySettingsBtn.addEventListener("click", () => {
      // Save privacy settings to localStorage
      const privacySettings = {
        collectLearningData: document.getElementById("collectLearningData").checked,
        collectUsageData: document.getElementById("collectUsageData").checked,
        profileVisibility: document.querySelector('input[name="profileVisibility"]:checked').id,
        shareCertifications: document.getElementById("shareCertifications").checked,
        shareAchievements: document.getElementById("shareAchievements").checked,
      }

      localStorage.setItem("pbcomPrivacySettings", JSON.stringify(privacySettings))

      // Show success toast
      const toast = new bootstrap.Toast(document.getElementById("settingsSavedToast"))
      toast.show()
    })
  }

  // Mobile sidebar toggle
  const sidebarToggleBtn = document.createElement("button")
  sidebarToggleBtn.className = "btn btn-sm btn-outline-light d-md-none"
  sidebarToggleBtn.innerHTML = '<i class="bi bi-list"></i>'
  sidebarToggleBtn.style.position = "fixed"
  sidebarToggleBtn.style.bottom = "20px"
  sidebarToggleBtn.style.right = "20px"
  sidebarToggleBtn.style.zIndex = "1000"
  sidebarToggleBtn.style.borderRadius = "50%"
  sidebarToggleBtn.style.width = "45px"
  sidebarToggleBtn.style.height = "45px"
  sidebarToggleBtn.style.padding = "0"
  sidebarToggleBtn.style.display = "flex"
  sidebarToggleBtn.style.alignItems = "center"
  sidebarToggleBtn.style.justifyContent = "center"
  sidebarToggleBtn.style.backgroundColor = "#dc3545"
  sidebarToggleBtn.style.borderColor = "#dc3545"

  document.body.appendChild(sidebarToggleBtn)

  sidebarToggleBtn.addEventListener("click", () => {
    const sidebar = document.querySelector(".sidebar")
    sidebar.classList.toggle("show")
  })

  // Handle responsive behavior
  function handleResponsive() {
    const sidebar = document.querySelector(".sidebar")
    if (window.innerWidth < 768) {
      sidebar.classList.remove("show")
      sidebarToggleBtn.style.display = "flex"
    } else {
      sidebarToggleBtn.style.display = "none"
    }
  }

  window.addEventListener("resize", handleResponsive)
  handleResponsive()
})

// Password strength meter function
function updatePasswordStrength(password) {
  const passwordStrength = document.getElementById("passwordStrength")
  const passwordFeedback = document.getElementById("passwordFeedback")

  // Reset
  passwordStrength.className = "progress-bar"

  if (!password) {
    passwordStrength.style.width = "0%"
    passwordFeedback.textContent = ""
    return
  }

  // Check password strength
  let strength = 0

  // Length check
  if (password.length >= 8) {
    strength += 25
  }

  // Contains lowercase
  if (/[a-z]/.test(password)) {
    strength += 25
  }

  // Contains uppercase
  if (/[A-Z]/.test(password)) {
    strength += 25
  }

  // Contains number or special char
  if (/[0-9!@#$%^&*(),.?":{}|<>]/.test(password)) {
    strength += 25
  }

  // Update UI
  passwordStrength.style.width = strength + "%"

  if (strength < 50) {
    passwordStrength.classList.add("bg-danger")
    passwordFeedback.textContent = "Weak password"
    passwordFeedback.className = "form-text text-danger"
  } else if (strength < 75) {
    passwordStrength.classList.add("bg-warning")
    passwordFeedback.textContent = "Moderate password"
    passwordFeedback.className = "form-text text-warning"
  } else {
    passwordStrength.classList.add("bg-success")
    passwordFeedback.textContent = "Strong password"
    passwordFeedback.className = "form-text text-success"
  }
}

// Validate password match
function validatePasswordMatch() {
  const newPassword = document.getElementById("newPassword").value
  const confirmPassword = document.getElementById("confirmPassword").value

  if (!confirmPassword) {
    return
  }

  if (newPassword !== confirmPassword) {
    confirmPassword.setCustomValidity("Passwords do not match")
    document.getElementById("confirmPassword").classList.add("is-invalid")
  } else {
    confirmPassword.setCustomValidity("")
    document.getElementById("confirmPassword").classList.remove("is-invalid")
  }
}

// Save all settings to localStorage
function saveAllSettings() {
  // Notification settings
  const notificationSettings = {
    emailNotifications: document.getElementById("emailNotifications").checked,
    pushNotifications: document.getElementById("pushNotifications").checked,
    notificationFrequency: document.querySelector('input[name="notificationFrequency"]:checked').value,
  }

  // Learning preferences
  const learningPreferences = {
    autoplayVideos: document.getElementById("autoplayVideos").checked,
    previewAutoplay: document.getElementById("previewAutoplay").checked,
    learningTrack: document.getElementById("learningTrack").value,
    learningPace: document.getElementById("learningPace").value,
    formatVideo: document.getElementById("formatVideo").checked,
    formatReading: document.getElementById("formatReading").checked,
    formatInteractive: document.getElementById("formatInteractive").checked,
    formatQuizzes: document.getElementById("formatQuizzes").checked,
  }

  // Language settings
  const languageSettings = {
    interfaceLanguage: document.getElementById("interfaceLanguage").value,
    contentLanguage: document.getElementById("contentLanguage").value,
    closedCaptions: document.getElementById("closedCaptions").checked,
    highContrast: document.getElementById("highContrast").checked,
    screenReader: document.getElementById("screenReader").checked,
  }

  // Security settings
  const securitySettings = {
    twoFactorAuth: document.getElementById("twoFactorAuth").checked,
    autoLogout: document.getElementById("autoLogout").value,
  }

  // Save to localStorage
  localStorage.setItem("pbcomNotificationSettings", JSON.stringify(notificationSettings))
  localStorage.setItem("pbcomLearningPreferences", JSON.stringify(learningPreferences))
  localStorage.setItem("pbcomLanguageSettings", JSON.stringify(languageSettings))
  localStorage.setItem("pbcomSecuritySettings", JSON.stringify(securitySettings))

  console.log("All settings saved to localStorage")
}

// Load saved settings from localStorage
function loadSavedSettings() {
  // Notification settings
  try {
    const notificationSettings = JSON.parse(localStorage.getItem("pbcomNotificationSettings"))
    if (notificationSettings) {
      document.getElementById("emailNotifications").checked = notificationSettings.emailNotifications
      document.getElementById("pushNotifications").checked = notificationSettings.pushNotifications

      const frequencyRadio = document.querySelector(
        `input[name="notificationFrequency"][value="${notificationSettings.notificationFrequency}"]`,
      )
      if (frequencyRadio) {
        frequencyRadio.checked = true
      }
    }
  } catch (e) {
    console.error("Error loading notification settings", e)
  }

  // Learning preferences
  try {
    const learningPreferences = JSON.parse(localStorage.getItem("pbcomLearningPreferences"))
    if (learningPreferences) {
      document.getElementById("autoplayVideos").checked = learningPreferences.autoplayVideos
      document.getElementById("previewAutoplay").checked = learningPreferences.previewAutoplay
      document.getElementById("learningTrack").value = learningPreferences.learningTrack
      document.getElementById("learningPace").value = learningPreferences.learningPace
      document.getElementById("formatVideo").checked = learningPreferences.formatVideo
      document.getElementById("formatReading").checked = learningPreferences.formatReading
      document.getElementById("formatInteractive").checked = learningPreferences.formatInteractive
      document.getElementById("formatQuizzes").checked = learningPreferences.formatQuizzes
    }
  } catch (e) {
    console.error("Error loading learning preferences", e)
  }

  // Language settings
  try {
    const languageSettings = JSON.parse(localStorage.getItem("pbcomLanguageSettings"))
    if (languageSettings) {
      document.getElementById("interfaceLanguage").value = languageSettings.interfaceLanguage
      document.getElementById("contentLanguage").value = languageSettings.contentLanguage
      document.getElementById("closedCaptions").checked = languageSettings.closedCaptions
      document.getElementById("highContrast").checked = languageSettings.highContrast
      document.getElementById("screenReader").checked = languageSettings.screenReader

      // Apply high contrast if enabled
      if (languageSettings.highContrast) {
        document.body.classList.add("high-contrast")
      }
    }
  } catch (e) {
    console.error("Error loading language settings", e)
  }

  // Security settings
  try {
    const securitySettings = JSON.parse(localStorage.getItem("pbcomSecuritySettings"))
    if (securitySettings) {
      document.getElementById("twoFactorAuth").checked = securitySettings.twoFactorAuth
      document.getElementById("autoLogout").value = securitySettings.autoLogout
    }
  } catch (e) {
    console.error("Error loading security settings", e)
  }

  // Privacy settings
  try {
    const privacySettings = JSON.parse(localStorage.getItem("pbcomPrivacySettings"))
    if (privacySettings) {
      document.getElementById("collectLearningData").checked = privacySettings.collectLearningData
      document.getElementById("collectUsageData").checked = privacySettings.collectUsageData

      const visibilityRadio = document.getElementById(privacySettings.profileVisibility)
      if (visibilityRadio) {
        visibilityRadio.checked = true
      }

      document.getElementById("shareCertifications").checked = privacySettings.shareCertifications
      document.getElementById("shareAchievements").checked = privacySettings.shareAchievements
    }
  } catch (e) {
    console.error("Error loading privacy settings", e)
  }
}

// Auto logout timer
let logoutTimer

function resetLogoutTimer() {
  clearTimeout(logoutTimer)

  const securitySettings = JSON.parse(localStorage.getItem("pbcomSecuritySettings")) || {}
  const autoLogoutValue = securitySettings.autoLogout || "30"

  if (autoLogoutValue !== "never") {
    const timeoutMinutes = Number.parseInt(autoLogoutValue, 10)
    logoutTimer = setTimeout(
      () => {
        alert("You have been logged out due to inactivity")
        // In a real app, you would redirect to login page
      },
      timeoutMinutes * 60 * 1000,
    )
  }
}
// Reset timer on user activity
;["click", "mousemove", "keypress", "scroll", "touchstart"].forEach((evt) => {
  document.addEventListener(evt, resetLogoutTimer, false)
})

// Initialize logout timer
resetLogoutTimer()
