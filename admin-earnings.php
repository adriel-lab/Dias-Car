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


	$mediaMensal = $totalServicosAnoAtual / 12;





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

	// Configurar o fuso horário para São Paulo
	date_default_timezone_set('America/Sao_Paulo');

	// Obter o mês atual e o ano atual
	$mesAtual = date('n'); // Retorna o mês atual sem zeros à esquerda (1 a 12)
	$anoAtual = date('Y'); // Retorna o ano atual com 4 dígitos

	// Função para verificar se o ano é bissexto
	function ehBissexto($ano)
	{
		return (($ano % 4 == 0 && $ano % 100 != 0) || $ano % 400 == 0);
	}

	// Array associativo com a quantidade de dias em cada mês
	$diasPorMes = array(
		1 => 31, // Janeiro
		2 => (ehBissexto($anoAtual) ? 29 : 28), // Fevereiro (considerando se é bissexto)
		3 => 31, // Março
		4 => 30, // Abril
		5 => 31, // Maio
		6 => 30, // Junho
		7 => 31, // Julho
		8 => 31, // Agosto
		9 => 30, // Setembro
		10 => 31, // Outubro
		11 => 30, // Novembro
		12 => 31 // Dezembro
	);

	// Obtendo o número de dias do mês atual
	$numDiasMesAtual = $diasPorMes[$mesAtual];

	// Exibindo o resultado
	//echo "O mês atual (". date('F') .") tem $numDiasMesAtual dias.";

	$mediaDiaria = $totalServicosMesAtual / $numDiasMesAtual;

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


	// Obtenha uma conexão com o banco de dados
	$conn = getDbConnection();
	date_default_timezone_set('America/Sao_Paulo');
	// Data atual
	$dataAtual = date('Y-m-d');

	// Obter o primeiro dia do mês atual
	$primeiroDiaMesAtual = date('Y-m-01');

	// Calcular o valor total dos serviços no mês atual até agora
	$sql = "SELECT SUM(valor) AS total FROM servicos WHERE data BETWEEN :primeiroDiaMesAtual AND :dataAtual";
	$stmt = $conn->prepare($sql);
	$stmt->execute([':primeiroDiaMesAtual' => $primeiroDiaMesAtual, ':dataAtual' => $dataAtual]);
	$totalServicosMesAtual = $stmt->fetchColumn();

	// Calcular o número de dias no mês atual até hoje
	$numDiasMesAtual = date('j');




	// Verificar se já existe uma média diária registrada para a data atual
	$sqlVerificar = "SELECT COUNT(*) FROM medias_diarias WHERE data = :dataAtual";
	$stmtVerificar = $conn->prepare($sqlVerificar);
	$stmtVerificar->execute([':dataAtual' => $dataAtual]);
	$existe = $stmtVerificar->fetchColumn();

	if ($existe) {
		// Se existir, atualizar o registro
		$sqlUpdate = "UPDATE medias_diarias SET media_diaria = :mediaDiaria WHERE data = :dataAtual";
		$stmtUpdate = $conn->prepare($sqlUpdate);
		$stmtUpdate->execute([':mediaDiaria' => $mediaDiaria, ':dataAtual' => $dataAtual]);
	} else {
		// Se não existir, inserir um novo registro
		$sqlInsert = "INSERT INTO medias_diarias (data, media_diaria) VALUES (:dataAtual, :mediaDiaria)";
		$stmtInsert = $conn->prepare($sqlInsert);
		$stmtInsert->execute([':dataAtual' => $dataAtual, ':mediaDiaria' => $mediaDiaria]);
	}

	// Obter a média diária do dia anterior
	$dataDiaAnterior = date('Y-m-d', strtotime('-1 day'));
	$sqlAnterior = "SELECT media_diaria FROM medias_diarias WHERE data = :dataDiaAnterior";
	$stmtAnterior = $conn->prepare($sqlAnterior);
	$stmtAnterior->execute([':dataDiaAnterior' => $dataDiaAnterior]);
	$mediaDiariaAnterior = $stmtAnterior->fetchColumn();



	if ($mediaDiariaAnterior !== false) {
		// Calcular a diferença entre os valores
		$diferenca = $mediaDiaria - $mediaDiariaAnterior;

		// Calcular o aumento percentual
		$aumentoPercentual = ($diferenca / $mediaDiariaAnterior) * 100;

		// Exibir o resultado
		//echo "O aumento percentual foi de " . number_format($aumentoPercentual, 2) . "%<br>";
		$aumento = number_format($aumentoPercentual, 2) . "%<br>";
	} else {
		// echo "Não há dados anteriores para comparar.<br>";
		$aumento = '0%';
	}

	// Exibir a média diária atual
	// echo "Ganho médio diário no dia atual: R$ " . number_format($mediaDiaria, 2, ',', '.');


	date_default_timezone_set('America/Sao_Paulo');

	// Data atual
	$dataAtualMes = date('Y-m-d');

	// Obter o primeiro dia do ano atual
	$primeiroDiaAnoAtual = date('Y-01-01');

	// Obter o primeiro dia do mês atual
	$primeiroDiaMesAtual = date('Y-m-01');

	// Obter o primeiro dia do mês anterior
	$primeiroDiaMesAnterior = date('Y-m-01', strtotime('first day of last month'));

	// Obter o último dia do mês anterior
	$ultimoDiaMesAnterior = date('Y-m-t', strtotime('last month'));

	// Calcular o valor total dos serviços no ano atual até agora
	$sqlTotalAno = "SELECT SUM(valor) AS total FROM servicos WHERE data BETWEEN :primeiroDiaAnoAtual AND :dataAtualMes";
	$stmtTotalAno = $conn->prepare($sqlTotalAno);
	$stmtTotalAno->execute([':primeiroDiaAnoAtual' => $primeiroDiaAnoAtual, ':dataAtualMes' => $dataAtualMes]);
	$totalServicosAno = $stmtTotalAno->fetchColumn();
	$totalServicosAno = $totalServicosAno ? $totalServicosAno : 0; // Garantir que não seja nulo

	// Calcular o valor total dos serviços no mês anterior
	$sqlTotalMesAnterior = "SELECT SUM(valor) AS total FROM servicos WHERE data BETWEEN :primeiroDiaMesAnterior AND :ultimoDiaMesAnterior";
	$stmtTotalMesAnterior = $conn->prepare($sqlTotalMesAnterior);
	$stmtTotalMesAnterior->execute([':primeiroDiaMesAnterior' => $primeiroDiaMesAnterior, ':ultimoDiaMesAnterior' => $ultimoDiaMesAnterior]);
	$totalServicosMesAnterior = $stmtTotalMesAnterior->fetchColumn();
	$totalServicosMesAnterior = $totalServicosMesAnterior ? $totalServicosMesAnterior : 0; // Garantir que não seja nulo

	// Calcular o número de meses no ano atual até agora
	$numMesesAno = date('n');

	// Calcular a média mensal do ano atual até agora
	$mediaMensalAno = $mediaMensal;

	// Verificar se já existe uma média mensal registrada para o mês atual e ano atual
	$sqlVerificarMesAtual = "SELECT COUNT(*) FROM medias_anuais WHERE ano = :anoAtual AND mes = :mesAtual";
	$stmtVerificarMesAtual = $conn->prepare($sqlVerificarMesAtual);
	$stmtVerificarMesAtual->execute([':anoAtual' => date('Y'), ':mesAtual' => date('n')]);
	$existeMesAtual = $stmtVerificarMesAtual->fetchColumn();

	if ($existeMesAtual) {
		// Se existir, atualizar o registro existente do mês e ano atual
		$sqlUpdateMesAtual = "UPDATE medias_anuais SET media_mensal = :mediaMensalAno WHERE ano = :anoAtual AND mes = :mesAtual";
		$stmtUpdateMesAtual = $conn->prepare($sqlUpdateMesAtual);
		$stmtUpdateMesAtual->execute([':mediaMensalAno' => $mediaMensalAno, ':anoAtual' => date('Y'), ':mesAtual' => date('n')]);
	} else {
		// Se não existir, inserir um novo registro para o mês atual e ano atual
		$sqlInsertMesAtual = "INSERT INTO medias_anuais (ano, mes, media_mensal) VALUES (:anoAtual, :mesAtual, :mediaMensalAno)";
		$stmtInsertMesAtual = $conn->prepare($sqlInsertMesAtual);
		$stmtInsertMesAtual->execute([':anoAtual' => date('Y'), ':mesAtual' => date('n'), ':mediaMensalAno' => $mediaMensalAno]);
	}

	// Ler o valor da média mensal do mês anterior do ano atual (ou retornar zero se não houver registro)
	$sqlSelecionarMesAnterior = "SELECT COALESCE(media_mensal, 0) AS media_mensal FROM medias_anuais WHERE ano = :anoAtual AND mes = :mesAnterior";
	$stmtSelecionarMesAnterior = $conn->prepare($sqlSelecionarMesAnterior);
	$stmtSelecionarMesAnterior->execute([':anoAtual' => date('Y'), ':mesAnterior' => date('n', strtotime('last month'))]);
	$mediaMensalMesAnterior = $stmtSelecionarMesAnterior->fetchColumn();

	// Calcular o aumento percentual entre a média mensal do ano atual e a média mensal do mês anterior
	if ($mediaMensalMesAnterior !== false && $mediaMensalMesAnterior != 0) {
		$diferencaMes = $mediaMensalAno - $mediaMensalMesAnterior;
		$aumentoPercentualMes = ($diferencaMes / $mediaMensalMesAnterior) * 100;
		$aumentoMes = number_format($aumentoPercentualMes, 2) . "%<br>";
	} else {
		$aumentoMes = '0%';
	}



	$sqlTotal = "SELECT SUM(valor) AS total FROM servicos";
	$stmtTotal = $conn->prepare($sqlTotal);
	$stmtTotal->execute();
	$totalServicos = $stmtTotal->fetchColumn();

	if ($totalServicos === null) {
		$totalServicos = 0;
	}

	// Agora $totalServicos contém a soma de todos os valores da coluna 'valor' na tabela todos os anos de 'servicos'

	//echo "". $totalServicos ."";



} catch (PDOException $e) {
	// Trate erros de conexão
	handleException($e);
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/admin-earnings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:52 GMT -->

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






						<li class="nav-item"> <a class="nav-link" href="admin-booking-list.php">Serviços</a></li>
						<li class="nav-item"> <a class="nav-link" href="account-bookings.php">Cadastros</a></li>
						<!-- Menu item -->
						<li class="nav-item"> <a class="nav-link active" href="admin-earnings.php">Receitas</a></li>




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
						<h1 class="h3 mb-0">Receitas</h1>
					</div>
				</div>

				<!-- Earning block START -->
				<div class="row g-4">
					<!-- Block item -->
					<div class="col-sm-6 col-xxl-3">
						<div class="card card-body bg-light p-4 h-100">
							<h6>Ganhos médios diários
								<a tabindex="0" class="h6 mb-0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="top" data-bs-content="Os ganhos médios diários correspondem ao total mensal dividido pela quantidade de dias do mês atual.">
									<i class="bi bi-info-circle-fill small"></i>
								</a>
							</h6>

							<h3 class="mb-2 mt-2"> <?php echo 'R$ ' . number_format($mediaDiaria, 2, ',', '.'); ?></h3>

							<?php $aumento = (float) str_replace('%', '', $aumento); ?>

							<?php if ($aumento > 0) { ?>
								<p class="mt-auto mb-0">Aumento em relação ao dia anterior <span class="badge bg-success bg-opacity-10 text-success"> <i class="bi bi-graph-up"> +<?php echo $aumento; ?>%</i></span></p>
							<?php
							} else if ($aumento < 0) {
							?>
								<p class="mt-auto mb-0">Queda em relação ao dia anterior <span class="badge bg-danger bg-opacity-10 text-danger"> <i class="bi bi-graph-down"> <?php echo $aumento; ?>%</i></span></p>
							<?php
							} else {
							?>
								<p class="mt-auto mb-0">Não houve variação em relação ao dia passado <span class="badge bg-danger bg-opacity-10 text-danger"> <i class="bi bi-graph-down"></i> <?php echo $aumento; ?>%</span></p>
							<?php } ?>

						</div>
					</div>

					<!-- Block item -->
					<div class="col-sm-6 col-xxl-3">
						<div class="card card-body bg-light p-4 h-100">
							<h6>Ganhos médios mensais
								<a tabindex="0" class="h6 mb-0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="top" data-bs-content="Os ganhos médios mensais são obtidos ao se dividir o valor total acumulado ao longo do ano pela quantidade de meses no ano corrente, ou seja, doze meses. Este cálculo fornece uma média representativa dos ganhos mensais ao longo do ano.">
									<i class="bi bi-info-circle-fill small"></i>
								</a>
							</h6>

							<h3 class="mb-2 mt-2"> <?php echo 'R$ ' . number_format($mediaMensal, 2, ',', '.'); ?></h3>

							<?php $aumentoMes = (float) str_replace('%', '', $aumentoMes); ?>

							<?php if ($aumentoMes > 0) { ?>
								<p class="mt-auto mb-0">Aumento em relação ao mês passado <span class="badge bg-success bg-opacity-10 text-success"> <i class="bi bi-graph-up"></i> +<?php echo $aumentoMes; ?>%</span></p>
							<?php } elseif ($aumentoMes < 0) { ?>
								<p class="mt-auto mb-0">Queda em relação ao mês passado <span class="badge bg-danger bg-opacity-10 text-danger"> <i class="bi bi-graph-down"></i> -<?php echo abs($aumentoMes); ?>%</span></p>
							<?php } else { ?>
								<p class="mt-auto mb-0">Não houve variação em relação ao mês passado <span class="badge bg-danger bg-opacity-10 text-danger"> <i class="bi bi-graph-down"></i> <?php echo $aumentoMes; ?>%</span></p>
							<?php } ?>


						</div>
					</div>

					<!-- Block item -->
					<div class="col-sm-6 col-xxl-3">
						<div class="card card-body bg-light p-4 h-100">
							<h6>On hold
								<a tabindex="0" class="h6 mb-0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="top" data-bs-content="<?php
																																										echo "Faça download do relatório financeiro em PDF para o mês: " . date('m') . " e ano " . date('Y') . " com todos os registros.";
																																										?>">
									<i class="bi bi-info-circle-fill small"></i>
								</a>
							</h6>

<br>
							<div class="container text-center">
								<div class="row align-items-start">
									<div class="col">
										<div class="d-grid"><a href="pdf/mes.php" target="_blank" class="btn btn-primary-soft mb-0"><i class="bi bi-filetype-pdf"></i> Baixar Relatório do Mês</a></div>
										<br>
										<div class="d-grid"><a href="pdf/ano.php" target="_blank" class="btn btn-primary-soft mb-0"><i class="bi bi-filetype-pdf"></i> Baixar Relatório do Ano</a></div>
									</div>

									<div class="col">
										<div class="d-grid"><a href="pdf/completo.php" target="_blank" class="btn btn-primary-soft mb-0"><i class="bi bi-filetype-pdf"></i> Baixar Relatório Completo</a></div>
										<br>

									
										<label for="exampleFormControlInput1" style="font-size: 10px; color:#5143d9;" class="form-label">*Download PDF do intervalo desejado</label>
										<form action="pdf/custom.php" method="POST" target="_blank">
											<div class="input-group input-group-sm mb-3">
												<select class="form-control" name="mes" aria-label="Mês" aria-describedby="inputGroup-sizing-sm" required>
													<option value="" disabled selected>Mês</option>
													<option value="01">JAN</option>
													<option value="02">FEV</option>
													<option value="03">MAR</option>
													<option value="04">ABR</option>
													<option value="05">MAI</option>
													<option value="06">JUN</option>
													<option value="07">JUL</option>
													<option value="08">AGO</option>
													<option value="09">SET</option>
													<option value="10">OUT</option>
													<option value="11">NOV</option>
													<option value="12">DEZ</option>
												</select>
												<input type="text" class="form-control" name="ano" placeholder="Ano" aria-label="Ano" aria-describedby="inputGroup-sizing-sm" required>
												<button class="btn btn-primary-soft mb-0" type="submit" id="button-addon1">Baixar</button>
											</div>
										</form>

									</div>
								</div>
							</div>


						</div>
					</div>

					<!-- Block item -->
					<div class="col-sm-6 col-xxl-3">
						<div class="card bg-primary p-4">
							<div class="d-flex justify-content-between align-items-start text-white">
								<i class="bi bi-cash-coin" style="font-size: 40px;"></i>
								<!-- Card action START -->
								<div class="dropdown">
									<a class="text-white" href="#" id="creditcardDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
										<!-- Dropdown Icon -->
										<i class="bi bi-info-square-fill"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="creditcardDropdown">
										<p>O balanço total corresponde à soma de todas as receitas registradas no sistema e ao montante total ganho desde o início do uso do sistema. </p>
									</ul>
								</div>
								<!-- Card action END -->
							</div>
							<div class="mt-4 text-white">
								<span>Balanço total</span>
								<h3 class="text-white mb-0"> <?php echo 'R$ ' . number_format($totalServicos, 2, ',', '.'); ?></h3>
							</div>
							<?php
							// Obtém a data atual
							date_default_timezone_set('America/Sao_Paulo');
							$anoAtual = date('Y');
							$mesAtual = date('m');
							$diaAtual = date('d');
							$horaAtual = date('H')

							?>
							<h5 class="text-white mt-4">**** **** **** <?php echo $horaAtual . $diaAtual; ?></h5>
							<div class="d-flex justify-content-between text-white">


								<span>Data atual: <?php echo $mesAtual; ?>/<?php echo $anoAtual ?></span>
								<span>CVV: ***</span>
							</div>
						</div>
					</div>
				</div>
				<!-- Earning block END -->

				<!-- Payment history START -->
				<div class="card shadow mt-5">
					<!-- Card header -->
					<div class="card-header border-bottom">
						<h5 class="card-title mb-0">Histórico de pagamento</h5>
					</div>

					<!-- Card body START -->
					<div class="card-body">
						<!-- Table head -->
						<div class="bg-light rounded p-3 d-none d-sm-block">
							<div class="row row-cols-7 g-4">
								<div class="col">
									<h6 class="mb-0">N° da ordem</h6>
								</div>
								<div class="col">
									<h6 class="mb-0">Data</h6>
								</div>
								<div class="col">
									<h6 class="mb-0">Valor total</h6>
								</div>
								<div class="col">
									<h6 class="mb-0">Carro</h6>
								</div>

							</div>
						</div>
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

								<!-- Table data -->
								<div class="row row-cols-xl-7 g-4 align-items-sm-center border-bottom px-2 py-4">
									<!-- Data item -->
									<div class="col">
										<small class="d-block d-sm-none">Booked by:</small>
										<h6 class="fw-light mb-0"><?php echo $servico['id_ordem']; ?></h6>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-sm-none">Date:</small>
										<?php $data_formatada = date('d/m/Y', strtotime($servico['data']));	?>

										<h6 class="mb-0 fw-normal"><?php echo $data_formatada; ?></h6>
									</div>

									<!-- Data item -->
									<div class="col position-relative">
										<small class="d-block d-sm-none">Amount:</small>

										<div class="d-flex">
											<h6 class="mb-0 me-1"><?php $valor = $servico['valor'];
																	$valorFormatado = number_format($valor, 2, ',', '.');
																	echo "R$ " . $valorFormatado; ?> </h6>
											<!-- Dropdown icon -->
											<a href="#" class="h6 mb-0" role="button" id="dropdownShare1" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-info-circle-fill"></i>
											</a>
											<!-- Dropdown items -->

										</div>
									</div>

									<!-- Data item -->
									<div class="col">
										<small class="d-block d-sm-none">Status:</small>
										<div class="badge bg-warning bg-opacity-10 text-warning"><?php echo implode(' ', array_slice(explode(' ', $servico['modelo_carro']), 0, 2)); ?> - PLACA: <?php echo $servico['placa'] ?></div>
									</div>

									<!-- Data item -->

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
					<!-- Card body END -->
					<?php


					// Exibir informações de paginação
					$inicio = $offset + 1;
					$fim = min($offset + $registros_por_pagina, $total_registros);
					?>

					<!-- Card footer START -->
					<div class="card-footer pt-0">
						<!-- Pagination and content -->
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

					</div>
					<!-- Card footer END -->
				</div>
				<!-- Payment history END -->

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

<!-- Mirrored from booking.webestica.com/admin-earnings.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:52 GMT -->

</html>