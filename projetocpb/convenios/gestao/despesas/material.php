<?php 
if(!isset($_SESSION)){
session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript" src="../../../ajax/funcs.js"></script>
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" />
<script type='text/javascript' src='../../../jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#evento").autocomplete("../eventos/suggest_eventos.php", {
		  width: 315,
		  matchContains: true,
		  selectFirst: false
	  });
  });
function carregaEvento(valor) {
	document.getElementById('eventoid').value=document.getElementById('evento').value;
	}
</script>
</head>
<body>
<div id='box3'><br/>
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['tipoId'])){
$tipoId=$_POST['tipoId'];
$id=$_POST['idproj'];
$titMod=$_POST['titMod'];
$_SESSION['titModSession']=$titMod;
$editar=$_POST['evento'];
$_SESSION['editarEventoSession']=$editar;
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
$editar=$_SESSION['editarEventoSession'];
	}
include "../projetos/detalhesProj.php";
echo "<br><h2>".$titMod."</h2>";
echo "";
echo "<h3>Material</h3>";
	include 'material/index.php';
?>
<a href="../modalidades/index.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>