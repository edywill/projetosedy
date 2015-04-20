<?php
require '../../../../conexaomysql.php';
//include "../../mb.php";

$cargo=$_GET['valor'];
$cargoExp=explode("-",$cargo);
if($cargoExp[0]<>"0"){
$sql = "SELECT salario FROM convrhreferencia WHERE id='".$cargoExp[0]."'";
$resultado = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo $resultado['salario'];
		}
}
?>