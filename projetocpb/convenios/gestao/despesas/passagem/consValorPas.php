<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$origem=$_GET['valor'];
$destino=$_GET['valor2'];
$abrg=$_GET['abrg'];
if($origem<>"" && $destino<>""){
if($abrg=='Nacional'){
$sql = "SELECT id,valor,abrg FROM convpasreferencia WHERE upper(origem) = '".mb_strtoupper($origem)."' AND upper(destino) = '".mb_strtoupper($destino)."'";
$resultado = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo trim($resultado['valor'])."-".trim($resultado['abrg'])."-".trim($resultado['id']);
		}
}else{
	$sql = "SELECT id,valor,abrg FROM convpasintreferencia WHERE upper(origem) = '".mb_strtoupper($_GET['cidorigem'])."-".mb_strtoupper($origem)."' AND upper(destino) = '".mb_strtoupper($_GET['ciddestino'])."-".mb_strtoupper($destino)."'";
	$resultado = mysql_query($sql) or die(mysql_error());
	$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo trim($resultado['valor'])."-".trim($resultado['abrg'])."-".trim($resultado['id']);
		}
	}
}
?>