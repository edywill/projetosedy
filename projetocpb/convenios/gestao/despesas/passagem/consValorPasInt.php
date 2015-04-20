<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$trecho=$_GET['valor'];
$trecho=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $trecho ) );
if($trecho<>''){
$sql = "SELECT id,valor,abrg FROM convpasintreferencia WHERE upper(trecho) like '".mb_strtoupper($trecho)."'";
$resultado = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo trim($resultado['valor'])."-".trim($resultado['abrg'])."-".trim($resultado['id']);
		}
}
?>