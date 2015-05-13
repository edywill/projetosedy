<?php 
session_start();
require "../conectsqlserver.php";
require "../conect.php";
$valida=0;
$countError=0;
$errorMsg='';
extract($_GET);
$_SESSION['dtidaSav10']=$dtida;
$_SESSION['dtvoltaSav10']=$dtvolta;
$_SESSION['dtidaSavEvento10']=$dtida;
$_SESSION['dtvoltaSavEvento10']=$dtvolta;
$_SESSION['destinoidaSav10']=utf8_decode($destinoida);
$_SESSION['ciddestinoidaSav10']='';
if($_SESSION['abrangenciaSav']=='Internacional'){
$_SESSION['ciddestinoidaSav10']=utf8_decode($ciddestinoida);
}
$_SESSION['horarioVolta10']=$horarioVolta;

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
if(empty($_SESSION['destinoidaSav10'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o destino da ida para caracterização do trecho.<br>';
	 }

if($valida==0){
$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav10']);
$consultaLocais1='';
if($_SESSION['abrangenciaSav']=='Nacional'){
	$consultaLocais1="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayDestinoIda[0]."'";
	}else{
		$consultaLocais1="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayDestinoIda[0]."'";
		}
$queryConsultaLocais1=mysql_query($consultaLocais1);
$executaConsultaLocais1=mysql_fetch_array($queryConsultaLocais1);
if($executaConsultaLocais1['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Destino informado é inválido.<br>';
	}
}
if($valida==0){
$status2=utf8_decode("Elaboração");
			//Update

$sqlRegistro="UPDATE savregistros SET dtida='".$_SESSION['dtidaSav10']."', dtvolta='".$_SESSION['dtvoltaSav10']."',origemida='".$arrayDestinoIda[0]."',origemvolta='".$arrayDestinoIda[0]."',cidorigemida='".$_SESSION['ciddestinoidaSav10']."',cidorigemvolta='".$_SESSION['ciddestinoidaSav10']."',destinoida='".$arrayDestinoIda[0]."',destinovolta='".$arrayDestinoIda[0]."',ciddestinoida='".$_SESSION['ciddestinoidaSav10']."',ciddestinovolta='".$_SESSION['ciddestinoidaSav10']."',horarioida='manha',horariovolta='".$_SESSION['horarioVolta10']."' WHERE id='".$_SESSION['numSav']."'";
			$queryRegistro=mysql_query($sqlRegistro);
			if(!$queryRegistro){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
}
if($valida>0){
	$_SESSION['tpSav']=2;
	$erro=$errorMsg;
	}else{	
		$_SESSION['tpSav']=3;
		$erro='Atualizado com sucesso!<br>CLIQUE EM CONCLUIR';
	}
	echo $erro;
?>