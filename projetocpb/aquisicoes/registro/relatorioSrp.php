<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$idReg=$_POST['idsrp'];
$_SESSION['idRegAqui']=$idReg;
$sqlDadosReg=mysql_query("SELECT * FROM aquireg WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$dtinicio=$arrayDadosReg['dtinicio'];
				$dtfim=$arrayDadosReg['dtfim'];
				$idEmpresa=$arrayDadosReg['cdempres'];
				$idProc=$arrayDadosReg['proc'];
				$sqlProcEdit=odbc_fetch_array(odbc_exec($conCab,"select projeto, assunto
from GMPROCDOC (nolock) 
where projeto='".$idProc."'"));
				$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where Cd_empresa='".$idEmpresa."'"));
				$empresa=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
				$processo=$sqlProcEdit['projeto']."-".$sqlProcEdit['assunto'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("../../suggest_material.php", {
		  width: 352,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<style>
    .sel { width: 70px; }
    
</style>
<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*1.2;
	obj.width=obj.width*1.2;
}
 
function diminui(obj){
	obj.height=obj.height/1.2;
	obj.width=obj.width/1.2;
}
//-->
</script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
	  $('#qtd').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
    });
	 </script>
     <script type='text/javascript' src='../../basic/js/jquery.js'></script>
<script type='text/javascript' src='../../basic/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='../../basic/js/basic.js'></script>
<link type='text/css' href='../../basic/css/basic.css' rel='stylesheet' media='screen' />
<script type="text/javascript">
function reescreveDados(valor){
	// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveModal.php?idmat="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('basic-modal-content').innerHTML=resposta;
}
}
req.send(null);
	}
</script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Registro de Preço - Relatório</h3>  
<br />
<div id="basic-modal-content">

</div>
<div id='tabela'>
<table width="100%" border="0">
<tr><th width="30%">Processo</th><td><?php echo utf8_encode($processo); ?></td></tr>
<tr><th width="30%">Empresa</th><td><?php echo utf8_encode($empresa); ?></td></tr>
<tr><th width="30%">Vigência</th><td><?php echo $dtinicio; ?> à <?php echo $dtfim; ?></td></tr>
</table>
<?php 
?>
<h4>ITENS CADASTRADOS</h4>
<table border="1" width="100%">
<tr>
<th rowspan="2">GR. DESPESA</th><th rowspan="2">MATERIAL</th><th rowspan="2">VALOR UNITARIO(R$)</th><th colspan="6" align="center">QUANTIDADE</th></tr>
<tr><th>INICIAL</th><th>TOTAL(R$)</th><th>SOLICITADO</th><th>TOTAL(R$)</th><th>SALDO</th><th>TOTAL(R$)</th></tr>
<?php
$totSol=0;
$totQtd=0;
$totSaldo=0;
$totalGeralIn=0;
$totalGeralSol=0;
$totalGeralSal=0;
$sqlGrupoDespesa=mysql_query("SELECT aquicadmat.grupo FROM aquimat LEFT JOIN aquicadmat ON aquicadmat.id=aquimat.cdmat WHERE aquimat.idreg='".$_SESSION['idRegAqui']."' GROUP BY aquicadmat.grupo ORDER BY aquicadmat.grupo");
while($objGrupo=mysql_fetch_object($sqlGrupoDespesa)){
	$sqlDadosGrupo=mysql_fetch_array(mysql_query("SELECT codigo,descricao FROM aquigrupo WHERE id='".$objGrupo->grupo."'"));
	$sqlMaterial=mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idRegAqui']."' AND aquicadmat.grupo='".$objGrupo->grupo."' ORDER BY aquigrupo.id") or die(mysql_error());
$countMat=mysql_num_rows($sqlMaterial);
	echo "<tr><td valign='middle' rowspan='".$countMat."'><strong>".$sqlDadosGrupo['codigo']."-".utf8_encode($sqlDadosGrupo['descricao'])."</strong></td>";
	$countitem=0;
	$totQtdGr=0;
	$totSolGr=0;
	$totSaldoGr=0;
	$vltotInGr=0;
	$vltotSolGr=0;
	$vltotSalGr=0;

while($objMat=mysql_fetch_object($sqlMaterial)){
	$solicitado=0;
	$cor='';
	$sqlPedidos=mysql_query("SELECT qtd FROM aquipedidoitem WHERE idmat='".$objMat->id."'") or die(mysql_error());
	while($objPedidos=mysql_fetch_object($sqlPedidos)){
		$solicitado=$solicitado+$objPedidos->qtd;
		}
	$saldo=$objMat->quant-$solicitado;
	$saldotext=$saldo;
	if($saldo<0){
		$cor=" bgcolor='red' ";
		$saldotext="<font color='white'>".$saldo."</font>";
		}
	$totSol=$totSol+$solicitado;
	$totQtd=$totQtd+$objMat->quant;
	$totSaldo=$totSaldo+$saldo;
	
	$totQtdGr=$totQtdGr+$objMat->quant;
	$totSolGr=$totSolGr+$solicitado;
	$totSaldoGr=$totSaldoGr+$saldo;
	
	if($countitem>0){
		echo "<tr>";
		}
	$totalInicial=$objMat->quant*str_replace(",",".",str_replace(".","",$objMat->vlunit));
	$totalSolicitado=$solicitado*str_replace(",",".",str_replace(".","",$objMat->vlunit));
	$totalSaldo=$saldotext*str_replace(",",".",str_replace(".","",$objMat->vlunit));
	$vltotInGr=$vltotInGr+$totalInicial;
	$vltotSolGr=$vltotSolGr+$totalSolicitado;
	$vltotSalGr=$vltotSalGr+$totalSaldo;
	echo "<td>".utf8_encode($objMat->nome)."</td><td>R$ ".$objMat->vlunit."</td><td align='center'>".$objMat->quant."</td><td align='right'>".number_format($totalInicial,2,",",".")."</td><td align='center'";
	if($solicitado>0){
	echo "bgcolor='#B4B4B4'><div id='basic-modal'>
<a href='' target='' class='basic' onclick='reescreveDados(".$objMat->id.")' alt='Clique para visualizar as Ordens relacionadas a esse material' title='Clique para visualizar as Ordens relacionadas a esse material'><strong><font color='white'>".$solicitado."</font></strong></a></div>";
	}else{
	echo "><strong>".$solicitado."</strong>";
	}
echo "</td><td align='right'>".number_format($totalSolicitado,2,",",".")."</td><td align='center' $cor>".$saldotext."</td><td align='right'>".number_format($totalSaldo,2,",",".")."</td></tr>";
	$countitem++;
	}
	echo "<tr><td colspan='3' align='right'><b>Total Grupo ".utf8_encode($sqlDadosGrupo['descricao'])."</b></td><td align='center'><b>".$totQtdGr."</b></td><td align='right'><b>".number_format($vltotInGr,2,",",".")."</b></td><td align='center'><b>".$totSolGr."</b></td><td align='right'><b>".number_format($vltotSolGr,2,",",".")."</b></td><td align='center'><b>".$totSaldoGr."</b></td><td align='right'><b>".number_format($vltotSalGr,2,",",".")."</b></td></tr>";
	$totalGeralIn+=$vltotInGr;
	$totalGeralSol+=$vltotSolGr;
	$totalGeralSal+=$vltotSalGr;
}
echo "<tr><th colspan='3' align='right'><h3>TOTAL GERAL</h3></td> <td align='center'><h3>".$totQtd."</h3></td><td align='right'><h3>".number_format($totalGeralIn,2,",",".")."</h3></td><td align='center'><h3>".$totSol."</h3></td><td align='right'><h3>".number_format($totalGeralSol,2,",",".")."</h3></td><td align='center'><h3>".$totSaldo."</h3></td><td align='right'><h3>".number_format($totalGeralSal,2,",",".")."</h3></td></tr>";
if(!empty($_POST['pagsrp'])){
?>
<tr><td colspan="5">
<a href="<?php echo $_POST['pagsrp']; ?>"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td></tr>
<?php 
}
?>
</table>
</div>
</div>
</body>
</html>