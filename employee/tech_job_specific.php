<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PBCom Dashboard</title>
	<link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
	<script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>


	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<!-- Font Awesome for icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="../assets/css/courses.css">
</head>

<body>
	<div class="wrapper">
		<!-- Header -->
		<?php include 'topbar.php' ?>

		<div class="content-wrapper">
			<!-- Sidebar -->
			 <?php include 'sidebar.php' ?>

			<!-- Main Content -->
			<main class="main-content">
				<div class="container-fluid">
					<!-- Mobile Search -->
					<div class="mobile-search d-md-none mb-4">
						<div class="input-group">
							<span class="input-group-text bg-transparent">
								<i class="fas fa-search"></i>
							</span>
							<input type="text" class="form-control" placeholder="Search courses...">
						</div>
					</div>
					&nbsp;
					&nbsp;
					&nbsp;
					<!-- Page Header -->
					<div class="page-header mb-4">
						<div class="d-flex justify-content-between align-items-center">
							<h1 class="page-title">Technical/Job Specific Systems</h1>
							<span class="badge mandatory-badge">Mandatory Training</span>
						</div>
						<p class="text-muted mt-2">
							Complete these required courses to ensure compliance with banking regulations
						</p>
					</div>

					<!-- Course Grid -->
					<div class="row g-4">
						<!-- Core Banking System -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-red">
									<div class="course-icon">
										<i class="fas fa-money-bill-wave"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">Core Banking System</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										Mastering our primary banking platform
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 2 hours</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Loan Processing -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-blue">
									<div class="course-icon">
										<i class="fas fa-shield-alt"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">Loan Processing</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										End-to-end loan application workflow
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 1.5 hours</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- CRM System -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-purple">
									<div class="course-icon">
										<i class="fas fa-lock"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">CRM System</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										Customer relationship management tools
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 1 hour</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Fraud Detection Systems -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-green">
									<div class="course-icon">
										<i class="fas fa-users"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">Fraud Detection Systems</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										Using technology to identify fraud
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 1.5 hours</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Data Analytics Tools -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-amber">
									<div class="course-icon">
										<i class="fas fa-exclamation-triangle"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">Data Analytics Tools</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										Business intelligence for banking
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 2 hours</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Compliance Reporting -->
						<div class="col-md-6 col-lg-4">
							<div class="course-card">
								<div class="course-image bg-gradient-slate">
									<div class="course-icon">
										<i class="fas fa-chart-pie"></i>
									</div>
								</div>
								<div class="course-content">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<h3 class="course-title">Compliance Reporting</h3>
										<span class="badge required-badge">Required</span>
									</div>
									<p class="course-description">
										Automated regulatory reporting systems
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="course-duration">Duration: 2.5 hours</div>
										<button class="btn btn-link start-course-btn">
											Start Course <i class="fas fa-chevron-right ms-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Pagination -->
					<div class="pagination-container mt-5">
						<nav aria-label="Page navigation">
							<ul class="pagination justify-content-center">
								<li class="page-item active">
									<a class="page-link" href="#">1</a>
								</li>
								<li class="page-item">
									<a class="page-link" href="#">2</a>
								</li>
								<li class="page-item">
									<a class="page-link" href="#">
										<i class="fas fa-chevron-right"></i>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>

				<!-- Footer -->
				<?php include '../footer.php' ?>
			</main>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

	<!-- SweetAlert 2 CDN -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Custom JS -->
	<script src="../assets/js/script.js"></script>
	<script src="../assets/js/sidebar.js"></script>
</body>

</html>