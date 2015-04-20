<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<style>
@media print{
*{
margin:0;
padding:0;
}
.LandscapeDiv{
	width: 100%;
	height: 100%;
	filter: progid:DXImageTransform.Microsoft.BasicImage(Rotation=3);
}
}
</style>
</head>

<body>
<div id="conteiner" class="LandscapeDiv">
<?php 
require "../../../conexaomysql.php";
$consultaEventos="WHERE id='1'";
$tipoCons=0;
if(!empty($_POST['tipoId'])){
$consultaEventos="modal='".$_SESSION['modalRef']."'";	
	$titEvento="Consolidado ";
	}else{
		$tipoCons=1;
		$titEvento="de Evento ";
		$consultaEventos="id='".$_POST['idevento']."'";
		}
echo "<h1 align='center'><font color='blue'>Relat&oacute;rio ".$titEvento.$_POST['titMod']."</font></h2>";
$sqlEvento=mysql_query("SELECT * FROM conveventos WHERE ".$consultaEventos."");
function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
$totalGeralEvento=0;
$totalGeralModal=0;
echo "<div id='tabela'>
<table border='1' cellspacing='0' cellpadding='0' rowspan='0' celspan='0' width='100%'>";
if($tipoCons==0){
include "material.php";
}
echo "</table></div>";
while($objEventos=mysql_fetch_object($sqlEvento)){
$totalGeralValorMat=0;
$totalGeralValorPas=0;
$totalGeralValorHos=0;
$totalGeralValorAli=0;
$totalGeralValorTra=0;
$totalGeralValorRh=0;
$totalGeralValorSgv=0;
$idEvento=$objEventos->id;
$evento=utf8_encode($objEventos->nome);
$abrg="Nacional";
if($objEventos->tipoloc=='int'){
	$abrg="Internacional";
	}
$periodo=$objEventos->dtinicio." &agrave; ".$objEventos->dtfim;
$dtfim=$objEventos->dtfim;
$dtinicio=$objEventos->dtinicio;
$dtInicial=geraTimestamp($dtinicio);
$dtFinal=geraTimestamp($dtfim);
$diferenca=$dtFinal-$dtInicial;
$calculaDias = (int)floor($diferenca / (60 * 60 * 24));
$qtdDias=$calculaDias+1;
$cidade=utf8_encode($objEventos->cidade);
echo "<h2></h2>
<div id='tabela'>
<table border='1' cellspacing='0' cellpadding='0' width='100%'>
  <tr>
    <td width='100%' colspan='14' nowrap='nowrap' valign='bottom' bgcolor='#006666'><p align='center'><h2><font color='white'>".$evento."</font><h2></p></td>
  </tr>
  <tr>
    <th width='30%' nowrap='nowrap' valign='bottom'><p align='right'><strong>Per&iacute;odo    Previsto:</strong> </p></th>
    <td width='20%' colspan='3' nowrap='nowrap' valign='bottom'><p>".$periodo."</p></td>
    <th width='23%' colspan='2' nowrap='nowrap' valign='bottom'><p><strong>Dias: </strong></p></th>
    <td width='20' nowrap='nowrap' valign='bottom'><p>".$qtdDias."</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='30%' nowrap='nowrap' valign='bottom'><p align='right'><strong>Per&iacute;odo    Previsto:</strong> </p></th>
    <td width='20%' colspan='2' nowrap='nowrap' valign='bottom'><p>".$periodo."</p></td>
    <th width='23%' colspan='2' nowrap='nowrap' valign='bottom'><p><strong>Dias: </strong></p></th>
    <td width='20%' nowrap='nowrap' valign='bottom'><p>".$qtdDias."</p></td>
  </tr>
  <tr>
    <th width='40%' colspan='4' nowrap='nowrap' valign='bottom'><p align='center'><em>".$abrg."</em></p></th>
    <th width='20%' colspan='2' nowrap='nowrap' valign='bottom'><p><strong>Local:</strong></p></th>
    <td width='20%' nowrap='nowrap' valign='bottom'><p>".$cidade."</p></td>
    <td width='2' nowrap='nowrap' valign='bottom'></td>
    <th width='40%' colspan='3' nowrap='nowrap' valign='bottom'><p align='center'><em>".$abrg."</em></p></th>
    <th width='20%' colspan='2' nowrap='nowrap' valign='bottom'><p><strong>Local:</strong></p></th>
    <td width='20%' nowrap='nowrap' valign='bottom'><p>".$cidade."</p></td>
  </tr>
  <tr><td colspan='14' height='5'></td></tr>
    <tr>";
include "passagem.php";
include "hospedagem.php";
include "alimentacao.php";
include "transporte.php";
include "rh.php";
include "sgv.php";
$totalGeralEvento=$totalGeralValorPas+$totalGeralValorHos+$totalGeralValorAli+$totalGeralValorTra+$totalGeralValorRh+$totalGeralValorSgv+$totalGeralValorMat;
$totalGeralModal=$totalGeralModal+$totalGeralEvento;
echo "<tr><td colspan='14' height='5'></td></tr>
    <tr>
<tr><th width='50%' colspan='3' align='right'><h2 align='right'>Total Projetado do Evento:</h2></th><td align='left' colspan='4'><h2>R$ ".number_format($totalGeralEvento,2,",",".")."</h2></td><td></td><th width='50%' colspan='3' align='right'><h2 align='right'>Total Realizado do Evento:</h2></th><td align='left' colspan='3'><h2>R$ 0,00</h2></td>
</tr>
<tr><td colspan='14' height='5' bgcolor='grey'></td></tr>";
}
if($tipoCons==0){
	echo "
	<tr><td colspan='14' height='5'></td></tr>
    <tr>
<tr><th width='50%' colspan='3' align='right'><h2 align='right'>Total Projetado ".$_POST['titMod'].":</h2></th><td align='left' colspan='4'><h2>R$ ".number_format($totalGeralModal,2,",",".")."</h2></td><td></td><th width='50%' colspan='3' align='right'><h2 align='right'>Total Realizado ".$_POST['titMod'].":</h2></th><td align='left' colspan='3'><h2>R$ 0,00</h2></td>
</tr>
<tr><td colspan='14' height='5' bgcolor='grey'></td></tr>";
	}

  echo "</table>
</div>
";
?>
</div>
</body>
</html>