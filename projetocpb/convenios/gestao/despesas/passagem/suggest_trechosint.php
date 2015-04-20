<?php
require "../../../../conexaomysql.php";
//include "../../../mb.php";
$q = strtolower($_GET["q"]);
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
$SQLCiItensV="select trecho
from convpasintreferencia 
where lower(trecho) LIKE '%".$q."%'";
		$rs = mysql_query($SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = mysql_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = utf8_encode(trim($row['trecho']));
            echo $cname."\n";
            //echo $q."\n";
			}
			echo "teste";


