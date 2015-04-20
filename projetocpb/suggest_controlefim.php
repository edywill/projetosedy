<?php
require "conectsqlserverci.php";
include "mb.php";
//$q =preg_replace('/[^[:alpha:]_]/', '',addslashes(strtolower($_GET["q"])));
$q=addslashes(strtolower($_GET["q"]));
$q=mb_convert_encoding($q,'UTF-8','ASCII');
$q=preg_replace( '/[`^~็ว\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
$q2=explode(" ",$q);
$countQ2=count($q2);
$cont=0;
$multq='';
foreach($q2 as $qmult){
	$cont++;
	if($cont==$countQ2){
	$multq.=" lower(Descricao) LIKE '%".$qmult."%'";
	}else{
		$multq.=" lower(Descricao) LIKE '%".$qmult."%' AND";
		}
	}
$SQLCiItensV="
SELECT Controle,
       Descricao
FROM COCSO (nolock)
where (".$multq.") 
OR (Controle LIKE '%".$q."%')
order by Controle";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Controle'])."-".trim($row['Descricao']);
            echo $cname."\n";
            }


