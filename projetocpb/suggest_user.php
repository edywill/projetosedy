<?php
require "conectsqlserverci.php";
include "mb.php";
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', strtoupper($_GET["q"]) ) );
$q = explode(" ",$q);
  $count=sizeof($q);
  $sql='';
  $i=1;
  if($count==1){
	  $sql="((Nome_completo LIKE '".$q[0]."%') OR (Cd_empresa LIKE '".$q[0]."%'))";
	  }else{
		  $sql="((Cd_empresa LIKE '".$q[0]."%') OR (Nome_completo LIKE '".$q[0]."%')";  
		  while($i<$count){
			  $sql.=" AND (Nome_completo LIKE '%".$q[$i]."%')";
			  $i++;
			  }
			  $sql.=")";
		  }
$SQLCiItensV="select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where ".$sql."
and ativo = 1 AND divisao<>'20'
";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['Cd_empresa'])."-".trim($row['Nome_completo']);
            echo $cname."\n";
            }


