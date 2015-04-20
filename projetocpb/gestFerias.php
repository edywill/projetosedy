<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>

<body>
<div id='box3'>
<br/><strong>Solicitações Pendentes de Aprovação:</strong><br/>
<?php
include "function.php";
$usuario=$_GET['usuario'];
require('conexaomysql.php');
	//consulta
listaSolicitac($usuario);
?>
</div>
</body>
</html>