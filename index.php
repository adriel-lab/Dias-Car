<?php

// Função para obter a conexão com o banco de dados
function getDbConnection()
{
	$dbname = 'crud/oficina_mecanica.db';
	try {
		$conn = new PDO("sqlite:" . $dbname);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (PDOException $e) {
		handleException($e);
		return null;
	}
}

// Função para lidar com exceções
function handleException($e)
{
	echo "Erro: " . $e->getMessage();
}

try {
	// Obtenha uma conexão com o banco de dados
	$conn = getDbConnection();

	// Consulta SQL para contar o número de clientes
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM clientes");
	$totalClientes = $stmt->fetchColumn();

	// Exibir o total de clientes
	// echo "Total de clientes: " . $totalClientes;

	// Obter o ano atual
	$anoAtual = date("Y");

	// Consulta SQL para calcular o valor total dos serviços no ano atual
	$sql = "SELECT SUM(valor) AS total FROM servicos WHERE strftime('%Y', data) = :anoAtual";
	$stmt = $conn->prepare($sql);
	$stmt->execute([':anoAtual' => $anoAtual]);
	$totalServicosAnoAtual = $stmt->fetchColumn();

	if ($totalServicosAnoAtual  === null) {
		$totalServicosAnoAtual  = 0;
	}
	// Exibir o total dos serviços realizados no ano atual
	// echo "Valor total dos serviços realizados no ano atual: " . $totalServicosAnoAtual;

	// Obter o primeiro dia do mês atual
	$primeiroDiaMesAtual = date('Y-m-01');

	// Obter o último dia do mês atual
	$ultimoDiaMesAtual = date('Y-m-t');

	// Consulta SQL para calcular o valor total dos serviços no intervalo do mês atual
	$sql = "SELECT SUM(valor) AS total FROM servicos WHERE data BETWEEN :primeiroDiaMesAtual AND :ultimoDiaMesAtual";
	$stmt = $conn->prepare($sql);
	$stmt->execute([':primeiroDiaMesAtual' => $primeiroDiaMesAtual, ':ultimoDiaMesAtual' => $ultimoDiaMesAtual]);
	$totalServicosMesAtual = $stmt->fetchColumn();

	if ($totalServicosMesAtual  === null) {
		$totalServicosMesAtual  = 0;
	}

	// Exibir o total dos serviços realizados no mês atual
	// echo "Valor total dos serviços realizados no mês atual: " . $totalServicosMesAtual;

	// Obter a data atual
	$dataAtual = date('Y-m-d');

	// Consulta SQL para contar a quantidade de serviços cadastrados para hoje
	$sql = "SELECT COUNT(*) AS quantidade FROM servicos WHERE data = :dataAtual";
	$stmt = $conn->prepare($sql);
	$stmt->execute([':dataAtual' => $dataAtual]);
	$quantidadeServicosHoje = $stmt->fetchColumn();

	// Se não houver serviços para hoje, definir a quantidade como 0
	if ($quantidadeServicosHoje === null) {
		$quantidadeServicosHoje = 0;
	}

	// Exibir a quantidade de serviços cadastrados para hoje
	// echo "Quantidade de serviços cadastrados para hoje: " . $quantidadeServicosHoje;

} catch (PDOException $e) {
	// Trate erros de conexão
	handleException($e);
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/admin-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:06 GMT -->

<head>
	<title>Dias Car</title>

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

		const setTheme = function(theme) {
			if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				document.documentElement.setAttribute('data-bs-theme', 'dark')
			} else {
				document.documentElement.setAttribute('data-bs-theme', theme)
			}
		}

		setTheme(getPreferredTheme())

		window.addEventListener('DOMContentLoaded', () => {
			var el = document.querySelector('.theme-icon-active');
			if (el != 'undefined' && el != null) {
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
	<link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/overlayscrollbars.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/apexcharts/css/apexcharts.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>

	<!-- **************** MAIN CONTENT START **************** -->
	<main>

		<!-- Sidebar START -->
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
						<li class="nav-item ms-2 my-2">Paginas</li>






						<li class="nav-item"> <a class="nav-link" href="admin-booking-list.php">Serviços</a></li>
						<li class="nav-item"> <a class="nav-link" href="account-bookings.php">Cadastros</a></li>
						<!-- Menu item -->
						<li class="nav-item"> <a class="nav-link" href="admin-earnings.php">Receitas</a></li>




				</div>
			</div>
		</nav>
		<!-- Sidebar END -->

		<!-- Page content START -->
		<div class="page-content">

			<!-- Top bar START -->
			<nav class="navbar top-bar navbar-light py-0 py-xl-3">
				<div class="container-fluid p-0">
					<div class="d-flex align-items-center w-100">

						<!-- Logo START -->
						<div class="d-flex align-items-center d-xl-none">
							<a class="navbar-brand" href="index.php">
								<img class="navbar-brand-item h-40px" src="assets/images/logo-icon.svg" alt="">
							</a>
						</div>
						<!-- Logo END -->

						<!-- Toggler for sidebar START -->
						<div class="navbar-expand-xl sidebar-offcanvas-menu">
							<button class="navbar-toggler me-auto p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-expanded="false" aria-label="Toggle navigation" data-bs-auto-close="outside">
								<i class="bi bi-list text-primary fa-fw" data-bs-target="#offcanvasMenu"></i>
							</button>
						</div>
						<!-- Toggler for sidebar END -->

						<!-- Top bar left -->
						<div class="navbar-expand-lg ms-auto ms-xl-0">
							<!-- Toggler for menubar START -->
							<button class="navbar-toggler ms-auto p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopContent" aria-controls="navbarTopContent" aria-expanded="false" aria-label="Toggle navigation">
								<i class="bi bi-search"></i>
							</button>
							<!-- Toggler for menubar END -->

							<!-- Topbar menu START -->
							<div class="collapse navbar-collapse w-100 z-index-1" id="navbarTopContent">
								<!-- Top search START -->
								<div class="nav my-3 my-xl-0 flex-nowrap align-items-center">
									<div class="nav-item w-100">
										<form class="position-relative">
											<input class="form-control bg-light pe-5" type="search" placeholder="Search" aria-label="Search">
											<button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
										</form>
									</div>
								</div>
								<!-- Top search END -->
							</div>
							<!-- Topbar menu END -->
						</div>
						<!-- Top bar left END -->

						<!-- Top bar right START -->
						<ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">
							<!-- Dark mode options START -->

							<!-- Dark mode options END-->

							<!-- Notification dropdown START -->

							<!-- Notification dropdown END -->

							<!-- Profile dropdown START -->
							<!-- Profile dropdown START -->
					<li class="nav-item ms-3 dropdown">
						<!-- Avatar -->
						<a class="avatar avatar-xs p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
							<img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
						</a>

						<!-- Profile dropdown START -->
						<ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
							<!-- Profile info -->
							<li class="px-3 mb-3">
								<div class="d-flex align-items-center">
									<!-- Avatar -->
									<div class="avatar me-3">
										<img class="avatar-img rounded-circle shadow" src="assets/images/avatar/01.jpg" alt="avatar">
									</div>
									<div>
										<a class="h6 mt-2 mt-sm-0" href="#">Peterson Dias Cruz</a>
								
									</div>
								</div>
							</li>

							<!-- Links -->
							<li>
						
						
								<hr class="dropdown-divider">
							</li>

							<!-- Dark mode options START -->
							<li>
								<div class="nav-pills-primary-soft theme-icon-active d-flex justify-content-between align-items-center p-2 pb-0">
									<span>Modo:</span>
									<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0" data-bs-theme-value="light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Light">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
											<use href="#"></use>
										</svg>
									</button>
									<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0" data-bs-theme-value="dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dark">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
											<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
											<use href="#"></use>
										</svg>
									</button>
									<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0 active" data-bs-theme-value="auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Auto">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
											<use href="#"></use>
										</svg>
									</button>
								</div>
							</li>
							<!-- Dark mode options END-->
						</ul>
						<!-- Profile dropdown END -->
					</li>
					<!-- Profile dropdown END -->
							<!-- Profile dropdown END -->
						</ul>
						<!-- Top bar right END -->
					</div>
				</div>
			</nav>
			<!-- Top bar END -->

			<!-- Page main content START -->
			<div class="page-content-wrapper p-xxl-4">

				<!-- Title -->
				<div class="row">
					<div class="col-12 mb-4 mb-sm-5">
						<div class="d-sm-flex justify-content-between align-items-center">
							<h1 class="h3 mb-2 mb-sm-0">Dashboard</h1>

						</div>
					</div>
				</div>

				<!-- Counter boxes START -->
				<div class="row g-4 mb-5">
					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body bg-warning bg-opacity-10 border border-warning border-opacity-25 p-4 h-100">
							<div class="d-flex justify-content-between align-items-center">
								<!-- Digit -->
								<div>
									<h4 class="mb-0"><?php echo $totalClientes; ?></h4>
									<span class="h6 fw-light mb-0">Total de clientes</span>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle bg-warning text-white mb-0"><i class="fa-solid fa-hotel fa-fw"></i></div>
							</div>
						</div>
					</div>

					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body bg-success bg-opacity-10 border border-success border-opacity-25 p-4 h-100">
							<div class="d-flex justify-content-between align-items-center">
								<!-- Digit -->
								<div>
								
									<h4 class="mb-0"><?php echo 'R$ ' . number_format($totalServicosAnoAtual, 2, ',', '.'); ?></h4>
									<span class="h6 fw-light mb-0">Total Anual</span>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle bg-success text-white mb-0"><i class="fa-solid fa-hand-holding-dollar fa-fw"></i></div>
							</div>
						</div>
					</div>

					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body bg-primary bg-opacity-10 border border-primary border-opacity-25 p-4 h-100">
							<div class="d-flex justify-content-between align-items-center">
								<!-- Digit -->
								<div>
									<h4 class="mb-0"><?php echo 'R$ ' . number_format( $totalServicosMesAtual, 2, ',', '.'); ?></h4>
									<span class="h6 fw-light mb-0">Total Mensal</span>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle bg-primary text-white mb-0"><i class="bi bi-calendar3"></i></div>
							</div>
						</div>
					</div>

					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body bg-info bg-opacity-10 border border-info border-opacity-25 p-4 h-100">
							<div class="d-flex justify-content-between align-items-center">
								<!-- Digit -->
								<div>
									<h4 class="mb-0"><?php echo $quantidadeServicosHoje; ?></h4>
									<span class="h6 fw-light mb-0">Serviços hoje</span>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle bg-info text-white mb-0"><i class="fa-solid fa-building-circle-check fa-fw"></i></div>
							</div>
						</div>
					</div>
				</div>
				<!-- Counter boxes END -->

				<!-- Hotel grid START -->
				<div class="row g-4 mb-5">
					<!-- Title -->
					<div class="col-12">
						<div class="d-flex justify-content-between">
							<h4 class="mb-0">Ultimos Serviços realizados</h4>

						</div>
					</div>

					<?php
					try {
						// Obtenha uma conexão com o banco de dados
						$conn = getDbConnection();

						// Consulta SQL para obter os últimos 4 serviços realizados com informações do cliente e do carro
						$sql = "SELECT s.*, c.nome AS nome_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
							FROM servicos s 
							JOIN carros car ON s.carro_id = car.id 
							JOIN clientes c ON car.cliente_id = c.id 
							ORDER BY s.data DESC 
							LIMIT 4";
						$stmt = $conn->query($sql);
						$ultimosServicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

						// Exibir os últimos 4 serviços realizados em cards
						foreach ($ultimosServicos as $servico) {


					?>
							<!-- Hotel item -->
							<div class="col-lg-6">
								<div class="card shadow p-3">
									<div class="row g-4">
										<!-- Card img -->
										<div class="col-md-3">
											<img src="assets/images/category/hotel/4by3/10.jpg" class="rounded-2" alt="Card image">
										</div>

										<!-- Card body -->
										<div class="col-md-9">
											<div class="card-body position-relative d-flex flex-column p-0 h-100">

												<!-- Buttons -->
												<div class="list-inline-item dropdown position-absolute top-0 end-0">
													<!-- Share button -->
													<a href="#" class="btn btn-sm btn-round btn-light" role="button" id="dropdownAction1" data-bs-toggle="dropdown" aria-expanded="false">
														<i class="bi bi-three-dots-vertical"></i>
													</a>
													<!-- dropdown button -->
													<ul class="dropdown-menu dropdown-menu-end min-w-auto shadow" aria-labelledby="dropdownAction1">
														<li><a class="dropdown-item small" href="#"><i class="bi bi-info-circle me-2"></i>Report</a></li>
														<li><a class="dropdown-item small" href="#"><i class="bi bi-slash-circle me-2"></i>Disable</a></li>
													</ul>
												</div>
												<?php $data_formatada = date('d/m/Y', strtotime($servico['data']));	?>
												<span class="mb-0 me-2"> <?php echo $data_formatada; ?> </span>
												<!-- Title -->
												<h5 class="card-title mb-0 me-5"><a href="hotel-detail.html"> <?php echo $servico['nome_cliente'] ?></a></h5>

												<small><i class="bi bi-car-front-fill"></i> <?php echo $servico['modelo_carro'] ?> - PLACA: <?php echo $servico['placa'] ?></small>

												<!-- Price and Button -->
												<div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
													<!-- Price -->
													<div class="d-flex align-items-center">
													
														<h5 class="fw-bold mb-0 me-1"><?php echo 'R$ ' . number_format($servico['valor'], 2, ',', '.'); ?></h5>

													</div>
													<!-- Button -->
													<div class="hstack gap-2 mt-3 mt-sm-0">
														<a href="#" class="btn btn-sm btn-primary-soft px-2 mb-0"><i class="bi bi-pencil-square fa-fw"></i></a>
														<a href="#" class="btn btn-sm btn-danger-soft px-2 mb-0"><i class="bi bi-slash-circle fa-fw"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					<?php
						}
					} catch (PDOException $e) {
						// Trate erros de conexão
						handleException($e);
					}
					?>

				</div>
				<!-- Hotel grid END -->

				<!-- Widget START -->
				<div class="row g-4">




					<div class="col-lg-6 col-xxl-4">
						<div class="card shadow h-100">
							<!-- Card header -->
							<div class="card-header border-bottom">
								<h5 class="card-header-title">Cadastros</h5>

							</div>

							<!-- Card body START -->
							<div class="card-body p-3">
								<!-- Chart -->
								<div class="d-grid"><a href="crud/cadastrar_cliente.php" class="btn btn-primary-soft mb-0"><i class="bi bi-plus-lg fa-fw"></i> Cadastrar Cliente</a></div><br>
								<div class="d-grid"><a href="crud/cadastrar_carro.php" class="btn btn-primary-soft mb-0"><i class="bi bi-plus-lg fa-fw"></i> Cadastrar Carro</a></div><br>
								<div class="d-grid"><a href="crud/cadastrar_servico.php" class="btn btn-primary-soft mb-0"><i class="bi bi-plus-lg fa-fw"></i> Registrar Serviço</a></div>



							</div>
						</div>
					</div>
					<!-- Booking graph END -->

					<!-- Rooms START -->
					<div class="col-lg-6 col-xxl-4">
						<div class="card shadow h-100">
							<!-- Card header -->
							<div class="card-header border-bottom d-flex justify-content-between align-items-center">
								<h5 class="card-header-title">Ultimos Clientes cadastrados</h5>

							</div>

							<!-- Card body START -->
							<div class="card-body">
								<!-- Rooms item START -->

								<?php try {
									// Obtenha uma conexão com o banco de dados
									$conn = getDbConnection();

									// Consulta SQL para obter os últimos 5 clientes cadastrados
									$sql = "SELECT * FROM clientes ORDER BY id DESC LIMIT 2";
									$stmt = $conn->query($sql);
									$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

									// Exibir os dados dos últimos 5 clientes cadastrados
									foreach ($result as $cliente) { ?>

										<div class="d-flex justify-content-between align-items-center">
											<!-- Image and info -->
											<div class="d-sm-flex align-items-center mb-1 mb-sm-0">
												<!-- Avatar -->
												<div class="flex-shrink-0">
													<i class="bi bi-person rounded" style="font-size: 40px;"></i>



												</div>
												<!-- Info -->
												<div class="ms-sm-3 mt-2 mt-sm-0">
													<h6 class="mb-1"><?php echo $cliente['nome']; ?></h6>
													<ul class="nav nav-divider small">
														<li class="nav-item"><?php echo $cliente['telefone']; ?></li>
														<li class="nav-item"><span class="text-success">Cadastrado</span></li>
													</ul>
												</div>
											</div>
											<!-- Button -->

										</div>
										<!-- Rooms item END -->

										<hr><!-- Divider -->

								<?php

									}
								} catch (PDOException $e) {
									// Trate erros de conexão
									handleException($e);
								}
								?>


							</div>
							<!-- Card body END -->
						</div>
					</div>
					<!-- Rooms END -->
					<!-- Booking Chart START -->
					<div class="col-xxl-8">
						<!-- Chart START -->
						<div class="card shadow h-100">
							<!-- Card header -->
							<div class="card-header border-bottom">
								<h5 class="card-header-title">DIAS CAR - DCar Manager DESKTOP AUTH v1.0.0</h5>
							</div>

							<!-- Card body -->
							<div class="card-body">
							<section class="vh-xxl-100">
	<div class="container h-100 d-flex px-0 px-sm-4">
		<div class="row justify-content-center align-items-center m-auto">
			<div class="col-12">
				<div class="shadow bg-mode rounded-3 overflow-hidden">
					<div class="row g-0 align-items-center">
						<!-- Vector Image -->
						<div class="col-lg-6 d-md-flex align-items-center order-2 order-lg-1">
							<div class="p-3 p-lg-5">
								<img class="light-mode-item" src="assets/images/element/dias.png" alt="">
								<img class="dark-mode-item" src="assets/images/element/diasW.png" alt="">
							</div>
							<!-- Divider -->
							<div class="vr opacity-1 d-none d-lg-block"></div>
						</div>
		
						<!-- Information -->
						<div class="col-lg-6 order-1">
							<div class="p-4 p-sm-7">
								<!-- Logo -->
								<a href="index.php">
									<img class="light-mode-item mb-4 h-50px" src="assets/images/logo-icon.svg" alt="logo">
									<img class="dark-mode-item mb-4 h-50px" src="assets/images/logo-light.svg" alt="logo">

								</a>
								<!-- Title -->
								<h1 class="mb-2 h3">DCar Manager v1.0</h1>
								<p class="mb-sm-0">Crie, agende e acompanhe ordens de serviço de forma <b> eficiente.</b></p>
								
								<!-- Form START -->
								<form class="mt-sm-4">
									<!-- Input box -->
									
									
									<!-- Button link -->
									<div class="d-sm-flex justify-content-between small mb-4">
										<span>Versão: 1.0.0-hash7f87b2</span>
										<a href="#" class="btn btn-sm btn-link p-0 text-decoration-underline mb-0">DCar_Manager-v1.0.0</a>
									</div>

									<!-- Button -->
							
		
									<!-- Copyright -->
									
									<div class="text-primary-hover mt-3 text-center"> Copyrights ©<?php echo date("Y"); ?> Dias Car - Desenvolvido e projetado por<a href="https://adrieldias.netlify.app/" class="text-body"> Adriel Dias</a>. </div>
								</form>
								<!-- Form END -->
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

							</div>
						</div>
						<!-- Chart END -->
					</div>

					<!-- Reviews END -->
				</div>
				<!-- Widget END -->

			</div>
			<!-- Page main content END -->
		</div>
		<!-- Page content END -->

	</main>
	<!-- **************** MAIN CONTENT END **************** -->

	<!-- Bootstrap JS -->
	<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Vendor -->
	<script src="assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js"></script>
	<script src="assets/vendor/apexcharts/js/apexcharts.min.js"></script>

	<!-- ThemeFunctions -->
	<script src="assets/js/functions.js"></script>

</body>

<!-- Mirrored from booking.webestica.com/admin-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:08 GMT -->

</html>