<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
    <script type="text/javascript" src="jquery/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="jquery/js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript"> 
 
		jQuery(document).ready(function(){
			$('#funcionario').autocomplete({source:'suggest_funcionario.php', minLength:1});
		});
 
	</script>
    <script language="Javascript">
function showDiv(div)
{
document.getElementById("1").className = "invisivel";
document.getElementById(div).className = "visivel";
}
</script>
<style>
.invisivel { display: none; }
.visivel { visibility: visible; }
</style>
    
    
 
	<link rel="stylesheet" href="jquery/css/smoothness/jquery-ui-1.8.2.custom.css" /> 
	<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style> 
    </head>
    <style>
        span.reference{
            position:fixed;
            left:5px;
            top:5px;
            font-size:10px;
            text-shadow:1px 1px 1px #fff;
        }
        span.reference a{
            color:#555;
            text-decoration:none;
			text-transform:uppercase;
        }
        span.reference a:hover{
            color:#000;
            
        }
        h1{
            color:#ccc;
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
    </style>
<style type="text/css">
.negrito {
	font-weight: bold;
}
</style>
</head>

<body>
<div id='box2'>
<?php 
//include "valida.php";
include "function.php";
$usuario3=$_GET['usuario'];
 ?>
<br/> Selecione o Usuário que deseja alterar o perfil:<br /><br />
<form action="alterUsuarioCont.php" method="post" name="form1" onsubmit="return validaCampo();" >
<table width="350" border="0">
  <tr>
    <td width="87" class="negrito">Funcionário: </td>
    <td><input name="funcionario" id="funcionario" type="text" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td> <td>&nbsp;</td>
    <td><input class='button' name="enviar" type="submit" value="enviar" /></td>
  </tr>
</table>
<br />
<br />
<br />
</form>
</div>
</body>
</html>
