<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$cidade=$_GET['valor'];
$cidade=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $cidade ) );
$tipo=$_GET['tipo'];
$tipo=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $tipo ) );
if($cidade<>"" && $tipo<>""){
$sql = "SELECT id,valor,abrg FROM convtrareferencia WHERE upper(local) like '".mb_strtoupper($cidade)."' AND tipo='".$tipo."'";
$resultado = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo trim($resultado['valor'])."-".trim($resultado['abrg'])."-".trim($resultado['id']);
		}
}
?>