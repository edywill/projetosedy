<?php 
$sqlDetEvento=mysql_query("SELECT conveventos.* FROM conveventos WHERE conveventos.id='".trim($idEvento)."'") or die(mysql_error());
$arrayDetEvento=mysql_fetch_array($sqlDetEvento);
if(empty($arrayDetEvento)){
	echo $idEvento;
	}
if($arrayDetEvento['tipoloc']=='nac'){
	$tipoLocEvento='Nacional';
	$sqlCidadeGeral=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$arrayDetEvento['cidade']."'"));
	$cidade=utf8_encode($sqlCidadeGeral['municipio']);
	$estado=$arrayDetEvento['uf'];
	}else{
		$tipoLocEvento='Internacional';
		$cidade=utf8_encode($arrayDetEvento['cidade']);
		$estado=$arrayDetEvento['uf'];
		}
	$sqlValorUnitAli=mysql_query("SELECT total FROM convali WHERE idevento='".trim($idEvento)."'");
	$totalEventoAli=0;
	while($objValorUnitAli=mysql_fetch_object($sqlValorUnitAli)){
		$totalEventoAli=$totalEventoAli+(float)$objValorUnitAli->total;
		}
	$sqlValorUnitHos=mysql_query("SELECT total FROM convhos WHERE idevento='".trim($idEvento)."'");
	$totalEventoHos=0;
	while($objValorUnitHos=mysql_fetch_object($sqlValorUnitHos)){
		$totalEventoHos=$totalEventoHos+(float)$objValorUnitHos->total;
		}
	$sqlValorUnitTra=mysql_query("SELECT total FROM convtra WHERE idevento='".trim($idEvento)."'");
	$totalEventoTra=0;
	while($objValorUnitTra=mysql_fetch_object($sqlValorUnitTra)){
		$totalEventoTra=$totalEventoTra+(float)$objValorUnitTra->total;
		}
	$sqlValorUnitPas=mysql_query("SELECT total FROM convpas WHERE idevento='".trim($idEvento)."'");
	$totalEventoPas=0;
	while($objValorUnitPas=mysql_fetch_object($sqlValorUnitPas)){
		$totalEventoPas=$totalEventoPas+(float)$objValorUnitPas->total;
		}
	$sqlValorUnitSgv=mysql_query("SELECT total FROM convsgv WHERE idevento='".trim($idEvento)."'");
	$totalEventoSgv=0;
	while($objValorUnitSgv=mysql_fetch_object($sqlValorUnitSgv)){
		$totalEventoSgv=$totalEventoSgv+(float)$objValorUnitSgv->total;
		}
	$sqlValorUnitRh=mysql_query("SELECT total FROM convrh WHERE idevento='".trim($idEvento)."'");
	$totalEventoRh=0;
	while($objValorUnitRh=mysql_fetch_object($sqlValorUnitRh)){
		$totalEventoRh=$totalEventoRh+(float)$objValorUnitRh->total;
		}
	$totalEventoGeral=$totalEventoAli+$totalEventoHos+$totalEventoPas+$totalEventoTra+$totalEventoSgv+$totalEventoRh;
echo "
<h3>Evento</h3>
<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Evento:</th><td colspan='2'>".utf8_encode($arrayDetEvento['nome'])."</td><td><strong>".$tipoLocEvento."</strong></td></tr>";
if($arrayDetEvento['tipoloc']=='nac'){
echo "<tr><th>Cidade/UF:</th><td width='20%' colspan='2'>".$cidade."/".$estado."</td>";
}else{
	echo "<tr><th>Cidade/Pa&iacute;s:</th><td width='20%'>".$cidade."</td><th width='20%'>Pa&iacute;s:</th><td width='20%'>".utf8_encode($arrayDetEvento['pais'])."</td>";
	}
echo "<tr>
<tr><th>In&iacute;cio:</th><td width='20%'>".$arrayDetEvento['dtinicio']."</td><th width='20%'>Fim:</th><td width='20%'>".$arrayDetEvento['dtfim']."</td><tr>
<tr><th>Total do Evento (R$)</th><td>".number_format($totalEventoGeral,2,",",".")."</td><td align='center' colspan='1'><form action='../eventos/editEvento.php' name='formProjEdit' method='post'>
<input type='hidden' name='idEv' value='".$arrayDetEvento['id']."'/><input type='hidden' name='idproj' value='".$id."'/><input type='hidden' value='".$tipoId."' name='tipoId'/><input type='hidden' name='titMod' value='".$titMod."'/>
<input type='submit' name='editar' value='Editar' class='button'/></form></td><td align='center' colspan='1'><form action='../relatorios/index.php' name='formProjEdit' method='post' target='_blank'><input type='hidden' name='titMod' value='".$titMod."'/><input type='hidden' name='idevento' value='".$arrayDetEvento['id']."'/><input type='submit' name='editar' value='Relat&oacute;rio' class='button'/></form></td></tr></table></div>";
?>