<?php 
//Funcao de Mascara
session_start();	
include "../../mascara.php";  
	  require "../../conectsqlserverci.php";
	  require "../../conect.php";
	  require_once ("../../dompdf/dompdf_config.inc.php");
	  //Gerar senha aleatoria
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';

$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;

$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}
	  include "buscaDadosOrdem.php";

	  $html='<html>
<head>
<meta>
<title>Documento sem título</title>
</head>

<body style="padding: 10px;
    margin: 20px; font-size:12px">';
	$html.='
    <table border="0" width="100%"><tr><td align="center"><img src="../../imagens/logoDocumento2.png" width="12" height="20" />
    </td></tr></table>';
    
	$html.='<p>Brasília-DF, '.$dataHoje.'.</p>
    <p align="right">Ordem de Serviço/Compra n.°: '.$numOrdem.'.</p>';

$html.='<table border="0" width="100%"><tr height="10"><td width="120">Departamento Emissor:</td><td> <strong>DEAC</strong>. </td></tr>
<tr><td height="10">Prestador de Serviços:</td><td><strong>'.$empresa.'</strong>.</td></tr></table>
<div style="padding-left:8px; padding-top:2px">
';
$html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">1.</td><td>Documento Interno Referência: <strong>'.$processo.'</strong></td></tr></table></td></tr></table>';
  
  $html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">2.</td><td>Dados para <strong><i>Faturamento</i></strong>:</td></tr>
  <tr valign="top"><td align="center"></td><td>
  <table border="0" width="100%">
  <tr><td width="20%"></td><td align="left">
'.html_entity_decode($faturamento).'
  </td></tr></table>
</td></tr>
  </table></td></tr></table>';
  
$html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">3.</td><td>Descrição:</td></tr></table>
  <p align="center"><strong>'.$evento.'</strong>
  </p>
  
  <div align="center">
  <table border="1" width="100%" style="padding-left:80;padding-right:80">
  <tr align="center" bgcolor="#6668A3"><td width="40%"><font color="#FFFFFF"><strong>MATERIAL</strong></font></td>
    <td width="15%"><font color="#FFFFFF"><strong>QTD.</strong></font></td>
    <td width="22%"><font color="#FFFFFF"><strong>VL.UN.</strong></font></td>
    <td width="23%"><font color="#FFFFFF"><strong>TOTAL</strong></font></td></tr>';
		$html.=$tabelaMaterial;
	$html.='</table>
	</div>
	'.$descricao.'
  </td></tr></table>';

$html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">4.</td><td>Valor: <strong>R$ '.$valorDaOrdem.'</strong></td></tr></table></td></tr></table>';
  
 $html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">5.</td><td>Data e local de entrega:</td></tr>
  <tr valign="top"><td align="center"></td><td>
  <table border="0" width="100%">
  <tr><td width="10%"></td><td align="left">
'.html_entity_decode($dtlcentrega).'
  </td></tr></table>
</td></tr>
  </table></td></tr></table>';
 $html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td colspan="2">6. '.$complemento.'</td></tr></table></td></tr></table>';
   
   $html.='<div style="page-break-after: auto;"><table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td width="12">7.</td><td>Emissor:</td></tr>
  <tr valign="top"><td align="center"></td><td>
  <p align="center">
'.$assinaturaEletronica.'
</p>
</td></tr>
  </table></td></tr></table></div>';
  
$html.='<table border="1" width="100%">
<tr valign="middle">
  <td height="25">
  <table border="0" width="100%"><tr valign="bottom"><td align="right" width="80%">
   <font size="-1">Para verificar a autenticidade, acesse: <a href="http://187.32.216.249/intrahomolog/verifica" target="_blank">http://intranetcpb.cpb.org.br/verifica </a>  e informe o código: </font></td><td><font size="-1"><strong> <u>'.$codigoHash.'</u></strong></font></td></tr></table></td></tr></table>';
    
$html.='</div></body>
</html>';
$dompdf=new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper('a4','portrait');
$dompdf->render();
ob_start ();
$dompdf->stream('OS N'.$numOrdem.'.pdf',array('Attachment'=>0));
?>