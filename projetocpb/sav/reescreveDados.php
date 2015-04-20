<?php
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";

$abrangencia=$_SESSION['abrangenciaSav'];
echo '<div id="tabela">';
if($_SESSION['passagemSav']=='sim'){
	$arrayOrigemIda=explode("-",$_SESSION['origemidaSav2']);
	$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav2']);
	$complementoInt='';
	if($abrangencia=='Nacional'){
		$abrangTipo=' (SELECT municipio FROM municipios WHERE id=savpassagem.origem) AS origemTrecho, (SELECT municipio FROM municipios WHERE id=savpassagem.destino) AS destinoTrecho ';
		}else{
			$abrangTipo=' (SELECT nome FROM paises WHERE iso=savpassagem.origem) AS origemTrecho, (SELECT nome FROM paises WHERE iso=savpassagem.destino) AS destinoTrecho ';
			$complementoInt=" AND inter='itn'";
			}
	$sqlPassagemConsulta=mysql_query("SELECT savpassagem.id,savpassagem.valor,savpassagem.cadeirante,savpassagem.horarioida,savpassagem.horariovolta,savpassagem.dtida,savpassagem.dtvolta,".$abrangTipo.",savpassagem.tipo,savpassagem.cidorigem,savpassagem.ciddestino FROM savpassagem WHERE savpassagem.idsav='".$_SESSION['numSav']."' ".$complementoInt."");
	$countPassagemConsulta=mysql_num_rows($sqlPassagemConsulta);
	if($countPassagemConsulta>0){	
		echo "<table border='1' width='100%'>
		<tr><th colspan='4'>PASSAGEM AÉREA ".strtoupper($abrangencia)."</th></tr>
		<tr><th width='45%'>Trecho</th><th width='30%'>Datas</th><th width='15%'>Valor</th><th width='10%'>Excluir</th></tr>";
		$trechoPassagem='';
		$datasViagem='';
		$cadeirante="";
		while($objPassagemConsulta=mysql_fetch_object($sqlPassagemConsulta)){
		if($objPassagemConsulta->cadeirante==1){
			$cadeirante="*";
			}
		if($objPassagemConsulta->tipo==2){
			if(!empty($objPassagemConsulta->cidorigem)){
			  $trechoPassagem=$cadeirante.$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->ciddestino."-".$objPassagemConsulta->destinoTrecho." x ".$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho;
			}else{
			  $trechoPassagem=$cadeirante.$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->destinoTrecho." x ".$objPassagemConsulta->origemTrecho;
				}
			$datasViagem=$objPassagemConsulta->dtida."(".strtoupper($objPassagemConsulta->horarioida).") / ".$objPassagemConsulta->dtvolta."(".strtoupper($objPassagemConsulta->horariovolta).")";
		}else{
			if(!empty($objPassagemConsulta->cidorigem)){
			$trechoPassagem=$cadeirante.$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->ciddestino."-".$objPassagemConsulta->destinoTrecho;	
			}else{
			$trechoPassagem=$cadeirante.$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->destinoTrecho;
			}
			$datasViagem=$objPassagemConsulta->dtida."(".strtoupper($objPassagemConsulta->horarioida).")";
			}
		echo "<tr><td>".utf8_encode($trechoPassagem)."</td><td>".$datasViagem."</td><td>R$ ".$objPassagemConsulta->valor."</td><td align='center'><a href='excluirPassagem.php?id=".$objPassagemConsulta->id."'><img src='css/icone_excluir.png'/></a></td></tr>";	
			}
			echo "</table>";
	}
}
	if(trim($_SESSION['diariaSav'])=='sim'){
	$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav3']);
	if($abrangencia=='Nacional'){
		$abrangTipo=' (SELECT municipio FROM municipios WHERE id=savhospedagem.destino) AS destinoTrecho ';
		}else{
			$abrangTipo=' (SELECT nome FROM paises WHERE iso=savhospedagem.destino) AS destinoTrecho ';
			}
	$sqlHospedagemConsulta=mysql_query("SELECT savhospedagem.id,savhospedagem.dtida,savhospedagem.dtvolta,".$abrangTipo.",savhospedagem.tipo,savhospedagem.cidhos FROM savhospedagem WHERE savhospedagem.idsav='".$_SESSION['numSav']."'");
	$countHospedagemConsulta=mysql_num_rows($sqlHospedagemConsulta);
	if($countHospedagemConsulta>0){	
		echo "<div id='tabela'><table border='1' width='100%'>
		<tr><th colspan='4'>HOSPEDAGEM</th></tr>
		<tr><th width='45%'>Cidade</th><th width='30%'>Datas</th><th width='15%'>Tipo Quarto</th><th width='10%'>Excluir</th></tr>";
		while($objHospedagemConsulta=mysql_fetch_object($sqlHospedagemConsulta)){
			$destinoTrecho=$objHospedagemConsulta->destinoTrecho;
			if(!empty($objHospedagemConsulta->cidhos)){
				$destinoTrecho=$objHospedagemConsulta->cidhos."-".$objHospedagemConsulta->destinoTrecho;
				}
		echo "<tr><td>".utf8_encode($destinoTrecho)."</td><td>".$objHospedagemConsulta->dtida." a ".$objHospedagemConsulta->dtvolta."</td><td>".$objHospedagemConsulta->tipo."</td><td align='center'><a href='excluirHospedagem.php?id=".$objHospedagemConsulta->id."'><img src='css/icone_excluir.png'></a></td></tr>";	
			}
			echo "</table></div>";
	}
}
if($_SESSION['transladoSav']=='sim'){
	$sqlTransConsulta=mysql_query("SELECT savtranslado.id,savtranslado.valor,savtranslado.dtida,savtranslado.dtvolta FROM savtranslado WHERE savtranslado.idsav='".$_SESSION['numSav']."'");
	$countTransConsulta=mysql_num_rows($sqlTransConsulta);
	if($countTransConsulta>0){	
		echo "<div id='tabela'><table border='1' width='100%'>
		<tr><th colspan='4'>LOCAÇÃO DE VEÍCULO - TRANSPORTE</th></tr>
		<tr><th width='75%'>Datas</th><th width='15%'>Valor</th><th width='10%'>Excluir</th></tr>";
		$datasViagem2='';
		while($objTransConsulta=mysql_fetch_object($sqlTransConsulta)){
		$datasViagem2=$objTransConsulta->dtida." / ".$objTransConsulta->dtvolta."";
		echo "<tr><td>".$datasViagem2."</td><td>R$ ".$objTransConsulta->valor."</td><td align='center'><a href='excluirTranslado.php?id=".$objTransConsulta->id."'><img src='css/icone_excluir.png'></a></td></tr>";	
			}
			echo "</table></div>";
	}
}
echo "
</div>";
?>