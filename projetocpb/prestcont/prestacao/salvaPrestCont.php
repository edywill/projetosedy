<?php 
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$valida=0;
if(empty($_SESSION['idPrestCont'])){
	$sqlMaxPrest=mysql_fetch_array(mysql_query("SELECT max(id) AS maxid FROM prestsav"));
	$id=$sqlMaxPrest['maxid']+1;
$sqlInsertPrest=mysql_query("INSERT INTO prestsav(id,savid,data,obs)
values(".$id.",
".$_POST['sav'].",
'".date("d/m/Y")."',
'".utf8_decode($_POST['obs'])."')") or die(mysql_error());
}else{
	$sqlInsertPrest=mysql_query("UPDATE prestsav SET dtalt='".date("d/m/Y")."', obs='".utf8_decode($_POST['obs'])."' WHERE id='".$_SESSION['idPrestCont']."'") or die(mysql_error());;
	$id=$_SESSION['idPrestCont'];
	}
if(!$sqlInsertPrest){
		$valida=1;
		};
//Processo de upload dos arquivos
$i = 0;
 
#Analisa cada arquivo
foreach ($_FILES['arquivos']['tmp_name'] as $key => $tmp_name) {
    # Definir o diretório onde salvar os arquivos.
    $destino = "anexos/SAV[".$_POST['sav']."]".utf8_decode(str_replace(" ","",$_FILES["arquivos"]["name"][$key]));
	if(file_exists ($destino)){
		$destino="anexos/SAV[".$_POST['sav']."](copia)".utf8_decode(str_replace(" ","",$_FILES["arquivos"]["name"][$key]));
		}
			$sqlArquivo=mysql_query("INSERT prestsavarq(idprest,arquivo) VALUES ('".$id."','".$destino."')") or die(mysql_error());
			if(!$sqlArquivo){
				$valida=1;
				};
    #Move o arquivo para o diretório de destino
    if(!move_uploaded_file($_FILES['arquivos']['tmp_name'][$key],$destino)){
		$valida=1;
		echo $_FILES["arquivos"]["error"][$key];
		};
    #Próximo arquivo a ser analisado
    $i++;
}
if($valida==0){
	echo "<script>alert('Processado com sucesso');window.location.href='prestUser.php';</script>"; 
	}else{
		echo "<script>alert('Ocorreu um erro! Tente novamente!');window.location.href='prestUser.php';</script>";
		}
?>