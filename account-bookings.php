<?php
session_start();
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


	// Consulta SQL para contar o número total de clientes
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM clientes");
	$totalClientes = $stmt->fetchColumn();

	// Exibir o total de clientes
	//echo "Total de clientes cadastrados: " . $totalClientes . "<br>";

	// Consulta SQL para contar o número total de carros
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM carros");
	$totalCarros = $stmt->fetchColumn();

	// Exibir o total de carros cadastrados
	//echo "Total de carros cadastrados: " . $totalCarros . "<br>";

	// Consulta SQL para contar o número total de serviços
	$stmt = $conn->query("SELECT COUNT(*) AS total FROM servicos");
	$totalServicos = $stmt->fetchColumn();

	// Exibir o total de serviços cadastrados
	//echo "Total de serviços realizados: " . $totalServicos . "<br>";

} catch (PDOException $e) {
	// Trate erros de conexão
	handleException($e);
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/account-bookings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:04 GMT -->

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

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body class="dashboard">

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
				<button class="navbar-toggler ms-auto mx-3 me-md-0 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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

					<!-- Button -->
					<li class="nav-item ms-3 d-none d-sm-block">

					</li>
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
Content START -->
		<section class="pt-3">
			<div class="container">
				<div class="row g-2 g-lg-4">

					<!-- Sidebar START -->

					<!-- Sidebar END -->

					<!-- Main content START -->
					<center>
						<div class="col-lg-8 col-xl-9 ps-xl-5">

							<!-- Offcanvas menu button -->
							<div class="d-grid mb-0 d-lg-none w-100">
								<button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
									<i class="fas fa-sliders-h"></i> Menu
								</button>
							</div>

							<div class="card border bg-transparent">
								<!-- Card header -->
								<div class="card-header bg-transparent border-bottom">

									<h4 class="card-header-title">Cadastros</h4>
								</div>

								<!-- Card body START -->
								<div class="card-body p-0">

									<!-- Tabs -->
									<ul class="nav nav-tabs nav-bottom-line nav-responsive nav-justified">
										<li class="nav-item">
											<a class="nav-link mb-0 active" data-bs-toggle="tab" href="#tab-1"><i class="bi bi-briefcase-fill fa-fw me-1"></i>Serviços</a>
										</li>
										<li class="nav-item">
											<a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-2"><i class="fa-solid fa-car fa-fw me-1"></i>Carros</a>
										</li>
										<li class="nav-item">
											<a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-3"><i class="bi bi-patch-check fa-fw me-1"></i>Clientes</a>
										</li>
									</ul>

									<!-- Tabs content START -->
									<div class="tab-content p-2 p-sm-4" id="nav-tabContent">

										<!-- Tab content item START -->
										<div class="tab-pane fade show active" id="tab-1">

											<h6>Serviços Registrados (<?php echo $totalServicos;  ?>)</h6>


											<?php
											try {
												// Conectar ao banco de dados
												$conn = getDbConnection();

												// Definir o número de registros por página
												$registros_por_pagina = 5;

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
												$_SESSION['total_registros'] = $total_registros;
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
													<br>
													<?php
													// Formatar valor para reais (formato brasileiro)
													$valorFormatado = 'R$ ' . number_format($servico['valor'], 2, ',', '.');

													// Formatar data para exibir no formato brasileiro (dd/mm/yyyy)
													$dataFormatada = date('d/m/Y', strtotime($servico['data']));
													?>
													<!-- Card item START -->
													<div class="card border">
														<!-- Card header -->
														<div class="card-header border-bottom d-md-flex justify-content-md-between align-items-center">
															<!-- Icon and Title -->
															<div class="d-flex align-items-center">
																<div class="icon-lg bg-light rounded-circle flex-shrink-0"><i class="bi bi-tools"></i></div>
																<!-- Title -->
																<div class="ms-2">
																	<h6 class="card-title mb-0"><?php echo htmlspecialchars($servico['modelo_carro']); ?></h6>
																	<ul class="nav nav-divider small">
																		<li class="nav-item">ID do Serviço: <?php echo htmlspecialchars($servico['id_ordem']); ?></li>
																		<li class="nav-item"><?php echo htmlspecialchars($servico['nome_cliente']); ?></li>
																	</ul>
																</div>
															</div>

															<!-- Button -->
															<div class="mt-2 mt-md-0">
																<a href="crud/delete_servico.php?id=<?php echo $servico['id']; ?>" class="btn btn-danger-soft mb-0"><i class="bi bi-trash"></i></a>
																<a href="crud/edit_servico.php?id=<?php echo $servico['id']; ?>" class="btn btn-primary-soft mb-0"><i class="bi bi-pencil-square"></i></a>
															</div>
														</div>

														<!-- Card body -->
														<div class="card-body">
															<div class="row g-3">
																<div class="col-sm-6 col-md-4">
																	<span>Data do Serviço</span>
																	<h6 class="mb-0"><?php echo $dataFormatada; ?></h6>
																</div>

																<div class="col-sm-6 col-md-4">
																	<span>Valor</span>
																	<h6 class="mb-0"><?php echo $valorFormatado; ?></h6>
																</div>

																<div class="col-md-4">
																	<span>Placa do Carro</span>
																	<h6 class="mb-0"><?php echo htmlspecialchars($servico['placa']); ?></h6>
																</div>
															</div>
														</div>
													</div>
													<!-- Card item END -->


												<?php
												}


												?>


											<?php
											} catch (PDOException $e) {
												// Trate erros de conexão
												handleException($e);
											}
											?>

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

											</div>
										</div>
										<!-- Tabs content item END -->

										<!-- Tab content item START -->
										<div class="tab-pane fade" id="tab-2">
											<h6>Carros Registrados (<?php echo $totalCarros; ?>)</h6>


											<?php
											try {
												// Conectar ao banco de dados
												$conexao_bd = getDbConnection();

												// Definir o número de registros por página
												$registros_por_pagina = 5;

												// Determinar a página atual
												$carro_pagina_atual = isset($_GET['carro_pagina']) ? $_GET['carro_pagina'] : 1;

												// Calcular o offset
												$carro_offset = ($carro_pagina_atual - 1) * $registros_por_pagina;

												// Obter o termo de pesquisa
												$carro_termo_pesquisa = isset($_GET['search']) ? $_GET['search'] : '';

												// Obter o total de registros no banco de dados com base na pesquisa
												$sql_total = "SELECT COUNT(*) FROM carros WHERE modelo LIKE :termo_pesquisa OR placa LIKE :termo_pesquisa";
												$stmt_total = $conexao_bd->prepare($sql_total);
												$stmt_total->bindValue(':termo_pesquisa', '%' . $carro_termo_pesquisa . '%', PDO::PARAM_STR);
												$stmt_total->execute();
												$total_registros = $stmt_total->fetchColumn();

												// Calcular o total de páginas
												$total_paginas = ceil($total_registros / $registros_por_pagina);

												// Consulta SQL para obter os carros com paginação e pesquisa
												$sql = "SELECT * FROM carros WHERE modelo LIKE :termo_pesquisa OR placa LIKE :termo_pesquisa ORDER BY id DESC LIMIT :limit OFFSET :offset";
												$stmt = $conexao_bd->prepare($sql);
												$stmt->bindValue(':termo_pesquisa', '%' . $carro_termo_pesquisa . '%', PDO::PARAM_STR);
												$stmt->bindParam(':limit', $registros_por_pagina, PDO::PARAM_INT);
												$stmt->bindParam(':offset', $carro_offset, PDO::PARAM_INT);
												$stmt->execute();
												$carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

												// Exibir mensagem se nenhum resultado for encontrado
												if (count($carros) == 0) {
													echo '<p class="text-center">Nenhum carro encontrado.</p>';
												}

												// Exibir os carros em cards
												foreach ($carros as $carro) {
											?>
													<br>
													<!-- Card item START -->
													<div class="card border">
														<!-- Card header -->
														<div class="card-header border-bottom d-md-flex justify-content-md-between align-items-center">
															<!-- Icon and Title -->
															<div class="d-flex align-items-center">
																<div class="icon-lg bg-light rounded-circle flex-shrink-0"><i class="fa-solid fa-car"></i></div>
																<!-- Title -->
																<div class="ms-2">
																	<h6 class="card-title mb-0"><?php echo htmlspecialchars($carro['modelo']); ?></h6>
																	<ul class="nav nav-divider small">
																		<li class="nav-item">Placa: <?php echo htmlspecialchars($carro['placa']); ?></li>
																		<li class="nav-item">Ano: <?php echo htmlspecialchars($carro['ano']); ?></li>
																	</ul>
																</div>
															</div>
															<!-- Button -->
															<div class="mt-2 mt-md-0">
																<a href="crud/delete_carro.php?id=<?php echo $carro['id']; ?>" class="btn btn-danger-soft mb-0"><i class="bi bi-trash"></i></a>
																<a href="crud/edit_carro.php?id=<?php echo $carro['id']; ?>" class="btn btn-primary-soft mb-0"><i class="bi bi-pencil-square"></i></a>
															</div>
														</div>
													</div>
													<!-- Card item END -->
											<?php
												}
											} catch (PDOException $e) {
												// Tratar erros de conexão
												handleException($e);
											}
											?>

											<?php
											// Exibir informações de paginação
											$inicio = $carro_offset + 1;
											$fim = min($carro_offset + $registros_por_pagina, $total_registros);
											?>
											<!-- Pagination START -->
											<div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4">
												<!-- Content -->
												<p class="mb-sm-0 text-center text-sm-start">Mostrando <?php echo $inicio; ?> até <?php echo $fim; ?> de <?php echo $total_registros; ?> registros...</p>
												<!-- Pagination -->
												<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
													<ul class="pagination pagination-sm pagination-primary-soft mb-0">
														<!-- Previous Page Link -->
														<li class="page-item <?php echo ($carro_pagina_atual == 1) ? 'disabled' : ''; ?>">
															<a class="page-link" href="?carro_pagina=<?php echo $carro_pagina_atual - 1; ?>#tab-2" tabindex="-1">Anterior</a>
														</li>

														<!-- Always show page 1 -->
														<?php if ($carro_pagina_atual > 2) : ?>
															<li class="page-item">
																<a class="page-link" href="?carro_pagina=1#tab-2">1</a>
															</li>
															<?php if ($carro_pagina_atual > 3) : ?>
																<li class="page-item disabled">
																	<a class="page-link" href="#">...</a>
																</li>
															<?php endif; ?>
														<?php endif; ?>

														<!-- Page Number Links -->
														<?php
														$max_links = 3; // Máximo de links para exibir antes e depois da página atual
														$start = max(1, $carro_pagina_atual - $max_links); // Primeira página no intervalo
														$end = min($total_paginas, $carro_pagina_atual + $max_links); // Última página no intervalo

														// Exibir links das páginas
														for ($pagina = $start; $pagina <= $end; $pagina++) :
														?>
															<li class="page-item <?php echo ($pagina == $carro_pagina_atual) ? 'active' : ''; ?>">
																<a class="page-link" href="?carro_pagina=<?php echo $pagina; ?>#tab-2"><?php echo $pagina; ?></a>
															</li>
														<?php endfor; ?>

														<!-- Always show last page -->
														<?php if ($carro_pagina_atual < $total_paginas - 1) : ?>
															<?php if ($carro_pagina_atual < $total_paginas - 2) : ?>
																<li class="page-item disabled">
																	<a class="page-link" href="#">...</a>
																</li>
															<?php endif; ?>
															<li class="page-item">
																<a class="page-link" href="?carro_pagina=<?php echo $total_paginas; ?>#tab-2"><?php echo $total_paginas; ?></a>
															</li>
														<?php endif; ?>

														<!-- Next Page Link -->
														<li class="page-item <?php echo ($carro_pagina_atual == $total_paginas) ? 'disabled' : ''; ?>">
															<a class="page-link" href="?carro_pagina=<?php echo $carro_pagina_atual + 1; ?>#tab-2">Posterior</a>
														</li>
													</ul>
												</nav>
											</div>
											<!-- Pagination END -->

											<!-- Script para ativar a aba correta -->
											<script>
												document.addEventListener('DOMContentLoaded', function() {
													if (window.location.hash === "#tab-2") {
														var tabElement = document.querySelector('a[href="#tab-2"]');
														var tab = new bootstrap.Tab(tabElement);
														tab.show();
													}
												});
											</script>



										</div>
										<!-- Tabs content item END -->

										<!-- Tab content item START -->
										<div class="tab-pane fade" id="tab-3">
											<h6>Clientes Registrados (<?php echo  $totalClientes;  ?>)</h6>
											<?php
											try {
												// Conectar ao banco de dados
												$conexao_bd = getDbConnection();

												// Definir o número de registros por página para clientes
												$clientes_por_pagina = 5;

												// Determinar a página atual para clientes
												$pagina_atual_cliente = isset($_GET['cliente_pagina']) ? $_GET['cliente_pagina'] : 1;

												// Calcular o offset para clientes
												$offset_cliente = ($pagina_atual_cliente - 1) * $clientes_por_pagina;

												// Obter o termo de pesquisa para clientes
												$termo_pesquisa_cliente = isset($_GET['search_cliente']) ? $_GET['search_cliente'] : '';

												// Obter o total de registros de clientes no banco de dados com base na pesquisa
												$sql_total_cliente = "SELECT COUNT(*) FROM clientes WHERE nome LIKE :termo_pesquisa OR cpf LIKE :termo_pesquisa";
												$stmt_total_cliente = $conexao_bd->prepare($sql_total_cliente);
												$stmt_total_cliente->bindValue(':termo_pesquisa', '%' . $termo_pesquisa_cliente . '%', PDO::PARAM_STR);
												$stmt_total_cliente->execute();
												$total_registros_cliente = $stmt_total_cliente->fetchColumn();

												// Calcular o total de páginas para clientes
												$total_paginas_cliente = ceil($total_registros_cliente / $clientes_por_pagina);

												// Consulta SQL para obter os clientes com paginação e pesquisa
												$sql_cliente = "SELECT * FROM clientes WHERE nome LIKE :termo_pesquisa OR cpf LIKE :termo_pesquisa ORDER BY id DESC LIMIT :limit OFFSET :offset";
												$stmt_cliente = $conexao_bd->prepare($sql_cliente);
												$stmt_cliente->bindValue(':termo_pesquisa', '%' . $termo_pesquisa_cliente . '%', PDO::PARAM_STR);
												$stmt_cliente->bindParam(':limit', $clientes_por_pagina, PDO::PARAM_INT);
												$stmt_cliente->bindParam(':offset', $offset_cliente, PDO::PARAM_INT);
												$stmt_cliente->execute();
												$clientes = $stmt_cliente->fetchAll(PDO::FETCH_ASSOC);

												// Exibir mensagem se nenhum cliente for encontrado
												if (count($clientes) == 0) {
													echo '<p class="text-center">Nenhum cliente encontrado.</p>';
												}

												// Exibir os clientes em cards
												foreach ($clientes as $cliente) {
											?>
													<br>
													<!-- Card item START -->
													<div class="card border">
														<!-- Card header -->
														<div class="card-header border-bottom d-md-flex justify-content-md-between align-items-center">
															<!-- Icon and Title -->
															<div class="d-flex align-items-center">
																<div class="icon-lg bg-light rounded-circle flex-shrink-0"><i class="fa-solid fa-user"></i></div>
																<!-- Title -->
																<div class="ms-2">
																	<h6 class="card-title mb-0"><?php echo htmlspecialchars($cliente['nome']); ?></h6>
																	<ul class="nav nav-divider small">
																		<li class="nav-item">CPF: <?php echo htmlspecialchars($cliente['cpf']); ?></li>
																	</ul>
																</div>
															</div>
															<!-- Button -->
															<div class="mt-2 mt-md-0">

																<a href="crud/edit_cliente.php?id=<?php echo $cliente['id']; ?>" class="btn btn-primary-soft mb-0"><i class="bi bi-pencil-square"></i></a>
															</div>
														</div>
													</div>
													<!-- Card item END -->
											<?php
												}
											} catch (PDOException $e) {
												// Tratar erros de conexão
												handleException($e);
											}
											?>

											<?php
											// Exibir informações de paginação para clientes
											$inicio_cliente = $offset_cliente + 1;
											$fim_cliente = min($offset_cliente + $clientes_por_pagina, $total_registros_cliente);
											?>
											<!-- Pagination START -->
											<div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4">
												<!-- Content -->
												<p class="mb-sm-0 text-center text-sm-start">Mostrando <?php echo $inicio_cliente; ?> até <?php echo $fim_cliente; ?> de <?php echo $total_registros_cliente; ?> registros...</p>
												<!-- Pagination -->
												<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
													<ul class="pagination pagination-sm pagination-primary-soft mb-0">
														<!-- Previous Page Link -->
														<li class="page-item <?php echo ($pagina_atual_cliente == 1) ? 'disabled' : ''; ?>">
															<a class="page-link" href="?cliente_pagina=<?php echo $pagina_atual_cliente - 1; ?>#tab-3" tabindex="-1">Anterior</a>
														</li>

														<!-- Always show page 1 -->
														<?php if ($pagina_atual_cliente > 2) : ?>
															<li class="page-item">
																<a class="page-link" href="?cliente_pagina=1#tab-3">1</a>
															</li>
															<?php if ($pagina_atual_cliente > 3) : ?>
																<li class="page-item disabled">
																	<a class="page-link" href="#">...</a>
																</li>
															<?php endif; ?>
														<?php endif; ?>

														<!-- Page Number Links -->
														<?php
														$max_links_cliente = 3; // Máximo de links para exibir antes e depois da página atual
														$start_cliente = max(1, $pagina_atual_cliente - $max_links_cliente); // Primeira página no intervalo
														$end_cliente = min($total_paginas_cliente, $pagina_atual_cliente + $max_links_cliente); // Última página no intervalo

														// Exibir links das páginas
														for ($pagina_cliente = $start_cliente; $pagina_cliente <= $end_cliente; $pagina_cliente++) :
														?>
															<li class="page-item <?php echo ($pagina_cliente == $pagina_atual_cliente) ? 'active' : ''; ?>">
																<a class="page-link" href="?cliente_pagina=<?php echo $pagina_cliente; ?>#tab-3"><?php echo $pagina_cliente; ?></a>
															</li>
														<?php endfor; ?>

														<!-- Always show last page -->
														<?php if ($pagina_atual_cliente < $total_paginas_cliente - 1) : ?>
															<?php if ($pagina_atual_cliente < $total_paginas_cliente - 2) : ?>
																<li class="page-item disabled">
																	<a class="page-link" href="#">...</a>
																</li>
															<?php endif; ?>
															<li class="page-item">
																<a class="page-link" href="?cliente_pagina=<?php echo $total_paginas_cliente; ?>#tab-3"><?php echo $total_paginas_cliente; ?></a>
															</li>
														<?php endif; ?>

														<!-- Next Page Link -->
														<li class="page-item <?php echo ($pagina_atual_cliente == $total_paginas_cliente) ? 'disabled' : ''; ?>">
															<a class="page-link" href="?cliente_pagina=<?php echo $pagina_atual_cliente + 1; ?>#tab-3">Posterior</a>
														</li>
													</ul>
												</nav>
											</div>
											<!-- Pagination END -->

											<!-- Script para ativar a aba correta -->
											<script>
												document.addEventListener('DOMContentLoaded', function() {
													if (window.location.hash === "#tab-3") {
														var tabElement = document.querySelector('a[href="#tab-3"]');
														var tab = new bootstrap.Tab(tabElement);
														tab.show();
													}
												});
											</script>


										</div>
										<!-- Tabs content item END -->
									</div>

								</div>
								<!-- Card body END -->

								<a href="admin-booking-list.php" class="btn btn-primary-soft mb-0">Voltar</a>
							</div>
						</div>
					</center>
					<!-- Main content END -->
				</div>
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
						<a href="index.php"> <img class="h-30px" src="assets/images/logo-light.svg" alt="logo"> </a>
					</div>
				</div>

				<!-- Widget -->
				<div class="col-md-4">
				<div class="text-body-secondary text-primary-hover"> Copyrights ©<?php echo date("Y"); ?> Dias Car. Desenvolvido e projetado por <a href="https://adrieldias.netlify.app/" class="text-body-secondary">Adriel Dias</a>. </div>
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

	<!-- ThemeFunctions -->
	<script src="assets/js/functions.js"></script>

</body>

<!-- Mirrored from booking.webestica.com/account-bookings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:04 GMT -->

</html>