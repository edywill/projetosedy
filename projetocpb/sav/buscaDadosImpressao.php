<?php 
	$funcionario='X';
	$dirigente='';
	$sqlSavImpressao=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'"));
	$sqlSuperIntendente=mysql_query("SELECT nome,dtalt,tipo FROM savdirex");
	$superintendente='';
	$presidente='';
	while($objValorSuper=mysql_fetch_object($sqlSuperIntendente)){
	$arrayVigencia=explode("/",$objValorSuper->dtalt);
	$arrayDtIda=explode("/",$sqlSavImpressao['dtida']);
	if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) >= strtotime($arrayVigencia[2]."-".$arrayVigencia[1]."-".$arrayVigencia[0])){
		if($objValorSuper->tipo=='1'){
		$superintendente=utf8_encode($objValorSuper->nome);
		}else{
			$presidente=utf8_encode($objValorSuper->nome);
			}
	  }
	}
	$sqlFunc="Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.DESCRICAO40 As SETORCOMPLETO,
  RHSETORES.DESCRICAO20 As SETORSIGLA,
  RHCARGOS.CARGO,
  RHCARGOS.DESCRICAO20 As NOMECARGO,
  RHPESSOAS.CPF,
  RHCONTRATOS.BANCOCREDOR,
  RHBANCOS.DESCRICAO40 As NOMEBANCO,
  RHBANCOS.AGENCIA,
  RHBANCOS.NROBANCO,
  RHCONTRATOS.CONTACORRENTE
From
  RHPESSOAS (nolock) Inner Join
  RHCONTRATOS (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO left Join
  RHBANCOS (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$sqlSavImpressao['funcionario']."'
AND RHPESSOAS.EMPRESA='0001'";
  $dadosFuncionario=odbc_fetch_array(odbc_exec($conCab,$sqlFunc));
  //Consulta Tabela de Cargos da SAV e verifica se o cargo em questão pertence a classe I ou II
  $consultaClasse=mysql_fetch_array(mysql_query("SELECT classe FROM savcargos WHERE id='".$dadosFuncionario['CARGO']."'"));
  if($consultaClasse['classe']<3){
	  $funcionario='';
	  $dirigente='X';
	}
	  $_SESSION['nomeFuncSav']=$dadosFuncionario['NOME'];
	  $_SESSION['idCargo']=$dadosFuncionario['CARGO'];
  	  $_SESSION['cpfSav']=mask($dadosFuncionario['CPF'],"###.###.###-##");
	  $_SESSION['setorSav']=$dadosFuncionario['SETORCOMPLETO']."/".$dadosFuncionario['SETORSIGLA'];
	  $_SESSION['cargoSav']=$dadosFuncionario['NOMECARGO'];
	  $_SESSION['bancoSav']=$dadosFuncionario['NROBANCO']."-".$dadosFuncionario['NOMEBANCO'];
	  $_SESSION['agenciaSav']=$dadosFuncionario['AGENCIA'];
	  $_SESSION['contCorrenteSav']=$dadosFuncionario['CONTACORRENTE'];
	  $assinadoSuper='Pendente de Aprovação';
	  $assinadoPresi='Pendente de Aprovação';
	  $_SESSION['pendAprov']=2;
	  $_SESSION['codValida']='';
	 $numCi=$sqlSavImpressao['numci'];
	 
	 $sqlDocumentoOnline=mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,savdoc.aprov,savdoc.data FROM docdigital LEFT JOIN savdoc ON docdigital.id=savdoc.iddoc WHERE savdoc.numsav='".$numSav."'");
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
			 $sqlDocumentoOnlineUp=mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,savdoc.aprov,savdoc.data FROM docdigital LEFT JOIN savdoc ON docdigital.id=savdoc.iddoc WHERE savdoc.numsav='".$numSav."'");
	 while($objDocOnline=mysql_fetch_object($sqlDocumentoOnlineUp)){
		 if(empty($idDoc)){
		 $idDoc=$objDocOnline->id;
		 $_SESSION['codValida']=$objDocOnline->hash2;
		 }
		 if($objDocOnline->aprov=='17'){
			 $aprovGestor='X';
			 $countAprov++;
			 }
		 if($objDocOnline->aprov=='05'){
			 $aprovSuper='X';
			 $countAprov++;
			 }
		 if($objDocOnline->aprov=='AP'){
			 $aprovPresi='X';
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
		if($aprovSuper=='X' || $aprovPresi=='X'){
			$assinadoSuper="Assinado Eletronicamente";
			}
			if($aprovPresi=='X'){
		     $assinadoPresi="Assinado Eletronicamente";
			}
			if($countAprov>2){
			$_SESSION['pendAprov']=0;	
				};
?>