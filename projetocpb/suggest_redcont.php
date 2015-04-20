<?php
require "conectsqlserverci.php";
include "mb.php";
$q = strtolower($_GET["q"]);
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
  
$SQLCiItensV="
SELECT pcc_nome_conta,
       cd_pcc_reduzid
FROM CCPCC (nolock)
where pcc_classific_c between '1' and '6Ž'    
and pcc_tipo = 'A'
and livre_alfa_18 between 'S' and 'Sim'
and (pcc_nome_conta LIKE '%".$q."%' OR cd_pcc_reduzid LIKE '%".$q."%')
order by pcc_classific_c,
         pcc_nome_conta,
         cd_pcc_reduzid";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['cd_pcc_reduzid'])."-".trim($row['pcc_nome_conta']);
            echo $cname."\n";
            }


