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
$usuarioRecibo=$_SESSION['usuario'];
 ?>
<br />Por favor, escolha o mês e ano para impressão de seu <b>recibo de pagamento</b>:<br /><br />
<form action="geracontracheque.php" method="post" name="geracontracheque">
<table width="461" border="0">
  <tr>
    <td width="112" class="negrito">Funcionário: </td>
    <td width="354"><?php echo $usuario ?><input name="nomeCh" id="nomeCh" type="hidden" value="<?php echo $usuarioRecibo ?>" size="30"/>
    </td>
  </tr>
  <tr>
    <td class="negrito">Mês:</td>
    <td>
	<div id="select">
	<select style='width:55px'  name="mesCh" id="mesCh" >
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
      <option>13-1</option>
      <option>13-2</option>
    </select></div></td>
  </tr>
  <tr>
    <td class="negrito">Ano:</td>
    <td><input class="input" type="text" name="anoCh" id="anoCh" size="2" maxlength="4"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td><input class="button" name="enviar" type="submit" value="enviar" /></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
