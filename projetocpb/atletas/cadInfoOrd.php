<?php 
session_start();
function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}
require "../conectsqlserverci.php";
require "../conect.php";
$userCriac=$_SESSION['userAquis'];
$idOrdem= $_SESSION['idRegOrdem'];
$documento=$_POST['doc'];
$faturaAnt="<b>COMITÊ PARAOLÍMPICO BRASILEIRO - CPB<br />
CNPJ n.º 00.700.114/0001-44<br />
Setor Bancário Norte, Quadra 02, Lote 12, Bloco “F”, 14º Andar<br />
Brasília-DF - Cep. 70.040-020</b>";
$fatura='';
if($_POST['fatura']<>$faturaAnt){
	$fatura=$_POST['fatura'];
	}
$descricao=$_POST['desc'];
$vlunit=$_POST['vlunit'];
$dtentrega=$_POST['dtentrega'];
$evento=$_POST['evento'];
$compAnterior="O pagamento será efetuado por meio de ordem bancária ou qualquer outro meio idôneo adotado pelo CPB, mediante a apresentação de Nota Fiscal / Fatura devidamente atestada (responsável pelo recebimento), no prazo de até <u>10 (dez) dias úteis a contar do seu recebimento</u>, devendo ser efetuada a retenção na fonte dos tributos e contribuições determinadas pelos órgãos fiscais e fazendários em conformidade com a legislação vigente, quando for o caso.";
$complemento='';
if($compAnterior<>$_POST['comp']){
	$complemento=$_POST['comp'];
}
$emissor=$_POST['emissor'];
$sqlQueryUpdateOrdem="UPDATE aquiordem SET doc='".utf8_decode($documento)."',fatura='".htmlentities(addslashes($fatura))."', descric='".htmlentities(addslashes($descricao))."', vlunit='".trim($vlunit)."',dtentrega='".utf8_decode($dtentrega)."',comp='".htmlentities(addslashes($complemento))."',emissor='".utf8_decode($emissor)."',evento='".utf8_decode($evento)."' WHERE id='".$idOrdem."'";
$sqlUpdateOrdem=mysql_query($sqlQueryUpdateOrdem) or die (mysql_error());

if(!$sqlUpdateOrdem){
	?>
       <script type="text/javascript">
       alert("Erro ao processar os dados.");
       window.location="ordemDados.php";
       </script>
       <?php
	}else{
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../prestcont/css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
<script language="JavaScript" type="text/javascript"> 
// função usada para carregar o código 
function fecha() { 
// fechando a janela atual ( popup ) 
window.close(); 
// dando um refresh na página principal 
opener.location.href="index.php"; 
// fim da função 
} 
</script>  
<style media="print">
.botao {
display: none;
}

#table th, td {
	border: 1px solid #000000;
	border-collapse: collapse;
	font-family: "Trebuchet MS", Arial, sans-serif;  
}


#table td, th {
	padding: 4px;
	
}

#table th {
	text-align: center;
	background: #E6EDF5;
	color: #000;
	font-size: 90% !important;
}
#table td{
	font-size: 80%;
}

tbody th {
	font-weight: bold;  
        background: #CFCFCF;
}

#table tbody tr { background: #FCFDFE; }

#table tbody tr.odd { background: #F7F9FC; }

#table table a:link {
	color: #718ABE;
	text-decoration: none;
}

#table table a:visited {
	//color: #718ABE;
        color:#E8E8E8;
	text-decoration: none;
}

#table table a:hover {
	color: #718ABE;
	text-decoration: underline !important;
}

#table tfoot th, tfoot td {
	font-size: 95%; 
}


</style>
<style>
body{
    width:800px;
	
}

</style>
</head>
<body onUnload="javascript:fecha()">
<div id="container">
    <div id="content">
            
<div id="notable" class='botao'>
    <table width="100%">
        <tr  valign="bottom"><td width='37'></td>
        <td align=right ><div id='link'>           Clique em imprimir, alterando a orientação da página caso julgue necessário.<br><a href='javascript:;'  class='botao' onclick='window.print();return false'><input type='button' class='button' name='enviar' id='enviar' value='IMPRIMIR' /></a></td></tr>
    </table> 
             
  </div>   
<div style="page-break-after: auto;">
 <div align="center"><img width="100px" src="../prestcont/css/Logo_CPB_transparente.png" ></div>                
                
<div id="table">  
<?php
$sqlOrdemGeral=mysql_query("SELECT aquiordem.*, aquireg.cdempres FROM aquiordem INNER JOIN aquireg ON aquireg.id=aquiordem.idreg WHERE aquiordem.id='".$idOrdem."'") or die(mysql_error());
$arrayOrdemGeral=mysql_fetch_array($sqlOrdemGeral);
	$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
	$mesNum=date('m');
	$dataHoje=date("d")." de ".$meses[$mesNum]." de ".date("Y"); 
	$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo,Cnpj_cpf
from GEEMPRES (nolock) 
where Cd_empresa='".$arrayOrdemGeral['cdempres']."'"));
				$empresa=$sqlEmpresaEdit['Nome_completo']." - ".mask($sqlEmpresaEdit['Cnpj_cpf'],'##.###.###/####-##');
	?>
<font size="+1">Brasília-DF, <?php echo $dataHoje; ?></font>
<p align="right">
<font color="#000000">Ordem de Serviço/Compra n.º:  <?php  echo $idOrdem." / ".date("y");?></font>
</p>
<br />
    <font size="+1">Departamento Emissor: <strong>DEAC</strong></font><br /><br />
    <font size="+1">Prestador de Serviço: </font><font size="2"><strong><?php echo utf8_encode($empresa); ?></strong></font><br /><br />
<table width="100%">   
    <tr><td colspan='2'><font size="+1">1. Documento Interno Referência: <strong><?php echo utf8_encode($arrayOrdemGeral['doc']); ?> </strong></font></td></tr> 
    <tr><td colspan='2'><font size="+1">2. Dados para <strong>Faturamento:<strong> <blockquote><blockquote><blockquote><font color="#000000"><?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['fatura'])); ?> </font></blockquote></blockquote></blockquote></strong></font></td></tr> 
    <tr><td colspan='2'><font size="+1">3. Descrição
    <blockquote><blockquote><blockquote><blockquote><blockquote><blockquote>
    <strong><?php echo $evento;?></strong>
    <table width="100%">
    <tr><th width="70%">MATERIAL</th>
    <th width="30%">QTD</th></tr>
    <?php 
	$sqlPedidosOrdem=mysql_query("SELECT aquipedidoitem.*,aquimat.cdmat FROM aquipedidoitem INNER JOIN aquimat ON aquimat.id=aquipedidoitem.idmat WHERE idos='".$idOrdem."'");
	while($objPedidoOrdem=mysql_fetch_object($sqlPedidosOrdem)){
		$arrayDescMatOrd=odbc_fetch_array(odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$objPedidoOrdem->cdmat."'"));
		echo "<tr><td><font size='+1'>".utf8_decode($arrayDescMatOrd['Descricao'])."</font></td><td align='center'><font size='+1'>".$objPedidoOrdem->qtd."</font></td></tr>";
		}
	?>
    </table>
    </blockquote></blockquote></blockquote></blockquote></blockquote></blockquote>
    <br />
    <?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['descric'])); ?>
    </td></tr>
    </div>
    <div style="page-break-after: auto;">
     <tr><td colspan='2'><font size="+1">4. Valor: <strong>R$ <?php echo utf8_encode($arrayOrdemGeral['vlunit']); ?> </strong></font></td></tr> 
     <tr><td colspan='2'><font size="+1">5. Data e local de entrega: <strong>
     <blockquote><blockquote><blockquote><font color="#000000"><?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['dtentrega'])); ?> </font></blockquote></blockquote></blockquote>
     </strong></font></td></tr> 
     <tr><td colspan='2'><font size="+1">6. Observações<br /><?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['comp'])); ?></font></td></tr> 
	<tr><td colspan='2'><font size="+1">7. Emissor:<br /><br />Autorizado por: <strong> <?php echo utf8_encode($arrayOrdemGeral['emissor'])." em ".date("d/m/Y H:i:s"); ?></strong></font></td></tr> 
</table>
</div>
 </div>
 </div>
 </div>
    <BR/><BR/>
</body>
</html>        
		<?php 
		}
			   ?>