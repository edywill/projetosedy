<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
if(!empty($_POST['idatu'])){
$idReg=$_POST['idatu'];
$_SESSION['idatumat']=$idReg;
$sqlReg=mysql_fetch_array(mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idatumat']."'"));

$_SESSION['materialComp']=$sqlReg['id'];
$_SESSION['materialCompDesc']=$arrayDescMat['nome'];
$_SESSION['qtdMat']=$sqlReg['quant'];
$_SESSION['vlunitMat']=$sqlReg['vlunit'];
}else{
    $idReg=$_SESSION['idatumat'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/icon.css">
	<script type="text/javascript" src="../jqueryDown/easy/jquery.easyui.min.js"></script>
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
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Registro de Preço</h3>  
<br />
<div id='tabela'>
<form action="insereNovoItemSrp.php" name="insere" method="post">
<h4>ATUALIZAR ITEM</h4>
<table border="0" width="50%"><tr>
<th width="30%">Material</th><td><input type="hidden" size="40" name="atualizar" id='atualizar' class="input" value='<?php echo $_SESSION['idatumat'];?>'>
<select name="material" id="material" class="easyui-combobox">
<option selected="selected" value="<?php echo $_SESSION['materialComp']; ?>"><?php echo $_SESSION['materialCompDesc']; ?></option>
<?php 
$SQLMaterial=mysql_query("SELECT nome FROM aquicadmat WHERE inativo=0 ORDER BY nome");
while($objMaterial=mysql_fetch_object($SQLMaterial)){
	echo "<option value='".$objMaterial->id."'>".utf8_encode($objMaterial->nome)."</option>";	
	}
?>
</select>
</td></tr>
<tr>
<th width="30%">Quantidade</th><td><input type="text" size="20" name="qtd" id='qtd' class="input" value='<?php echo $_SESSION['qtdMat']; ?>'></td>
</tr><tr>
<th width="30%">Valor Unitário</th><td><input type="text" size="20" name="vlunit" id='vlunit' class="input" value='<?php echo $_SESSION['vlunitMat']; ?>'></td>
</tr>
<tr><td width="30%"><a href="insereItensSrp.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="Alterar" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>