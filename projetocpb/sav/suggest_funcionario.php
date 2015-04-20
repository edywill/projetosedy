<?php
require "../conectsqlserver.php";
include "../mb.php";
$q=preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', strtoupper($_GET["q"]) ) );
$q = explode(" ",$q);
  $count=sizeof($q);
  $sql='';
  $i=1;
  if($count==1){
	  $sql="((RHPESSOAS.NOME LIKE '%".$q[0]."%') OR (RHPESSOAS.PESSOA LIKE '%".$q[0]."%'))";
	  }else{
		  $sql="((RHPESSOAS.PESSOA LIKE '%".$q[0]."%') OR (RHPESSOAS.NOME LIKE '%".$q[0]."%')";  
		  while($i<$count){
			  $sql.=" AND (RHPESSOAS.NOME LIKE '%".$q[$i]."%')";
			  $i++;
			  }
			  $sql.=")";
		  }
$SQLCiItensV = "Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA
From
  RHPESSOAS Inner Join
  RHCONTRATOS On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND ".$sql."";
    $rs = odbc_exec($conCab, $SQLCiItensV);
		//$numRegistros = odbc_num_rows($resCiItensV);
    while( $row = odbc_fetch_array($rs) )
    {
            //$cname = $row['Cd_reduzido']." -".$row['Descricao'];
			$cname = trim($row['PESSOA'])."-".trim($row['NOME']);
            echo $cname."\n";
			}


