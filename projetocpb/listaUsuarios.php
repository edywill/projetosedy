<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.titulo {
	font-size: 18px;
}
.titulo_footer {
	font-weight: bold;
	text-align: center;
}
-->
</style>

<style media="print">
.botao {
display: none;
}
</style>

</head>

<body>

<div id='box'>
<br/><strong>Solicitações Pendentes de Aprovação:</strong><br/>
<?php
include "function.php";
require('conexaomysql.php');
	//consulta
echo "<div id='link2'><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";

listaUsuarios();
?>
</div>
</body>
</html>