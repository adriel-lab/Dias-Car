<?php
// Incluir o arquivo de configuração do banco de dados e funções úteis
include 'db_connection.php';// Supondo que 'config.php' contém a função getDbConnection() e outras configurações

// Verificar se o parâmetro 'id' foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirecionar para alguma página de erro, pois o ID do carro não foi fornecido
 echo 'error 404';
    exit();
}

// Obtém o ID do carro a ser deletado
$id_carro = $_GET['id'];

try {
    // Conectar ao banco de dados
    $conn = getDbConnection();

    // Query para deletar o carro
    $sql_delete = "DELETE FROM carros WHERE id = :id";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_carro, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Redirecionar para uma página de sucesso ou para a listagem de carros após a exclusão
    echo "<script>window.location='../account-bookings.php?carro_pagina=1#tab-2';</script>";
    exit();

} catch (PDOException $e) {
    // Trate erros de conexão ou de exclusão
    handleException($e);
}
?>
