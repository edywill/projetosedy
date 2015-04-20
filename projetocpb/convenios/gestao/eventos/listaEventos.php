<?php 
if(!isset($_SESSION)){
session_start();
}
$_SESSION['abrangenciaEventoSession']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'><br/>
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['tipoId'])){
	$tipoId=$_POST['tipoId'];
	$id=$_POST['id'];
	$titMod=$_POST['titMod'];
}else{
	$tipoId=$_SESSION['tipoIdSessionConv'];
	$id=$_SESSION['projetoConvS'];
	$titMod=$_SESSION['titModSession'];
}
include "../projetos/detalhesProj.php";

echo "<br><h2>".$titMod."</h2><h3>Eventos de ".$titMod."</h3>";
echo "<table><tr><td><form action='../eventos/novoEvento.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='hidden' name='abrangencia' value='nac'/>
<input type='submit' class='button' value='Novo Evento Nacional' name='evento'/>
</form></td><td><form action='../eventos/novoEvento.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='hidden' name='abrangencia' value='inter'/>
<input type='submit' class='button' value='Novo Evento Internacional' name='evento'/>
</form></td></tr></table><br>";

$sqlEventos=mysql_query("SELECT conveventos.* FROM conveventos WHERE conveventos.idproj='".trim($id)."' AND conveventos.modal='".$tipoId."'") or die(mysql_error());
//$arrayEventos=mysql_fetch_array($sqlEventos);
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Nome</th><th width='20%'>Cidade/UF/País</th><th width='10%'>Abrangência</th><th width='15%'>Vl. Tot(R$)</th><th width='15%'>Inic./Fim</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
while($objEventos=mysql_fetch_object($sqlEventos)){
	$abrang='';
	if($objEventos->tipoloc=='nac'){
		$abrang='Nacional';
		if(!empty($objEventos->uf)){
			$estado=$objEventos->uf;
			$sqlCidadeNac=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$objEventos->cidade."'"));
			$cidade=utf8_encode($sqlCidadeNac['municipio']);
		}else{
			$estado='';
			$cidade='';
			}
	}elseif($objEventos->tipoloc=='inter'){
		$abrang='Internacional';
		if(!empty($objEventos->pais)){
			$estado=$objEventos->pais;
			$cidade=utf8_encode($objEventos->cidade);
		}else{
			$estado='';
			$cidade='';
			}
		}
$sqlValorUnitAli=mysql_query("SELECT total FROM convali WHERE idevento='".$objEventos->id."'");
	$totalEventoAli=0;
	while($objValorUnitAli=mysql_fetch_object($sqlValorUnitAli)){
		$totalEventoAli=$totalEventoAli+(float)$objValorUnitAli->total;
		}
	$sqlValorUnitHos=mysql_query("SELECT total FROM convhos WHERE idevento='".$objEventos->id."'");
	$totalEventoHos=0;
	while($objValorUnitHos=mysql_fetch_object($sqlValorUnitHos)){
		$totalEventoHos=$totalEventoHos+(float)$objValorUnitHos->total;
		}
	$sqlValorUnitTra=mysql_query("SELECT total FROM convtra WHERE idevento='".$objEventos->id."'");
	$totalEventoTra=0;
	while($objValorUnitTra=mysql_fetch_object($sqlValorUnitTra)){
		$totalEventoTra=$totalEventoTra+(float)$objValorUnitTra->total;
		}
	$sqlValorUnitPas=mysql_query("SELECT total FROM convpas WHERE idevento='".$objEventos->id."'");
	$totalEventoPas=0;
	while($objValorUnitPas=mysql_fetch_object($sqlValorUnitPas)){
		$totalEventoPas=$totalEventoPas+(float)$objValorUnitPas->total;
		}
	$sqlValorUnitSgv=mysql_query("SELECT total FROM convsgv WHERE idevento='".$objEventos->id."'");
	$totalEventoSgv=0;
	while($objValorUnitSgv=mysql_fetch_object($sqlValorUnitSgv)){
		$totalEventoSgv=$totalEventoSgv+(float)$objValorUnitSgv->total;
		}
	$sqlValorUnitRh=mysql_query("SELECT total FROM convrh WHERE idevento='".$objEventos->id."'");
	$totalEventoRh=0;
	while($objValorUnitRh=mysql_fetch_object($sqlValorUnitRh)){
		$totalEventoRh=$totalEventoRh+(float)$objValorUnitRh->total;
		}
	$totalEventoGeral=$totalEventoAli+$totalEventoHos+$totalEventoPas+$totalEventoTra+$totalEventoSgv+$totalEventoRh;
	echo "<tr><td width='15%'>".utf8_encode($objEventos->nome)."</td><td width='20%'>".$cidade."/".utf8_encode($estado)."</td><td width='15%'>".$abrang."</td><td width='5%'>".number_format($totalEventoGeral,2,",",".")."</td><td width='15%'>".$objEventos->dtinicio." - ".$objEventos->dtfim."</td><td width='25%'><table border='0'><tr><td><form action='editEvento.php' name='formProjConv' method='post'><input type='hidden' name='idEv' value='".$objEventos->id."'/><input type='hidden' name='idproj' value='".$id."'/><input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' name='titMod' value='".$titMod."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td>
<form action='../relatorios/index.php' name='formProjEdit' method='post' target='_blank'><input type='hidden' name='titMod' value='".$titMod."'/><input type='hidden' name='idevento' value='".$objEventos->id."'/><input type='submit' name='editar' value='Relat&oacute;rio' class='button'/></form></td></tr></table></td></tr>";
	}
echo "</table></div>";
?>
<br /><br />
<a href="../modalidades/index.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>
