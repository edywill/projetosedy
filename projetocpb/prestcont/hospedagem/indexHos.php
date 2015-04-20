<?php 
session_start();
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
    
<h3>AUTORIZACÕES HOSPEDAGEM</h3>   

<h4>Pesquisar CI</h4> 
<form action="incluiHospedagem.php" method="post">
    <strong>Nº da CI:</strong><input class='input' name="ci" type="text" size="5" />
    <br/><br/><br/>
      <input type="submit" class='button' value="PESQUISAR"/>
</form>
<br/>
</div>
</body>
</html>