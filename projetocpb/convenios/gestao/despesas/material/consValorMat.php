<?php
require '../../../../conexaomysql.php';
require '../../../buscaCambio.php';
$moeda=$_GET['valor'];
if($moeda<>"" || $moeda<>"R$" || $moeda<>"Outros"){
	$resultado=pegaCotacao($moeda);
	if (!empty($resultado)){	
			echo trim($resultado['cotacao'])."-".trim($resultado['data'])."-".trim($resultado['hora']);
		}
}
?>