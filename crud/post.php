<?php
// Verifica se houve uma requisição POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Itera sobre todas as variáveis no POST
    foreach ($_POST as $key => $value) {
        // Imprime cada chave e valor
        echo "Chave: " . htmlspecialchars($key) . ", Valor: " . htmlspecialchars($value) . "<br>";
    }
} else {
    // Se não houve POST, exibe uma mensagem
    echo "Nenhum dado enviado via POST.";
}
?>
