<?php 
session_start();
if(!empty($_GET['usuario'])){
	unset($_SESSION['userPas']);
	$_SESSION['userPas']=$_GET['usuario'];
	}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>

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
    
<h3>AUTORIZACÕES</h3>  
Escolha o tipo de autorização:<br /><br />

<table width="100%" border="0"><tr align="center"><td><a href="passagens/indexPas.php"><input type="button" class="button" name="Passagens" value="Passagens" /></a></td><td><a href="hospedagem/indexHos.php"><input type="button" class="button" name="hospedagem" value="Hospedagem" /></a></td><td><input type="hidden" class="button" name="transporte" value="Transporte" /></td></tr></table>
</div>
</body>
</html>