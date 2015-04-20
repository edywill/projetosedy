<?php
session_start();
require "../conect.php";
//include "../mb.php";
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', strtoupper($_GET["q"]) ) );
$q = explode(" ",$q);
  $count=sizeof($q);
  $sql='';
  $i=1;
  $tabela='municipios';
  $campo='id,municipio,uf ';
  $campo2='municipio';
  $showUf='';
  if($_SESSION['abrangenciaSav']=='Internacional'){
		$tabela='paises';
  		$campo='iso,nome,iso3 ';
		$campo2='nome';
	  }
  if($count==1){
	  $sql="((".$campo2." LIKE '%".$q[0]."%'))";
	  }else{
		  $sql="((".$campo2." LIKE '%".$q[0]."%')";  
		  while($i<$count){
			  $sql.=" AND (".$campo2." LIKE '%".$q[$i]."%')";
			  $i++;
			  }
			  $sql.=")";
		  }
$SQLCiItensV = "SELECT ".$campo." FROM ".$tabela." where ".$sql."";
    $rs = mysql_query($SQLCiItensV) or die(mysql_error());
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = mysql_fetch_array($rs) )
    {
            if($tabela<>'paises'){
				$showUf="(".trim(utf8_encode($row['uf'])).")";
				$cname = trim($row['id'])."-".trim(utf8_encode($row[$campo2])).$showUf;
				}else{
					$showUf="(".trim(utf8_encode($row['iso3'])).")";
					$cname = trim($row['iso'])."-".trim(utf8_encode($row[$campo2])).$showUf;
					}
			//$cname = $row['Cd_reduzido']." -".$row['Descricao'];
            echo $cname."\n";
			}


