<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$idGrupo=$_POST['grupo'];
$idMaterial=$_POST['material'];
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
<h3>Relatório - Grupo de Despesa/Material</h3>  
<br />
<div id="basic-modal-content">

</div>
<div id='tabela'>
<table border="1" width="100%">
<tr>
<th rowspan="2">GR. DESPESA</th><th rowspan="2">MATERIAL</th><th colspan="2" align="center">QUANTIDADE</th></tr>
<tr><th>SOLICITADO</th><th>TOTAL(R$)</th>
<?php 
if($_SESSION['tipoRelatorio']==2){
	echo "<th>STATUS</th>";
	}
?>
</tr>
<?php
$totSolGeral=0;
$vltotInGeral=0;
$condicionalGrupo='';
if($idGrupo>0){
$condicionalGrupo="WHERE aquicadmat.grupo='".$idGrupo."'";
}

$sqlGrupoDespesa=mysql_query("SELECT aquicadmat.grupo FROM aquicadmat ".$condicionalGrupo." GROUP BY aquicadmat.grupo ORDER BY aquicadmat.grupo") or die(mysql_error());

while($objGrupo=mysql_fetch_object($sqlGrupoDespesa)){
	$sqlDadosGrupo=mysql_fetch_array(mysql_query("SELECT codigo,descricao FROM aquigrupo WHERE id='".$objGrupo->grupo."'"));
	$condicionaMaterial='';
	if($idMaterial>0){
		$condicionaMaterial="AND aquicadmat.id='".$idMaterial."'";
		}
	$sqlMaterial=mysql_query("SELECT aquicadmat.id AS cadmat,aquicadmat.nome FROM aquicadmat WHERE aquicadmat.grupo='".$objGrupo->grupo."' AND aquicadmat.inativo=0 ".$condicionaMaterial." ORDER BY aquicadmat.grupo") or die(mysql_error());
$countMat=mysql_num_rows($sqlMaterial);
	echo "<tr><td valign='middle' rowspan='".$countMat."'><strong>".$sqlDadosGrupo['codigo']."-".utf8_encode($sqlDadosGrupo['descricao'])."</strong></td>";
	$countitem=0;
	$totSolGr=0;
	$vltotInGr=0;
while($objMat=mysql_fetch_object($sqlMaterial)){
	if($countitem>0){
		echo "<tr>";
		}
	$totQuant=0;
	$vlItem=0;
	$vlMedio=0;
	if($_SESSION['tipoRelatorio']=='0'){
	$sqlMaterialContaSrp=mysql_query("
	SELECT aquimat.vlunit,aquipedidoitem.qtd 
	FROM aquicadmat 
	LEFT JOIN aquimat ON aquimat.cdmat=aquicadmat.id 
	LEFT JOIN aquipedidoitem ON aquipedidoitem.idmat=aquimat.id
	WHERE aquicadmat.id='".$objMat->cadmat."'");
	while($objMaterialContaSrp=mysql_fetch_object($sqlMaterialContaSrp)){
		$vlUnitTotal=0;
		$totQuant+=$objMaterialContaSrp->qtd;
		$vlUnitTotal=str_replace(",",".",str_replace(".","",$objMaterialContaSrp->vlunit))*$objMaterialContaSrp->qtd;
		$vlItem+=$vlUnitTotal;
		}
	}
	$condicionalTipo="";
	if($_SESSION['tipoRelatorio']=='1'){
	$condicionalTipo=" AND aquilic.tplicit<>'cd'";
	}elseif($_SESSION['tipoRelatorio']=='2'){
		$condicionalTipo=" AND aquilic.tplicit='cd'";
		}
$sqlMaterialContaLic=mysql_query("
	SELECT aquimatlic.vlunit,aquimatlic.quant 
	FROM aquicadmat 
	LEFT JOIN aquimatlic ON aquimatlic.cdmat=aquicadmat.id 
	LEFT JOIN aquilic ON aquilic.id=aquimatlic.idreg
	WHERE aquicadmat.id='".$objMat->cadmat."' ".$condicionalTipo."");
	while($objMaterialContaLic=mysql_fetch_object($sqlMaterialContaLic)){
		$vlUnitTotal2=0;
		$totQuant+=$objMaterialContaLic->quant;
		$vlUnitTotal=str_replace(",",".",str_replace(".","",$objMaterialContaLic->vlunit))*$objMaterialContaLic->quant;
		$vlItem+=$vlUnitTotal;
		}
		
		
		$totSolGr+=$totQuant;
		$vltotInGr+=$vlItem;
		
	echo "<td>".utf8_encode($objMat->nome)."</td><td align='center'";
	
	if($totQuant>0){
	echo "bgcolor='#B4B4B4'><div id='basic-modal'>
<a href='' target='' class='basic' onclick='reescreveDados(".$objMat->cadmat.")' alt='Clique para visualizar as Ordens relacionadas a esse material' title='Clique para visualizar as Ordens relacionadas a esse material'><strong><font color='white'>".$totQuant."</font></strong></a></div>";
	}else{
	echo "><strong>".$totQuant."</strong>";
	}
	if($vlItem>25000){
		if($_SESSION['tipoRelatorio']==2){
echo "</td><td align='right' bgcolor='red'><strong><font color='white'>".number_format($vlItem,2,",",".")."</font></strong></td><td bgcolor='red'><font color='white'>Limite Ultrapassado</font></td></tr>";
		}else{
	echo "</td><td align='right'><strong>".number_format($vlItem,2,",",".")."</strong></td></tr>";
			}
	
	}else{
		echo "</td><td align='right'><strong>".number_format($vlItem,2,",",".")."</strong></td></tr>";
		}
	$countitem++;
	}
	echo "<tr><td colspan='2' align='right'><b>Total Grupo ".utf8_encode($sqlDadosGrupo['descricao'])."</b></td><td align='center'><b>".$totSolGr."</b></td><td align='right'><b>".number_format($vltotInGr,2,",",".")."</b></td></tr>";
    	$totSolGeral+=$totSolGr;
		$vltotInGeral+=$vltotInGr;
}
echo "<tr><th colspan='2' align='right'><h3>TOTAL GERAL</h3></td> <td align='center'><h3>".$totSolGeral."</h3></td><td align='right'><h3>".number_format($vltotInGeral,2,",",".")."</h3></td></tr>";
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