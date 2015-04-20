<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$cidade=$_GET['valor'];
$cidade=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $cidade ) );
if($cidade<>""){
$sqls = "SELECT id,vljant,vlalm,vlamb,abrg FROM convalireferencia WHERE upper(local) like '".mb_strtoupper($cidade)."'";
$resultados = mysql_query($sqls) or die(mysql_error());
$resultados=mysql_fetch_array($resultados);		
		if (!empty($resultados)){	
			echo trim($resultados['vljant'])."-".trim($resultados['vlalm'])."-".trim($resultados['vlamb'])."-".trim($resultados['abrg'])."-".trim($resultados['id']);
		//echo $cidade;
		}
}
?>