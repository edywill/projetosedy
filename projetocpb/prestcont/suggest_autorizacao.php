<?php
require "conectsqlserverci.php";
require "../conexaomysql.php";
include "mb.php";
$q = strtolower($_GET["q"]);
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
$SQLCiItensV="select projeto, assunto
from GMPROCDOC (nolock) 
where (projeto LIKE '".$q."%' OR assunto LIKE '".$q."%')";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            $sqlMySql=mysql_query("SELECT projeto FROM registros WHERE projeto='".$row['projeto']."' AND bdpass=0");
			$countMySql=mysql_num_rows($sqlMySql);
			if($countMySql>0){
			//$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim(utf8_encode($row['projeto']))."-".trim(utf8_encode($row['assunto']));
            echo $cname."\n";
			   }
			}


