<?php
// Iniciar a sessão
session_start();

// Limpar todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();
echo "<script>window.location='admin-earnings.php';</script>";
?>
