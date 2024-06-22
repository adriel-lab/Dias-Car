<?php
// Incluir o arquivo de configuração do banco de dados e funções úteis
include 'db_connection.php'; // Supondo que 'config.php' contém a função getDbConnection() e outras configurações

// Verificar se o parâmetro 'id' foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirecionar para alguma página de erro, pois o ID do cliente não foi fornecido
  echo 'Error 404';
    exit();
}

// Inicializa variáveis para armazenar os dados do cliente
$id_cliente = $_GET['id'];
$nome = '';
$cpf = '';
$email = '';
$telefone = '';

try {
    // Conectar ao banco de dados
    $conn = getDbConnection();

    // Verificar se o formulário foi submetido
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extrair os dados do formulário
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        // Query para atualizar o cliente no banco de dados
        $sql_update = "UPDATE clientes SET 
                        nome = :nome,
                        cpf = :cpf,
                        email = :email,
                        telefone = :telefone
                       WHERE id = :id";

        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_update->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt_update->bindParam(':id', $id_cliente, PDO::PARAM_INT);

        $stmt_update->execute();

        // Redirecionar para uma página de sucesso ou para a listagem de clientes após a atualização
        echo "<script>window.location='../account-bookings.php?cliente_pagina=1#tab-3';</script>";
        exit();
    }

    // Query para selecionar os dados do cliente a ser editado
    $sql_select = "SELECT * FROM clientes WHERE id = :id";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindParam(':id', $id_cliente, PDO::PARAM_INT);
    $stmt_select->execute();

    $cliente = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        // Se não encontrar o cliente, redirecionar ou exibir mensagem de erro
        header("Location: erro.php");
        exit();
    }

    // Extrair dados do cliente
    $nome = $cliente['nome'];
    $cpf = $cliente['cpf'];
    $email = $cliente['email'];
    $telefone = $cliente['telefone'];

} catch (PDOException $e) {
    // Trate erros de conexão ou de atualização
    handleException($e);
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

                <!-- Profile and Notification START -->
                <ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">
                    <!-- Search dropdown START -->

                    <!-- Search dropdown END -->

                    <!-- Notification dropdown START -->

                    <!-- Notification dropdown END -->

                    <!-- Profile dropdown START -->
                    <li class="nav-item dropdown">
                        <!-- Avatar -->
                        <a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="avatar-img rounded-2" src="../assets/images/avatar/01.jpg" alt="avatar">
                        </a>

                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                            <!-- Profile info -->
                            <li class="px-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <img class="avatar-img rounded-circle shadow" src="../assets/images/avatar/01.jpg" alt="avatar">
                                    </div>
                                    <div>
                                        <a class="h6 mt-2 mt-sm-0" href="#">Lori Ferguson</a>
                                        <p class="small m-0">example@gmail.com</p>
                                    </div>
                                </div>
                            </li>

                            <!-- Links -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark-check fa-fw me-2"></i>My Bookings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-heart fa-fw me-2"></i>My Wishlist</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear fa-fw me-2"></i>Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle fa-fw me-2"></i>Help Center</a></li>
                            <li><a class="dropdown-item bg-danger-soft-hover" href="#"><i class="bi bi-power fa-fw me-2"></i>Sign Out</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <!-- Dark mode options START -->
                            <li>
                                <div class="nav-pills-primary-soft theme-icon-active d-flex justify-content-between align-items-center p-2 pb-0">
                                    <span>Mode:</span>
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
Page Banner START -->
        <section class="pt-4 pt-md-5 pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto text-center">
                    <h2>Editar Cliente - <?php echo htmlspecialchars($nome); ?></h2>
                    </div>



                 
                    
        <!-- Formulário de edição de cliente aqui -->
        <form method="POST">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" class="form-control" value="<?php echo htmlspecialchars($cpf); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" >
            </div>
            <div class="mb-3">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" class="form-control" value="<?php echo htmlspecialchars($telefone); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>











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
                margin-top: 20px;
                /* Ajuste conforme necessário */
            }
        </style>

        <section>
            <div class="container">
                
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
    <script>
        $(document).ready(function() {
            $('#formulario-servicos').submit(function(event) {
                event.preventDefault(); // Evita o comportamento padrão de submit do formulário

                $.ajax({
                    type: 'POST',
                    url: 'teste1.php', // Caminho do arquivo PHP que processa o formulário
                    data: $(this).serialize(), // Serializa os dados do formulário para enviar
                    success: function(response) {
                        console.log(response); // Log da resposta para depuração
                        const jsonResponse = JSON.parse(response);
                        $('#resultado').html(jsonResponse.html_resposta); // Exibe a resposta do servidor na div com id "resultado"

                        // Guarda os dados para futuro uso
                        $('#mao_de_obra_valor').val(jsonResponse.mao_de_obra);
                        $('#total_servicos_valor').val(jsonResponse.total_servicos);
                        $('#total_valor').val(jsonResponse.total);

                        // Guarda os serviços
                        jsonResponse.servicos.forEach((servico, index) => {
                            $('#servico_descricao_' + index).val(servico.descricao);
                            $('#servico_valor_' + index).val(servico.valor);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Status: " + status);
                        console.error(xhr.responseText);
                        $('#resultado').html('<p>Erro ao enviar os dados. Por favor, tente novamente.</p>');
                    }
                });
            });
        });
    </script>

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

