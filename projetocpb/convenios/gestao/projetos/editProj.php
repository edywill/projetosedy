<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
<link rel="stylesheet" href="../../../jqueryDown/jquery-ui.css" />
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../../../jqueryDown/jquery-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-ui.css" /> 
<script>
  $(function() {
	  $( "#inicvig" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimvig" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
</head>

<body>
<div id="box3">
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
echo $tituloEditProjeto;
$sqlProj=mysql_query("SELECT * FROM convprojetos WHERE id='".$_POST['idEdit']."'");
$arrayProj=mysql_fetch_array($sqlProj);
$titulo=trim($arrayProj['titulo']);
$nconv=trim($arrayProj['numconv']);
$nprop=trim($arrayProj['numprop']);
$inicvig=trim($arrayProj['iniciovig']);
$fimvig=trim($arrayProj['fimvig']);
$titButton='Atualizar';
echo "<form action='atualizaProjeto.php' name='formProjConv' method='post'>
<input type='hidden' name='id' value='".$_POST['idEdit']."'/>";
include "cadastraProj.php";
echo "</form>";
?>

</div>
</body>
</html>