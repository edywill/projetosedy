<?php 
require("valida.php");
$_SESSION['protocoloSession']='';
$_SESSION['idUserSession']='';
$_SESSION['mensagemSession']='';
$_SESSION['mensagemAcSession']='';
$_SESSION['anonimoSession']='';
$perfil=odbc_fetch_array(odbc_exec($conCab,"SELECT perfil,nome,estado FROM login WHERE id_login='".$_SESSION['usuarioID']."'"));
$_SESSION['perfilSession']=$perfil['perfil'];
$_SESSION['estadoSession']=$perfil['estado'];

$tabela[]='';
			if($_SESSION['estadoSession']=='28' || $_SESSION['estadoSession']=='29'){
			$sqlGeral="SELECT device_id FROM report WHERE protocolo IS NULL GROUP BY device_id";
			}else{
				$sqlGeral="SELECT device_id FROM report WHERE protocolo IS NULL
				AND estado_id='".$_SESSION['estadoSession']."' GROUP BY device_id";
				}
			$queryGeral = odbc_exec($conCab,$sqlGeral) or die("<p>".odbc_errormsg());
			$count=0;
			$estadoPredominante1='N/D';
			while ($resultadoGeral = odbc_fetch_object($queryGeral)){
				$sqlDevice=odbc_fetch_array(odbc_exec($conCab,"SELECT * FROM device WHERE id='".$resultadoGeral->device_id."'"));
				$nome='Indefinido';
				if(!empty($sqlDevice)){
					$nome=$sqlDevice['name'];
					}
				$sqlReports=odbc_exec($conCab,"SELECT report.datetime_2,(SELECT sigla FROM estado WHERE id=report.estado_id) AS sigla FROM report WHERE report.protocolo IS NULL AND report.device_id='".$resultadoGeral->device_id."'");
				$dataPrimOcorr='';
				$latLong='';
				$countReports=0;
				while($objReports=odbc_fetch_object($sqlReports)){
					$countReports++;
					if(!empty($dataPrimOcorr)){
						$arrayDataHoraAnt=explode(" ",$dataPrimOcorr);
						$arrayDataHoraNova=explode(" ",$objReports->datetime_2);
						$arrayDataAnt=explode("/",$arrayDataHoraAnt[0]);
						$arrayDataNova=explode("/",$arrayDataHoraNova[0]);
					if(strtotime($arrayDataAnt[2]."-".$arrayDataAnt[1]."-".$arrayDataAnt[0])>strtotime($arrayDataNova[2]."-".$arrayDataNova[1]."-".$arrayDataNova[0])){
					  $dataPrimOcorr=$objReports->datetime_2;
					  }
					 }else{
						 $dataPrimOcorr=$objReports->datetime_2;
						 }
						$estadoPredominante1=$objReports->sigla;
					}
					if(empty($dataPrimOcorr)){
						$dataPrimOcorr='N/D';
						}
					if(empty($estadoPredominante1)){
						$estadoPredominante1='N/D';
						}
				if($resultadoGeral->device_id>0){
					if($countReports>0){
				$tabela[$count]="<tr><td>Novo</td><td>".utf8_encode($nome)."</td><td align='center'>".$estadoPredominante1."</td><td align='center'>".$countReports."</td><td>".$dataPrimOcorr."</td><td>Não Direcionado</td><td align='center'>Novo</td><td><form name='detalhar' action='analiseOcorr.php' method='POST'><input type='hidden' name='idUser' value='".$resultadoGeral->device_id."'/><input type='submit' name='analisar' value='Analisar'/></form></td></tr>";
			$count++;
					}
				}else{
					if($countReports>0){
				$tabela[$count]="<tr><td>Novo</td><td>".utf8_encode($nome)."</td><td align='center'>".$estadoPredominante1."</td><td align='center'>".$countReports."</td><td>".$dataPrimOcorr."</td><td>Não Direcionado</td><td align='center'>Novo</td><td>N/D</td></tr>";
			$count++;
					}
					}
			}
			
			
			$sql = "SELECT protocolo.id AS idprot,protocolo.device_id,protocolo.dt_criacao,protocolo.status_id, login.nome AS analista,tipostatus.descricao FROM protocolo LEFT JOIN login ON protocolo.id_analista=login.id_login LEFT JOIN tipostatus ON protocolo.status_id=tipostatus.id WHERE protocolo.status_id<>7 ORDER BY protocolo.status_id";
   			$query = odbc_exec($conCab,$sql) or die("<p>".odbc_errormsg());
			$estadoPredominante='N/D';
			echo "<tbody>";
			while ($resultado = odbc_fetch_object($query)){
				$sqlDevice2=odbc_fetch_array(odbc_exec($conCab,"SELECT * FROM device WHERE id='".$resultado->device_id."'"));
				$nome2='Indefinido';
				if(!empty($sqlDevice2)){
					$nome2=$sqlDevice2['name'];
					}
				$countReportsProt=0;
				$dataPrimOcorrProt='';
				
				if($_SESSION['estadoSession']=='28' || $_SESSION['estadoSession']=='29'){
				$sqlReportsProt=odbc_exec($conCab,"SELECT datetime_2,(SELECT sigla FROM estado WHERE id=report.estado_id) AS sigla FROM report WHERE protocolo='".$resultado->idprot."' AND device_id='".$resultado->device_id."'");
				}else{
					$sqlReportsProt=odbc_exec($conCab,"SELECT datetime_2,(SELECT sigla FROM estado WHERE id=report.estado_id) AS nome FROM report WHERE protocolo='".$resultado->idprot."' AND device_id='".$resultado->device_id."' AND estado_id='".$_SESSION['estadoSession']."'");
					}
				while($objReportsProt=odbc_fetch_object($sqlReportsProt)){
					$countReportsProt++;
					if(!empty($dataPrimOcorrProt)){
						$arrayDataHoraAntProt=explode(" ",$dataPrimOcorrProt);
						$arrayDataHoraNovaProt=explode(" ",$objReportsProt->datetime_2);
						$arrayDataAntProt=explode("/",$arrayDataHoraAntProt[0]);
						$arrayDataNovaProt=explode("/",$arrayDataHoraNovaProt[0]);
					if(strtotime($arrayDataAntProt[2]."-".$arrayDataAntProt[1]."-".$arrayDataAntProt[0])>strtotime($arrayDataNovaProt[2]."-".$arrayDataNovaProt[1]."-".$arrayDataNovaProt[0])){
					  $dataPrimOcorrProt=$objReportsProt->datetime_2;
					  }
					 }else{
						 $dataPrimOcorrProt=$objReportsProt->datetime_2;
						 }
						 $estadoPredominante=$objReportsProt->sigla;
					}
					if(empty($dataPrimOcorrProt)){
						$dataPrimOcorrProt='Criacao Protocolo<br>'.$resultado->dt_criacao;
						}
						if(empty($estadoPredominante)){
						$estadoPredominante='N/D';
						}
				if($countReportsProt>0){
				$tabela[$count]="<tr><td>".$resultado->idprot."</td><td>".utf8_encode($nome2)."</td><td>".utf8_encode($estadoPredominante)."</td><td>".$countReportsProt."</td><td>".$dataPrimOcorrProt."</td><td>".utf8_encode($resultado->analista)."</td><td>".utf8_encode($resultado->descricao)."</td><td><form name='detalharProt' action='analiseOcorr.php' method='POST'><input type='hidden' name='idProt' value='".$resultado->idprot."'/><input type='submit' name='analisarProt' value='Analisar'/></form></td></tr>";
			$count++;
				}
			}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" type="text/css" href="datatables/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="datatables/dataTables.jqueryui.css">
<link rel="stylesheet" href="colorbox.css" />
<script type="text/javascript" language="javascript" src="datatables/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/dataTables.jqueryui.js"></script>
<script src="jscolorb.js"></script>
<script>
			$(document).ready(function(){
				$(".iframe").colorbox({iframe:true, width:700, height:550});
				
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 4, "asc" ]],
		"pagingType": "full_numbers"
    } );
} );

	</script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td></td>
<td colspan="2" width="1024px" align="center"></td><td></td>
</tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/topo_brasil.png" center top/></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><a href="principal.php" style="border:hidden"><img src="imagens/topo_dnit.png" center top/></a></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" valign="middle" align="center" style="background:url(imagens/topoceu.png) no-repeat center top">
<table border="0" cellpadding="0" cellspacing="0" width="1105px"><tr><td width="3%"></td>
<td height='130' colspan="2" align="left">
<h3><font color="#000066" style="padding-left:5em">Bem vindo <?php 
$arrayNome=explode(" ",$perfil['nome']);
if(count($arrayNome)>1){
	$_SESSION['nomeUserSession']=$arrayNome[0]." ".$arrayNome[1];
}else{
	$_SESSION['nomeUserSession']=$arrayNome[0];
	}
	echo $_SESSION['nomeUserSession'];
?></font></h3>
</td><td width="30%"></td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center" style="">

<table border="0" cellpadding="0" cellspacing="0" width="1104px" height="500">
<tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<?php 
include "menu.php";
?>
</td></tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top" align="center">
    <td height="34" valign="top" align="center">
<table id="example" width="100%" cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
  <thead>
  <tr><td colspan="11" align="right"><font size="+3" color="#000066"><strong>PAINEL DE REGISTROS</strong></font></tr>
			<tr bgcolor="#FFFFFF">	
            		<th width='8%'>Protocolo</th>
                    <th width='20%'>Usuário</th>
                    <th width='8%' height="21">UF Princ.</th>				
					<th width='8%' height="21">Qtd. Ocorr.</th>
					<th width='13%'>Prim. Ocor.</th>
                    <th width='13%'>Analista</th>
                    <th width='13%'>Status</th>
                    <th width='10%'>Analisar</th>  
				</tr>				
			</thead>
            <?php
			echo "<tbody>";
			for($j=0;$j<count($tabela);$j++){
				echo $tabela[$j];
				}
			?>
            </tbody>
            </table>
            <table border="0" width="100%">
            <tr bgcolor="#FBF7F7">
            <td colspan="2" align="left">          
           
           
            <a href="#" onclick="window.open('faq.php?id=0', 'FAQ DNIT Móvel', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=870, HEIGHT=700');"><strong>FAQ</strong></a>
            </td>
              <td colspan="9" align="right"><a href='finalizados.php'><strong>PROTOCOLOS FINALIZADOS</strong></a></td></tr>
              <tr><td colspan="11" align="right" height="10px"></tr>
              <tr bgcolor="#E7E5E5"><td colspan="11" align="right"><font size="+3" color="#000066"><strong>MAPA DE OCORRÊNCIAS</strong></font></tr>
              <td colspan="11" align="left">          
              <iframe width="940" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://dnit-v-esri.intranet/portaldnitgeo/apps/OnePane/basicviewer/embed.html?webmap=7ad00fa080194e67a320a2c323fd8d03&amp;gcsextent=-81.771,-31.5848,-16.8638,3.9008&amp;displayslider=true&amp;displayscalebar=true&amp;displaylegend=true&amp;displaysearch=true&amp;searchextent=true&amp;displaybasemaps=true"></iframe>
               </td></tr>
              <tr bgcolor="#E7E5E5">
                <td colspan="11" align="center"><a href="http://dnit-v-esri.intranet/portaldnitgeo/home/webmap/viewer.html?webmap=7ad00fa080194e67a320a2c323fd8d03&amp;extent=-81.771,-31.5848,-16.8638,3.9008" style="color:#0000FF;text-align:left" target="_blank"><strong>AMPLIAR MAPA</strong></a></tr>
              </table>
            </td></tr></table>
</td></tr>
<tr>
<td colspan="3" align="left" height="150px" style="background:url(imagens/rodapecentro.png) no-repeat">
</td></tr>
</table>
</td><td></td></tr>

</table>
<?php 
?>
</body>
</html>