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



// Define um array com os nomes dos meses
$meses = array(
    1 => 'Janeiro', 
    2 => 'Fevereiro', 
    3 => 'Março', 
    4 => 'Abril', 
    5 => 'Maio', 
    6 => 'Junho', 
    7 => 'Julho', 
    8 => 'Agosto', 
    9 => 'Setembro', 
    10 => 'Outubro', 
    11 => 'Novembro', 
    12 => 'Dezembro'
);

// Obtém o número do mês atual
$numero_mes = date('n');

// Obtém o nome do mês atual usando o array $meses
$nome_mes = $meses[$numero_mes];

// Obtém o ano atual
$ano = date('Y');

// Imprime a data atual com o mês escrito por extenso
//echo "Hoje é " . date('d') . " de " . $nome_mes . " de " . $ano;



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


    $imagePath = "http://localhost/car2.png";
    $imagePath2 = "http://localhost/dias.png";
    // Consulta SQL para obter todos os serviços do mês atual com base na pesquisa
    $sql = "SELECT s.*, c.nome AS nome_cliente, c.cpf AS cpf_cliente, car.modelo AS modelo_carro, car.ano AS ano_carro, car.placa 
            FROM servicos s 
            JOIN carros car ON s.carro_id = car.id 
            JOIN clientes c ON car.cliente_id = c.id 
            WHERE (c.nome LIKE :termo_pesquisa 
            OR car.modelo LIKE :termo_pesquisa 
            OR car.placa LIKE :termo_pesquisa)
            
            
            ORDER BY s.data DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);

 
    $stmt->execute();
    $ultimosServicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obter a soma dos valores dos serviços do mês atual com base na pesquisa
    $sql_soma = "SELECT SUM(s.valor) AS total_valor
                 FROM servicos s 
                 JOIN carros car ON s.carro_id = car.id 
                 JOIN clientes c ON car.cliente_id = c.id 
                 WHERE (c.nome LIKE :termo_pesquisa 
                 OR car.modelo LIKE :termo_pesquisa 
                 OR car.placa LIKE :termo_pesquisa)";
                 
               
    $stmt_soma = $conn->prepare($sql_soma);
    $stmt_soma->bindValue(':termo_pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
 
    
    $stmt_soma->execute();
    $total_valor = $stmt_soma->fetchColumn();

// Criar o HTML principal
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>


     .page-break {
            page-break-before: always;
        }

  :root {
    --font-color: black;
    --highlight-color: #000;
    --header-bg-color: #FFF;
    --footer-bg-color: #BFC0C3;
    --table-row-separator-color: #BFC0C3;
  }

   .logo {
            max-width: 200px;
        }
 .logo2 {
            max-width: 500px;
        }
.total {
color: white;
}


  body {
    margin: 0;
    padding: 0cm 0cm;
    color: var(--font-color);
 
    font-size: 10pt;
  }

  a {
    color: inherit;
    text-decoration: none;
  }


  hr {
    margin: 1cm 0;
    height: 0;
    border: 0;
    border-top: 1mm solid var(--highlight-color);
  }


  header {
    height: 8cm;
    padding: 0 2cm;
    position: running(header);
    background-color: var(--header-bg-color);
  }


  header .headerSection {
    display: flex;
    justify-content: space-between;
  }


  header .headerSection:first-child {
    padding-top: .5cm;
  }

  header .headerSection:last-child {
    padding-bottom: .5cm;
  }


  header .headerSection div:last-child {
    width: 35%;
  }

  header .logoAndName {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  header .logoAndName svg {
    width: 1.5cm;
    height: 1.5cm;
    margin-right: .5cm;
  }

  header .headerSection .estimateDetails {
    padding-top: 1cm;
  }


  header .headerSection .issuedTo {
    display: flex;
    justify-content: space-between;
  }

  header .headerSection .issuedTo h3 {
    margin: 0 .75cm 0 0;
    color: var(--highlight-color);
  }


  header .headerSection div p {
    margin-top: 2px;
  }


  header h1,
  header h2,
  header h3,
  header p {
    margin: 0;
  }


  header h2,
  header h3 {
    text-transform: uppercase;
  }

  header hr {
    margin: 1cm 0 .5cm 0;
  }


  main table {
    width: 100%;
    border-collapse: collapse;
  }


  main table thead th {
    height: 1cm;
    color: var(--highlight-color);
  }


  main table thead th:nth-of-type(2),
  main table thead th:nth-of-type(3),
  main table thead th:last-of-type {
    width: 2.5cm;
  }

  main table tbody td {
    padding: 2mm 0;
    border-bottom: 0.5mm solid var(--table-row-separator-color);
  }

  main table thead th:last-of-type,
  main table tbody td:last-of-type {
    text-align: right;
  }

  main table th {
    text-align: left;
  }


  main table.summary {
    width: calc(40% + 2cm);
    margin-left: 60%;
    margin-top: .5cm;
  }


  main table.summary tr.total {
    font-weight: bold;
    background-color: var(--highlight-color);
  }


  main table.summary th {
    padding: 4mm 0 4mm 1cm;
    border-bottom: 0;
  }


  main table.summary td {
    padding: 4mm 2cm 4mm 0;
    border-bottom: 0;
  }

  aside {
    -prince-float: bottom;
    padding: 0 2cm .5cm 2cm;
  }

  /*
The content itself is shown in 2 columns.
*/
  aside p {
    margin: 0;
    column-count: 2;
  }


  footer {
    height: 3cm;
    line-height: 3cm;
    padding: 0 2cm;
    position: running(footer);
    background-color: var(--footer-bg-color);
    font-size: 8pt;
    display: flex;
    align-items: baseline;
    justify-content: space-between;
  }

  footer a:first-child {
    font-weight: bold;
  }
</style>
    <title>Document</title>
</head>
<header>
  <div >
    <!-- As a logo we take an SVG element and add the name in an standard H1 element behind it. -->
    <div >
      <svg>
        <circle cx="50%" cy="50%" r="40%" stroke="black" stroke-width="3" fill="black" />
      </svg>
      <div class="header">
      <center>
        <img src="' . $imagePath . '" class="logo" alt="Logo da Empresa">
       </center>
    </div>
    </div>
    <!-- Details about the estimation are on the right top side of each page. -->
    <div>
      
      <p>
       
      </p>
      <p>
         <b>Relatorio gerado em: </b> ' . $mesAtual . '/' . $anoAtual . '
      </p>
    </div>
      <br>
    <h3> <center> Relatório Gerado Referente a todo periodo de trabalho  </center> </h3>
  </div>
  <!-- The two header rows are divided by an blue line, we use the HR element for this. -->
  <hr />
  <div class="headerSection">
    <!-- The clients details come on the left side below the logo and company name. -->
    <div class="issuedTo">
    
      <p>
      
      Neste documento, consolidamos os totais financeiros mais relevantes para a Dias Car durante todo periodo de trabalho. Os registros incluídos neste relatório abrangem receitas totais, despesas operacionais, lucro líquido e outros indicadores financeiros fundamentais. Cada seção foi meticulosamente preparada para oferecer uma análise abrangente e transparente do desempenho financeiro da empresa durante o período especificado.


<br>
<br>
Atenciosamente,
<br>

<b>Peterson Dias Cruz</b>
<br>
Dias Car
<br>
' .   date('d') .' de '.  $nome_mes .' de ' . $ano . '

<br>
      </p>
    </div>
    <!-- Additional notes can be placed below the estimation details. -->
    <div>
  
    </div>
  </div>
</header>
<body>
   <main>

   <br>
    <br>
     <br>
      <br>
      
  <table>
    <!-- A THEAD element is used to ensure the header of the table is repeated if it consumes more than one page. -->
    <thead>
      <tr>
        <th>Ordem</th>
          <th>Nome</th>
            <th>Data</th>
             <th>CPF</th>
        <th>Modelo do Carro</th>
        <th>Placa</th>
        <th>Valor</th>
      </tr>
    </thead>

    <tbody>';
    
    // Loop pelos serviços para preencher a tabela
    foreach ($ultimosServicos as $servico) {
        $html .= '
 <tr>
   <td>
      <b>  ' . $servico['id_ordem'] . ' </b>
    </td>
    <td>
        ' . $servico['nome_cliente'] . '
    </td>
    
      <td>
        ' .  $data_formatada = date('d/m/Y', strtotime($servico['data'])) . '
    </td>
    <td>
       ' . substr_replace(substr_replace(substr_replace($servico['cpf_cliente'], '.', 3, 0), '.', 7, 0), '-', 11, 0) . '
    </td>
    <td>
      '  . strtoupper(implode(' ', array_slice(explode(' ', $servico['modelo_carro']), 0, 2))) . '
    </td>
    <td>
      ' . $servico['placa']  . '
    </td>
      <td>
      R$ ' . $valorFormatado = number_format($servico['valor'], 2, ',', '.') . '
    </td>
</tr>

        
        
        ';
    }

      $html .= '  </tbody>
  </table>


  
  <table class="summary">
  
  
    <tr class="total">
      <th>
        Total 
      </th>
      <td>
      R$ ' . $valorFormatadoTotal = number_format($total_valor, 2, ',', '.') .'
      </td>
    </tr>
  </table>
</main>
<div class="page-break"></div>
<aside>
  <!-- Before the terms and conditions we will add another blue divider line with the help of the HR tag. -->
  <hr />
  <b>Termos e Condições - Dias Car

</b><br>
  <p>
<b> Serviços Prestados </b>
<br>
A Dias Car oferece serviços de manutenção e reparo de veículos automotores. Os serviços são executados por técnicos qualificados utilizando peças e equipamentos adequados.
<br>
<b> Responsabilidade </b>
<br>
A Dias Car não se responsabiliza por danos ou perdas nos veículos, exceto por casos de negligência comprovada da empresa.
<br>
<b> Pagamento </b>
<br>
Os serviços são faturados conforme o trabalho realizado, incluindo mão de obra, peças e impostos aplicáveis.
<br>
<b> Cancelamento e Reagendamento </b>
<br>
Cancelamentos ou reagendamentos devem ser feitos com pelo menos 24 horas de antecedência. Casos contrários podem estar sujeitos a taxas.
<br>
<b> Privacidade </b>
<br>
Respeitamos a privacidade de nossos clientes e garantimos a confidencialidade das informações pessoais.
<br>
<b> Modificações dos Termos </b>
<br>
Reservamos o direito de modificar estes termos a qualquer momento, com vigência imediata após a publicação.
  </p>

  <center>
   <img src="' . $imagePath2 . '" class="logo2" alt="Logo da Empresa">
</center>


</aside>
</body>
<footer>
  <a href="https://companywebsite.com">
    companywebsite.com
  </a>
  <a href="mailto:company@website.com">
    company@website.com
  </a>
  <span>
    317.123.8765
  </span>
  <span>
    123 Alphabet Road, Suite 01, Indianapolis, IN 46260
  </span>
</footer>
</html>



';



// Carrega o HTML no Dompdf
$dompdf->loadHtml($html);

// Renderiza o PDF
$dompdf->render();

// Saída do PDF para o navegador (opção para enviar para impressão)
$dompdf->stream('recibo.pdf', array('Attachment' => 0));
} catch (PDOException $e) {
    // Trate erros de conexão
    handleException($e);
}
?>
