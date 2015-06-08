<?php 
session_start();
require "../conectsqlserver.php";
require "../conect.php";
$_SESSION['tpSav']=3;
$numCi=$_SESSION['numCiSav'];
$numSav=$_SESSION['numSav'];
$tipoPas=2;
extract($_GET);
$_SESSION['dtidaSav4']=$dtida;
$_SESSION['dtvoltaSav4']=$dtvolta;
$_SESSION['valorTransSav']=$valorpass;
$abrangencia=$_SESSION['abrangenciaSav'];
$valida=0;
$countError=0;
$errorMsg='';
if(empty($_SESSION['dtidaSav4'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de ida.<br>';
	}elseif(empty($_SESSION['dtvoltaSav4'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe a data de volta.<br>';
		
		}
	else{
	$arrayDtIda=explode("/",$_SESSION['dtidaSav4']);
	$arrayDtVolta=explode("/",$_SESSION['dtvoltaSav4']);
		if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) > strtotime($arrayDtVolta[2]."-".$arrayDtVolta[1]."-".$arrayDtVolta[0])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Data de ida nao pode ser superior a de volta.<br>';
		}
	}
	if(empty($_SESSION['valorTransSav'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe valor previsto da locacao.<br>';
		}
		$sqlDatasAnteriores=mysql_num_rows(mysql_query("SELECT savtranslado.id FROM savtranslado INNER JOIN savregistros ON savtranslado.idsav=savregistros.id WHERE savtranslado.dtida='".$_SESSION['dtidaSav4']."' AND savregistros.funcionario='".$_SESSION['idFuncSav']."'"));
if($sqlDatasAnteriores>0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Já existe pedido de passagem com data início igual.<br>';
	}
if($valida==0){
	$sqlInsertPassagem=mysql_query("INSERT INTO savtranslado VALUES ('','".$numSav."','".$_SESSION['dtidaSav4']."','".$_SESSION['dtvoltaSav4']."','".$_SESSION['valorTransSav']."','".$numCi."','".$tipoPas."')");
		if(!$sqlInsertPassagem){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Problema ao inserir o dado, tente novamente.<br>';
		}
	}

if($valida==1){
		echo $errorMsg;
		}else{
			$_SESSION['dtidaSav4']='';
			$_SESSION['dtvoltaSav4']='';
			$_SESSION['valorTransSav']='';
			echo "1";
			}
?>