<?php session_start()  ?>
<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];

    $conn = getDbConnection();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO carros (cliente_id, modelo, ano, placa) VALUES (:cliente_id, :modelo, :ano, :placa)");
            $stmt->bindParam(':cliente_id', $cliente_id);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano', $ano);
            $stmt->bindParam(':placa', $placa);
            $stmt->execute();

            $_SESSION['success_message'] = "Carro cadastrado com sucesso!";
            echo "<script>window.location='cadastrar_carro.php';</script>";
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erro ao cadastrar carro: " . $e->getMessage();
            echo "<script>window.location='cadastrar_carro.php';</script>";
        }
        $conn = null;
    }
}

?>