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

// Verifica se o recibo está armazenado na sessão
// Verificando se as variáveis de sessão existem
if (isset($_SESSION['dataAtual'])) {
    $dataAtual = $_SESSION['dataAtual'];
}

if (isset($_SESSION['endereco'])) {
    $endereco = $_SESSION['endereco'];
}

if (isset($_SESSION['telefone'])) {
    $telefone = $_SESSION['telefone'];
}

if (isset($_SESSION['whatsapp'])) {
    $whatsapp = $_SESSION['whatsapp'];
}

if (isset($_SESSION['cnpj'])) {
    $cnpj = $_SESSION['cnpj'];
}

// Dados pessoais do cliente
if (isset($_SESSION['enderecoCliente'])) {
    $enderecoCliente = $_SESSION['enderecoCliente'];
}

if (isset($_SESSION['numeroCliente'])) {
    $numeroCliente = $_SESSION['numeroCliente'];
}

if (isset($_SESSION['generoCliente'])) {
    $generoCliente = $_SESSION['generoCliente'];
}

if (isset($_SESSION['nomeCliente'])) {
    $nomeCliente = $_SESSION['nomeCliente'];
}

if (isset($_SESSION['emailCliente'])) {
    $emailCliente = $_SESSION['emailCliente'];
}

if (isset($_SESSION['cpfCliente'])) {
    $cpfCliente = $_SESSION['cpfCliente'];
}

if (isset($_SESSION['telefoneCliente'])) {
    $telefoneCliente = $_SESSION['telefoneCliente'];
}

// Informações do veículo
if (isset($_SESSION['modeloCarro'])) {
    $modeloCarro = $_SESSION['modeloCarro'];
}

if (isset($_SESSION['placa'])) {
    $placa = $_SESSION['placa'];
}

// Detalhes do serviço e valores
if (isset($_SESSION['maoDeObra'])) {
    $maoDeObra = $_SESSION['maoDeObra'];
}

if (isset($_SESSION['servicoDescricao0'])) {
    $servicoDescricao0 = $_SESSION['servicoDescricao0'];
}

if (isset($_SESSION['servicoValor0'])) {
    $servicoValor0 = $_SESSION['servicoValor0'];
}

if (isset($_SESSION['servicoDescricao1'])) {
    $servicoDescricao1 = $_SESSION['servicoDescricao1'];
}

if (isset($_SESSION['servicoValor1'])) {
    $servicoValor1 = $_SESSION['servicoValor1'];
}

if (isset($_SESSION['servicoDescricao2'])) {
    $servicoDescricao2 = $_SESSION['servicoDescricao2'];
}

if (isset($_SESSION['servicoValor2'])) {
    $servicoValor2 = $_SESSION['servicoValor2'];
}

if (isset($_SESSION['totalValor'])) {
    $totalValor = $_SESSION['totalValor'];
}

// Opções de pagamento
if (isset($_SESSION['valorAVista'])) {
    $valorAVista = $_SESSION['valorAVista'];
}

if (isset($_SESSION['valorCartao'])) {
    $valorCartao = $_SESSION['valorCartao'];
}

if (isset($_SESSION['desconto'])) {
    $desconto = $_SESSION['desconto'];
}

if (isset($_SESSION['taxas'])) {
    $taxas = $_SESSION['taxas'];
}

if (isset($_SESSION['idOrdem'])) {
    $id = $_SESSION['idOrdem'];
}

// Caminho para a imagem que você deseja incluir no PDF
$imagePath = "http://localhost/car2.png";
$imagePath2 = "http://localhost/dias.png";


// Constrói o conteúdo HTML para o PDF
$html = '
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title></title>
    <style type="text/css" rel="stylesheet" media="all">
    /* Base ------------------------------ */
    
    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");


     .logo {
            max-width: 200px;
        }
 .logo2 {
            max-width: 500px;
        }
    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }
    
    a {
      color: #3869D4;
    }
    
    a img {
      border: none;
    }
    
    td {
      word-break: break-word;
    }
    
    .preheader {
      display: none !important;
      visibility: hidden;
      mso-hide: all;
      font-size: 1px;
      line-height: 1px;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
    }
    /* Type ------------------------------ */
    
    body,
    td,
    th {
      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
    }
    
    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }
    
    h2 {
      margin-top: 0;
      color: #333333;
      font-size: 16px;
      font-weight: bold;
      text-align: left;
    }
    
    h3 {
      margin-top: 0;
      color: #333333;
      font-size: 14px;
      font-weight: bold;
      text-align: left;
    }
    
    td,
    th {
      font-size: 16px;
    }
    
    p,
    ul,
    ol,
    blockquote {
      margin: .4em 0 1.1875em;
      font-size: 16px;
      line-height: 1.625;
    }
    
    p.sub {
      font-size: 13px;
    }
    /* Utilities ------------------------------ */
    
    .align-right {
      text-align: right;
    }
    
    .align-left {
      text-align: left;
    }
    
    .align-center {
      text-align: center;
    }
    
    .u-margin-bottom-none {
      margin-bottom: 0;
    }
    /* Buttons ------------------------------ */
    
    .button {
      background-color: #3869D4;
      border-top: 10px solid #3869D4;
      border-right: 18px solid #3869D4;
      border-bottom: 10px solid #3869D4;
      border-left: 18px solid #3869D4;
      display: inline-block;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
      -webkit-text-size-adjust: none;
      box-sizing: border-box;
    }
    
    .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
    }
    
    .button--red {
      background-color: #FF6136;
      border-top: 10px solid #FF6136;
      border-right: 18px solid #FF6136;
      border-bottom: 10px solid #FF6136;
      border-left: 18px solid #FF6136;
    }
    
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
    /* Attribute list ------------------------------ */
    
    .attributes {
      margin: 0 0 21px;
    }
    
    .attributes_content {
      background-color: #F4F4F7;
      padding: 16px;
    }
    
    .attributes_item {
      padding: 0;
    }
    /* Related Items ------------------------------ */
    
    .related {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .related_item {
      padding: 10px 0;
      color: #CBCCCF;
      font-size: 15px;
      line-height: 18px;
    }
    
    .related_item-title {
      display: block;
      margin: .5em 0 0;
    }
    
    .related_item-thumb {
      display: block;
      padding-bottom: 10px;
    }
    
    .related_heading {
      border-top: 1px solid #CBCCCF;
      text-align: center;
      padding: 25px 0 10px;
    }
    /* Discount Code ------------------------------ */
    
    .discount {
      width: 100%;
      margin: 0;
      padding: 24px;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
      border: 2px dashed #CBCCCF;
    }
    
    .discount_heading {
      text-align: center;
    }
    
    .discount_body {
      text-align: center;
      font-size: 15px;
    }
    /* Social Icons ------------------------------ */
    
    .social {
      width: auto;
    }
    
    .social td {
      padding: 0;
      width: auto;
    }
    
    .social_icon {
      height: 20px;
      margin: 0 8px 10px 8px;
      padding: 0;
    }
    /* Data table ------------------------------ */
    
    .purchase {
      width: 100%;
      margin: 0;
      padding: 5px 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_content {
      width: 100%;
      margin: 0;
      padding: 5px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_item {
      padding: 10px 0;
      color: #51545E;
      font-size: 15px;
      line-height: 18px;
    }
    
    .purchase_heading {
      padding-bottom: 8px;
      border-bottom: 1px solid #EAEAEC;
    }
    
    .purchase_heading p {
      margin: 0;
      color: #85878E;
      font-size: 12px;
    }
    
    .purchase_footer {
      padding-top: 15px;
      border-top: 1px solid #EAEAEC;
    }
    
    .purchase_total {
      margin: 0;
      text-align: right;
      font-weight: bold;
      color: #333333;
    }
    
    .purchase_total--label {
      padding: 0 15px 0 0;
    }
    
    body {
      background-color: #F2F4F6;
      color: #51545E;
    }
    
    p {
      color: #51545E;
    }
    
    .email-wrapper {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F2F4F6;
    }
    
    .email-content {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    /* Masthead ----------------------- */
    
    .email-masthead {
      padding: 25px 0;
      text-align: center;
    }
    
    .email-masthead_logo {
      width: 94px;
    }
    
    .email-masthead_name {
      font-size: 16px;
      font-weight: bold;
      color: #A8AAAF;
      text-decoration: none;
      text-shadow: 0 1px 0 white;
    }
    /* Body ------------------------------ */
    
    .email-body {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .email-body_inner {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-footer {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .email-footer p {
      color: #A8AAAF;
    }
    
    .body-action {
      width: 100%;
      margin: 30px auto;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .body-sub {
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid #EAEAEC;
    }
    
    .content-cell {
      padding: 45px;
    }
    /*Media Queries ------------------------------ */
    
    @media only screen and (max-width: 600px) {
      .email-body_inner,
      .email-footer {
        width: 100% !important;
      }
    }
    
   
    
    :root {
      color-scheme: light dark;
      supported-color-schemes: light dark;
    }
    </style>
    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
  </head>
  <body>
 
    <span class="preheader">This is an invoice for your purchase on {{ purchase_date }}. Please submit payment by {{ due_date }}</span>
   
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead">
                <a href="#" class="f-fallback email-masthead_name">
               
 <div class="header">
        <img src="' . $imagePath . '" class="logo" alt="Logo da Empresa">
       
    </div>

              </a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <h1>Olá ' .  $nomeCliente . ',</h1>
                        <center><p>Agradecemos por escolher os serviços da Dias Car.<br> Este documento é o recibo do seu pedido mais recente.</p></center>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Valor pago: </strong>R$ ' . number_format($totalValor, 2, ',', '.') . ' REAIS
            </span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Encerrado em:</strong> ' .  $dataAtual . '
            </span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <!-- Border based button
           https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                              <h3> Ordem N°: ' .  $id . '</h3>
                            </td>
                            <td>
                              <h3 class="align-right">' .  $dataAtual . '</h3>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Serviço / Produto</p>
                                  </th>
                                  <th class="purchase_heading" align="right">
                                    <p class="f-fallback">Valor</p>
                                  </th>
                                </tr>
                                {{#each invoice_details}}
                             <tr>
                                    <td width="80%" class="purchase_item"><span class="f-fallback">' . ($servicoDescricao0 ?: '') . '</span></td>
                                    <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">R$ ' . (isset($servicoValor0) && $servicoValor0 !== '' ? number_format($servicoValor0, 2, ',', '.') : '') . '</span></td>
                                </tr>

                                <tr>
                                    <td width="80%" class="purchase_item"><span class="f-fallback">' . ($servicoDescricao1 ?: '') . '</span></td>
                                    <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">R$ ' . (isset($servicoValor1) && $servicoValor1 !== '' ? number_format($servicoValor1, 2, ',', '.') : '') . '</span></td>
                                </tr>

                                <tr>
                                    <td width="80%" class="purchase_item"><span class="f-fallback">' . ($servicoDescricao2 ?: '') . '</span></td>
                                    <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">R$ ' . (isset($servicoValor2) && $servicoValor2 !== '' ? number_format($servicoValor2, 2, ',', '.') : '') . '</span></td>
                                </tr>
                                
                               <tr>
                                    <td width="80%" class="purchase_item"><span class="f-fallback">Mão de obra </span></td>
                                    <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">R$ ' . (isset($maoDeObra) && $maoDeObra !== '' ? number_format($maoDeObra, 2, ',', '.') : '') . '</span></td>
                                </tr>

                              
                                {{/each}}
                                <tr>
                                  <td width="80%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                  </td>
                                  <td width="20%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total">R$ ' . number_format($totalValor, 2, ',', '.') . '</p>
                                  </td>
                                </tr>
                                
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>Se tiver alguma dúvida sobre este recibo, basta contatar nossa equipe de suporte para obter ajuda.</p>
                        <p>Peterson Cruz,
                          <br>Dias Car</p>
                        <!-- Sub copy -->
                        <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub"></p>
                              <p class="f-fallback sub"></p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">
                       
   <img src="' . $imagePath2 . '" class="logo2" alt="Logo da Empresa">

                        <br> Av. Francisco Munhoz Cegarra
                        <br>DCar Manager v1.0
                        <div style="font-size: 10px; color: grey;" class="f-fallback sub align-center"> Copyrights ©'.  date("Y").' Dias Car - Desenvolvido e projetado por<a href="https://adrieldias.netlify.app/" class="f-fallback sub align-center"> Adriel Dias</a>. </div>
						
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
    ';

// Carrega o HTML no Dompdf
$dompdf->loadHtml($html);

// Renderiza o PDF
$dompdf->render();

$ordemFinal = $nomeCliente .'_'. $id ;

// Saída do PDF para o navegador (opção para enviar para impressão)
$dompdf->stream('recibo_'.$ordemFinal.'.pdf', array('Attachment' => 0));
