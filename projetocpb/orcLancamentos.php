<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>

</head>

<body>
<div id="box3">
<h2>Or&ccedil;amento - Lan&ccedil;amentos Financeiros</h2>
Escolha a Conta Gerencial:
<form action="orcLancFin.php" name="limite" method="post">
<?php 
include "funcOrc.php";
montaComboConta();
?>
<input type="submit" name="submit" value="OK" class="buttonVerde"/>
</form>
</div>
</body>
</html>