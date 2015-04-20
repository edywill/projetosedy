<?php 
session_start();
$_SESSION['modalRef']='';
$_SESSION['projetoConvS']='';
$_SESSION['tipoIdSessionConv']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'><br/>
<?php 
require "../common/tagsConv.php";
echo $titulo;
require "../../conexaomysql.php";
include "projetos/selecionaProj.php";
?>

<p></p>
<a href="projetos/cadProjConv.php">
<img src="../imagens/adicionarProje.png" border="0"/>
</a>
</form>
</div>
</body>
</html>