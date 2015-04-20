<?php 
    include "../mb.php";
	require "../conectsqlserverciprod.php";
	
	 $tituloDoc="CI - Comunicação Interna";
	$sqlCi=mysql_fetch_array(mysql_query("SELECT cidoc.* FROM cidoc
	WHERE cidoc.iddoc='".$arrayDocumentoOnline['id']."'"));
	$numCi=$sqlCi['numci'];
$numeroCiImpressao=$numCi;
	  $_SESSION['pendAprov']=0;
	  $_SESSION['codValida']='';
	 $sqlDocumentoOnline=mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,cidoc.data,tipodoc.endereco FROM docdigital LEFT JOIN cidoc ON docdigital.id=cidoc.iddoc
	 INNER JOIN tipodoc ON tipodoc.id=docdigital.tipo WHERE cidoc.numci='".$numCi."'");
	 $arrayDocOnline=mysql_fetch_array($sqlDocumentoOnline);
	 		 $endereco=$arrayDocOnline['endereco'];
			  $_SESSION['codValida']=$arrayDocOnline['hash2'];

$sqlAcompImpressao=odbc_exec($conCab,"Select
  aprovado = Case When GEACOMP.Historico Like '%de 03%' Then 'ELABORAÇÃO DA CI'
    When GEACOMP.Historico Like '%de 17%para 05%' Or
    GEACOMP.Historico Like '%de 17%para 16%' Then 'APROVAÇÃO SUAFC'
    When GEACOMP.Historico Like '%de 13%para 05%' Or
    GEACOMP.Historico Like '%de 13%para 16%' Then 'APROVAÇÃO VICE PRESIDÊNCIA'
    When GEACOMP.Historico Like '%de 14%para 05%' Or
    GEACOMP.Historico Like '%de 14%para 16%' Then 'APROVAÇÃO DIR. EXECUTIVA'
    When GEACOMP.Historico Like '%de 15%para 05%' Or
    GEACOMP.Historico Like '%de 15%para 16%' Then 'APROVAÇÃO DIR. TÉCNICA'
    When GEACOMP.Historico Like '%de 18%para 05%' Or
    GEACOMP.Historico Like '%de 18%para 16%' Then
    'APROVAÇÃO DIR. DE COMUNICAÇÃO'
    When GEACOMP.Historico Like '%de 19%para 05%' Or
    GEACOMP.Historico Like '%de 19%para 16%' Then
    'APROVAÇÃO DIR. DE MARKETING'
    When GEACOMP.Historico Like '%de 16%para 05%' Or
    GEACOMP.Historico Like '%de 16%para EP%' Then 'APROVAÇÃO CONVÊNIO'
    When GEACOMP.Historico Like '%de 05%para EP%' Or
    GEACOMP.Historico Like '%de 05%para 16%' Then 'APROVAÇÃO ORÇAMENTO'
    When GEACOMP.Historico Like '%para AP%' Then 'APROVAÇÃO PRESIDÊNCIA' Else '0'
  End,
  GEACOMP.Data As Data1,
  GEACOMP.Hora As Hora1,
  GEUSUARI.Nome
From
  GEACOMP With(NoLock) Left Join
  GEUSUARI On GEUSUARI.Cd_usuario = GEACOMP.Usuario
Where
  GEACOMP.Campo39 = 1 And
  GEACOMP.Campo40 = 1 And
  GEACOMP.Sequencia_item = 0 And
  LTrim(RTrim(GEACOMP.Embarque_pedido)) = '".$numeroCiImpressao."'
Order By
  Data1,
  Hora1");
		echo "</table><br><br>";
		    $counCompImp=odbc_num_rows($sqlAcompImpressao);
			if($counCompImp>0){
			$tabelaDados='<table border="0" width="100%">';
			 $countImpressao=0;
			 $statusAcomp[]='';
			 $usuarioAcomp[]='';
			 $dataAcomp[]='';
			 $horaAcomp[]='';
		while($objImpAcomp=odbc_fetch_object($sqlAcompImpressao)){		  
		$statusAcomp[$countImpressao]=$objImpAcomp->aprovado;
	    $dataAcomp[$countImpressao]=$objImpAcomp->Data1;
		$horaAcomp[$countImpressao]=$objImpAcomp->Hora1;
		$usuarioAcomp[$countImpressao]=utf8_decode($objImpAcomp->Nome);
		for($i=0;$i<$countImpressao;$i++){
			if($statusAcomp[$countImpressao]==$statusAcomp[$i]){
				$statusAcomp[$i]='R';
				unset($horaAcomp[$i]);
				unset($dataAcomp[$i]);
				unset($usuarioAcomp[$i]);
				}
			}
		$countImpressao++;
		}
		$countDadosCi=0;
		for($j=0;$j<$countImpressao;$j++){
			if($statusAcomp[$j]<>'R' && $statusAcomp[$j]<>"0"){
				$arrayHoraP=str_split(str_pad($horaAcomp[$j], 6, "0", STR_PAD_LEFT),2);
		  $horaDataP=$arrayHoraP[0].':'.$arrayHoraP[1].":".$arrayHoraP[2];

$tabelaDados.="<tr><td height='25'><font size='-2'><strong>".$usuarioAcomp[$j]."</strong></font></td><td height='25'><font size='-2'>".$statusAcomp[$j]."</font></td><td><font size='-2'>Em <u>".date("d/m/Y", strtotime($dataAcomp[$i]))." &aacute;s ".$horaDataP."</u></font></td></tr>";
				$countDadosCi++;
				}
			}
		$tabelaDados.="</table>";
			}else{
				$_SESSION['pendAprov']=2;
				}
	 if($countDadosCi==0){
		 $_SESSION['pendAprov']=2;
		 }
$idDoc2=$numCi;

?>