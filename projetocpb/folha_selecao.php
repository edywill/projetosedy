<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
.negrito {
	font-weight: bold;
}
</style>
</head>

<body>
<div id='box2'>
<?php 
include "valida.php";
$usuario=$_GET['usuario'];
$usuarioFolha=$_SESSION['usuario'];
 ?>
<br />Por favor, escolha o mês e ano para impressão de sua <b>folha de frequência</b>:<br /><br />
<form  action="gerafolha.php" method="post" name="gerafolha">
<table width="461" border="0">
  <tr>
    <td width="109" class="negrito">Funcionário: </td>
    	<td width="342"> <?php echo $usuario ?><input name="nome" id="nome" type="hidden" value= "<?php echo $usuarioFolha ?>" size="30"/>
    </td>
  </tr>
  <tr>
    <td class="negrito">Mês:</td>
    <td>
	<div id="select">
	<select style='width:55px'   name="mes" id="mes">
      <option selected="selected"></option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
    </select></div></td>
  </tr>
  <tr>
    <td class="negrito">Ano:</td>
    <td><input class="input" type="text" name="ano" id="ano" size="2" maxlength="4"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td><input class='button' name="enviar" type="submit" value="enviar" /></td>
  </tr>
</table><br />
<br />
<label for="ano"></label><br />
</form>

</div>
</body>
</html>
