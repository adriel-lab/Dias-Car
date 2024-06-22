<?php session_start()  ?>
<?php

include 'db_connection.php';


// Obter a lista de clientes para o dropdown
$conn = getDbConnection();
$clientes = [];
if ($conn) {
    try {
        $stmt = $conn->query("SELECT id, nome FROM clientes");
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao obter clientes: " . $e->getMessage();
    }
    $conn = null;
}
?>





<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from booking.webestica.com/add-listing-minimal.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:38:50 GMT -->

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
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Poppins:wght@400;500;700&amp;display=swap">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/choices/css/choices.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/dropzone/css/dropzone.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

</head>

<body>

    <!-- Header START -->
    <header class="navbar-light header-sticky">
        <!-- Logo Nav START -->
        <nav class="navbar navbar-expand-xl">
            <div class="container">
                <!-- Logo START -->
                <a class="navbar-brand" href="../index.php">
                    <img class="light-mode-item navbar-brand-item" src="../assets/images/logo.svg" alt="logo">
                    <img class="dark-mode-item navbar-brand-item" src="../ssets/images/logo-light.svg" alt="logo">
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
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav navbar-nav-scroll mx-auto">
                        <!-- Nav item Listing -->
                    
                    </ul>
                </div>
                <!-- Main navbar END -->

                    <!-- Profile dropdown START -->
                    <li class="nav-item ms-3 dropdown">
                        <!-- Avatar -->
                        <a class="avatar avatar-xs p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="avatar-img rounded-circle" src="../assets/images/avatar/01.jpg" alt="avatar">
                        </a>

                        <!-- Profile dropdown START -->
                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                            <!-- Profile info -->
                            <li class="px-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <img class="avatar-img rounded-circle shadow" src="../assets/images/avatar/01.jpg" alt="avatar">
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
                <!-- Profile and Notification START -->
            </div>
        </nav>
        <!-- Logo Nav END -->
    </header>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Page Banner START -->
        <section class="pt-4 pt-md-5 pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto text-center">
                        <h1 class="fs-2 mb-2"> CADASTRAR CARRO</h1>
                        <p class="mb-0">Cadastre os carros dos clientes aqui.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Page Banner END -->

        <!-- =======================
Main content START -->
<style>
        .message-container {
            text-align: center;
            margin-top: 20px; /* Ajuste conforme necessário */
        }
    </style>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                  
                        <?php if (isset($_SESSION['success_message'])) : ?>
                           
                            <div class="message-container"  style="color: green;"><?php echo $_SESSION['success_message']; ?></div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error_message'])) : ?>
                            <div class="message-container"  style="color: red;"><?php echo $_SESSION['error_message']; ?></div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <form method="POST" action="upCarro.php" class="vstack gap-4">

                            <!-- Owner Detail START -->
                            <div class="card shadow">
                                <!-- Card header -->
                                <div class="card-header border-bottom">
                                    <h5 class="mb-0">Cadastrar carro</h5>
                                </div>

                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Owner name -->

                                        <div class="col-md-6">

                                            <label class="form-label" for="cliente_id">Cliente:</label>
                                            <select class="form-select js-choice" data-search-enabled="true" id="cliente_id" name="cliente_id" required>
                                                <?php foreach ($clientes as $cliente) : ?>
                                                    <option value="<?= $cliente['id'] ?>"><?= $cliente['nome'] ?></option>
                                                <?php endforeach; ?>
                                            </select><br>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="modelo">Modelo:</label>
                                            <input class="form-control" type="text" id="modelo" name="modelo" required><br>
                                        </div>

                                        <!-- Contact number -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="ano">Ano:</label>
                                            <input class="form-control" type="number" id="ano" name="ano" required><br>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="placa">Placa:</label>
                                            <input class="form-control" type="text" id="placa" name="placa" required><br>
                                        </div>
                                        <div class="text-end">
                                            <a href="../../index.php">Voltar</a>
                                            <button class="btn btn-primary mb-0" type="submit">Cadastrar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                           
                                           <a href="cadastrar_servico.php" class="btn btn-primary-soft mb-0"><i class="bi bi-arrow-right"></i> Gerar ordem</a><br>
                                       </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Main content END -->

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
                        <a href="../index.php"> <img class="h-30px" src="../assets/images/logo-light.svg" alt="logo"> </a>
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
    <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendors -->
    <script src="../assets/vendor/choices/js/choices.min.js"></script>
    <script src="../assets/vendor/dropzone/js/dropzone.js"></script>

    <!-- ThemeFunctions -->
    <script src="../assets/js/functions.js"></script>

</body>

<!-- Mirrored from booking.webestica.com/add-listing-minimal.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 12:38:50 GMT -->

</html>