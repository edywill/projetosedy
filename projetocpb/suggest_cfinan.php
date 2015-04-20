<?php
require "conectsqlserverci.php";
include "mb.php";
$q = strtolower($_GET["q"]);
  
$SQLCiItensV="select *
			  from GFCONTA (nolock) 
			  where Descricao LIKE '%".$q."%' AND 
			  ativo = 1 AND
			  tipo_conta = 'A'
";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Cd_conta'])."-".trim($row['Descricao']);
            echo $cname."\n";
            }


