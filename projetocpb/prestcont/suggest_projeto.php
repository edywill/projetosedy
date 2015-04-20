<?php
require "conectsqlserverci.php";
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
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['projeto'])."-".trim($row['assunto']);
            echo $cname."\n";
            }


