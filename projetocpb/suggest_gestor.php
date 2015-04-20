<?php
require "conectsqlserverci.php";
include "mb.php";
$q =strtolower($_GET["q"]);
$q=addslashes($q);
$q=mb_convert_encoding($q,'UTF-8','ASCII');
$q=preg_replace( '/[`^~\´\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
$q2=explode(" ",$q);
$countQ2=count($q2);
$cont=0;
$multq='';
foreach($q2 as $qmult){
	$cont++;
	if($cont==$countQ2){
	$multq.=" lower(Nome_completo) LIKE '%".$qmult."%'";
	}else{
		$multq.=" lower(Nome_completo) LIKE '%".$qmult."%' AND";
		}
	}
$SQLCiItensV="select Cd_empresa,Nome_completo
			  from GEEMPRES (nolock) 
			  where 
			  (".$multq.")
			  OR (Cd_empresa LIKE '".$q."')
			  AND ativo = 1 AND divisao<>'20'
			  ORDER BY Nome_completo";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($rs);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Cd_empresa'])."-".trim($row['Nome_completo']);
            echo $cname."\n";
            }


