<?php 
session_start();
require "../conectsqlserverci.php";
require "../conect.php";
if(!empty($_POST['idatu'])){
$idReg=$_POST['idatu'];
$_SESSION['idatumat']=$idReg;
$sqlRegQuery=mysql_query("Select aquipedidoitem.id AS iditor,aquipedidoitem.qtd AS qtdor, aquimat.* FROM aquipedidoitem INNER JOIN aquimat ON aquimat.id=aquipedidoitem.idmat where aquipedidoitem.id='".$idReg."'") or die(mysql_error());
$sqlReg=mysql_fetch_array($sqlRegQuery);
$arrayDescMat=odbc_fetch_array(odbc_exec($conCab,"SELECT Cd_reduzido,Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$sqlReg['cdmat']."'"));
$_SESSION['materialComp']=$sqlReg['id']."-".$arrayDescMat['Cd_reduzido']."-".$arrayDescMat['Descricao'];
$_SESSION['qtdMat']=$sqlReg['qtdor'];
}else{
    $idReg=$_SESSION['idatumat'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("suggest_material_ordem.php", {
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
<script type='text/javascript' src='../jquery_price.js'></script>
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
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Compra/Serviço</h3>  
<br />
<div id='tabela'>
<form action="insereNovoItemOrd.php" name="insere" method="post">
<h4>ATUALIZAR ITEM</h4>
<table border="0" width="50%"><tr>
<th width="30%">Material</th><td><input type="hidden" size="40" name="atualizar" id='atualizar' class="input" value='<?php echo $_SESSION['idatumat'];?>'><input type="text" size="40" name="material" id='material' class="input" value='<?php echo utf8_encode($_SESSION['materialComp']); ?>'></td></tr>
<tr>
<th width="30%">Quantidade</th><td><input type="text" size="20" name="qtd" id='qtd' class="input" value='<?php echo $_SESSION['qtdMat']; ?>'></td>
</tr>
<tr><td width="30%"><a href="novaOrdem.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="Alterar" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>