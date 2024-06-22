<?php
// Incluir o arquivo de configuração do banco de dados e funções úteis
include 'db_connection.php';// Supondo que 'config.php' contém a função getDbConnection() e outras configurações

// Verificar se o parâmetro 'id' foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirecionar para alguma página de erro, pois o ID do serviço não foi fornecido
    header("Location: erro.php");
    exit();
}

// Obtém o ID do serviço a ser deletado
$id_servico = $_GET['id'];

try {
    // Conectar ao banco de dados
    $conn = getDbConnection();

    // Query para deletar o serviço
    $sql_delete = "DELETE FROM servicos WHERE id = :id";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_servico, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Redirecionar para uma página de sucesso ou para a página de listagem de serviços após a exclusão
    echo "<script>window.location='../account-bookings.php?pagina=1';</script>";
    exit();

} catch (PDOException $e) {
    // Trate erros de conexão ou de exclusão
    handleException($e);
}
?>
