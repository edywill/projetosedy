<?php
session_start();
require "../conectsqlserverci.php";
include "../mb.php";
require "../conect.php";
$q =preg_replace('/[^[:alpha:]_]/', '',addslashes(strtolower($_GET["q"])));
$q=addslashes(strtolower($_GET["q"]));
//$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $q ) );
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
$SQLCiItensV="SELECT Cd_material,Descricao,Cd_reduzido
FROM ESMATERI (nolock) 
WHERE 
((".$multq.") 
OR (Cd_reduzido LIKE '%".$q."%')) 
AND (tipo <> 'I' AND
	 tipo <> 'O' AND 
	 Cd_grupo<> '800' AND
	 dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 0 OR 
	 dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 1)
";
		$rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
		 $sqlRegistros=mysql_query("SELECT id,cdmat FROM aquimat WHERE cdmat='".$row['Cd_reduzido']."' AND idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
            $arrayRegistros=mysql_fetch_array($sqlRegistros);
			if(!empty($arrayRegistros)){
			//$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = $arrayRegistros['id']."-".trim($row['Cd_reduzido'])."-".trim(utf8_encode($row['Descricao']));
            echo $cname."\n";
			}
			}


