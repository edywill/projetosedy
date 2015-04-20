<?php 
session_start();
if(!empty($_GET['usuario'])){
	unset($_SESSION['userAquis']);
	$_SESSION['userAquis']=$_GET['usuario'];
	}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
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
    
  <h2>AQUISIÇÕES</h2>
  <h3><strong>Ordem de Compra</strong><br />
      
  </h3>
  <ul>
    <li><strong><a href="index.php">Registro de Preço</a></strong><br />
      <br /></li>
<li><strong><a href="licitacao/novaOrdem.php?tipo=cd">Compra Direta</a></strong><br />
  <br /></li>
<li><strong><a href="licitacao/index.php">Outras Modalidades</a></strong><br />
  <br /></li>
</ul>
</div>
</body>
</html>