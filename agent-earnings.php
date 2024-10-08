<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/agent-earnings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:05 GMT -->
<head>
	<title>Receitas</title>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Booking - Multipurpose Online Booking Theme">

	<!-- Dark mode -->
	<script>
		const storedTheme = localStorage.getItem('theme')
 
		const getPreferredTheme = () => {
			if (storedTheme) {
				return storedTheme
			}
			return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
		}

		const setTheme = function (theme) {
			if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				document.documentElement.setAttribute('data-bs-theme', 'dark')
			} else {
				document.documentElement.setAttribute('data-bs-theme', theme)
			}
		}

		setTheme(getPreferredTheme())

		window.addEventListener('DOMContentLoaded', () => {
		    var el = document.querySelector('.theme-icon-active');
			if(el != 'undefined' && el != null) {
				const showActiveTheme = theme => {
				const activeThemeIcon = document.querySelector('.theme-icon-active use')
				const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
				const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

				document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
					element.classList.remove('active')
				})

				btnToActive.classList.add('active')
				activeThemeIcon.setAttribute('href', svgOfActiveBtn)
			}

			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
				if (storedTheme !== 'light' || storedTheme !== 'dark') {
					setTheme(getPreferredTheme())
				}
			})

			showActiveTheme(getPreferredTheme())

			document.querySelectorAll('[data-bs-theme-value]')
				.forEach(toggle => {
					toggle.addEventListener('click', () => {
						const theme = toggle.getAttribute('data-bs-theme-value')
						localStorage.setItem('theme', theme)
						setTheme(theme)
						showActiveTheme(theme)
					})
				})

			}
		})
		
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Poppins:wght@400;500;700&amp;display=swap">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/apexcharts/css/apexcharts.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/choices/css/choices.min.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>

<!-- Header START -->
<header class="navbar-light header-sticky">
	<!-- Logo Nav START -->
	<nav class="navbar sidebar navbar-expand-xl navbar-light">
		<!-- Navbar brand for xl START -->
		<div class="d-flex align-items-center">
			<a class="navbar-brand" href="index.php">
				<img class="light-mode-item navbar-brand-item" src="assets/images/logo.svg" alt="logo">
				<img class="dark-mode-item navbar-brand-item" src="assets/images/logo-light.svg" alt="logo">
			</a>
		</div>
		<!-- Navbar brand for xl END -->
		
		<div class="offcanvas offcanvas-start flex-row custom-scrollbar h-100" data-bs-backdrop="true" tabindex="-1" id="offcanvasSidebar">
			<div class="offcanvas-body sidebar-content d-flex flex-column pt-4">
	
				<!-- Sidebar menu START -->
				<ul class="navbar-nav flex-column" id="navbar-sidebar">
					<!-- Menu item -->
					<li class="nav-item"><a href="index.php" class="nav-link active">Dashboard</a></li>

					<!-- Title -->
					<li class="nav-item ms-2 my-2">Pages</li>

					
	
				

					
					<li class="nav-item"> <a class="nav-link" href="admin-booking-list.php">Booking List</a></li>
					<li class="nav-item"> <a class="nav-link" href="admin-booking-detail.php">Booking Detail</a></li>
					<!-- Menu item -->
					<li class="nav-item"> <a class="nav-link" href="admin-earnings.php">Receitas</a></li>
	
				
		
				
			</div>
		</div>
	</nav>
	<!-- Logo Nav END -->
</header>
<!-- Header END -->

<!-- **************** MAIN CONTENT START **************** -->
<main>

<!-- =======================
Menu item START -->
<section class="pt-4">
	<div class="container">
		<div class="card rounded-3 border p-3 pb-2">
			<!-- Avatar and info START -->
			<div class="d-sm-flex align-items-center">
				<div class="avatar avatar-xl mb-2 mb-sm-0">
					<img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
				</div>
				<h4 class="mb-2 mb-sm-0 ms-sm-3"><span class="fw-light">Hi</span> Jacqueline Miller</h4>
				<a href="add-listing.html" class="btn btn-sm btn-primary-soft mb-0 ms-auto flex-shrink-0"><i class="bi bi-plus-lg fa-fw me-2"></i>Add New Listing</a>
			</div>
			<!-- Avatar and info START -->
			
			<!-- Responsive navbar toggler -->
			<button class="btn btn-primary w-100 d-block d-xl-none mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#dashboardMenu" aria-controls="dashboardMenu">
				<i class="bi bi-list"></i> Dashboard Menu
			</button>

			<!-- Nav links START -->
			<div class="offcanvas-xl offcanvas-end mt-xl-3" tabindex="-1" id="dashboardMenu">
				<div class="offcanvas-header border-bottom p-3">
					<h5 class="offcanvas-title">Menu</h5>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#dashboardMenu" aria-label="Close"></button>
				</div>
				<!-- Offcanvas body -->
				<div class="offcanvas-body p-3 p-xl-0">
					<!-- Nav item -->
					<div class="navbar navbar-expand-xl">
						<ul class="navbar-nav navbar-offcanvas-menu">

							<li class="nav-item"> <a class="nav-link" href="agent-dashboard.html"><i class="bi bi-house-door fa-fw me-1"></i>Dashboard</a>	</li>

							<li class="nav-item"> <a class="nav-link" href="agent-listings.html"><i class="bi bi-journals fa-fw me-1"></i>Listings</a> </li>

							<li class="nav-item"> <a class="nav-link" href="agent-bookings.html"><i class="bi bi-bookmark-heart fa-fw me-1"></i>Bookings</a> </li>

							<li class="nav-item"> <a class="nav-link" href="agent-activities.html"><i class="bi bi-bell fa-fw me-1"></i>Activities</a> </li>
		
							<li class="nav-item"> <a class="nav-link active" href="agent-earnings.html"><i class="bi bi-graph-up-arrow fa-fw me-1"></i>Earnings</a>	</li>

							<li class="nav-item"> <a class="nav-link" href="agent-reviews.html"><i class="bi bi-star fa-fw me-1"></i>Reviews</a></li>

							<li class="nav-item"> <a class="nav-link" href="agent-settings.html"><i class="bi bi-gear fa-fw me-1"></i>Settings</a></li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="dropdoanMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="bi bi-list-ul fa-fw me-1"></i>Dropdown
								</a>
								<ul class="dropdown-menu" aria-labelledby="dropdoanMenu">
									<!-- Dropdown menu -->
									<li> <a class="dropdown-item" href="#">Item 1</a></li>
									<li> <a class="dropdown-item" href="#">Item 2</a></li>
								</ul>
							</li>	
						</ul>
					</div>
				</div>
			</div>
			<!-- Nav links END -->
		</div>
	</div>
</section>
<!-- =======================
Menu item END -->
	
<!-- =======================
Content START -->
<section class="pt-0">
	<div class="container vstack gap-4">
		<!-- Title START -->
		<div class="row">
			<div class="col-12">
				<h1 class="fs-4 mb-0"><i class="bi bi-graph-up-arrow fa-fw me-1"></i>Earnings</h1>
			</div>
		</div>	
		<!-- Title END -->

		<!-- Counter START -->
		<div class="row g-4">
			
			<!-- Earning item -->
			<div class="col-md-6 col-lg-3">
				<div class="card card-body border p-4 h-100">
					<h6 class="mb-0">Sales this month</h6>
					<h3 class="mb-2 mt-2">$12,825</h3>
					<a href="#" class="mt-auto">View transaction</a>
				</div>
			</div>

			<!-- Grid item -->
			<div class="col-md-6 col-lg-3">
				<div class="card card-body border p-4 h-100">
					<h6>To be paid
						<a tabindex="0" class="h6 mb-0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="top" data-bs-content="After US royalty withholding tax">
							<i class="bi bi-info-circle-fill small"></i>
						</a>
					</h6>
					<h3>$15,356</h3>
					<p class="mb-0 mt-auto">Expected payout on 05/10/2022</p>
				</div>
			</div>

			<!-- Grid item -->
			<div class="col-lg-6">
				<div class="card bg-primary p-4">
						<div class="d-flex justify-content-between align-items-start text-white">
							<img class="w-40px" src="assets/images/element/visa.svg" alt="">
							<!-- Card action START -->
							<div class="dropdown">
								<a class="text-white" href="#" id="creditcardDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
									<!-- Dropdown Icon -->
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle fill="currentColor" cx="12.5" cy="3.5" r="2.5"></circle>
										<circle fill="currentColor" opacity="0.5" cx="12.5" cy="11.5" r="2.5"></circle>
										<circle fill="currentColor" opacity="0.3" cx="12.5" cy="19.5" r="2.5"></circle>
									</svg>
								</a>               
								<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="creditcardDropdown">
									<li><a class="dropdown-item" href="#"><i class="bi bi-credit-card-2-front-fill me-2 fw-icon"></i>Edit card</a></li>
									<li><a class="dropdown-item" href="#"><i class="bi bi-credit-card me-2 fw-icon"></i>Add new card</a></li>
									<li><a class="dropdown-item" href="#"><i class="bi bi-arrow-bar-down me-2 fw-icon"></i>Withdrawal money</a></li>
									<li><a class="dropdown-item" href="#"><i class="bi bi-calculator me-2 fw-icon"></i>Currency converter</a></li>
								</ul>
							</div>
							<!-- Card action END -->
						</div>
						<div class="mt-4 text-white">
							<span>Total Balance</span>
							<h3 class="text-white mb-0">$32,000</h3>
						</div>
						<h5 class="text-white mt-4">**** **** **** 1569</h5>
						<div class="d-flex justify-content-between text-white">
							<span>Valid thru: 12/26</span>
							<span>CVV: ***</span>
						</div>
				</div>
			</div>

		</div>
		<!-- Counter END -->

		<!-- Chart START -->
		<div class="row">
			<div class="col-12">
				<div class="card card-body border overflow-hidden">
					<div class="row g-4">
						<!-- Content -->
						<div class="col-sm-6 col-md-4">
							<span class="badge text-bg-dark">Current Month</span>
							<h4 class="text-primary my-2">$35000</h4>
							<p class="mb-0"><span class="text-success me-1">0.20%<i class="bi bi-arrow-up"></i></span>vs last month</p>
						</div>

						<!-- Content -->
						<div class="col-sm-6 col-md-4">
							<span class="badge text-bg-dark">Last Month</span>
							<h4 class="my-2">$28000</h4>
							<p class="mb-0"><span class="text-danger me-1">0.10%<i class="bi bi-arrow-down"></i></span>Then last month</p>
						</div>
					</div>

					<!-- Apex chart -->
					<div id="apexChartTrafficStats"></div>
				</div>
			</div> 
		</div>	
		<!-- Chart START -->

		<!-- Invoice history START -->
		<div class="row">
			<div class="col-12">
				<div class="card border rounded-3">
					<!-- Card header START -->
					<div class="card-header border-bottom">
						<h5 class="card-header-title">Invoice history</h5>
					</div>
					<!-- Card header END -->

					<!-- Card body START -->
					<div class="card-body">
						<!-- Search and select START -->
						<div class="row g-3 align-items-center justify-content-between mb-3">
							<!-- Search -->
							<div class="col-md-8">
								<form class="rounded position-relative">
									<input class="form-control pe-5" type="search" placeholder="Search" aria-label="Search">
									<button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6"></i></button>
								</form>
							</div>

							<!-- Select option -->
							<div class="col-md-3">
								<!-- Short by filter -->
								<form>
									<select class="form-select js-choice" aria-label=".form-select-sm">
										<option value="">Sort by</option>
										<option>Free</option>
										<option>Newest</option>
										<option>Oldest</option>
									</select>
								</form>
							</div>
						</div>
						<!-- Search and select END -->

						<!-- Hotel room list START -->
						<div class="table-responsive border-0">
							<table class="table align-middle p-4 mb-0 table-hover table-shrink">
								<!-- Table head -->
								<thead class="table-light">
									<tr>
										<th scope="col" class="border-0 rounded-start">Invoice ID</th>
										<th scope="col" class="border-0">Date</th>
										<th scope="col" class="border-0">Amount</th>
										<th scope="col" class="border-0">Status</th>
										<th scope="col" class="border-0 rounded-end">Action</th>
									</tr>
								</thead>

								<!-- Table body START -->
								<tbody class="border-top-0">
									<!-- Table item -->
									<tr>
										<td> #254684 </td>
										<td> 29 Aug 2022 </td>
										<td>$3,999
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare1" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->
											<ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare1">
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Commission</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
	
												<li>
													<div class="d-flex justify-content-between">
														<span class="me-4 small">Us royalty withholding</span>
														<span class="text-danger small">-$0.00</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
												
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Earning</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
												</li>
											</ul>
										</td>
										<td> <div class="badge bg-success bg-opacity-10 text-success">Paid</div> </td>
										<td> <a href="#" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download"><i class="bi bi-cloud-download"></i></a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td> #158468 </td>
										<td> 02 Sep 2022 </td>
										<td>$3,000
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare5" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->
											<ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare5">
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Commission</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
	
												<li>
													<div class="d-flex justify-content-between">
														<span class="me-4 small">Us royalty withholding</span>
														<span class="text-danger small">-$0.00</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
												
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Earning</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
												</li>
											</ul>
										</td>
										<td> <div class="badge bg-orange bg-opacity-10 text-orange">Pending</div> </td>
										<td> <a href="#" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download"><i class="bi bi-cloud-download"></i></a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td> #245778 </td>
										<td> 05 Sep 2022 </td>
										<td>$4,258
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare2" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->
											<ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare2">
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Commission</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
	
												<li>
													<div class="d-flex justify-content-between">
														<span class="me-4 small">Us royalty withholding</span>
														<span class="text-danger small">-$0.00</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
												
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Earning</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
												</li>
											</ul>
										</td>
										<td> <div class="badge bg-success bg-opacity-10 text-success">Paid</div> </td>
										<td> <a href="#" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download"><i class="bi bi-cloud-download"></i></a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td> #245778 </td>
										<td> 07 Sep 2022 </td>
										<td>$1,225
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare3" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->
											<ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare3">
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Commission</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
	
												<li>
													<div class="d-flex justify-content-between">
														<span class="me-4 small">Us royalty withholding</span>
														<span class="text-danger small">-$0.00</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
												
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Earning</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
												</li>
											</ul>
										</td>
										<td> <div class="badge bg-danger bg-opacity-10 text-danger">Cancelled</div> </td>
										<td> <a href="#" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download"><i class="bi bi-cloud-download"></i></a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td> #254896 </td>
										<td> 10 Sep 2022 </td>
										<td>$2,588
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare4" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->
											<ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare4">
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Commission</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
	
												<li>
													<div class="d-flex justify-content-between">
														<span class="me-4 small">Us royalty withholding</span>
														<span class="text-danger small">-$0.00</span>
													</div>
													<hr class="my-1"> <!-- Divider -->
												</li>
												
												<li>
													<div class="d-flex justify-content-between">
														<span class="small">Earning</span>
														<span class="h6 mb-0 small">$86</span>
													</div>
												</li>
											</ul>
										</td>
										<td> <div class="badge bg-success bg-opacity-10 text-success">Paid</div> </td>
										<td> <a href="#" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download"><i class="bi bi-cloud-download"></i></a> </td>
									</tr>
								</tbody>
								<!-- Table body END -->
							</table>
						</div>
						<!-- Hotel room list END -->
					</div>
					<!-- Card body END -->

					<!-- Card footer START -->
					<div class="card-footer pt-0">
						<!-- Pagination and content -->
						<div class="d-sm-flex justify-content-sm-between align-items-sm-center">
							<!-- Content -->
							<p class="mb-sm-0 text-center text-sm-start">Showing 1 to 8 of 20 entries</p>
							<!-- Pagination -->
							<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
								<ul class="pagination pagination-sm pagination-primary-soft mb-0">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1">Prev</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item active"><a class="page-link" href="#">2</a></li>
									<li class="page-item disabled"><a class="page-link" href="#">..</a></li>
									<li class="page-item"><a class="page-link" href="#">15</a></li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!-- Card footer END -->
				</div>
			</div>
		</div>
		<!-- Invoice history END -->
	</div>
</section>
<!-- =======================
Content END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
Footer START -->
<footer class="bg-dark p-3">
	<div class="container">
		<div class="row align-items-center">

			<!-- Widget -->
			<div class="col-md-4">
				<div class="text-center text-md-start mb-3 mb-md-0">
					<a href="index-2.html"> <img class="h-30px" src="assets/images/logo-light.svg" alt="logo"> </a>
				</div> 
			</div>
			
			<!-- Widget -->
			<div class="col-md-4">
				<div class="text-body-secondary text-primary-hover"> Copyrights ©2024 Booking. Build by <a href="https://www.webestica.com/" class="text-body-secondary">Webestica</a>. </div>
			</div>

			<!-- Widget -->
			<div class="col-md-4">
				<ul class="list-inline mb-0 text-center text-md-end">
					<li class="list-inline-item ms-2"><a href="#"><i class="text-white fab fa-facebook"></i></a></li>
					<li class="list-inline-item ms-2"><a href="#"><i class="text-white fab fa-instagram"></i></a></li>
					<li class="list-inline-item ms-2"><a href="#"><i class="text-white fab fa-linkedin-in"></i></a></li>
					<li class="list-inline-item ms-2"><a href="#"><i class="text-white fab fa-twitter"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<!-- =======================
Footer END -->

<!-- Back to top -->
<div class="back-top"></div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/apexcharts/js/apexcharts.min.js"></script>
<script src="assets/vendor/choices/js/choices.min.js"></script>

<!-- ThemeFunctions -->
<script src="assets/js/functions.js"></script>

</body>

<!-- Mirrored from booking.webestica.com/agent-earnings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:05 GMT -->
</html>