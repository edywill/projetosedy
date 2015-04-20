<?php 
require("valida.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" type="text/css" href="datatables/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="datatables/dataTables.jqueryui.css">
<link rel="stylesheet" href="colorbox.css" />
<script type="text/javascript" language="javascript" src="datatables/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/dataTables.jqueryui.js"></script>
<script src="jscolorb.js"></script>
<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
       	"pagingType": "full_numbers"
    } );
} );

	</script>
    <style type="text/css">
  .botao{
        font-size:12px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#06A62C;
        border:0px;
        width:80px;
        height:30px;
		border-radius:20px;
       }
</style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td></td>
<td colspan="2" width="1024px" align="center"></td><td></td>
</tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/topo_brasil.png" center top/></td><td></td></tr>
<td></td><td colspan="2" width="1024px" align="center"><a href="principal.php" style="border:hidden"><img src="imagens/topo_dnit.png" center top/></a></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" valign="middle" align="center" style="background:url(imagens/topoceu.png) no-repeat center top">
<table border="0" cellpadding="0" cellspacing="0" width="1105px"><tr><td width="3%"></td>
<td height='130' colspan="2" align="left">
<h3><font color="#000066" style="padding-left:5em">Bem vindo 
<?php 
echo $_SESSION['nomeUserSession'];
?></font></h3>
</td><td width="30%"></td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center" style="">

<table border="0" cellpadding="0" cellspacing="0" width="1104px" height="500">
<tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">

<?php 
include "menu.php";
?>

</td></tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top" align="center">
    <td height="174" valign="top" align="center">
    <form name='cadanalista' method="post" action="cadanalista.php">
<table width="100%" cellpadding='0' cellspacing='0' border='1' name='tabelacadastro'>
  <thead>
   <tr bgcolor="#DCDBDB">
     <td colspan="2" align="right"><font size="+3" color="#000066"><strong>CADASTRO DE ANALISTA</strong></font></tr>			
			</thead>
			<tbody>
			<tr align="left">
            <th width="20%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Nome:</font></th>
            <td bgcolor="#FFFFFF"><input type="text" name="nome" size="60" maxlength="32" value='' />
            </td></tr>
            
            <tr align="left">
            <th height="32" bgcolor="#DCDBDB"><font size="+1" color="#000066">E-mail:</font></th>
            <td bgcolor="#FFFFFF"><input type="text" name="email" size="60" maxlength="32" value='' /></td></tr>
            
            <tr align="left">
            <th height="32" bgcolor="#DCDBDB"><font size="+1" color="#000066">Usuário:</font></th>
            <td bgcolor="#FFFFFF"><input type="text" name="usuario" size="60" maxlength="32" value='' /></td></tr>
            
            <tr align="left">
            <th height="32" bgcolor="#DCDBDB"><font size="+1" color="#000066">Senha:</font></th>
            <td bgcolor="#FFFFFF"><input type="password" name="senha" size="60" maxlength="10" value='' /></td></tr>
			<tr align="left">
            <th height="32" bgcolor="#DCDBDB"><font size="+1" color="#000066">Perfil:</font></th>
            <td bgcolor="#FFFFFF">
            <input type="radio" name="perfil" value="usr" checked="checked"/> - Usuário Comum <br />
            <input type="radio" name="perfil" value="adm"/> - Administrador</td></tr>
            <tr align="left">
            <th height="32" bgcolor="#DCDBDB"><font size="+1" color="#000066">Localização:</font></th>
            <td bgcolor="#FFFFFF">
            <select name="estado">
            <option value="0" selected="selected">Selecione</option>
            <?php 
			$sqlEstados=odbc_exec($conCab,"SELECT * FROM estado");
			while($objEstados=odbc_fetch_object($sqlEstados)){
				echo "<option value='".$objEstados->id."'>".utf8_encode($objEstados->nome)."/".$objEstados->sigla."</option>";
				}
			?>
            </select>
            </td></tr>
            <tr align="left"><td height="33"><a href="admin.php"><input type="button" name="voltar" value='<<Voltar'/></a></td><td align="right"><input class="botao" type="submit" name="atualiza" value='Cadastrar'/></td></tr>
		    </tbody>
            </table>
            </form>
            </td></tr></table>
</td></tr>
<tr>
<td colspan="3" align="left" height="150px" style="background:url(imagens/rodapecentro.png) no-repeat">
</td></tr>
</table>
</td><td></td></tr>

</table>
<?php 
?>
</body>
</html>