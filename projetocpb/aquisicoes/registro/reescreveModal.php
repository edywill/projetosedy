<?php
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$sqlMaterial2=mysql_query("
SELECT aquipedidoitem.qtd,
aquimat.vlunit,
aquireg.cdempres,
aquiordem.data,
aquiordem.idos,
aquiordem.ano,
aquiordem.id 
FROM aquipedidoitem 
LEFT JOIN aquimat ON aquipedidoitem.idmat=aquimat.id
LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquiordem ON aquipedidoitem.idos=aquiordem.idos
LEFT JOIN aquireg ON aquiordem.idreg=aquireg.id
WHERE aquimat.id='".$_GET['idmat']."' ") or die(mysql_error());
$sqlMatNome=mysql_fetch_array(mysql_query("SELECT 
aquicadmat.nome
FROM aquicadmat LEFT JOIN aquimat ON aquimat.cdmat=aquicadmat.id
WHERE aquimat.id='".$_GET['idmat']."'"));
//$arrayMat=mysql_fetch_array($sqlMaterial2);
$countRegistros=mysql_num_rows($sqlMaterial2);
echo "<h2 align='center' style='line-height:50%;'>Ordens de Compra</h2>";
echo "<table border='1' width='100%' style=\"border-collapse:collapse; border:inherit; font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif\">
<tr style='border:3px solid #AAA7A7;' bgcolor='#C9C6C6'><th style='border:3px solid #AAA7A7;'><font color='#FFFFFF'>Material</font></th><th style='border:3px solid #AAA7A7;'><font color='#FFFFFF'>Ordem</font></th><th style='border:3px solid #AAA7A7;'><font color='#FFFFFF'>Quant.</font></th><th style='border:3px solid #AAA7A7;'><font color='#FFFFFF'>Valor(R$)</font></th><th style='border:3px solid #AAA7A7;'><font color='#FFFFFF'>Visualizar</font></th></tr>";
echo "<tr><td width='40%' rowspan='".$countRegistros."' style='border:3px solid #AAA7A7;' align='center'>".utf8_encode($sqlMatNome['nome'])."</td>";
$countMat=0;
while($objMat=mysql_fetch_object($sqlMaterial2)){
	$totalSolicitado='';
	$totalSolicitado=$objMat->qtd*str_replace(",",".",str_replace(".","",$objMat->vlunit));
	if($countMat>0){
		echo "<tr>";
		}
	echo "<td width='15%' align='center' style='border:3px solid #AAA7A7;'><strong>".$objMat->idos."/".$objMat->ano."</strong></td><td width='10%' align='center' style='border:3px solid #AAA7A7;'>".$objMat->qtd."</td><td width='20%' style='border:3px solid #AAA7A7;' align='right'>".number_format($totalSolicitado,2,",",".")."</td><td width='15%' style='border:3px solid #AAA7A7;' align='center'><a href='../ordem/geraPdfOs.php?id=".$objMat->idos."' target='_blank'><img src='../impressora.jpg' width='30px' height='30px' BORDER='0' alt='Visualizar Ordem' title='Visualizar Ordem'/></a></td></tr>";
	$countMat++;
	}
?>