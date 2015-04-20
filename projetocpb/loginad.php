<?php 
 session_start();
 session_unset();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Intranet - CPB</title>
</head>

<body >
	<div  style='position:relative; top:0px; left:0px;'>
		<img width="100%" src="imagens/topo_new1.png" border=0>
	</div>
	<!--<div style='position:absolute; top:70px; left:50px;'>
		<img width="280px" src="imagens/logo_cpb1.png"/>
	</div>
	<img src="imagens/topo_new.png" width="100%"  border="0" />
	<img width="280px" style="margin-top: -140px; margin-left: 50px; " src='imagens/logo_cpb1.png'>-->
<div id="container">
<div id="content">
<table width="100%" border="0">
<tr><td></td></tr>
</table>
<br><br><br>
<form id="form1" name="form1" method="post" action="validaad.php">
<table  width="100%" height="20" border="0">
<tr><td>
  <p align="center"><strong>Bem vindo a Intranet do CPB</strong></p><br/>
  <div class="field">	
   <table border="0" width="100%"><tr>
    <td align="right" width="27%"></td><td width="15%">
    <label for="login">Login</label></td><td width="36%" align="left">
    <input class='input' type="text" name="login" id="login" /></td><td width="22%"></td></tr></table>
  </div><br/>
  <div class="field">	
  <table border="0" width="100%"><tr>
    <td align="right" width="27%"></td><td width="15%">
      <label for="senha">Senha</label></td><td width="36%" align="left">
    <input  type='password' align="center" class="input" name="senha" id="senha" /></td><td width="22%"></td></tr></table>
  </p>
  </div>
  <p><br/>
  <div id='sair'>
    <input type="submit" class='button' name="enviar" id="enviar" value="ENTRAR" />
  </div>
 </p><br/><br/>
  <p align='center'>Por favor, digite seu usuário e senha de rede para acessar o sistema.</p>
</td></tr>
</form>
</table>

</div>
</div>

	<div  style='position:relative; bottom:0%; left:0px;'>
		<img width="100%" src="imagens/rodape_new1.png" border=0>
	</div>




<!--<img src="imagens/rodape_new.jpg"  width="100%"  border="0" />
<img width="280px" style="margin-top: -140px; margin-left: 50px; " src=''>-->
</body>
</html>