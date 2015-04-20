<?php 
session_start();
$_SESSION['teste']='Teste';
require "conexaobd/conectbd.php";


$sql = "SELECT nome,
			        tipo_aviso2.tipo AS tipo_aviso2_resumo, 
					tipo_aviso1.tipo AS tipo_aviso1_resumo, 
					info.*,
					info.id AS idinfo,
					tipo_aviso3.tipo AS tipo_aviso3_resumo,
        			tipo_aviso6.resumo AS tipo_aviso6_resumo,
					tipo_aviso5.tipo AS tipo_aviso5_resumo
        FROM (((((info LEFT JOIN email ON
        info.cod = email.cod) LEFT JOIN tipo_aviso1 ON
        info.a1 = tipo_aviso1.id_tipo1) LEFT JOIN tipo_aviso1 tipo_aviso2 ON
        info.a2 = tipo_aviso2.id_tipo1) LEFT JOIN tipo_aviso1 tipo_aviso3 ON
        info.a3 = tipo_aviso3.id_tipo1) LEFT JOIN tipo_aviso1 tipo_aviso5 ON
        info.a5 = tipo_aviso5.id_tipo1) LEFT JOIN tipo_aviso1 tipo_aviso6 ON
        info.a6 = tipo_aviso6.id_tipo1";
   			$query = odbc_exec($conCab,$sql) or die("<p>".odbc_errormsg());
			$count=0;
			while ($resultado = odbc_fetch_object($query)){
			$count++;
			}
			echo $count;
			echo $_SESSION['teste'];
?>