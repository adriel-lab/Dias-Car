<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'] ?? null; // Campo não obrigatório
    $endereco = $_POST['endereco']; 
    $cpf = $_POST['cpf'];
    $numero_residencial = $_POST['numero_residencial'];
    $sexo = $_POST['sexo'];

    // Conexão com o banco de dados
    $conn = getDbConnection();
    if ($conn) {
        try {
            // Prepara a consulta SQL para inserir os dados no banco de dados
            $stmt = $conn->prepare("
                INSERT INTO clientes (nome, telefone, email, endereco, cpf, numero, sexo) 
                VALUES (:nome, :telefone, :email, :endereco, :cpf, :numero, :sexo)
            ");
            
            // Vincula os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':numero', $numero_residencial);
            $stmt->bindParam(':sexo', $sexo);
            
            // Executa a consulta
            $stmt->execute();

            // Define uma mensagem de sucesso e redireciona para a página de cadastro
            $_SESSION['success_message'] = "Cliente cadastrado com sucesso!";
            echo "<script>window.location='cadastrar_cliente.php';</script>";
        } catch (PDOException $e) {
            // Define uma mensagem de erro e redireciona para a página de cadastro
            $_SESSION['error_message'] = "Erro ao cadastrar cliente: " . $e->getMessage();
            echo "<script>window.location='cadastrar_cliente.php';</script>";
        }
        // Fecha a conexão com o banco de dados
        $conn = null;
    }
}
?>
