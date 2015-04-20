<?php
require "conectsqlserverci.php";
include "mb.php";
$q = strtolower($_GET["q"]);
  
$SQLCiItensV="select Cd_portador,Nome
			  from GFPORTAD (nolock) 
			  where Nome LIKE '%".$q."%' OR Cd_portador LIKE '%".$q."%'  AND 
			  ativo = 1
";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Cd_portador'])."-".trim($row['Nome']);
            echo $cname."\n";
            }


