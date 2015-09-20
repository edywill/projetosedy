<?php 

if(empty($_SESSION['idPrestCont'])){
	$sqlMaxPrest=mysql_fetch_array(mysql_query("SELECT max(id) AS maxid FROM prestsav"));
	$id=$sqlMaxPrest['maxid']+1;
$sqlInsertPrest=mysql_query("INSERT INTO prestsav(id)
values(".$id.")") or die(mysql_error());
}else{
	$id=$_SESSION['idPrestCont'];
	}

$i = 0;
if(!empty($_FILES['arquivos']['tmp_name'])){
#Analisa cada arquivo
foreach ($_FILES['arquivos']['tmp_name'] as $key => $tmp_name) {
	if(!empty($tmp_name)){
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
		//echo $_FILES["arquivos"]["error"][$key];
		};
    #Próximo arquivo a ser analisado
    $i++;
}
}
}
?>