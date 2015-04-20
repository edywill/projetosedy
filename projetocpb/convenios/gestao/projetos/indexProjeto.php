<?Php 
session_start();
$_SESSION['modalRef']='';
$_SESSION['tipoIdSessionConv']='';
$_SESSION['titModSession']='';
$_SESSION['editarEventoSession']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'><br/>
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['projeto'])){
$id=$_POST['projeto'];
$_SESSION['projetoConvS']=$_POST['projeto'];
}
$id=$_SESSION['projetoConvS'];
include "detalhesProj.php";
echo "<h3>Sele&ccedil;&atilde;o de Modalidade</h3>";
include "../botoes.php";
?>
<br /><br />
<a href="../gestConv.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>