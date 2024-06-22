<?php
// Iniciar a sessão
session_start();

// Verificar se as variáveis de sessão existem e então usá-las
if (isset($_SESSION['nome_mes']) && isset($_SESSION['anoAtual'])) {
	$nome_mes = $_SESSION['nome_mes'];
	$anoAtual = $_SESSION['anoAtual'];

	// Exemplo de uso das variáveis de sessão
	//echo "Nenhum registro encontrado para o mês de $nome_mes de $anoAtual";


?>

	<!DOCTYPE html>
	<html lang="en">

	<!-- Mirrored from booking.webestica.com/error.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:03 GMT -->

	<head>
		<title>Error</title>

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



					<!-- Main navbar START -->

					<!-- Main navbar END -->

					<!-- Header right side START -->
					<ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">
						<!-- Dark mode options START -->
						<li class="nav-item dropdown me-2">
							<button class="btn btn-link text-warning p-0 mb-0" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-circle-half theme-icon-active fa-fw" viewBox="0 0 16 16">
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
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch me-1" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
											<use href="#"></use>
										</svg>Auto
									</button>
								</li>
							</ul>
						</li>
						<!-- Dark mode options END -->



					</ul>
					<!-- Header right side END -->

				</div>
			</nav>
			<!-- Logo Nav END -->
		</header>
		<!-- Header END -->

		<!-- **************** MAIN CONTENT START **************** -->
		<main>

			<!-- =======================
Main banner START -->
			<section>
				<div class="container">
					<div class="row align-items-center">
						<div class="col-md-10 text-center mx-auto">
							<!-- Image -->
							<img src="dias.png" style="height: 300px;" class="light-mode-item " alt="">
							<img src="diasW.png" style="height: 300px;" class="dark-mode-item " alt="">

							<!-- Title -->
							<h1 style="color: #ed1b24;" class="display-1 mb-0">404</h1>
							<!-- Subtitle -->
							<h2>Ah não, algo deu errado!</h2>
							<!-- info -->
							<p class="mb-4"><?php echo "Nenhum registro encontrado para o mês de $nome_mes de $anoAtual"; ?></p>
							<!-- Button -->
							<a href="voltar.php" class="btn btn-light mb-0">Voltar</a>
						</div>
					</div>
				</div>
			</section>
			<!-- =======================
Main banner START -->

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

		<!-- ThemeFunctions -->
		<script src="assets/js/functions.js"></script>

	</body>

	<!-- Mirrored from booking.webestica.com/error.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:39:03 GMT -->

	</html>
<?php
} else {
	echo "As variáveis de sessão não foram definidas.";
}
?>