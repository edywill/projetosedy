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
    
<h3>AUTORIZACÕES</h3>   

<h4>Pesquisar CI</h4> 
<form action="incluiPassagem.php" method="post">
    <strong>Nº da CI:</strong><input class='input' name="ci" type="text" size="5" />
    <br/><br/><strong>Tipo:</strong><select name="tipo"><option value="" selected="selected">Selecione</option><option value="I">Internacional</option><option value="N">Nacional</option></select><br /><br/>
      <input type="submit" class='button' value="PESQUISAR"/>
</form>
<br/><br/>
<a href="autLot.php"><input type="button" class="button" name="butto" value="Criação por Gerencial" /></a>
<br/><br/><br />
<table bgcolor="#FFFFFF" border='1' width="150px" heigth="80px"><tr>
          <td>
              <div align="center"> <p><a href="cadciaaerea.php"><strong>Cadastro Cia Aérea</strong><img hspace="10px" align="middle" width="30" src="../css/icone-aviao.png" onMouseOver="aumenta(this)" onMouseOut="diminui(this)"></a></p></div>
          </td>
        </tr>
</table>
</div>
</body>
</html>