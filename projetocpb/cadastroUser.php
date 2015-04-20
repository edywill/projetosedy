<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.small {
	font-size: x-small;
}
-->
</style>
</head>

<body>
<div id='box2'>
<p>
  <?php 
include "function.php";
?>
<br/>
Digite o nome do funcionário conforme cadastrado no CIGAM / META.<br /><br />
<strong>O login deverá ser a primeira parte do e-mail, para que possa autenticar-se no servidor.</strong></p>
<form action="incluiUsuario.php" method="post" name="form3" onsubmit="return validaCampo();" >
<table width="290" border="0">
  <tr>
    <td width="87" class="negrito">Nome: </td>
    <td width="193"><input name="func" class="input" id="func"  size="30" type="text"/>
   </td>
  </tr>
  <tr>
    <td class="negrito">Login:</td>
    <td><input name="login" class="input" id="login"  size="30" type="text"/>    </tr>
  <tr>
    <td class="negrito">Código CIGAM:</td>
    <td><input name="cigam" class="input" id="login"  size="15" type="text"/> <span class="small">*Caso desconheça, deixe em branco.</span> </td>  </tr>
    <tr>
    <td class="negrito">Módulos:</td>
    <td><table border="0" width="100%">
    <tr><td>GESTOR</td><td><input type="checkbox" name="gest" /></td></tr>
    <tr><td>PRESIDÊNCIA</td><td><input type="checkbox" name="presi" /></td></tr>
    <tr><td>RH</td><td><input type="checkbox" name="rh" /></td></tr>
    <tr><td>PRESTAÇÃO DE CONTAS</td><td><input type="checkbox" name="prestcont" /></td></tr>
    <tr><td>CONVÊNIOS</td><td><input type="checkbox" name="conv" /></td></tr>
    <tr><td>AQUISIÇÃO</td><td><input type="checkbox" name="aquis" /></td></tr>
    <tr><td>ATLETAS</td><td><input type="checkbox" name="atletas" /></td></tr></table>
    </td>
     </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td><input name="enviar" class="button" type="submit" value="Cadastrar" /></td>
  </tr>
  
</table>
<br/><span class="small">*Caso haja alguma divergência entre o login(email) informado e o cadastrado no CIGAM / META, o usuário não será cadastrado.</span><br />
  <br />
</form>

</body>
</html>