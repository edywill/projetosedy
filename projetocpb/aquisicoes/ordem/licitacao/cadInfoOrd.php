<?php 
session_start();
$_SESSION['idOrdemImpPdf']='';
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
require "../../../conectsqlserverci.php";
require "../../../conect.php";
$userCriac=$_SESSION['userAquis'];
$idOrdem= $_SESSION['idRegAqui'];
$documento=$_POST['doc'];
$faturaAnt="<b>COMITÊ PARAOLÍMPICO BRASILEIRO - CPB<br />
CNPJ n.º 00.700.114/0001-44<br />
Setor Bancário Norte, Quadra 02, Lote 12, Bloco \"F\", 14º Andar<br />
Brasília-DF - Cep. 70.040-020</b>";
$fatura='';
if($_POST['fatura']<>$faturaAnt){
	$fatura=$_POST['fatura'];
	}
$descricao=$_POST['desc'];
$vlunit=$_POST['vlunit'];
$dtentrega=$_POST['dtentrega'];
$evento=$_POST['evento'];
$complemento="O pagamento será efetuado por meio de ordem bancária ou qualquer outro meio idôneo adotado pelo CPB, mediante a apresentação de Nota Fiscal / Fatura devidamente atestada (responsável pelo recebimento), no prazo de até <u>10 (dez) dias úteis a contar do seu recebimento</u>, devendo ser efetuada a retenção na fonte dos tributos e contribuições determinadas pelos órgãos fiscais e fazendários em conformidade com a legislação vigente, quando for o caso.";
$emissor=$_POST['emissor'];
$dataEmissao=date("d/m/Y H:i:s");
$sqlQueryUpdateOrdem="UPDATE aquiordemlic SET doc='".utf8_decode($documento)."',fatura='".htmlentities(addslashes($fatura))."', descric='".htmlentities(addslashes($descricao))."', vlunit='".trim($vlunit)."',dtentrega='".utf8_decode($dtentrega)."',emissor='".utf8_decode($emissor)."',evento='".utf8_decode($evento)."',data='".$dataEmissao."' WHERE idreg='".$_SESSION['idRegAqui']."'";
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
<link rel="stylesheet" href="../../estilo.css" /> 
<script type="text/javascript" src="../../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" /> 
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
</head>
<body onUnload="javascript:fecha()">
<div id="container">
    <div id="box3">       
<br /><br />
<h1 id="h1">Resumo da Ordem de Serviço/Compra</h1>
<?php
$sqlOrdemGeral=mysql_query("SELECT aquiordemlic.*, aquilic.cdempres,aquilic.nlicit,aquilic.tplicit FROM aquiordemlic INNER JOIN aquilic ON aquilic.id=aquiordemlic.idreg WHERE aquiordemlic.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
$arrayOrdemGeral=mysql_fetch_array($sqlOrdemGeral);
	$meses = array (01 => "Janeiro", 02 => "Fevereiro", 03 => "Março", 04 => "Abril", 05 => "Maio", 06 => "Junho", 07 => "Julho", 08 => "Agosto", 09 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
	$mesNum=date('m');
	$mesNum=(int)$mesNum;
	$dataHoje=date("d")." de ".$meses[$mesNum]." de ".date("Y"); 
	$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo,Cnpj_cpf
from GEEMPRES (nolock) 
where Cd_empresa='".$arrayOrdemGeral['cdempres']."'"));
				$empresa=$sqlEmpresaEdit['Nome_completo']." - ".mask($sqlEmpresaEdit['Cnpj_cpf'],'##.###.###/####-##');
	?>
<p>
Ordem de Serviço/Compra n.º:  <strong><?php 
echo $_SESSION['idosSession']."/".date("Y")." (".$_SESSION['tipoLicSession'].")";
?></strong>
</p>
    <?php 
	if($arrayOrdemGeral['tplicit']<>'cd'){
	?>
    
    Licitação Nº: <strong><?php echo utf8_encode($arrayOrdemGeral['nlicit']); ?></strong><br />
    <br />
<?php 
	}
?>

    Departamento Emissor: <strong>DEAC</strong><br /><br />
    Prestador de Serviço: <strong><?php echo utf8_encode($empresa); ?></strong><br /><br />
<table width="100%">   
    <tr><td colspan='2'><h2 id="h2">1. Documento Interno Referência:</h2><?php echo utf8_encode($arrayOrdemGeral['doc']); ?> </strong></font><p></p></td></tr> 
    <tr><td colspan='2'><h2 id="h2">2. Dados para Faturamento:</h2><?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['fatura'])); ?> <p></p></td></tr> 
    <tr><td colspan='2'><h2 id="h2">3. Descrição</h2><?php echo $evento;?>
    <p></p>
    <table width="80%" border="1" style="border-bottom-color:#D5C7FC; border-color:#ADA7F8">
    <tr align="center" bgcolor="#6668A3"><td width="40%"><font color="#FFFFFF"><strong>MATERIAL</strong></font></td>
    <td width="20%"><font color="#FFFFFF"><strong>QTD</strong></font></td>
    <td width="20%"><font color="#FFFFFF"><strong>VL.UN.</strong></font></td>
    <td width="20%"><font color="#FFFFFF"><strong>TOTAL</strong></font></td></tr>
    <?php 
	$sqlPedidosOrdem=mysql_query("
	SELECT aquimatlic.id,aquimatlic.cdmat,aquimatlic.quant,aquimatlic.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimatlic LEFT JOIN aquicadmat ON aquimatlic.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimatlic.idreg='".$_SESSION['idRegAqui']."'");
	$valorTotal=0;
	$valorTotalUnit=0;
	$atualizaSaldo=0;
  	$saldo=0;
 	$solicitado=0;
	while($objPedidoOrdem=mysql_fetch_object($sqlPedidosOrdem)){
		$valorItem=0;
		$valorItem=str_replace(",",".",str_replace(".","",$objPedidoOrdem->vlunit));
		$valorTotalItem=(float)$valorItem*$objPedidoOrdem->quant;
		$valorTotalUnit+=$valorItem;
		$valorTotal+=$valorTotalItem;
		
		echo "<tr><td><font>".utf8_decode($objPedidoOrdem->nome)."</font></td><td align='center'><font>".$objPedidoOrdem->quant."</font></td><td align='center'><font>".number_format($valorItem,2,",",".")."</font></td><td align='center'><font>".number_format($valorTotalItem,2,",",".")."</font></td></tr>";
		}
	?>
    <tr>
      <td colspan="2" align="center"><strong>TOTAL</strong></td><td align="center"><strong><?php echo number_format($valorTotalUnit,2,",",".") ?></strong></td><td align="center"><strong><?php echo number_format($valorTotal,2,",",".") ?></strong></td></tr>
    </table>
    <?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['descric'])); ?>
    </td></tr>
    </div>
    <div style="page-break-after: auto;">
     <tr><td colspan='2'><h2 id="h2">4. Valor:</h2>R$ <?php echo utf8_encode($arrayOrdemGeral['vlunit']); ?> <p></p></td></tr> 
     <tr><td colspan='2'><h2 id="h2">5. Data e local de entrega:</h2> <?php echo html_entity_decode(utf8_encode($arrayOrdemGeral['dtentrega'])); ?><br /><br /></td></tr> 
     <tr><td colspan='2'><h2 id="h2">6. Informações Complementares</h2>
	 <?php echo $complemento; ?>
     </td></tr> 
	<tr><td colspan='2'><h2 id="h2">7. Emissor:</h2>Autorizado por: <strong> <?php echo utf8_encode($arrayOrdemGeral['emissor'])." em ".$arrayOrdemGeral['data']; ?></strong></td></tr> 
    <tr><td colspan='2' align="center"><a href="geraPdfOs.php?id=<?php echo $idOrdem; ?>" target="_blank"><input type="button" class="buttonVerde" name="imprimir" value="IMPRIMIR ORDEM" />
    </a></td></tr>
</table>
 </div>
 </div>
</body>
</html>        
		<?php 
		}
			   ?>