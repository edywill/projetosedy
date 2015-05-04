<?php 
session_start();
echo "<div style='display: none;'>";
require "../conectsqlserver.php";
require "../conect.php";
include "../ChromePhp.php";
$valida=0;
$countError=0;
$errorMsg='';
extract($_GET);
$_SESSION['dtidaSav10']=$dtida;
$_SESSION['dtvoltaSav10']=$dtvolta;
$_SESSION['dtidaSavEvento10']=$dtida;
$_SESSION['dtvoltaSavEvento10']=$dtvolta;
$_SESSION['origemidaSav10']=utf8_decode($origemida);
$_SESSION['destinoidaSav10']=utf8_decode($destinoida);
$_SESSION['origemvoltaSav10']=utf8_decode($origemvolta);
$_SESSION['destinovoltaSav10']=utf8_decode($destinovolta);
$_SESSION['cidorigemvoltaSav10']='';
$_SESSION['ciddestinovoltaSav10']='';
$_SESSION['cidorigemidaSav10']='';
$_SESSION['ciddestinoidaSav10']='';
if($_SESSION['abrangenciaSav']=='Internacional'){
$_SESSION['cidorigemvoltaSav10']=utf8_decode($cidorigemvolta);
$_SESSION['ciddestinovoltaSav10']=utf8_decode($ciddestinovolta);
$_SESSION['cidorigemidaSav10']=utf8_decode($cidorigemida);
$_SESSION['ciddestinoidaSav10']=utf8_decode($ciddestinoida);
}
$_SESSION['horarioidaSav10']=$horarioIda;
$_SESSION['horariovoltaSav10']=$horarioVolta;

if(empty($_SESSION['dtidaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Data de ida não informada.<br>';
	 }
if(empty($_SESSION['dtvoltaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Data de volta não informada.<br>';
	 }
if($valida==0){
	$arrayDtIda=explode("/",$_SESSION['dtidaSav10']);
	$arrayDtVolta=explode("/",$_SESSION['dtvoltaSav10']);
	if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) > strtotime($arrayDtVolta[2]."-".$arrayDtVolta[1]."-".$arrayDtVolta[0])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Data de ida não pode ser superior a de volta.<br>';
		}
	}
if(empty($_SESSION['origemidaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a origem da ida para caracterização do trecho.<br>';
	 }
if(empty($_SESSION['destinoidaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o destino da ida para caracterização do trecho.<br>';
	 }
if(empty($_SESSION['origemvoltaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a origem da volta para caracterização do trecho.<br>';
	 }
if(empty($_SESSION['destinovoltaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o destino da volta para caracterização do trecho.<br>';
	 }
	if($valida==0){
$arrayOrigemIda=explode("-",$_SESSION['origemidaSav10']);
$arrayOrigemVolta=explode("-",$_SESSION['origemvoltaSav10']);
$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav10']);
$arrayDestinoVolta=explode("-",$_SESSION['destinovoltaSav10']);
$consultaLocais1='';
if($_SESSION['abrangenciaSav']=='Nacional'){
	$consultaLocais1="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayOrigemIda[0]."'";
	$consultaLocais2="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayOrigemVolta[0]."'";
	$consultaLocais3="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayDestinoIda[0]."'";
	$consultaLocais4="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayDestinoVolta[0]."'";
	}else{
		$consultaLocais1="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayOrigemIda[0]."'";
		$consultaLocais2="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayOrigemVolta[0]."'";
		$consultaLocais3="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayDestinoIda[0]."'";
		$consultaLocais4="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayDestinoVolta[0]."'";
		}
$queryConsultaLocais1=mysql_query($consultaLocais1);
$executaConsultaLocais1=mysql_fetch_array($queryConsultaLocais1);
$queryConsultaLocais2=mysql_query($consultaLocais2);
$executaConsultaLocais2=mysql_fetch_array($queryConsultaLocais2);
$queryConsultaLocais3=mysql_query($consultaLocais3);
$executaConsultaLocais3=mysql_fetch_array($queryConsultaLocais3);
$queryConsultaLocais4=mysql_query($consultaLocais4);
$executaConsultaLocais4=mysql_fetch_array($queryConsultaLocais4);
if($executaConsultaLocais1['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Origem ida informada inválida.<br>';
	}
if($executaConsultaLocais2['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Origem volta informada inválida.<br>';
	}
if($executaConsultaLocais3['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Destino ida informada inválida.<br>';
	}
if($executaConsultaLocais4['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Destino volta informada inválida.<br>';
	}
}
if($valida==0){
$status2=utf8_decode("Elaboração");
			//Update

$sqlRegistro="UPDATE savregistros SET dtida='".$_SESSION['dtidaSav10']."', dtvolta='".$_SESSION['dtvoltaSav10']."',origemida='".$arrayOrigemIda[0]."',origemvolta='".$arrayOrigemVolta[0]."',cidorigemida='".$_SESSION['cidorigemidaSav10']."',cidorigemvolta='".$_SESSION['cidorigemvoltaSav10']."',destinoida='".$arrayDestinoIda[0]."',destinovolta='".$arrayDestinoVolta[0]."',ciddestinoida='".$_SESSION['ciddestinoidaSav10']."',ciddestinovolta='".$_SESSION['ciddestinovoltaSav10']."',horarioida='".$_SESSION['horarioidaSav10']."',horariovolta='".$_SESSION['horariovoltaSav10']."' WHERE id='".$_SESSION['numSav']."'";
			$queryRegistro=mysql_query($sqlRegistro);
			if(!$queryRegistro){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
}
echo "</div>";
if($valida>0){
	$_SESSION['tpSav']=2;
	$erro=$errorMsg;
	}else{	
		$_SESSION['tpSav']=3;
		$erro='Atualizado com sucesso!<br>CLIQUE EM CONCLUIR';
	}
	echo $erro;
?>