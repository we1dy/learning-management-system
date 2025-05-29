<header class="header">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col d-flex align-items-center">
				<button id="sidebar-toggle" class="btn btn-link text-white d-md-none me-2">
					<i class="bi bi-list"></i>
				</button>
				<div class="logo">
					<img src="assets/images/logo.png" width="180px" alt="PBCOM Logo" class="img-fluid">
				</div>
			</div>
			<div class="col-auto d-flex align-items-center">
				<div class="search-container d-none d-md-block me-3">
					<i class="bi bi-search search-icon"></i>
					<input type="text" class="form-control search-input" placeholder="Search...">
				</div>
				<div class="notification-bell  position-relative">
					<i class="bi bi-bell"></i>
					<span class="notification-indicator"></span>
				</div>
				<div class="notification-bell position-relative">
					<a href="employee_message.php" style="text-decoration:none;">
						<i class="fa fa-message"></i>
					</a>
				</div>
				<div class="dropdown">
					<div class="user-profile d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<div class="avatar me-2">
							<span>LC</span>
						</div>
						<i class="bi bi-chevron-down"></i>
					</div>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
						<li><a class="dropdown-item" href="employee_profile.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="bi bi-person me-2"></i>Profile</a></li>
						<li><a class="dropdown-item" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>