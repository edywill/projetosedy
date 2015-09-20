<?php 
session_start();
require "../conectsqlserver.php";
require "../conect.php";
$_SESSION['tpSav']=3;
$numCi=$_SESSION['numCiSav'];
$numSav=$_SESSION['numSav'];
$tipoPas=2;
extract($_GET);
$_SESSION['origemidaSav2']=$origemida;
$_SESSION['destinoidaSav2']=$destinoida;
$_SESSION['horarioidaSav2']=$horarioIda;
$_SESSION['horariovoltaSav2']=$horarioVolta;
$_SESSION['dtidaSav2']=$dtida;
$_SESSION['dtvoltaSav2']=$dtvolta;
$_SESSION['valorPasSav']=$valorpass;
$abrangencia=$_SESSION['abrangenciaSav'];
$_SESSION['cidorigemPasSav']='';
$_SESSION['ciddestinoPasSav']='';
if($abrangencia=='Internacional'){
	$_SESSION['cidorigemPasSav']=$cidorigem;
	$_SESSION['ciddestinoPasSav']=$ciddestino;
	}
if($idaevolta==0){
	$_SESSION['idaeVoltaSav']=1;
	$tipoPas=1;
	$_SESSION['dtvoltaSav2']='';
	$_SESSION['horariovoltaSav2']='';
	}
$cadeirante=0;
if($cadeirante2==1){
	$_SESSION['cadeiranteSav']=1;
	$cadeirante=1;
	}
$valida=0;
$countError=0;
$errorMsg='';
if(empty($_SESSION['origemidaSav2'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a origem.<br>';
	}
if(empty($_SESSION['destinoidaSav2'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o destino.<br>';
	}
	if($valida==0){
		if($_SESSION['destinoidaSav2']==$_SESSION['origemidaSav2']){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Origem e destino não podem ser iguais.<br>';
			}
		}
if(empty($_SESSION['horarioidaSav2']) || $_SESSION['horarioidaSav2']=='0'){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe hora de ida.<br>';
	}
if(empty($_SESSION['dtidaSav2'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de ida.<br>';
	}
	$arrayDtIdaEvento=explode("/",$_SESSION['dtidaSavEvento']);
	$arrayDtIda=explode("/",$_SESSION['dtidaSav2']);
	$arrayDtVolta=explode("/",$_SESSION['dtvoltaSav2']);

	if($_SESSION['idaeVoltaSav']<>1){
		if(empty($_SESSION['horariovoltaSav2']) || $_SESSION['horariovoltaSav2']=='0'){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe hora de volta.<br>';
		}
		if(empty($_SESSION['dtvoltaSav2'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe a data de volta.<br>';
		}else{
		if(!empty($_SESSION['dtidaSav2'])){
		if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) > strtotime($arrayDtVolta[2]."-".$arrayDtVolta[1]."-".$arrayDtVolta[0])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Data de ida nao pode ser superior a de volta.<br>';
		  }
		 }
		}
	}
	if(empty($_SESSION['valorPasSav'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe valor previsto da passagem.<br>';
		}
if($valida==0){
$arrayOrigemIda=explode("-",$_SESSION['origemidaSav2']);
$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav2']);
$consultaLocais1='';
$consultaLocais2='';
if($abrangencia=='Nacional'){
	$consultaLocais1="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayOrigemIda[0]."'";
	$consultaLocais2="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayDestinoIda[0]."'";
	}else{
		$consultaLocais1="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayOrigemIda[0]."'";
		$consultaLocais2="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayDestinoIda[0]."'";
		}
$queryConsultaLocais1=mysql_query($consultaLocais1) or die(mysql_error());
$executaConsultaLocais1=mysql_fetch_array($queryConsultaLocais1);
$queryConsultaLocais2=mysql_query($consultaLocais2) or die(mysql_error());
$executaConsultaLocais2=mysql_fetch_array($queryConsultaLocais2);
if($executaConsultaLocais1['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Origem informada invalida.<br>';
	}
if($executaConsultaLocais2['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Destino informado invalido.<br>';
	}
}
if($valida==0){
	$compl='0';
	if($abrangencia=='Internacional'){
		$compl='itn';
		}
	$sqlInsertPassagem=mysql_query("INSERT INTO savpassagem VALUES ('','".$numSav."','".$arrayOrigemIda[0]."','".$arrayDestinoIda[0]."','".utf8_decode($_SESSION['cidorigemPasSav'])."','".utf8_decode($_SESSION['ciddestinoPasSav'])."','".$_SESSION['dtidaSav2']."','".$_SESSION['dtvoltaSav2']."','".$_SESSION['horarioidaSav2']."','".$_SESSION['horariovoltaSav2']."','".$_SESSION['valorPasSav']."','".$numCi."','".$tipoPas."','".$cadeirante."','".$compl."')");
		if(!$sqlInsertPassagem){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Problema ao inserir o dado, tente novamente.<br>';
		}
	}

if($valida==1){
		
		echo $errorMsg;
		
		}else{
			if($_SESSION['idaeVoltaSav']==1){
			    $_SESSION['origemidaSav2']=$_SESSION['destinoidaSav2'];	
				$_SESSION['cidorigemPasSav']=$_SESSION['ciddestinoPasSav'];
				$_SESSION['destinoidaSav3']=$_SESSION['destinoidaSav2'];
				$_SESSION['cidHosSav']=$_SESSION['ciddestinoPasSav'];
				}else{
					$_SESSION['origemidaSav2']='';
					$_SESSION['cidorigemPasSav']='';
					}
			$_SESSION['idaeVoltaSav']='';
			$_SESSION['destinoidaSav2']='';
			$_SESSION['horarioidaSav2']='';
			$_SESSION['horariovoltaSav2']='';
			$_SESSION['dtidaSav2']='';
			$_SESSION['dtvoltaSav2']='';
			$_SESSION['valorPasSav']='';
			//$_SESSION['ciddestinoPasSav']='';
				echo "1";
			}
?>