<?php session_start(); ?>

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



} catch (PDOException $e) {
	// Trate erros de conexão
	handleException($e);
}
?>
<?php
try {
	// Conectar ao banco de dados
	$conn = getDbConnection();

	// Verifica se o ID foi passado na URL
	if (isset($_GET['id'])) {
		// Recupera o ID do serviço da URL
		$servico_id = $_GET['id'];

		// Consulta SQL para obter os detalhes do serviço com base no ID
		$sql = "SELECT s.*, c.nome AS nome_cliente, c.telefone AS telefone_cliente, c.endereco AS endereco_cliente, c.numero AS numero_cliente, c.sexo AS sexo_cliente, c.email AS email_cliente, c.cpf AS cpf_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
                FROM servicos s 
                JOIN carros car ON s.carro_id = car.id 
                JOIN clientes c ON car.cliente_id = c.id 
                WHERE s.id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $servico_id, PDO::PARAM_INT);
	} else {
		// Consulta SQL para obter todos os registros da tabela servicos
		$sql = "SELECT s.*, c.nome AS nome_cliente, c.telefone AS telefone_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
                FROM servicos s 
                JOIN carros car ON s.carro_id = car.id 
                JOIN clientes c ON car.cliente_id = c.id";

		$stmt = $conn->prepare($sql);
	}

	$stmt->execute();
	$servicos = $stmt->fetchAll();

	// Verifica se foram encontrados serviços
	if ($servicos) {
		isset($_GET['id']);

		foreach ($servicos as $servico) {
			//echo "<div>";
			//	echo "<h2>Serviço ID: " . $servico['id'] . "</h2>";
			//echo "<p>Cliente: " . $servico['nome_cliente'] . " (" . $servico['telefone_cliente'] . ")</p>";
			//	echo "<p>Carro: " . $servico['modelo_carro'] . " - " . $servico['ano_carro'] . " - " . $servico['placa'] . "</p>";
			//	echo "<p>Descrição: " . $servico['descricao'] . "</p>";
			//	echo "<p>Data: " . $servico['data'] . "</p>";
			//echo "<p>Valor Total dos Serviços: R$ " . $servico['total_servicos_valor'] . "</p>";
			//	echo "<p>Valor: R$ " . $servico['valor'] . "</p>";
			//	echo "<p>Valor da Mão de Obra: R$ " . $servico['mao_de_obra_valor'] . "</p>";
			//	echo "<p>Descrição do Serviço 0: " . $servico['servico_descricao_0'] . " - Valor: R$ " . $servico['servico_valor_0'] . "</p>";
			//	echo "<p>Descrição do Serviço 1: " . $servico['servico_descricao_1'] . " - Valor: R$ " . $servico['servico_valor_1'] . "</p>";
			//	echo "<p>Descrição do Serviço 2: " . $servico['servico_descricao_2'] . " - Valor: R$ " . $servico['servico_valor_2'] . "</p>";
			//	echo "<p>Valor Total: R$ " . $servico['total_valor'] . "</p>";
			//echo "</div>";
		}



?>


		<!DOCTYPE html>
		<html lang="en">

		<!-- Mirrored from booking.webestica.com/cab-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:38:42 GMT -->

		<head>
			<title>Ordem N° <?php echo $servico['id_ordem']; ?></title>

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
			<link rel="stylesheet" type="text/css" href="assets/vendor/tiny-slider/tiny-slider.css">
			<link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">
			<link rel="stylesheet" type="text/css" href="assets/vendor/flatpickr/css/flatpickr.min.css">

			<!-- Theme CSS -->
			<link rel="stylesheet" type="text/css" href="assets/css/style.css">

		</head>

		<body>

			<!-- Header START -->
			<header class="navbar-light header-sticky">
				<!-- Logo Nav START -->
				<nav class="navbar navbar-expand-xl">
					<div class="container">
						<!-- Logo START -->
						<a class="navbar-brand" href="index.php">
							<img class="light-mode-item navbar-brand-item" src="assets/images/logo.svg" alt="logo">
							<img class="dark-mode-item navbar-brand-item" src="assets/images/logo-light.svg" alt="logo">
						</a>
						<!-- Logo END -->

						<!-- Responsive navbar toggler -->
						<button class="navbar-toggler ms-auto mx-3 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-animation">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>

						<!-- Main navbar START -->

						<!-- Main navbar END -->

						<!-- Profile and Notification START -->
						<ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">



							<!-- Notification dropdown END -->

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
						</ul>
						<!-- Profile and Notification START -->
					</div>
				</nav>
				<!-- Logo Nav END -->
			</header>
			<!-- Header END -->

			<!-- **************** MAIN CONTENT START **************** -->


			<main>

				<!-- =======================
Main Banner START -->
				<section class="pt-4">
					<div class="container position-relative">
						<!-- Title and button START -->
						<div class="row">
							<div class="col-12">
								<!-- Meta -->
								<a href="admin-booking-list.php" class="btn btn-primary-soft mb-0">Voltar</a>
								<br>
								<br>
								<div class="d-flex justify-content-between align-items-lg-center">
									<!-- Title -->
									<ul class="nav nav-divider align-items-center mb-0">
										<li class="nav-item h5">Ordem N° <?php echo $servico['id_ordem']; ?> </li>
										<li class="nav-item h5 fw-light"><?php echo $servico['nome_cliente']; ?></li>
										<li class="nav-item h5 fw-light"><?php
																			$meses = array(
																				1 => 'Janeiro',
																				2 => 'Fevereiro',
																				3 => 'Março',
																				4 => 'Abril',
																				5 => 'Maio',
																				6 => 'Junho',
																				7 => 'Julho',
																				8 => 'Agosto',
																				9 => 'Setembro',
																				10 => 'Outubro',
																				11 => 'Novembro',
																				12 => 'Dezembro'
																			);

																			echo  $data_formatada = date('d', strtotime($servico['data'])) . ' de ' . $meses[date('n', strtotime($servico['data']))] . ' de ' . date('Y - h:i A', strtotime($servico['data'])); ?></li>
									</ul>

									<!-- Buttons -->
									<div class="ms-3">
										<!-- Share button -->
										<a href="#" class="btn btn-sm btn-light px-2 mb-0" role="button" id="dropdownShare" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa-solid fa-fw fa-share-alt"></i>
										</a>
										<!-- dropdown button -->
										<ul class="dropdown-menu dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare">
											<li><a class="dropdown-item" href="#"><i class="fab fa-twitter-square me-2"></i>Twitter</a></li>
											<li><a class="dropdown-item" href="#"><i class="fab fa-facebook-square me-2"></i>Facebook</a></li>
											<li><a class="dropdown-item" href="#"><i class="fab fa-linkedin me-2"></i>LinkedIn</a></li>
											<li><a class="dropdown-item" href="#"><i class="fa-solid fa-copy me-2"></i>Copy link</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- Title and button END -->
					</div>
				</section>
				<!-- =======================
Main Banner END -->

				<!-- =======================
Main Content START -->
				<section class="pt-0">
					<div class="container" data-sticky-container>
						<div class="row g-4">

							<!-- Main content START -->
							<div class="col-xl-8">
								<div class="vstack gap-5">

									<!-- Main cab list START -->
									<div class="card border p-4">
										<!-- Card body START -->
										<div class="card-body p-0">
											<div class="row g-4 align-items-center">
												<!-- Image -->
												<div class="col-md-4">
													<div class="bg-light rounded-3 px-4 py-5">
														<img src="assets/images/category/cab/seadan.svg" alt="">
													</div>
												</div>

												<!-- card body -->
												<div class="col-md-8">
													<!-- Title and rating -->
													<div class="d-sm-flex justify-content-sm-between">
														<!-- Card title -->
														<div>
															<h4 class="card-title mb-2"><?php echo $servico['modelo_carro'] ?> </h4>
															<ul class="nav nav-divider h6 fw-normal mb-2">
																<li class="nav-item">PLACA: <?php echo $servico['placa'] ?></li>

															</ul>
														</div>
														<!-- Rating Star -->
														<ul class="list-inline mb-0">
															<li class="list-inline-item me-0"><i class="fa-solid fa-star text-warning"></i></li>
															<li class="list-inline-item me-0"><i class="fa-solid fa-star text-warning"></i></li>
															<li class="list-inline-item me-0"><i class="fa-solid fa-star text-warning"></i></li>
															<li class="list-inline-item me-0"><i class="fa-solid fa-star text-warning"></i></li>
															<li class="list-inline-item"><i class="fa-solid fa-star-half-alt text-warning"></i></li>
														</ul>
													</div>

													<!-- List -->
													<ul class="list-group list-group-borderless mt-2 mb-0">
														<li class="list-group-item d-flex pb-0 mb-0">
															<span class="h6 fw-normal mb-0"><i class="bi bi-check-circle me-2"></i>Reparos gerais</span>
														</li>
														<li class="list-group-item d-flex pb-0 mb-0">
															<span class="h6 fw-normal mb-0"><i class="bi bi-check-circle me-2"></i>Troca de peças</span>
														</li>

													</ul>
												</div>
											</div>
										</div>
										<!-- Card body END -->

										<!-- Card footer -->
										<div class="card-footer p-0 pt-4">
											<div class="hstack gap-3 flex-wrap">
												<!-- Item -->
												<h6 class="bg-success bg-opacity-10 text-success fw-light rounded-2 d-inline-block mb-0 py-2 px-4">
													Manutenção garantida:
												</h6>

												<!-- Item -->
												<h6 class="bg-success bg-opacity-10 text-success fw-light rounded-2 d-inline-block mb-0 py-2 px-4">
													sua confiança, nossa expertise.
												</h6>
											</div>
										</div>
									</div>
									<!-- Main cab list END -->

									<!-- Trip Details START -->
									<div class="card border">
										<!-- Card header -->
										<div class="card-header border-bottom bg-transparent">
											<h4 class="mb-0">Detalhes do cliente</h4>
										</div>

										<!-- Card body START -->
										<div class="card-body">
											<!-- Form START -->
											<form class="row g-4">
												<!-- Input -->
												<div class="col-md-6">
													<div class="form-control-bg-light">
														<label class="form-label">Endereço</label>
														<input type="text" class="form-control form-control-lg" placeholder="Enter exact pick up address" readonly value="<?php echo $servico['endereco_cliente'] ?>">
														<div class="form-text"></div>
													</div>
												</div>

												<!-- Input -->
												<div class="col-md-6">
													<div class="form-control-bg-light">
														<label class="form-label">Numero</label>
														<input type="text" class="form-control form-control-lg" placeholder="Enter drop address" readonly value="<?php echo $servico['numero_cliente'] ?>">
													</div>

												</div>

												<h5 class="mb-0 mt-4">Informações pessoais</h5>

												<!-- Radio button -->
												<div class="col-md-4">
													<label class="form-label">Gênero</label>
													<div>
														<?php
														// Verifica o valor de $servico['sexo_cliente']
														$sexo = $servico['sexo_cliente'];
														?>
														<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
															<input type="radio" class="btn-check" name="btnradio" id="btnradio1" <?php echo ($sexo == 'M') ? 'checked' : ''; ?> disabled>
															<label class="btn btn-lg btn-light btn-dark-bg-check mb-0" for="btnradio1">Masc</label>

															<input type="radio" class="btn-check" name="btnradio" id="btnradio2" <?php echo ($sexo == 'F') ? 'checked' : ''; ?> disabled>
															<label class="btn btn-lg btn-light btn-dark-bg-check mb-0" for="btnradio2">Fem</label>
														</div>
													</div>
												</div>



												<!-- Input -->
												<div class="col-md-8">
													<div class="form-control-bg-light">
														<label class="form-label">Nome</label>
														<input type="text" class="form-control form-control-lg" value="<?php echo $servico['nome_cliente'] ?>" placeholder="Enter your name" readonly>
													</div>

												</div>

												<!-- Input -->
												<div class="col-md-6">
													<div class="form-control-bg-light">
														<label class="form-label">Email</label>
														<input type="email" class="form-control form-control-lg" value="<?php echo $servico['email_cliente'] ?>" placeholder="Enter your email" readonly>
													</div>
													<div class="form-control-bg-light">
														<label class="form-label">CPF</label>
														<input type="email" class="form-control form-control-lg" value="<?php echo substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0); ?>" placeholder="Enter your email" readonly>
													</div>
												</div>

												<!-- Input -->
												<div class="col-md-6">
													<div class="form-control-bg-light">
														<label class="form-label">Telefone</label>
														<input type="text" class="form-control form-control-lg" value="<?php $telefone_cliente = $servico['telefone_cliente'];
																														$telefone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone_cliente);
																														echo $telefone_formatado;
																														?>" placeholder="Enter your mobile number" readonly>
													</div>


												</div>
											</form>
											<!-- Form END -->
										</div>
										<!-- Card body END -->
									</div>
									<!-- Trip Details END -->

									<!-- Driver and cab detail START -->
									<div class="card bg-transparent">

										<!-- Card header -->
										<div class="card-header border-bottom bg-transparent px-0 pt-0">
											<h4 class="mb-0">Detalhes e descrição do serviço</h4>
										</div>

										<!-- Card body -->
										<div class="card-body pt-4 p-0">
											<!-- List -->
											<ul>
												<li class="mb-2"> <?php echo $servico['descricao'] ?></li>

											</ul>





										</div>

									</div>


								</div>
							</div>
							<!-- Main content END -->

							<!-- Sidebar START -->
							<aside class="col-xl-4">
								<div data-sticky data-margin-top="80" data-sticky-for="1199">
									<div class="card card-body bg-light p-4">
										<!-- Title -->
										<h6 class="text-danger fw-normal">Todos os valores a serem pagos.</h6>


										<!-- List -->
										<ul class="list-group list-group-borderless mb-0">
											<li class="list-group-item d-flex justify-content-between">
												<span class="h6 fw-light mb-0"><b>Mão de obra</b></span>
												<span class="h6 fw-light mb-0">R$ <?php echo $servico['mao_de_obra_valor']; ?></span>
											</li>
											<li class="list-group-item d-flex justify-content-between">
												<span class="h6 fw-light mb-0"> <?php echo $servico['servico_descricao_0']; ?></span>
												<span class="h6 fw-light mb-0">R$ <?php echo $servico['servico_valor_0']; ?></span>
											</li>
											<li class="list-group-item d-flex justify-content-between">
												<span class="h6 fw-light mb-0"> <?php echo $servico['servico_descricao_1']; ?></span>
												<span class="h6 fw-light mb-0">R$ <?php echo $servico['servico_valor_1']; ?></span>
											</li>
											<li class="list-group-item d-flex justify-content-between">
												<span class="h6 fw-light mb-0"> <?php echo $servico['servico_descricao_2']; ?></span>
												<span class="h6 fw-light mb-0">R$ <?php echo $servico['servico_valor_2']; ?></span>
											</li>
											<li class="list-group-item py-0">
												<hr class="my-0">
											</li>
											<!-- Divider -->
											<li class="list-group-item d-flex justify-content-between pb-0">
												<span class="h5 fw-normal mb-0">Valor total</span>
												<span class="h5 fw-normal mb-0"> <?php echo 'R$ ' . number_format($servico['total_valor'], 2, ',', '.');  ?></span>
											</li>
										</ul>

										<?php
										// Definindo os valores de desconto e acréscimo
										$descontoAVista = 0.01; // 5% de desconto para pagamento à vista
										$acrescimoCartao = 0.05; // 5% de acréscimo para pagamento no cartão de crédito

										// Calculando o valor total original
										$valorOriginal = $servico['total_valor'];

										// Calculando os valores com desconto e acréscimo
										$valorAVista  = $valorOriginal * (1 - $descontoAVista);
										$valorAVista = ($valorAVista - 1);
										$valorCartao = $valorOriginal * (1 + $acrescimoCartao);

										// Formatando os valores para exibição
										$valorOriginalFormatado = 'R$ ' . number_format($valorOriginal, 2, ',', '.');
										$valorAVistaFormatado = 'R$ ' . number_format($valorAVista, 2, ',', '.');
										$valorCartaoFormatado = 'R$ ' . number_format($valorCartao, 2, ',', '.');

										// Exibindo os valores
										//echo "Valor Original: $valorOriginalFormatado<br>";
										//echo "Valor para pagamento à vista: $valorAVistaFormatado<br>";
										//echo "Valor para pagamento no cartão de crédito: $valorCartaoFormatado<br>";
										?>


										<div class="d-grid mt-4 gap-2">
											<div class="form-check form-check-inline mb-0">
												<li class="list-group-item py-0">
													<hr class="my-0">
												</li>
												<p style="color: black; font-size: 14px;">• A vista com desconto:<b> <?php echo  $valorAVistaFormatado;  ?></b></p>
												<p style="color: black; font-size: 11px;">Desconto de:<b> <?php echo 'R$ ' . number_format(($valorOriginal - $valorAVista), 2, ',', '.'); ?></b></p>
												<li class="list-group-item py-0">
													<hr class="my-0">
												</li>
											</div>

											<div class="form-check form-check-inline mb-0">
												<li class="list-group-item py-0">
													<hr class="my-0">
												</li>
												<p style="color: black; font-size: 14px; "> • No cartão: <b> <?php echo  $valorCartaoFormatado;  ?> </b></p>
												<p style="color: black; font-size: 11px;">Taxas:<b> <?php echo 'R$ ' . number_format(($valorCartao - $valorOriginal), 2, ',', '.'); ?></b></p>
												<li class="list-group-item py-0">
													<hr class="my-0">
												</li>
											</div>
											<p style="font-size: 12px;" class="text-danger"><var> *Sugestão de valores pagos a vista e a prazo.</var></p>
											<?php
											// Obtém a data atual
											date_default_timezone_set('America/Sao_Paulo');
											$anoAtual = date('Y');
											$mesAtual = date('m');
											$diaAtual = date('d');
											$horaAtual = date('H');
											$dataAtual = date('d-m-Y');
											?>



											<?php
											// Informações adicionais com separadores ' | '
											// Cabeçalho da mensagem
											$cabecalho = "| *DIAS CAR* |\n";
											$cabecalho .= "| Data: " . $dataAtual . " |\n";
											$cabecalho .= "| Endereço: rua arpoador 1210 |\n";
											$cabecalho .= "| Tel.Fixo: (XX) XXXX-XXXX |\n"; // Substitua com o número correto
											$cabecalho .= "| Whatsapp: (13) 98170-6744 |\n";
											$cabecalho .= "| CNPJ 19.429.891/0001-24 |\n\n";

											// Montando a mensagem para enviar via WhatsApp
											$mensagem = $cabecalho;


											$mensagem .= "--------------------------------\n";
											$mensagem .= "*ORDEM N° " . $servico['id_ordem'] . "* \n";
											$mensagem .= "--------------------------------\n\n";


											// Dados pessoais do cliente
											$mensagem .= "--------------------------------\n";
											$mensagem .= "DADOS PESSOAIS DO CLIENTE\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| Endereço: " . $servico['endereco_cliente'] . " |\n";
											$mensagem .= "| Número: " . $servico['numero_cliente'] . " |\n";
											$mensagem .= "| Gênero: " . (($servico['sexo_cliente'] == 'M') ? 'Masculino' : 'Feminino') . " |\n";
											$mensagem .= "| Nome: " . $servico['nome_cliente'] . " |\n";
											$mensagem .= "| Email: " . $servico['email_cliente'] . " |\n";
											$mensagem .= "| CPF: " . substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0) . " |\n";
											$mensagem .= "| Telefone: " . preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $servico['telefone_cliente']) . " |\n";
											$mensagem .= "--------------------------------\n\n";

											// Informações do veículo
											$mensagem .= "--------------------------------\n";
											$mensagem .= "VEÍCULO\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| *CARRO: " . $servico['modelo_carro'] . "* |\n";
											$mensagem .= "| *PLACA: " . $servico['placa'] . "* |\n";
											$mensagem .= "--------------------------------\n\n";

											// Detalhes do serviço e valores
											$mensagem .= "--------------------------------\n";
											$mensagem .= "DETALHES DO SERVIÇO\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| Mão de obra: R$ " . $servico['mao_de_obra_valor'] . " |\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| " . $servico['servico_descricao_0'] . ": R$ " . $servico['servico_valor_0'] . " |\n";
											$mensagem .= "| " . $servico['servico_descricao_1'] . ": R$ " . $servico['servico_valor_1'] . " |\n";
											$mensagem .= "| " . $servico['servico_descricao_2'] . ": R$ " . $servico['servico_valor_2'] . " |\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| *Valor total: R$ " . number_format($servico['total_valor'], 2, ',', '.') . "* |\n";
											$mensagem .= "\n";
											$mensagem .= "--------------------------------\n";

											// Opções de pagamento
											$mensagem .= "| OPÇÕES DE PAGAMENTO\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| Valor à vista com desconto: R$ *" . number_format($valorAVista, 2, ',', '.') . "* |\n";
											$mensagem .= "| Desconto: R$ " . number_format(($valorOriginal - $valorAVista), 2, ',', '.') . " |\n";
											$mensagem .= "\n";
											$mensagem .= "--------------------------------\n";
											$mensagem .= "| Valor no cartão: R$ *" . number_format($valorCartao, 2, ',', '.') . "* |\n";
											$mensagem .= "| Taxas: R$ " . number_format(($valorCartao - $valorOriginal), 2, ',', '.') . " |\n";
											$mensagem .= "--------------------------------\n";

											// Cabeçalho do recibo
											$cabecalhoRecibo = "------------------------------------------------\n";
											$cabecalhoRecibo .= "|             RECIBO DE SERVIÇOS                |\n";
											$cabecalhoRecibo .= "------------------------------------------------\n";
											$cabecalhoRecibo .= "| *DIAS CAR*                                  |\n";
											$cabecalhoRecibo .= "| Data: " . $dataAtual . "                       |\n";
											$cabecalhoRecibo .= "| Endereço: rua arpoador 1210                  |\n";
											$cabecalhoRecibo .= "| Tel.Fixo: (XX) XXXX-XXXX                     |\n"; // Substitua com o número correto
											$cabecalhoRecibo .= "| Whatsapp: (13) 98170-6744                    |\n";
											$cabecalhoRecibo .= "| CNPJ 19.429.891/0001-24                      |\n";
											$cabecalhoRecibo .= "------------------------------------------------\n\n";

											// Montando o corpo do recibo
											$corpoRecibo = "------------------------------------------------\n";
											$corpoRecibo .= "*ORDEM N° " . $servico['id_ordem'] . "* \n";
											$corpoRecibo .= "------------------------------------------------\n\n";

											// Dados pessoais do cliente
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "DADOS PESSOAIS DO CLIENTE\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| Endereço: " . $servico['endereco_cliente'] . " |\n";
											$corpoRecibo .= "| Número: " . $servico['numero_cliente'] . " |\n";
											$corpoRecibo .= "| Gênero: " . (($servico['sexo_cliente'] == 'M') ? 'Masculino' : 'Feminino') . " |\n";
											$corpoRecibo .= "| Nome: " . $servico['nome_cliente'] . " |\n";
											$corpoRecibo .= "| Email: " . $servico['email_cliente'] . " |\n";
											$corpoRecibo .= "| CPF: " . substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0) . " |\n";
											$corpoRecibo .= "| Telefone: " . preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $servico['telefone_cliente']) . " |\n";
											$corpoRecibo .= "------------------------------------------------\n\n";

											// Informações do veículo
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "VEÍCULO\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| *CARRO: " . $servico['modelo_carro'] . "* |\n";
											$corpoRecibo .= "| *PLACA: " . $servico['placa'] . "* |\n";
											$corpoRecibo .= "------------------------------------------------\n\n";

											// Detalhes do serviço e valores
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "DETALHES DO SERVIÇO\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| Mão de obra: R$ " . $servico['mao_de_obra_valor'] . " |\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| " . $servico['servico_descricao_0'] . ": R$ " . $servico['servico_valor_0'] . " |\n";
											$corpoRecibo .= "| " . $servico['servico_descricao_1'] . ": R$ " . $servico['servico_valor_1'] . " |\n";
											$corpoRecibo .= "| " . $servico['servico_descricao_2'] . ": R$ " . $servico['servico_valor_2'] . " |\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| *Valor total: R$ " . number_format($servico['total_valor'], 2, ',', '.') . "* |\n";
											$corpoRecibo .= "\n";
											$corpoRecibo .= "------------------------------------------------\n";

											// Opções de pagamento
											$corpoRecibo .= "| OPÇÕES DE PAGAMENTO\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| Valor à vista com desconto: R$ *" . number_format($valorAVista, 2, ',', '.') . "* |\n";
											$corpoRecibo .= "| Desconto: R$ " . number_format(($valorOriginal - $valorAVista), 2, ',', '.') . " |\n";
											$corpoRecibo .= "\n";
											$corpoRecibo .= "------------------------------------------------\n";
											$corpoRecibo .= "| Valor no cartão: R$ *" . number_format($valorCartao, 2, ',', '.') . "* |\n";
											$corpoRecibo .= "| Taxas: R$ " . number_format(($valorCartao - $valorOriginal), 2, ',', '.') . " |\n";
											$corpoRecibo .= "------------------------------------------------\n";

											// Rodapé do recibo
											$rodapeRecibo = "------------------------------------------------\n";
											$rodapeRecibo .= "|               OBRIGADO PELA PREFERÊNCIA!     |\n";
											$rodapeRecibo .= "------------------------------------------------\n";

											// Combina todos os elementos do recibo
											$reciboCompleto = $cabecalhoRecibo . $corpoRecibo . $rodapeRecibo;

											$_SESSION['dataAtual'] = $dataAtual;
											$_SESSION['endereco'] = "rua arpoador 1210"; // Exemplo de endereço, substitua conforme necessário
											$_SESSION['telefone'] = "(XX) XXXX-XXXX"; // Substitua com o número correto
											$_SESSION['whatsapp'] = "(13) 98170-6744";
											$_SESSION['cnpj'] = "19.429.891/0001-24";
											$_SESSION['idOrdem'] = $servico['id_ordem'];

											// Dados pessoais do cliente
											$_SESSION['enderecoCliente'] = $servico['endereco_cliente'];
											$_SESSION['numeroCliente'] = $servico['numero_cliente'];
											$_SESSION['generoCliente'] = ($servico['sexo_cliente'] == 'M') ? 'Masculino' : 'Feminino';
											$_SESSION['nomeCliente'] = $servico['nome_cliente'];
											$_SESSION['emailCliente'] = $servico['email_cliente'];
											$_SESSION['cpfCliente'] = $servico['cpf_cliente'];
											$_SESSION['telefoneCliente'] = $servico['telefone_cliente'];

											// Informações do veículo
											$_SESSION['modeloCarro'] = $servico['modelo_carro'];
											$_SESSION['placa'] = $servico['placa'];

											// Detalhes do serviço e valores
											$_SESSION['maoDeObra'] = $servico['mao_de_obra_valor'];
											$_SESSION['servicoDescricao0'] = $servico['servico_descricao_0'];
											$_SESSION['servicoValor0'] = $servico['servico_valor_0'];
											$_SESSION['servicoDescricao1'] = $servico['servico_descricao_1'];
											$_SESSION['servicoValor1'] = $servico['servico_valor_1'];
											$_SESSION['servicoDescricao2'] = $servico['servico_descricao_2'];
											$_SESSION['servicoValor2'] = $servico['servico_valor_2'];
											$_SESSION['totalValor'] = $servico['total_valor'];

											// Opções de pagamento
											$_SESSION['valorAVista'] = $valorAVista;
											$_SESSION['valorCartao'] = $valorCartao;
											$_SESSION['desconto'] = $valorOriginal - $valorAVista;
											$_SESSION['taxas'] = $valorCartao - $valorOriginal;



											// Número de telefone para onde enviar a mensagem (substitua com seu número)
											$telefone_cliente = trim($telefone_cliente);
											$linkWhatsApp = "https://api.whatsapp.com/send?phone=" . urlencode($telefone_cliente) . "&text=" . urlencode($mensagem);


											?>


											<div class="d-grid mt-4 gap-2">
												<!-- Substitua o link atual pelo link do WhatsApp -->


												<a href="<?php echo $linkWhatsApp; ?>" target="_blank" class="btn btn-dark mb-0 mt-2"><i class="bi bi-whatsapp"></i> Enviar ordem via WhatsApp</a>
												<a href="pdf.php" class="btn btn-dark mb-0 mt-2" target="_blank"><i class="bi bi-file-pdf-fill"></i> Gerar recibo PDF</a>


												
											</div>





											<!-- Button -->

										</div>
									</div>
								</div>
							</aside>
							<!-- Sidebar END -->
						</div>
					</div>
				</section>
				<!-- =======================

					
Main Content END -->

			</main>
			<!-- **************** MAIN CONTENT END **************** -->

			<!-- =======================
Footer START -->
		
			<!-- =======================
Footer END -->

			<!-- Back to top -->
			<div class="back-top"></div>

			<!-- Bootstrap JS -->
			<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

			<!-- Vendors -->
			<script src="assets/vendor/sticky-js/sticky.min.js"></script>
			<script src="assets/vendor/glightbox/js/glightbox.js"></script>
			<script src="assets/vendor/flatpickr/js/flatpickr.min.js"></script>
			<script src="assets/vendor/tiny-slider/tiny-slider.js"></script>

			<!-- ThemeFunctions -->
			<script src="assets/js/functions.js"></script>

		</body>

		<!-- Mirrored from booking.webestica.com/cab-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:38:43 GMT -->

		</html>
<?php } else {
		echo isset($_GET['id']) ? "<p>Serviço não encontrado.</p>" : "<p>Nenhum serviço encontrado.</p>";
	}
} catch (PDOException $e) {
	echo 'Erro ao buscar serviços: ' . $e->getMessage();
}
?>