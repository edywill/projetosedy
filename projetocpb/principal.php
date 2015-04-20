<?php
include "valida.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Intranet - CPB</title>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<script type="text/javascript">
         function calcHeight()
         {
         var innerDoc = (document.getElementById('Frame1').contentDocument) ? document.getElementById('Frame1').contentDocument : document.getElementById('Frame1').contentWindow.document;
        if (innerDoc.body.offsetHeight) //ns6 syntax
          {
             document.getElementById('Frame1').height = innerDoc.body.offsetHeight + 110; //Extra height FireFox
          }
          else if (document.getElementById('Frame1').Document && document.getElementById('Frame1').body.scrollHeight) //ie5+ syntax
          {
             document.getElementById('Frame1').height = document.getElementById('Frame1').body.scrollHeight+ 400;
          }
		 //change the height of the iframe
         //document.getElementById('Frame1').style.height=
         //the_height+'px';
		 //document.getElementById('Frame1').height=
         //the_height;
		 //alert(the_height);
         }
		 
</script>
</head>

<body onload="calcHeight();">
	<div  style='position:relative; top:0px; left:0px;'>
		<img width="100%" src="imagens/topo_new1.png" border=0>
	</div>

<div id="container">
<!--<table width="100%" height="20" border="0">
<tr><td width="100%" align="center"><a href="principal.php"><img src="imagens/bannercpb2.png" width="1100" height="215" align="center" border="0" /></a></td>
<!--<td width="20%"></td>
</tr>
</table>-->

<table width="100%" height="100%" border="0">
<tr>
<td width="20%" valign="top">
<table width="100%" height="100%" border="0"><tr><td align="left" valign="top"><?php

include "menu.php";
     if(!isset($_SESSION['usuario']))
		header("Location: loginad.php");
montaMenu($_SESSION['usuario']);
?><br />
<form  action="logout.php" method="post" name="logout">
  <div id='sair'>
	<input class='button' name="sair" type="submit" value="Sair" />
  </div>
  <?php verifPendentes($_SESSION['usuario']); ?>
	</form></td></tr></table>
    </td>
    <td width="80%" valign="top"><iframe name="Frame1" id="Frame1" class="frame1" src="home.php" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden" height="900" width="100%" frameborder="0" scrolling="no" onmousemove='calcHeight()' onload='calcHeight()' onmouseover='calcHeight()'></iframe>
    </td></tr>
</table>
</div>
</div>
    <div  style='position:relative; bottom:0%; left:0px;'>
		<img width="100%" src="imagens/rodape_new1.png" border=0>
	</div>
</body>
</html>