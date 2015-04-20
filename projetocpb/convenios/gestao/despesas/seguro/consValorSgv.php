<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$cidade=$_GET['valor'];
$cidade=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $cidade ) );
$peri=$_GET['peri'];
$peri=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $peri ) );
if($cidade<>"" && $peri<>""){
$sql = "SELECT id,valor,abrg FROM convsgvreferencia WHERE upper(local) like '".mb_strtoupper($cidade)."' AND periodo>='".$peri."'";
$resultado = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo trim($resultado['valor'])."-".trim($resultado['abrg'])."-".trim($resultado['id']);
		}
}
?>