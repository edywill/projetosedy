<?php 
$id=$_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>

<body>

<div id='box2'>
<h2><strong>ATENÇÃO!</strong></h2>
<p>Para utilizar as funções da CI Web você deve atualizar o seu usuário, informando seu código do CIGAM com 3 letras no campo abaixo:</p>
<form name="user" action="atUserCigam.php" method="post">
<input name="id" maxlength="3" size="5" type="hidden" value="<?php echo $id;?>"/>
<input name="user" maxlength="3" size="10" class="input" />
<br />
<input type="submit" name="botao" value="Atualizar" class="buttonVerde" />
</form>

</div>
</body>
</html>