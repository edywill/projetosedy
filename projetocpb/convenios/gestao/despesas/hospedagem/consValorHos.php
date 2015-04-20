<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$cidade=$_GET['valor'];
$cidade=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $cidade ) );
if($cidade<>""){
$sqls = "SELECT id,valor,abrg FROM convhosreferencia WHERE upper(local) like '".mb_strtoupper($cidade)."' AND tipo='1'";
$resultados = mysql_query($sqls) or die(mysql_error());
$resultados = mysql_fetch_array($resultados);
$sqld = "SELECT id,valor,abrg FROM convhosreferencia WHERE upper(local) like '".mb_strtoupper($cidade)."' AND tipo='2'";
$resultadod = mysql_query($sqld) or die(mysql_error());
$resultadod = mysql_fetch_array($resultadod);
		if (!empty($resultados) || !empty($resultadod)){	
			echo trim($resultados['valor'])."-".trim($resultados['abrg'])."-".trim($resultados['id']).":".trim($resultadod['valor'])."-".trim($resultadod['abrg'])."-".trim($resultadod['id']);
		}
}
?>