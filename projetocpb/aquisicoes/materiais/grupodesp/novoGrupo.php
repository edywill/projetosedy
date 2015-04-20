<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
$userCriac=$_SESSION['userAquis'];
		$criar=0;
		$codigo='';
		$descricao='';
		if(!empty($_POST['idatu'])){
		$sqlRegAtu=mysql_fetch_array(mysql_query("SELECT * FROM aquigrupo WHERE id='".$_POST['idatu']."'"));
		if(empty($sqlRegAtu)){
			?>
       <script type="text/javascript">
       alert("Registro inexistente");
       window.location="index.php";
       </script>
       <?php
			}else{
		$codigo=$sqlRegAtu['codigo'];
		$descricao=utf8_encode($sqlRegAtu['descricao']);
		$criar=$_POST['idatu'];
			}
			}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<style>
    .sel { width: 70px; }
    
</style>
<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style>
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

</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Grupo de Despesa</h3>  

<div id='tabela'>
<form action="salvaGrupo.php" name="insere" method="post">
<table width="100%" border="0">
<tr><th width="20%">Código</th><td>
<input type="text" name="codigo" id="codigo" class="input" size="30" value="<?php echo $codigo; ?>" maxlength="29" />
</td></tr>
<tr><th width="20%">Descrição</th><td><input type='hidden' name='criar' id='criar' class='input' value='<?php echo $criar; ?>'/><input type="text" name="descricao" id="descricao" class="input" size="60" value="<?php echo $descricao; ?>" maxlength="99"/>

</td></tr>
<tr><td width="20%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="Continuar>>" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>