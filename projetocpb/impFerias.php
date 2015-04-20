<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
.header_folha {
	font-size: small;
}
.negrito {
	font-weight: bold;
	font-size: 20px;
}
.grande {
	font-size: 15px;
}
.menor {
	font-size: 10px;
}
.small {
	font-size: small;
}
.pequeno{
	font-size: 13px;
	font-weight: bold;
}
body{
	font:70% verdana; 
	color:#000000;
}
</style>
<style media="print">
.botao {
display: none;
}
body{
	font:70% verdana; 
	color:#000000;
}
</style>
</head>

<body>
<div id='folha'>
<?php
include 'function.php';
$idFerias=$_POST['id'];
echo "<div id='link'> <div class='botao'> Preencha (após imprimir) a data de hoje e assine. Os demais campos serão preenchidos pelo DRH. <br></div><a href='javascript:;'  class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";
imprimirFerias($idFerias);
?>
</div>
</body>
</html>