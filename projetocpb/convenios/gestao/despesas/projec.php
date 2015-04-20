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
$id=$_POST['id'];
$titMod=$_POST['titMod'];
$tipoDesp=$_POST['tipoDesp'];
$_SESSION['tipoDespSessionConv']=$tipoDesp;
$idEvento=trim($_SESSION['idEvento']);
$_SESSION['idEventoSession']=$idEvento;
$editar=$_POST['editar'];
$_SESSION['editarSession']=$editar;
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];

$tipoDesp=$_SESSION['tipoDespSessionConv'];
$idEvento=$_SESSION['idEventoSession'];
$editar=$_SESSION['editarSession'];
	}
if(empty($idEvento)||$idEvento==''){
	?>
			   <script type="text/javascript">
               alert("Escolha um evento válido!");
               window.location=<?php echo "'index.php?id=$id&tipoid=$tipoId&titmod=$titMod'";?>;
               </script>
               <?php
	}
include "../projetos/detalhesProj.php";
echo "<br><h2>".utf8_encode($titMod)."</h2>";
include "../eventos/detalhesEventos.php";
echo "";
echo "<h3>".$editar."</h3>";
if($tipoDesp=='pas'){
	include 'passagem/index.php';
	}elseif($tipoDesp=='hos'){
		include 'hospedagem/index.php';
		}elseif($tipoDesp=='ali'){
			include 'alimentacao/index.php';
			}elseif($tipoDesp=='tra'){
				include 'transporte/index.php';
				}elseif($tipoDesp=='sgv'){
					include 'seguro/index.php';
					}elseif($tipoDesp=='rht'){
						include 'rh/index.php';
						}
?>
<a href="index.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>