<?php
require "conectsqlserverci.php";
include "mb.php";
$q = strtolower($_GET["q"]);
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
  
$SQLCiItensV="select cg.Pcc_classific_c, cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where (cg.Pcc_nome_conta LIKE '%".$q."%' OR cg.Pcc_classific_c LIKE '%".$q."%')
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo <> 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Pcc_classific_c'])."-".trim($row['Pcc_nome_conta']);
            echo $cname."\n";
            }


