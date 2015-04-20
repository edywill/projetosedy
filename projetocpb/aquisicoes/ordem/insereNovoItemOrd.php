<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
extract($_GET);
$idRegistro=$_SESSION['idRegAqui'];
$_SESSION['materialComp']=$material;
$sqlCdMaterial=mysql_fetch_array(mysql_query("SELECT aquimat.cdmat,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquicadmat.id=aquimat.cdmat WHERE aquimat.id='".$_SESSION['materialComp']."'"));
$_SESSION['materialCompDesc']=utf8_encode($sqlCdMaterial['nome']);
$_SESSION['qtdMat']=$qtd;
$material=$_SESSION['materialComp'];
$qtd=trim($qtd);

$valida=0;
$countError=0;
$errorMsg='';

if($_SESSION['tipoAcao']=='inserir' && empty($_SESSION['idRegOrdem'])){
	$sqlUltimaOrdemAno=mysql_fetch_array(mysql_query("SELECT MAX(idos) AS id FROM aquiordem WHERE ano='".date("Y")."'"));
	$ultimaOrdemAno=$sqlUltimaOrdemAno['id']+1;
	$sqlUltimaOrdem=mysql_fetch_array(mysql_query("SELECT MAX(id) AS id FROM aquiordem"));
	$ultimaOrdem=$sqlUltimaOrdem['id']+1;
	$sqlCriaOrdem=mysql_query("INSERT INTO aquiordem (id,idreg,user,idos,ano) VALUES ('".$ultimaOrdem."','".$idRegistro."','".$_SESSION['userAquis']."','".$ultimaOrdemAno."','".date("Y")."')");
	$_SESSION['idRegOrdem']=$ultimaOrdem;
	$_SESSION['idOsImpSession']=$ultimaOrdemAno;
	$_SESSION['anoOsImpSession']=date("Y");
	}
if(empty($material) || $material=='0'){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Material inválido. Informe o material da lista.<br>';
	}else{
		$sqlMatDupQuery=mysql_query("SELECT id FROM aquipedidoitem WHERE idos='".$_SESSION['idRegOrdem']."' AND idmat='".$material."'") or die(mysql_error());
		$sqlMatDup=mysql_num_rows($sqlMatDupQuery);
		if($sqlMatDup>0 && $_SESSION['idatlSession']==0){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Material já cadastrado para essa Ordem.<br>';
			}
		}
if(empty($qtd) || $qtd=='0'){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a quantidade.<br>';
	}
 
if($valida==0){
	if(empty($_SESSION['idatlSession'])){
	$sqlInsertItemMat=mysql_query("INSERT INTO aquipedidoitem(idmat,idos,qtd) VALUES ('".$material."','".$_SESSION['idRegOrdem']."','".$qtd."')") or die(mysql_error());
	}else{
		$sqlInsertItemMat=mysql_query("UPDATE aquipedidoitem SET idmat='".$material."',idos='".$_SESSION['idRegOrdem']."',qtd='".$qtd."' WHERE id='".$_SESSION['idatlSession']."'") or die(mysql_error());
		}
  if(!$sqlInsertItemMat){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Erro ao processar o registro. Tente novamente.<br>';
	    }	
	}
if($valida==1)
{
	echo $errorMsg;
	
		}else{
$_SESSION['materialComp']='';
$_SESSION['materialCompDesc']='';
$_SESSION['qtdMat']='';
$_SESSION['idatlSession']='';
		echo "1";	
			}

?>