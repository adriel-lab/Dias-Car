<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['carro_id']) &&
    isset($_POST['descricao']) &&
    isset($_POST['day']) &&
    isset($_POST['month']) &&
    isset($_POST['year']) &&
    isset($_POST['mao_de_obra_valor']) &&
    isset($_POST['total_servicos_valor']) &&
    isset($_POST['servico_descricao_0']) &&
    isset($_POST['servico_valor_0']) &&
    isset($_POST['servico_descricao_1']) &&
    isset($_POST['servico_valor_1']) &&
    isset($_POST['servico_descricao_2']) &&
    isset($_POST['servico_valor_2']) &&
    isset($_POST['total_valor'])
) {
    $carro_id = $_POST['carro_id'];
    $descricao = $_POST['descricao'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $mao_de_obra_valor = $_POST['mao_de_obra_valor'];
    $total_servicos_valor = $_POST['total_servicos_valor'];
    $servico_descricao_0 = $_POST['servico_descricao_0'];
    $servico_valor_0 = $_POST['servico_valor_0'];
    $servico_descricao_1 = $_POST['servico_descricao_1'];
    $servico_valor_1 = $_POST['servico_valor_1'];
    $servico_descricao_2 = $_POST['servico_descricao_2'];
    $servico_valor_2 = $_POST['servico_valor_2'];
    $total_valor = $_POST['total_valor'];
    $ordem = date('His') . substr(bin2hex(random_bytes(2)), 0, 4) .$carro_id;

    // Formata a data no formato "Y-m-d"
    $data = date("Y-m-d", strtotime("$year-$month-$day"));

    // Formatar os valores para ter duas casas decimais
    $mao_de_obra_valor = number_format((float)$mao_de_obra_valor, 2, '.', '');
    $total_servicos_valor = number_format((float)$total_servicos_valor, 2, '.', '');
    $servico_valor_0 = number_format((float)$servico_valor_0, 2, '.', '');
    $servico_valor_1 = number_format((float)$servico_valor_1, 2, '.', '');
    $servico_valor_2 = number_format((float)$servico_valor_2, 2, '.', '');
    $total_valor = number_format((float)$total_valor, 2, '.', '');

    $conn = getDbConnection();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO servicos (
                carro_id, descricao, data, valor, total_servicos_valor, mao_de_obra_valor,
                servico_descricao_0, servico_valor_0, servico_descricao_1, servico_valor_1,
                servico_descricao_2, servico_valor_2, total_valor, id_ordem
            ) VALUES (
                :carro_id, :descricao, :data, :valor, :total_servicos_valor, :mao_de_obra_valor,
                :servico_descricao_0, :servico_valor_0, :servico_descricao_1, :servico_valor_1,
                :servico_descricao_2, :servico_valor_2, :total_valor, :id_ordem
            )");
            $stmt->bindParam(':carro_id', $carro_id);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':valor', $total_valor); // Aqui usamos total_valor como o valor total
            $stmt->bindParam(':total_servicos_valor', $total_servicos_valor);
            $stmt->bindParam(':mao_de_obra_valor', $mao_de_obra_valor);
            $stmt->bindParam(':servico_descricao_0', $servico_descricao_0);
            $stmt->bindParam(':servico_valor_0', $servico_valor_0);
            $stmt->bindParam(':servico_descricao_1', $servico_descricao_1);
            $stmt->bindParam(':servico_valor_1', $servico_valor_1);
            $stmt->bindParam(':servico_descricao_2', $servico_descricao_2);
            $stmt->bindParam(':servico_valor_2', $servico_valor_2);
            $stmt->bindParam(':total_valor', $total_valor);
            $stmt->bindParam(':id_ordem', $ordem);
            $stmt->execute();
            $_SESSION['success_message'] = "Ordem criada com sucesso!";
            echo "<script>window.location='cadastrar_servico.php';</script>";
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erro ao registrar ordem: " . $e->getMessage();
            echo "<script>window.location='cadastrar_servico.php';</script>";
        }
        $conn = null;
    } else {
        $_SESSION['error_message'] = "Erro na conexão com o banco de dados.";
        echo "<script>window.location='cadastrar_servico.php';</script>";
    }
}
?>
