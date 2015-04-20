<?php 
    require "../sav/conectsqlserversav.php";
	 include "../sav/funcoesGerais.php";
	 $tituloDoc="SAV - Solicitação de Auxílio Viagem";
	$sqlSav=mysql_fetch_array(mysql_query("SELECT savregistros.* FROM savdoc LEFT JOIN savregistros ON savdoc.numsav=savregistros.id WHERE savdoc.iddoc='".$arrayDocumentoOnline['id']."'"));
	$numSav=$sqlSav['id'];
	$funcionario='X';
	$dirigente='';
	$sqlSavImpressao=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'"));
	$numCi=$sqlSavImpressao['numci'];
	$sqlSuperIntendente=mysql_query("SELECT nome,dtalt,tipo FROM savdirex");
	$superintendente='';
	$presidente='';
	$gestor='';
	$sqlNomeGestor=odbc_fetch_array(odbc_exec($conCab2,"Select
  GEEMPRES.Nome_completo
From
  GEEMPRES
  WHERE Cd_empresa='".$sqlSavImpressao['gestor']."'"));
  $gestor=$sqlNomeGestor['Nome_completo'];
	while($objValorSuper=mysql_fetch_object($sqlSuperIntendente)){
	$arrayVigencia=explode("/",$objValorSuper->dtalt);
	$arrayDtIda=explode("/",$sqlSavImpressao['dtida']);
	
		if($objValorSuper->tipo=='1'){
		$superintendente=utf8_encode($objValorSuper->nome);
		}else{
			$presidente=utf8_encode($objValorSuper->nome);
			}
	  
	}
	  $_SESSION['pendAprov']=2;
	  $_SESSION['codValida']='';
	 $sqlDocumentoOnline=mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,savdoc.aprov,savdoc.data,tipodoc.endereco FROM docdigital LEFT JOIN savdoc ON docdigital.id=savdoc.iddoc
	 INNER JOIN tipodoc ON tipodoc.id=docdigital.tipo WHERE savdoc.numsav='".$numSav."'");
	 $countAprov=0;
	 $aprovGestor='';
	 $aprovSuper='';
	 $aprovPresi='';
	 $arrayDocOnline=mysql_fetch_array($sqlDocumentoOnline);
	 if(empty($arrayDocOnline)){
		 $hash=geraSenha(15);
		 $sqlMaxId=mysql_fetch_array(mysql_query("SELECT max(id) as maxid FROM docdigital"));
		 $idDoc=$sqlMaxId['maxid']+1;
		 $sqlCriaDoc=mysql_query("INSERT INTO docdigital VALUES ('".$idDoc."','".date("d/m/Y")."','".$hash."','1')") or die(mysql_error());
		 if(!$sqlCriaDoc){
			$hash=geraSenha(15);
			$sqlCriaDoc=mysql_query("INSERT INTO docdigital VALUES ('".$idDoc."','".date("d/m/Y")."','".$hash."','1')"); 
			 }
		$sqlDocSav=mysql_query("INSERT INTO savdoc VALUES ('".$idDoc."','".$numSav."','03','".date("d/m/Y - H:i:s")."')");
		 $_SESSION['codValida']=$hash;
		 }else{
			 $endereco=$arrayDocOnline['endereco'];
			 $sqlDocumentoOnlineUp=mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,savdoc.aprov,savdoc.data FROM docdigital LEFT JOIN savdoc ON docdigital.id=savdoc.iddoc WHERE savdoc.numsav='".$numSav."'");
	 while($objDocOnline=mysql_fetch_object($sqlDocumentoOnlineUp)){
		 if(empty($idDoc)){
		 $idDoc=$objDocOnline->id;
		 $_SESSION['codValida']=$objDocOnline->hash2;
		 }
		 if($objDocOnline->aprov=='17'){
			 $aprovGestor='X';
			 $dateGestor=$objDocOnline->data;
			 $countAprov++;
			 }
		 if($objDocOnline->aprov=='05'){
			 $aprovSuper='X';
			 $dateSuper=$objDocOnline->data;
			 $countAprov++;
			 }
		 if($objDocOnline->aprov=='AP'){
			 $aprovPresi='X';
			 $datePresi=$objDocOnline->data;
			 $countAprov++;
			 }
		 }
		}
if($countAprov<3){	   
	 $sqlConsultaDatasG=odbc_exec($conCab2,"Select
  GEACOMP.Data As Data1,
  GEACOMP.Hora As Hora1
From
  GEACOMP
Where
  GEACOMP.Campo39 = 1 And
  GEACOMP.Campo40 = 1 And
  GEACOMP.Sequencia_item = 0 And
  GEACOMP.Codigo_titulo = '' And
  GEACOMP.Historico Like '%para 17 -%' AND
  ltrim(rtrim(GEACOMP.Embarque_pedido))='".trim($numCi)."'") or die("<p>".odbc_errormsg());
	  $arrayConsultaDatasG=odbc_fetch_array($sqlConsultaDatasG);
	  if(!empty($arrayConsultaDatasG)){
		  $arrayHoraG=str_split(str_pad($arrayConsultaDatasG['Hora1'], 6, "0", STR_PAD_LEFT),2);
		  $horaDataG=$arrayHoraG[0].':'.$arrayHoraG[1].":".$arrayHoraG[2];
	  $dateGestor=date('d/m/Y',strtotime($arrayConsultaDatasG['Data1']))." - ".$horaDataG;
	  
	 if(empty($aprovGestor)){
			  $sqlDocSavG=mysql_query("INSERT INTO savdoc VALUES ('".$idDoc."','".$numSav."','17','".$dateGestor."')");
			  }
     $aprovGestor='X';
	 $countAprov=1;
    }
 $sqlConsultaDatasS=odbc_exec($conCab2,"Select
  GEACOMP.Data As Data1,
  GEACOMP.Hora As Hora1
From
  GEACOMP
Where
  GEACOMP.Campo39 = 1 And
  GEACOMP.Campo40 = 1 And
  GEACOMP.Sequencia_item = 0 And
  GEACOMP.Codigo_titulo = '' And
  GEACOMP.Historico Like '%para 05 -%' AND
  ltrim(rtrim(GEACOMP.Embarque_pedido))='".trim($numCi)."'") or die("<p>".odbc_errormsg());
	  $arrayConsultaDatasS=odbc_fetch_array($sqlConsultaDatasS);
	  if(!empty($arrayConsultaDatasS)){
		   $arrayHoraS=str_split(str_pad($arrayConsultaDatasS['Hora1'], 6, "0", STR_PAD_LEFT),2);
		  $horaDataS=$arrayHoraS[0].':'.$arrayHoraS[1].":".$arrayHoraS[2];
	  $dateSuper=date('d/m/Y',strtotime($arrayConsultaDatasS['Data1']))." - ".$horaDataS;
	  
	 if(empty($aprovSuper)){
			  $sqlDocSavS=mysql_query("INSERT INTO savdoc VALUES ('".$idDoc."','".$numSav."','05','".$dateSuper."')");
			  }
     $aprovSuper='X';
	 $countAprov=2;
    }
	$sqlConsultaDatasP=odbc_exec($conCab2,"Select
  GEACOMP.Data As Data1,
  GEACOMP.Hora As Hora1
From
  GEACOMP
Where
  GEACOMP.Campo39 = 1 And
  GEACOMP.Campo40 = 1 And
  GEACOMP.Sequencia_item = 0 And
  GEACOMP.Codigo_titulo = '' And
  GEACOMP.Historico Like '%para AP -%' AND
  ltrim(rtrim(GEACOMP.Embarque_pedido))='".trim($numCi)."'") or die("<p>".odbc_errormsg());
	  $arrayConsultaDatasP=odbc_fetch_array($sqlConsultaDatasP);
	  if(!empty($arrayConsultaDatasP)){
		   $arrayHoraP=str_split(str_pad($arrayConsultaDatasP['Hora1'], 6, "0", STR_PAD_LEFT),2);
		  $horaDataP=$arrayHoraP[0].':'.$arrayHoraP[1].":".$arrayHoraP[2];
	  $datePresi=date('d/m/Y',strtotime($arrayConsultaDatasP['Data1']))." - ".$horaDataP;
	  
	 if(empty($aprovPresi)){
			  $sqlDocSavP=mysql_query("INSERT INTO savdoc VALUES ('".$idDoc."','".$numSav."','AP','".$datePresi."')");
			  }
     $aprovPresi='X';
	 $countAprov=3;
    }
}
$tabelaDados='<table border="0" width="100%">';
if($aprovGestor=='X' || $aprovSuper=='X' || $aprovPresi=='X'){
		     $tabelaDados.="<tr height='25'>
    <td><font size='-2'><strong>".$gestor."</strong></font></td><td><font size='-2'>GESTOR</font></td><td><font size='-2'>Em <u>".$dateGestor."</u></font></td></tr>";
			}
		if($aprovSuper=='X' || $aprovPresi=='X'){
			$tabelaDados.="<tr height='25'>
    <td><font size='-2'><strong>".$superintendente."</strong></font></td><td><font size='-2'>SUPERINTENDENTE</font></td><td><font size='-2'>Em <u>".$dateSuper."</u></font></td></tr>";
			}
			if($aprovPresi=='X'){
		     $tabelaDados.="<tr height='25'>
    <td><font size='-2'><strong>".$presidente."</strong></font></td><td><font size='-2'>PRESIDENTE</font></td><td><font size='-2'>Em <u>".$datePresi."</u></font></td></tr>";
			}
			if($countAprov>2){
			$_SESSION['pendAprov']=0;	
				};
$tabelaDados.='</table>';
$idDoc2=$numSav;

?>