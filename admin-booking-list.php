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

	// Consulta SQL para contar o número total de ordens de serviço
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM servicos");
	$totalOrdensServico = $stmt->fetchColumn();

	// Exibir o total de ordens de serviço cadastradas
	//echo "Total de ordens de serviço: " . $totalOrdensServico . "<br>";

	// Consulta SQL para contar o número de ordens de serviço marcadas no dia atual
	$dataAtual = date('Y-m-d');
	$sql = "SELECT COUNT(*) AS total FROM servicos WHERE data = :dataAtual";
	$stmt = $conn->prepare($sql);
	$stmt->execute([':dataAtual' => $dataAtual]);
	$ordensServicoHoje = $stmt->fetchColumn();
	//echo "Total de ordens de serviço marcadas para hoje: " . $ordensServicoHoje . "<br>";

	// Consulta SQL para contar o número total de carros
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM carros");
	$totalCarros = $stmt->fetchColumn();
	//echo "Total de carros cadastrados: " . $totalCarros . "<br>";


	// Obtenha uma conexão com o banco de dados
	$conn = getDbConnection();

	// Obter o ano atual
	$anoAtual = date("Y");

	// Variáveis para armazenar as somas dos serviços por ano
	$soma = array();

	// Loop para obter os últimos cinco anos (incluindo o ano atual)
	for ($i = 0; $i < 5; $i++) {
		$ano = $anoAtual - $i;

		// Consulta SQL para calcular o valor total dos serviços no ano específico
		$sql = "SELECT SUM(valor) AS total FROM servicos WHERE strftime('%Y', data) = :ano";
		$stmt = $conn->prepare($sql);
		$stmt->execute([':ano' => $ano]);
		$totalServicos = $stmt->fetchColumn();

		// Armazenar o resultado na variável associativa
		$soma["ano{$i}"] = ($totalServicos === null) ? 0 : $totalServicos;
	}

	// Acesso às variáveis de soma
	$soma['ano1']; // Soma dos serviços do ano atual
	$soma['ano2']; // Soma dos serviços do ano anterior
	$soma['ano3']; // Soma dos serviços do terceiro ano
	$soma['ano4']; // Soma dos serviços do quarto ano




} catch (PDOException $e) {
	// Trate erros de conexão
	handleException($e);
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/admin-booking-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:52 GMT -->

<head>
	<title>Booking - Multipurpose Online Booking Theme</title>

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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
						<li class="nav-item"><a href="index.php" class="nav-link">Dashboard</a></li>

						<!-- Title -->
						<li class="nav-item ms-2 my-2">Pages</li>






						<li class="nav-item"> <a class="nav-link active" href="admin-booking-list.php">Serviços</a></li>
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
							<a class="navbar-brand" href="index-2.html">
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
							<li class="nav-item dropdown ms-3">
								<button class="nav-notification lh-0 btn btn-light p-0 mb-0" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw theme-icon-active" viewBox="0 0 16 16">
										<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
										<use href="#"></use>
									</svg>
								</button>

								<ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
									<li class="mb-1">
										<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
											<svg width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
												<path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
												<use href="#"></use>
											</svg>Light
										</button>
									</li>
									<li class="mb-1">
										<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
												<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
												<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
												<use href="#"></use>
											</svg>Dark
										</button>
									</li>
									<li>
										<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch" viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
												<use href="#"></use>
											</svg>Auto
										</button>
									</li>
								</ul>
							</li>
							<!-- Dark mode options END-->

							<!-- Notification dropdown START -->
				
							<!-- Notification dropdown END -->

							<!-- Profile dropdown START -->
								<!-- Profile dropdown START -->
					<li class="nav-item ms-3 dropdown">
						<!-- Avatar -->
						<span class="notif-badge animation-blink"></span>
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
					<div class="col-12 mb-5">
						<div class="d-sm-flex justify-content-between align-items-center">
							<h1 class="h3 mb-2 mb-sm-0">Lista de serviços</h1>
							<div class="d-grid"><a href="crud/cadastrar_servico.php" class="btn btn-primary-soft mb-0"><i class="bi bi-plus-lg fa-fw"></i> Adicionar serviço</a></div>
						</div>
					</div>
				</div>

				<!-- Counter START -->
				<div class="row g-4 mb-5">
					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body shadow p-4">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<!-- Number -->
								<div class="me-2">
									<span>Total Ordens de serviço</span>
									<h3 class="mb-0 mt-2"><?php echo $totalOrdensServico; ?></h3>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle flex-shrink-0 bg-primary bg-opacity-10 text-primary mb-0">
									<i class="bi bi-door-open fa-fw"></i>
								</div>
							</div>
							<!-- Progress bar -->
							<div class="progress progress-xs bg-primary bg-opacity-10 mb-2">
								<div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $ordensServicoHoje; ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							<span><span class="text-primary"> <?php echo $ordensServicoHoje; ?> Novas ordens</span> HOJE</span>
						</div>
					</div>

					<!-- Counter item -->
					<div class="col-md-6 col-xxl-3">
						<div class="card card-body shadow p-4">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<!-- Number -->
								<div class="me-2">
									<span>Total de carros</span>
									<h3 class="mb-0 mt-2"><?php echo $totalCarros; ?></h3>
								</div>
								<!-- Icon -->
								<div class="icon-lg rounded-circle flex-shrink-0 bg-danger bg-opacity-10 text-danger mb-0">
									<i class="bi bi-car-front"></i>
								</div>
							</div>
							<!-- Progress bar -->
							<div class="progress progress-xs bg-danger bg-opacity-10 mb-2">
								<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $totalCarros; ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							<span><span class="text-danger"><?php echo $totalCarros; ?> Carros cadastrados</span> </span>
						</div>
					</div>

					

					
				</div>
				<!-- Counter END -->

				<!-- Tabs and search START -->
				<div class="row g-4 justify-content-between align-items-center">
					<div class="col-lg-5">
						<!-- Tabs -->
						<ul class="nav nav-pills-shadow nav-responsive">
							<li class="nav-item">
								<a class="nav-link mb-0 me-sm-2 active" data-bs-toggle="tab" href="#tab-1">Todas as ordens</a>
							</li>

						</ul>
					</div>

					<div class="col-lg-6 col-xxl-5">
						<div class="d-sm-flex gap-4 justify-content-between justify-content-lg-end">
							<!-- Search -->
							<div class="col-md-8">
								<form method="GET" action="" class="rounded position-relative">
									<input type="text" class="form-control bg-transparent" type="search" aria-label="Search" name="search" placeholder="Pesquisar..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

									<button class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
										<i class="fas fa-search fs-6"></i>
									</button>
								</form>
							</div>
							<!-- Tabs -->
							<div class="d-flex justify-content-end mt-2 mt-sm-0">
								<ul class="nav nav-pills nav-pills-dark" id="room-pills-tab" role="tablist">
									<!-- Tab item -->
									<li class="nav-item">
										<button class="nav-link rounded-start rounded-0 active" id="grid-tab" data-bs-toggle="tab" data-bs-target="#grid-tab-pane" type="button" role="tab" aria-controls="grid-tab-pane" aria-selected="true"><i class="bi fa-fw bi-grid-fill"></i></button>
									</li>
									<!-- Tab item -->

								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Tabs and search END -->

				<!-- Tab content START -->
				<div class="tab-content mt-5" id="myTabContent">
					<!-- Content item START -->
					<div class="tab-pane fade show active" id="grid-tab-pane">
						<!-- Rooms START -->
						<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xxl-5 g-4">

							<?php
							try {
								// Conectar ao banco de dados
								$conn = getDbConnection();

								// Definir o número de registros por página
								$registros_por_pagina = 12;

								// Determinar a página atual
								$pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

								// Calcular o offset
								$offset = ($pagina_atual - 1) * $registros_por_pagina;

								// Obter o termo de pesquisa
								$termo_pesquisa = isset($_GET['search']) ? $_GET['search'] : '';

								// Obter o total de registros no banco de dados com base na pesquisa
								$sql_total = "SELECT COUNT(*) FROM servicos 
                  JOIN carros car ON servicos.carro_id = car.id 
                  JOIN clientes c ON car.cliente_id = c.id 
                  WHERE c.nome LIKE :termo_pesquisa 
                  OR car.modelo LIKE :termo_pesquisa 
                  OR car.placa LIKE :termo_pesquisa";
								$stmt_total = $conn->prepare($sql_total);
								$stmt_total->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
								$stmt_total->execute();
								$total_registros = $stmt_total->fetchColumn();

								// Calcular o total de páginas
								$total_paginas = ceil($total_registros / $registros_por_pagina);

								// Consulta SQL para obter os serviços com paginação e pesquisa
								$sql = "SELECT s.*, c.nome AS nome_cliente, c.cpf AS cpf_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
            FROM servicos s 
            JOIN carros car ON s.carro_id = car.id 
            JOIN clientes c ON car.cliente_id = c.id 
            WHERE c.nome LIKE :termo_pesquisa 
            OR car.modelo LIKE :termo_pesquisa 
            OR car.placa LIKE :termo_pesquisa
            ORDER BY s.data DESC 
            LIMIT :limit OFFSET :offset";
								$stmt = $conn->prepare($sql);
								$stmt->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
								$stmt->bindParam(':limit', $registros_por_pagina, PDO::PARAM_INT);
								$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
								$stmt->execute();
								$ultimosServicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

								// Exibir mensagem se nenhum resultado for encontrado
								if (count($ultimosServicos) == 0) {
									echo '<p class="text-center">Nenhum registro encontrado.</p>';
								}

								// Exibir os serviços em cards
								foreach ($ultimosServicos as $servico) {
							?>
									<!-- Room item -->
									<div class="col">
										<div class="card shadow h-100">
											<!-- Overlay item -->
											<div class="position-relative">
												<!-- Image -->
												<img src="assets/images/category/hotel/4by3/02.jpg" class="card-img-top" alt="Card image">
												<!-- Overlay -->
												<div class="card-img-overlay d-flex flex-column p-3">
													<!-- Card overlay top -->
													<div class="d-flex justify-content-between align-items-center">
														<div class="badge text-bg-dark"><i class="bi fa-fw bi-star-fill me-2 text-warning"></i>4.5</div>
														<!-- Buttons -->
														<div class="list-inline-item dropdown">
															<!-- Dropdown button -->
															<a href="#" class="btn btn-sm btn-round btn-light" role="button" id="dropdownAction1" data-bs-toggle="dropdown" aria-expanded="false">
																<i class="bi bi-three-dots-vertical"></i>
															</a>
															<!-- dropdown items -->
															<ul class="dropdown-menu dropdown-menu-end min-w-auto shadow rounded small" aria-labelledby="dropdownAction1">
																<li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2"></i>Deletar</a></li>
																<li><a class="dropdown-item" href="#"><i class="bi bi-pen me-2"></i>Editar</a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>

											<!-- Card body START -->
											<div class="card-body px-3">
												<!-- Title -->
												<h5 class="card-title mb-1"><a href="cab-detail.php?id=<?php echo $servico['id']; ?>"> <?php echo $servico['nome_cliente'] ?></a></h5>
												<ul class="list-group list-group-borderless small mt-2 mb-0">
													<li class="list-group-item pb-0">
														<i class="bi bi-car-front-fill"></i> <?php echo $servico['modelo_carro'] ?> - PLACA: <?php echo $servico['placa'] ?>
													</li>
													<li class="list-group-item pb-0">
														<i class="bi bi-person-vcard"></i></i> CPF - <?php echo substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0) ?> <?php $data_formatada = date('d/m/Y', strtotime($servico['data']));	?>
														<br> <i class="bi bi-calendar3"></i> DATA - <?php echo $data_formatada; ?>
													</li>


												</ul>
											</div>
											<!-- Card body END -->

											<!-- Card footer START-->
											<div class="card-footer pt-0">
												<!-- Price -->
												<div class="hstack gap-2 mb-2">
													<h6 class="fw-normal mb-0"><?php $valor = $servico['valor']; $valorFormatado = number_format($valor, 2, ',', '.'); echo "R$ " . $valorFormatado;?> </h6>
													<small>REAIS</small>
												</div>
												<a href="cab-detail.php?id=<?php echo $servico['id']; ?>" class="btn btn-sm btn-primary-soft mb-0 w-100">Ver detalhes</a>
											</div>
										</div>
									</div>
								<?php
								}


								?>


							<?php
							} catch (PDOException $e) {
								// Trate erros de conexão
								handleException($e);
							}
							?>


						</div>
						<!-- Rooms END -->
						<?php


						// Exibir informações de paginação
						$inicio = $offset + 1;
						$fim = min($offset + $registros_por_pagina, $total_registros);
						?>

						<!-- Pagination START -->
						<div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4">
							<!-- Content -->
							<p class="mb-sm-0 text-center text-sm-start">Mostrando <?php echo $inicio; ?> até <?php echo $fim; ?> de <?php echo $total_registros; ?> registros...</p>
							<!-- Pagination -->
							<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
								<ul class="pagination pagination-sm pagination-primary-soft mb-0">
									<!-- Previous Page Link -->
									<li class="page-item <?php echo ($pagina_atual == 1) ? 'disabled' : ''; ?>">
										<a class="page-link" href="?pagina=<?php echo $pagina_atual - 1; ?>" tabindex="-1">Anterior</a>
									</li>

									<!-- Always show page 1 -->
									<?php if ($pagina_atual > 2) : ?>
										<li class="page-item">
											<a class="page-link" href="?pagina=1">1</a>
										</li>
										<?php if ($pagina_atual > 3) : ?>
											<li class="page-item disabled">
												<a class="page-link" href="#">...</a>
											</li>
										<?php endif; ?>
									<?php endif; ?>

									<!-- Page Number Links -->
									<?php
									$max_links = 3; // Máximo de links para exibir antes e depois da página atual
									$start = max(1, $pagina_atual - $max_links); // Primeira página no intervalo
									$end = min($total_paginas, $pagina_atual + $max_links); // Última página no intervalo

									// Exibir links das páginas
									for ($pagina = $start; $pagina <= $end; $pagina++) :
									?>
										<li class="page-item <?php echo ($pagina == $pagina_atual) ? 'active' : ''; ?>">
											<a class="page-link" href="?pagina=<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
										</li>
									<?php endfor; ?>

									<!-- Always show last page -->
									<?php if ($pagina_atual < $total_paginas - 1) : ?>
										<?php if ($pagina_atual < $total_paginas - 2) : ?>
											<li class="page-item disabled">
												<a class="page-link" href="#">...</a>
											</li>
										<?php endif; ?>
										<li class="page-item">
											<a class="page-link" href="?pagina=<?php echo $total_paginas; ?>"><?php echo $total_paginas; ?></a>
										</li>
									<?php endif; ?>

									<!-- Next Page Link -->
									<li class="page-item <?php echo ($pagina_atual == $total_paginas) ? 'disabled' : ''; ?>">
										<a class="page-link" href="?pagina=<?php echo $pagina_atual + 1; ?>">Posterior</a>
									</li>
								</ul>
							</nav>
						</div>
						<!-- Pagination END -->
					</div>
					<!-- Content item END -->

					<!-- Content item START -->
					<div class="tab-pane fade" id="list-tab-pane">
						<div class="card shadow">

							<!-- Card body START -->
							<div class="card-body">
								<!-- Table head -->
								<div class="bg-light rounded p-3 d-none d-xxl-block">
									<div class="row row-cols-6 g-4">
										<div class="col">
											<h6 class="mb-0">Room Name</h6>
										</div>
										<div class="col">
											<h6 class="mb-0">Bed Type</h6>
										</div>
										<div class="col">
											<h6 class="mb-0">Room Floor</h6>
										</div>
										<div class="col">
											<h6 class="mb-0">Amount</h6>
										</div>
										<div class="col">
											<h6 class="mb-0">Rating</h6>
										</div>
										<div class="col">
											<h6 class="mb-0">Action</h6>
										</div>
									</div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/01.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Deluxe Pool View with Breakfast</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">King Size</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">Ground Floor: G5</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$1025</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/02.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Premium Room With Balcony</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">Single Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">First Floor: F3</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$750</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/03.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Deluxe Pool View</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">Family Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">Ground Floor: G3</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$895</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/04.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Superior Room</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">King Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">First Floor: F5</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$750</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/05.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Studio Suite King</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">Double Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">Fifth Floor: Ft3</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$1458</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/06.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Luxury Room with Balcony</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">Family Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">Third Floor: T2</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$847</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>

								<!-- Table data -->
								<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-6 g-2 g-sm-4 align-items-md-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room name:</small>
										<div class="d-flex align-items-center">
											<!-- Image -->
											<div class="w-80px flex-shrink-0">
												<img src="assets/images/category/hotel/4by3/07.jpg" class="rounded" alt="">
											</div>
											<!-- Title -->
											<h6 class="mb-0 ms-2">Deluxe Room Twin Bed With Balcony</h6>
										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Bed Type:</small>
										<h6 class="mb-0 fw-normal">Double Bed</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Room Floor:</small>
										<h6 class="mb-0 fw-normal">Fifth Floor: Ft1</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Amount:</small>
										<h6 class="text-success mb-0">$1650</h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-xxl-none">Payment:</small>
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
											<li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
										</ul>
									</div>

									<!-- Data item -->
									<div class="col"><a href="#" class="btn btn-sm btn-light mb-0">View</a></div>
								</div>
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
					<!-- Content item END -->
				</div>
				<!-- Tab content END -->
			</div>
			<!-- Page main content END -->
		</div>
		<!-- Page content END -->

	</main>
	<!-- **************** MAIN CONTENT END **************** -->
	<script>
		// Função para salvar a posição de rolagem no localStorage
		function saveScrollPosition() {
			localStorage.setItem('scrollPosition', window.scrollY);
		}

		// Adicionar um evento para salvar a posição de rolagem antes de recarregar a página
		window.addEventListener('beforeunload', saveScrollPosition);

		// Função para restaurar a posição de rolagem a partir do localStorage
		function restoreScrollPosition() {
			const scrollPosition = localStorage.getItem('scrollPosition');
			if (scrollPosition !== null) {
				window.scrollTo(0, parseInt(scrollPosition, 10));
			}
		}

		// Adicionar um evento para restaurar a posição de rolagem quando a página carregar
		window.addEventListener('load', restoreScrollPosition);
	</script>
	<!-- Bootstrap JS -->
	<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Vendor -->
	<script src="assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js"></script>

	<!-- ThemeFunctions -->
	<script src="assets/js/functions.js"></script>

</body>

<!-- Mirrored from booking.webestica.com/admin-booking-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:52 GMT -->

</html>