<?php
session_start(); // Inicia a sessão para acessar os dados do recibo

require_once 'vendor/autoload.php'; // Carrega o autoload do Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Instancia um objeto Options e define a configuração necessária
$options = new Options();
$options->set('isPhpEnabled', true); // Habilita o processamento de PHP no HTML
$options->set('isRemoteEnabled', true); // Habilita o acesso a recursos remotos (como imagens)

// Instancia o Dompdf com as opções configuradas
$dompdf = new Dompdf($options);

date_default_timezone_set('America/Sao_Paulo');
$mesAtual = date('m');
$anoAtual = date('Y');

function getDbConnection()
{
    $dbname = '../crud/oficina_mecanica.db';
    try {
        $conn = new PDO("sqlite:" . $dbname);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        handleException($e);
        return null;
    }
}

try {
    // Conectar ao banco de dados
    $conn = getDbConnection();

    // Obter o termo de pesquisa
    $termo_pesquisa = isset($_GET['search']) ? $_GET['search'] : '';

    // Consulta SQL para obter todos os serviços do mês atual com base na pesquisa
    $sql = "SELECT s.*, c.nome AS nome_cliente, c.cpf AS cpf_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
            FROM servicos s 
            JOIN carros car ON s.carro_id = car.id 
            JOIN clientes c ON car.cliente_id = c.id 
            WHERE (c.nome LIKE :termo_pesquisa 
            OR car.modelo LIKE :termo_pesquisa 
            OR car.placa LIKE :termo_pesquisa)
            AND strftime('%m', s.data) = :mesAtual 
            AND strftime('%Y', s.data) = :anoAtual
            ORDER BY s.data DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
    $stmt->bindValue(':mesAtual', $mesAtual, PDO::PARAM_STR);
    $stmt->bindValue(':anoAtual', $anoAtual, PDO::PARAM_STR);
    $stmt->execute();
    $ultimosServicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obter a soma dos valores dos serviços do mês atual com base na pesquisa
    $sql_soma = "SELECT SUM(s.valor) AS total_valor
                 FROM servicos s 
                 JOIN carros car ON s.carro_id = car.id 
                 JOIN clientes c ON car.cliente_id = c.id 
                 WHERE (c.nome LIKE :termo_pesquisa 
                 OR car.modelo LIKE :termo_pesquisa 
                 OR car.placa LIKE :termo_pesquisa)
                 AND strftime('%m', s.data) = :mesAtual 
                 AND strftime('%Y', s.data) = :anoAtual";
    $stmt_soma = $conn->prepare($sql_soma);
    $stmt_soma->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
    $stmt_soma->bindValue(':mesAtual', $mesAtual, PDO::PARAM_STR);
    $stmt_soma->bindValue(':anoAtual', $anoAtual, PDO::PARAM_STR);
    $stmt_soma->execute();
    $total_valor = $stmt_soma->fetchColumn();

    // Gerar o HTML para o PDF
    $html = '<html><body>';
    $html .= '<h1>Relatório de Serviços do Mês ' . $mesAtual . '/' . $anoAtual . '</h1>';

    // Exibir mensagem se nenhum resultado for encontrado
    if (count($ultimosServicos) == 0) {
        $html .= '<p class="text-center">Nenhum registro encontrado.</p>';
    } else {
        // Exibir os serviços em uma tabela
        $html .= '<table border="1" cellspacing="0" cellpadding="5">';
        $html .= '<tr>';
        $html .= '<th>Nome do Cliente</th>';
        $html .= '<th>Modelo do Carro</th>';
        $html .= '<th>Placa</th>';
        $html .= '<th>CPF do Cliente</th>';
        $html .= '<th>Data</th>';
        $html .= '<th>Valor</th>';
        $html .= '</tr>';
        foreach ($ultimosServicos as $servico) {
            $html .= '<tr>';
            $html .= '<td>' . $servico['nome_cliente'] . '</td>';
            $html .= '<td>' . $servico['modelo_carro'] . '</td>';
            $html .= '<td>' . $servico['placa'] . '</td>';
            $html .= '<td>' . substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0) . '</td>';
            $data_formatada = date('d/m/Y', strtotime($servico['data']));
            $html .= '<td>' . $data_formatada . '</td>';
            $valor = $servico['valor'];
            $valorFormatado = number_format($valor, 2, ',', '.');
            $html .= '<td>R$ ' . $valorFormatado . '</td>';
            $html .= '</tr>';
        }
        $html .= '<tr>';
        $html .= '<td colspan="5" style="text-align:right;"><strong>Total:</strong></td>';
        $totalValorFormatado = number_format($total_valor, 2, ',', '.');
        $html .= '<td><strong>R$ ' . $totalValorFormatado . '</strong></td>';
        $html .= '</tr>';
        $html .= '</table>';
    }

    $html .= '</body></html>';

    // Carrega o HTML no Dompdf
    $dompdf->loadHtml($html);

    // Renderiza o PDF
    $dompdf->render();

    // Saída do PDF para o navegador (opção para enviar para impressão)
    $dompdf->stream('relatorio_servicos_' . $mesAtual . '_' . $anoAtual . '.pdf', array('Attachment' => 0));

} catch (PDOException $e) {
    // Trate erros de conexão
    handleException($e);
}
?>
