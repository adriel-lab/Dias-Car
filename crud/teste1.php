<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["servicos"])) {
    $servicos = $_POST["servicos"];
    $mao_de_obra = isset($_POST["mao_de_obra"]) ? floatval($_POST["mao_de_obra"]) : 0;

    // Inicializa o total
    $total_servicos = 0;
    $total = $mao_de_obra;

    // Inicializa arrays para armazenar os serviços
    $servicos_realizados = array();

    // Processa os serviços
    foreach ($servicos as $index => $servico) {
        $descricao = isset($servico['descricao']) ? $servico['descricao'] : '';
        $valor = isset($servico['valor']) ? floatval($servico['valor']) : 0;
        

        // Armazena cada serviço em um array associativo
        if (!empty($descricao)) {
            $servicos_realizados[] = array(
                'descricao' => $descricao,
                'valor' => $valor
            );

            // Soma o valor do serviço ao total
            $total_servicos += $valor;
            $total += $valor;
        }
    }

    // Monta a resposta em formato HTML para exibição na página
    $html_resposta = "<h6>Serviços Realizados:</h6><ul>";
    foreach ($servicos_realizados as $servico) {
        $html_resposta .= "<li>{$servico['descricao']}: R$ " . number_format($servico['valor'], 2, ',', '.') . "</li>";
    }
    $html_resposta .= "</ul>";

    $html_resposta .= "<h6>Valor da Mão de Obra:</h6><p>R$ " . number_format($mao_de_obra, 2, ',', '.') . "</p>";

    $html_resposta .= "<h6>Total:</h6><p>R$ " . number_format($total, 2, ',', '.') . "</p>";


    // Retorna a resposta em JSON com os dados processados
    echo json_encode(array(
        'html_resposta' => $html_resposta,
        'mao_de_obra' => $mao_de_obra,
        'total_servicos' => $total_servicos,
        'total' => $total,
        'servicos' => $servicos_realizados
    ));
}
?>
