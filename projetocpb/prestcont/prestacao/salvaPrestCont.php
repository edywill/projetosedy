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
 
if(!empty($_FILES['arquivos']['tmp_name'])){
#Analisa cada arquivo
foreach ($_FILES['arquivos']['tmp_name'] as $key => $tmp_name) {
    echo $tmp_name."<br>";
	if(!empty($tmp_name)){
	# Definir o diretório onde salvar os arquivos.
    $destino = "anexos/SAV[".$_POST['sav']."]".utf8_decode(str_replace(" ","",$_FILES["arquivos"]["name"][$key]));
	if(file_exists ($destino)){
		$destino="anexos/SAV[".$_POST['sav']."](copia)".utf8_decode(str_replace(" ","",$_FILES["arquivos"]["name"][$key]));
		}
			$sqlArquivo=mysql_query("INSERT prestsavarq(idprest,arquivo) VALUES ('".$id."','".$destino."')") or die(mysql_error());
			if(!$sqlArquivo){
				$valida=1;
				echo "-inserido1";
				};
    #Move o arquivo para o diretório de destino
    if(!move_uploaded_file($_FILES['arquivos']['tmp_name'][$key],$destino)){
		$valida=1;
		echo "-inserido2<br>";
		//echo $_FILES["arquivos"]["error"][$key];
		};
    #Próximo arquivo a ser analisado
    $i++;
}
}
}
$querySavRegistros=mysql_query("SELECT savregistros.id FROM savregistros LEFT JOIN prestsav ON prestsav.savid=savregistros.id
WHERE prestsav.id='".$id."'") or die(mysql_error());
$sqlSavRegistro=mysql_fetch_array($querySavRegistros);

if(!empty($_POST['cont']) || $_POST['cont']>0){
  $sqlDeletePass=mysql_query("DELETE FROM prestsavvoo WHERE idprest='".$id."'");
  $contadorGeral=$_POST['cont'];
  $cont=0;
  while($contadorGeral>$cont){ 
	   $nomeCampoVoo='voo'.$cont;
	   $nomeCampoIdPas='idpas'.$cont;
	   $nomeCampoCia='cia'.$cont;
	   $nomeCampoLoc='loc'.$cont;
	   $nomeCampoHor='hora'.$cont;
	   $cia=$_POST[$nomeCampoCia];
	   $voo=$_POST[$nomeCampoVoo];
	   $loc=$_POST[$nomeCampoLoc];
	   $horario=$_POST[$nomeCampoHor];
	   $idpas=$_POST[$nomeCampoIdPas];
	  $incluiRegistro=mysql_query("INSERT prestsavvoo(idprest,idpass,voo,cia,loc,horario) values ('".$id."','".$idpas."','".$voo."','".$cia."','".$loc."','".$horario."')");
	  	$cont++;
	  }
}
if($valida==0){
	echo "<script>alert('Processado com sucesso');window.location.href='prestUser.php';</script>"; 
	}else{
		echo "<script>alert('Ocorreu um erro! Tente novamente!');window.location.href='prestContUser.php?id=".$id."';</script>";
		}
?>