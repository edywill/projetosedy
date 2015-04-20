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
require "conect.php";
include "function.php";
 $sqlCadastro="SELECT * FROM usuarios WHERE nome = '".$_POST['funcionario']."'";
 $rsCadastro = mysql_query($sqlCadastro) or die(mysql_error());
 $rstCadastro = mysql_fetch_array($rsCadastro);
 $sqlMod=mysql_query("SELECT * FROM modulo WHERE user='".$rstCadastro['id']."'");
 $gest=0;
	$convenios=0;
	$rh=0;
	$prestcont=0;
	$presidencia=0;
	$aquisic=0;
	$atletas=0;
		while($modObjs=mysql_fetch_object($sqlMod)){
		if($modObjs->mod=='gest'){
			$gest="checked='checked'";
			}
		if($modObjs->mod=='conv'){
			$convenios="checked='checked'";
			}
		if($modObjs->mod=='rh'){
			$rh="checked='checked'";
			}
		if($modObjs->mod=='prest'){
			$prestcont="checked='checked'";
			}
		if($modObjs->mod=='aqui'){
			$aquisic="checked='checked'";
			}
		if($modObjs->mod=='presi'){
			$presidencia="checked='checked'";
			}
			if($modObjs->mod=='atletas'){
			$atletas="checked='checked'";
			}
		  }
		  ?>
<br/>Altere os dados e módulos e clique em concluir.<br /><br />
<form action="alterarUsuario.php" method="post" name="form1" onsubmit="return validaCampo();" >
<table width="450" border="0">
  <tr>
    <td width="87" class="negrito">Funcionário: </td>
    <td><strong><?php echo $_POST['funcionario']; ?></strong><input name="funcionario" id="funcionario" type="hidden" value='<?php echo $rstCadastro['id']; ?>' readonly="readonly" class="input"/></td>
  </tr>
  <tr>
    <td class="negrito">Código CIGAM:</td>
    <td><input name="cigam" class="input" id="login"  size="15" type="text" value="<?php echo $rstCadastro['cigam']; ?>"/> </td>  </tr>
    <tr>
    <tr>
    <td class="negrito">Controle:</td>
    <td><input name="controle" class="input" id="login"  size="15" type="text" value="<?php echo $rstCadastro['controle']; ?>"/><br /><font size="-2">*Responsável por Controle no CIGAM </font><br /><br /></td>  </tr>
    <tr>
    <td class="negrito">Módulos:</td>
    <td><table border="0" width="100%">
    <tr><td>GESTOR</td><td><input type="checkbox" value='gest' name="gest" <?php echo $gest; ?>/></td></tr>
    <tr><td>PRESIDÊNCIA</td><td><input type="checkbox" name="presi" value='presi' <?php echo $presidencia; ?>/></td></tr>
    <tr><td>RH</td><td><input type="checkbox" name="rh" value='rh' <?php echo $rh; ?>/></td></tr>
    <tr><td>PRESTAÇÃO DE CONTAS</td><td><input type="checkbox"  name="prestcont" value='prestcont' <?php echo $prestcont; ?>/></td></tr>
    <tr><td>CONVÊNIOS</td><td><input type="checkbox" name="conv" value='conv' <?php echo $convenios; ?>/></td></tr>
    <tr><td>AQUISIÇÃO</td><td><input type="checkbox" name="aquis" value='aquis' <?php echo $aquisic; ?>/></td></tr>
    <tr><td>ATLETAS</td><td><input type="checkbox" name="atletas" value='atletas' <?php echo $atletas; ?>/></td></tr></table>
    </td>
     </tr>
  <tr>
    <td>&nbsp;</td> <td>&nbsp;</td>
    <td><input class='button' name="enviar" type="submit" value="Concluir" /></td>
  </tr>
</table>
<br />
<br />
<br />
</form>
</div>
</body>
</html>
