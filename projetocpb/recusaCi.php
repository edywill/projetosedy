<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'>
<br/><strong>CIWEB  - Recusar CI:</strong><br/>
Caso tenha alguma observação em relação a recusa dessa CI, informe no campo abaixo:
<form action="confRecusaCi.php" name="recusa" method="post">
<?php
echo "<div id='outro' style='display: none;'>";
include "function.php";
$usuario=$_SESSION['usuarioApCiweb'];
$usuario2=$_SESSION['userApCiweb'];
$usuarioCigam=$_SESSION['cigamApCiweb'];
echo "</div>";
echo "<input name='user_ci' id='user_ci' value='".$_POST['user_ci']."' size='40' type='hidden' />
							<input name='id_ci' id='id_ci' value='".$_POST['id_ci']."' size='40' type='hidden' />
							<input name='desc_ci' id='desc_ci' value='".$_POST['desc_ci']."' size='40' type='hidden' />";
?>
<br /><br />
<textarea rows="5" cols="60" name="recusa"></textarea><br /><br />
<a href="ciWeb.php?usuario=<?php echo $_SESSION['usuarioApCiweb'];?>"><input type="button" value="<<Voltar"/></a>
<input type="submit" name="recusa" value="Confirmar Recusa" class="buttonVerde" />
</form>
</div>
</body>
</html>