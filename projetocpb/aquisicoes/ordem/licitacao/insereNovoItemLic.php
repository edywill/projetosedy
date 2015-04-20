<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
$idRegistro=$_SESSION['idRegAqui'];
 extract($_GET);
$_SESSION['qtdMat']=$qtd;
$_SESSION['vlunitMat']=$vlunit;
$_SESSION['materialComp']=$material;
$qtd=trim($qtd);
$valida=0;
$countError=0;
$errorMsg='';
if(empty($material) || $material==0){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Material inválido.<br>';
	}
if(empty($vlunit)){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe o valor unitário.<br>';
	}
if(empty($qtd)){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a quantidade.<br>';
	}
	$tipo='';
	if($idatl==0){
	$sqlDuplicidade=mysql_num_rows(mysql_query("SELECT cdmat FROM aquimatlic WHERE idreg='".$idRegistro."' AND cdmat='".$material."'"));
	if($sqlDuplicidade>0){
		 $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Material já cadastrado para esse registro.<br>';
	}
}
if($valida==0){
	if($idatl==0){
	$sqlInsertItemMat=mysql_query("INSERT INTO aquimatlic(idreg,cdmat,quant,vlunit) VALUES ('".$idRegistro."','".$material."','".$qtd."','".$vlunit."')");
	}else{
		$sqlInsertItemMat=mysql_query("UPDATE aquimatlic SET idreg='".$idRegistro."',cdmat='".$material."',quant='".$qtd."',vlunit='".$vlunit."' WHERE id='".$idatl."'");
		}
  if(empty($sqlInsertItemMat)){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Erro ao processar o registro. Tente novamente.\\n';
	}	
	}

if($valida==1)
{
	echo $errorMsg;
	
		}else{
$_SESSION['materialComp']='';
$_SESSION['materialCompDesc']='';
$_SESSION['qtdMat']='';
$_SESSION['vlunitMat']='';
$_SESSION['acaoSession']='';
echo "1";	
			}

?>