<?php 
require("valida.php");
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
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
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
<tr"><td></td><td colspan="2" width="1024px" align="center"><a href="principal.php" style="border:hidden"><img src="imagens/topo_dnit.png" center top/></a></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" valign="middle" align="center" style="background:url(imagens/topoceu.png) no-repeat center top">
<table border="0" cellpadding="0" cellspacing="0" width="1105px"><tr><td width="3%"></td>
<td height='130' colspan="2" align="left">
<h3><font color="#000066" style="padding-left:5em">Bem vindo 
<?php 
echo strtoupper($_SESSION['usuario']);
?></font></h3>
</td><td width="30%"></td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center" style="">

<table border="0" cellpadding="0" cellspacing="0" width="1104px" height="500">
<tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">

<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top">
    <td height="34" valign="bottom">
    <a href="principal.php" style="border:hidden"> <img src="imagens/butpainel.png" /></a></td>
    <td valign="bottom"><a href="usuarios.php" style="border:hidden"> <img src="imagens/butusuarios.png" /></a></td>
    <td valign="bottom"><a href="ouvidoria.php" style="border:hidden"> <img src="imagens/butouv.png" /></a></td>
    <td valign="bottom"><a href="relatorios.php" style="border:hidden"> <img src="imagens/butrel.png" /></a></td>
    <td valign="bottom"><a href="logout.php" style="border:hidden"> <img src="imagens/butsair.png" /></a></td>
  </tr>
</table>

</td></tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top" align="center">
    <td height="34" valign="top" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#CCCCCC" >
<tr valign="bottom"><td></td><td align="right" bgcolor="#CCCCCC"><font size="+3" color="#000066"><strong>RELATÓRIO</strong></font></td></tr>
<tr valign="top"><td></td><td align="center" bgcolor="">
<?php 
require_once("conexaobd/conectbd.php");

$sql = "SELECT dt FROM info";
$query = odbc_exec($conCab,$sql);
$countJan=0;
$countFev=0;
$countMar=0;
$countAbr=0;
$countMai=0;
$countJun=0;
$countJul=0;
$countAgo=0;
$countSet=0;
$countOut=0;
$countNov=0;
$countDez=0;

while ($resultado = odbc_fetch_object($query)){
$arrayData=explode("/",date("d/m/y",strtotime($resultado->dt)));
if($arrayData[1]==1){
	    $countJan++;
	  }elseif($arrayData[1]==2){
	    $countFev++;
	  }elseif($arrayData[1]==3){
	    $countMar++;
	  }elseif($arrayData[1]==4){
	    $countAbr++;
	  }elseif($arrayData[1]==5){
	    $countMai++;
	  }elseif($arrayData[1]==6){
	    $countJun++;
	  }elseif($arrayData[1]==7){
	    $countJul++;
	  }elseif($arrayData[1]==8){
	    $countAgo++;
	  }elseif($arrayData[1]==9){
	    $countSet++;
	  }elseif($arrayData[1]==10){
	    $countOut++;
	  }elseif($arrayData[1]==11){
	    $countNov++;
	  }elseif($arrayData[1]==12){
	    $countDez++;
	  } 
	}
	?>
<table border="1" width="100%"><tr align="center"><td colspan="6" bgcolor="#003366"><font size="+2" color="#ffffff"><strong>REGISTROS MENSAIS 2014</strong></font></td></tr>
<tr align="center" bgcolor="#003366"><td><font color="#FFFFFF">JANEIRO</font></td><td><font color="#FFFFFF">FEVEREIRO</font></td><td><font color="#FFFFFF">MARÇO</font></td><td><font color="#FFFFFF">ABRIL</font></td><td><font color="#FFFFFF">MAIO</font></td><td><font color="#FFFFFF">JUNHO</font></td></tr>
<tr align="center" bgcolor="#FFFFFF"><td><?php echo $countJan; ?></td><td><?php echo $countFev; ?></td><td><?php echo $countMar; ?></td><td><?php echo $countAbr; ?></td><td><?php echo $countMai; ?></td><td><?php echo $countJun; ?></td></tr>
<tr align="center" bgcolor="#003366"><td><font color="#FFFFFF">JULHO</font></td><td><font color="#FFFFFF">AGOSTO</font></td><td><font color="#FFFFFF">SETEMBRO</font></td><td><font color="#FFFFFF">OUTUBRO</font></td><td><font color="#FFFFFF">NOVEMBRO</font></td><td><font color="#FFFFFF">DEZEMBRO</td></tr>
<tr align="center" bgcolor="#FFFFFF"><td><?php echo $countJul; ?></td><td><?php echo $countAgo; ?></td><td><?php echo $countSet; ?></td><td><?php echo $countOut; ?></td><td><?php echo $countNov; ?></td><td><?php echo $countDez; ?></td></tr>
</td></tr>
</table>
</td></tr>
<tr valign="top"><td height="500"></td><td align="center">
<?php
echo "<iframe src='grafmes.php?jan=".$countJan."&fev=".$countFev."&mar=".$countMar."&abr=".$countAbr."&mai=".$countMai."&jun=".$countJun."&jul=".$countJul."&ago=".$countAgo."&set=".$countSet."&out=".$countOut."&nov=".$countNov."&dez=".$countDez."' width='862' height='500' style='border:hidden'></iframe>";
?>
</td></tr>
<tr valign="top"><td height="20"></td><td align="center">
</td></tr>
<tr valign="top"><td></td><td align="left" bgcolor="">
<?php 
require_once("conexaobd/conectbd.php");

$sql = "SELECT uf FROM info";
$query = odbc_exec($conCab,$sql);
$countAc=0;
$countAl=0;
$countAp=0;
$countAm=0;
$countBa=0;
$countCe=0;
$countDf=0;
$countEs=0;
$countGo=0;
$countMa=0;
$countMt=0;
$countMs=0;
$countMg=0;
$countPa=0;
$countPb=0;
$countPr=0;
$countPe=0;
$countPi=0;
$countRj=0;
$countRn=0;
$countRs=0;
$countRo=0;
$countRr=0;
$countSc=0;
$countSp=0;
$countSe=0;
$countTo=0;
$countIn=0;
$countGeral=0;
while ($resultado = odbc_fetch_object($query)){
$countGeral++;
if(strtoupper($resultado->uf)==strtoupper('ac')){
	    $countAc++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ac')){
	    $countAl++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ap')){
	    $countAp++;
		}elseif(strtoupper($resultado->uf)==strtoupper('am')){
	    $countAm++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ba')){
	    $countBa++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ce')){
	    $countCe++;
		}elseif(strtoupper($resultado->uf)==strtoupper('df')){
	    $countDf++;
		}elseif(strtoupper($resultado->uf)==strtoupper('es')){
	    $countEs++;
		}elseif(strtoupper($resultado->uf)==strtoupper('go')){
	    $countGo++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ma')){
	    $countMa++;
		}elseif(strtoupper($resultado->uf)==strtoupper('mt')){
	    $countMt++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ms')){
	    $countMs++;
		}elseif(strtoupper($resultado->uf)==strtoupper('mg')){
	    $countMg++;
		}elseif(strtoupper($resultado->uf)==strtoupper('pa')){
	    $countPa++;
		}elseif(strtoupper($resultado->uf)==strtoupper('pb')){
	    $countPb++;
		}elseif(strtoupper($resultado->uf)==strtoupper('pr')){
	    $countPr++;
		}elseif(strtoupper($resultado->uf)==strtoupper('pe')){
	    $countPe++;
		}elseif(strtoupper($resultado->uf)==strtoupper('pi')){
	    $countPi++;
		}elseif(strtoupper($resultado->uf)==strtoupper('rj')){
	    $countRj++;
		}elseif(strtoupper($resultado->uf)==strtoupper('rn')){
	    $countRn++;
		}elseif(strtoupper($resultado->uf)==strtoupper('rs')){
	    $countRs++;
		}elseif(strtoupper($resultado->uf)==strtoupper('ro')){
	    $countRo++;
		}elseif(strtoupper($resultado->uf)==strtoupper('rr')){
	    $countRr++;
		}elseif(strtoupper($resultado->uf)==strtoupper('sc')){
	    $countSc++;
		}elseif(strtoupper($resultado->uf)==strtoupper('sp')){
	    $countSp++;
		}elseif(strtoupper($resultado->uf)==strtoupper('se')){
	    $countSe++;
		}elseif(strtoupper($resultado->uf)==strtoupper('to')){
	    $countTo++;
		}else{
	    $countIn++;
		}
	}
	?>
<table border="1" width="100%"><tr align="center"><td colspan="14" bgcolor="#003366"><font size="+2" color="#ffffff"><strong>REGISTROS ESTADUAIS 2014</strong></font></td></tr>
<tr align="center"><td bgcolor="#003366" width='10%'><font color="#FFFFFF">ACRE</font></td><td bgcolor="#FFFFFF"><?php echo $countAc; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>ALAGOS</font></td><td bgcolor="#FFFFFF"><?php echo $countAl; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>AMAPÁ</font></td><td bgcolor="#FFFFFF"><?php echo $countAp; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>AMAZONAS</font></td><td bgcolor="#FFFFFF"><?php echo $countAm; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>BAHIA</font></td><td bgcolor="#FFFFFF"><?php echo $countBa; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>CEARÁ</font></td><td bgcolor="#FFFFFF"><?php echo $countCe; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>DISTRITO FEDERAL</font></td><td bgcolor="#FFFFFF"><?php echo $countDf; ?></td></tr>
<tr align="center"><td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>ESPIRITO SANTO</font></td><td bgcolor="#FFFFFF"><?php echo $countEs; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>GOIÁS</font></td><td bgcolor="#FFFFFF"><?php echo $countGo; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>MARANHÃO</font></td><td bgcolor="#FFFFFF"><?php echo $countMa; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>MATO GROSSO</font></td><td bgcolor="#FFFFFF"><?php echo $countMt; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>MATO GROSSO DO SUL</font></td><td bgcolor="#FFFFFF"><?php echo $countMs; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>MINAS GERAIS</font></td><td bgcolor="#FFFFFF"><?php echo $countMg; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>PARÁ</font></td><td bgcolor="#FFFFFF"><?php echo $countPa; ?></td></tr>
<tr align="center"><td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>PARAÍBA</font></td><td bgcolor="#FFFFFF"><?php echo $countPb; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>PARANÁ</font></td><td bgcolor="#FFFFFF"><?php echo $countPr; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>PERNAMBUCO</font></td><td bgcolor="#FFFFFF"><?php echo $countPe; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>PIAUÍ</font></td><td bgcolor="#FFFFFF"><?php echo $countPi; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>RIO DE JANEIRO</font></td><td bgcolor="#FFFFFF"><?php echo $countRj; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>RIO GRANDE DO NORTE</font></td><td bgcolor="#FFFFFF"><?php echo $countRn; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>RIO GRANDE DO SUL</font></td><td bgcolor="#FFFFFF"><?php echo $countRs; ?></td></tr>
<tr align="center"><td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>RONDÔNIA</font></td><td bgcolor="#FFFFFF"><?php echo $countRo; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>RORAIMA</font></td><td bgcolor="#FFFFFF"><?php echo $countRr; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>SANTA CATARINA</font></td><td bgcolor="#FFFFFF"><?php echo $countSc; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>SÃO PAULO</font></td><td bgcolor="#FFFFFF"><?php echo $countSp; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>SERGIPE</font></td><td bgcolor="#FFFFFF"><?php echo $countSe; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>TOCANTINS</font></td><td bgcolor="#FFFFFF"><?php echo $countTo; ?></td>
<td bgcolor="#003366" width='10%'><font color="#FFFFFF" size='-3'>INDEFINIDO</font></td><td bgcolor="#FFFFFF"><?php echo $countIn; ?></td></tr>
<tr bgcolor="#003366">
  <td align="right" colspan="11"><font color="#FFFFFF" size="+1"><strong>TOTAL</strong></font></td><td align="center" colspan="7"><font color="#FFFFFF"><?php echo $countIn; ?></font></td></tr>
</td></tr>
</table>
</td></tr>
<tr valign="top"><td height="500"></td><td align="center">
<?php
echo "<iframe src='grafuf.php?ac=".$countAc."&al=".$countAl."&ap=".$countAp."&am=".$countAm."&ba=".$countBa."&ce=".$countCe."&df=".$countDf."&es=".$countEs."&go=".$countGo."&ma=".$countMa."&mt=".$countMt."&ms=".$countMs."&mg=".$countMg."&pa=".$countPa."&pb=".$countPb."&pe=".$countPe."&pi=".$countPi."&pr=".$countPr."&rj=".$countRj."&rn=".$countRn."&rs=".$countRs."&ro=".$countRo."&rr=".$countRr."&sc=".$countSc."&sp=".$countSp."&se=".$countSe."&to=".$countTo."&in=".$countIn."' width='862' height='500' style='border:hidden'></iframe>";
?>
</td></tr>
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