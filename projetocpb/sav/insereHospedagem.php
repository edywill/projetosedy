<?php 
session_start();
require "../conectsqlserver.php";
require "../conect.php";
$_SESSION['tpSav']=3;
$numCi=$_SESSION['numCiSav'];
$numSav=$_SESSION['numSav'];
$tipoPas=2;
extract($_GET);
$_SESSION['destinoidaSav3']=$destinoida2;
$_SESSION['dtidaSav3']=$dtida;
$_SESSION['dtvoltaSav3']=$dtvolta;
$_SESSION['tipoQuartoSav']=$tipoQuarto;
$abrangencia=$_SESSION['abrangenciaSav'];
$_SESSION['cidHosSav']='';
if($abrangencia=='Internacional'){
	$_SESSION['cidHosSav']=$cidhos;
	}
$_SESSION['valorHosSav']=$valorhos;
$valida=0;
$countError=0;
$errorMsg='';
if(empty($_SESSION['destinoidaSav3'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o destino.<br>';
	}
if(empty($_SESSION['dtidaSav3'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe data de ida.<br>';
	}elseif(!empty($_SESSION['dtvoltaSav3'])){
	$arrayDtIdaEvento=explode("/",$_SESSION['dtidaSavEvento']);
	$arrayDtIda=explode("/",$_SESSION['dtidaSav3']);
	$arrayDtVolta=explode("/",$_SESSION['dtvoltaSav3']);
	
	if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) > strtotime($arrayDtVolta[2]."-".$arrayDtVolta[1]."-".$arrayDtVolta[0])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Data de ida nao pode ser superior a de volta.<br>';
		  }
	}
		if(empty($_SESSION['dtvoltaSav3'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe a data de volta.<br>';
		}
		if(empty($_SESSION['valorHosSav'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe valor previsto da hospedagem.<br>';
		}
if($valida==0){
$arrayDestinoIda=explode("-",$_SESSION['destinoidaSav3']);
$sqlDatasAnteriores=mysql_num_rows(mysql_query("SELECT savhospedagem.id FROM savhospedagem INNER JOIN savregistros ON savhospedagem.idsav=savregistros.id WHERE savhospedagem.dtida='".$_SESSION['dtidaSav3']."' AND savhospedagem.cidhos='".$arrayDestinoIda[0]."' AND savregistros.funcionario='".$_SESSION['idFuncSav']."'"));
if($sqlDatasAnteriores>0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Já existe pedido de passagem com data de início e localidade igual.<br>';
	}
$consultaLocais2='';
if($abrangencia=='Nacional'){
	$consultaLocais2="SELECT count(id) as idqtd FROM municipios WHERE id='".$arrayDestinoIda[0]."'";
	}else{
		$consultaLocais2="SELECT count(iso) as idqtd FROM paises WHERE iso='".$arrayDestinoIda[0]."'";
		}
$queryConsultaLocais2=mysql_query($consultaLocais2) or die(mysql_error());
$executaConsultaLocais2=mysql_fetch_array($queryConsultaLocais2);
if($executaConsultaLocais2['idqtd']<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Localidade informada invalida.<br>';
	}
}
if($valida==0){
	$sqlInsertHospedagem=mysql_query("INSERT INTO savhospedagem(id,idsav,destino,cidhos,dtida,dtvolta,atci,tipo,valor) VALUES ('','".$numSav."','".$arrayDestinoIda[0]."','".utf8_decode($_SESSION['cidHosSav'])."','".$_SESSION['dtidaSav3']."','".$_SESSION['dtvoltaSav3']."','".$numCi."','".$_SESSION['tipoQuartoSav']."','".$_SESSION['valorHosSav']."')");
		if(!$sqlInsertHospedagem){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Problema ao inserir o dado, tente novamente.<br>'.mysql_error();
		}
	}

if($valida==1){
		echo $errorMsg;
		}else{
			$_SESSION['destinoidaSav3']='';
			$_SESSION['dtidaSav3']='';
			$_SESSION['dtvoltaSav3']='';
			$_SESSION['tipoQuartoSav']='';
			$_SESSION['valorHosSav']='';
			
		echo "1";
			}
?>