<?php
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<style type="text/css">
.botao01{
	background: -webkit-linear-gradient(bottom, #E0E0E0, #057fce 70%);
	background: -moz-linear-gradient(bottom, #E0E0E0, #057fce 70%);
	background: -o-linear-gradient(bottom, #E0E0E0, #057fce 70%);
	background: -ms-linear-gradient(bottom, #E0E0E0, #057fce 70%);
	background: linear-gradient(bottom, #E0E0E0, #057fce 70%);
	border: 1px solid #CCCCCE;
	border-radius: 3px;
	box-shadow: 0 3px 0 rgba(0, 0, 0, .3),
                   0 2px 7px rgba(0, 0, 0, 0.2);
	color: #FFF;
	display: block;
	font-family: "Trebuchet MS";
	font-size: 14px;
	font-weight: bold;
	line-height: 25px;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	text-shadow:1px 1px 0 #FFF;
	padding: 5px 15px;
	position: relative;
	width: 80px;
}
 
.botao01:before{
     border: 1px solid #FFF;
     border-radius: 3px;
     box-shadow: inset 0 -2px 12px -4px rgba(70, 70, 70, .2),
                   inset 0 3px 2px -1px rgba(255, 255, 255, 1);
     content: "";
     bottom: 0;
     left: 0;
     right: 0;
     top: 0;
     padding: 5px;
     position: absolute;
    }
 
    .botao01:after{
     background: rgba(255, 255, 255, .4);
     border-radius: 2px;
     content: "";
     bottom: 15px;
     left: 0px;
     right: 0px;
     top: 0px;
     position: absolute;
    }
 .botao01:active{
     box-shadow: inset 0 0 7px rgba(0, 0, 0, .2);
     top: 4px;
    }
    .botao01:active:before{
     border: none;
     box-shadow:none;
    }
</style>
</head>
<body>
<form action="login.php" method="post" name="login">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td></td>
<td width="1024px" colspan="2" align="center"><img src="imagens/topo_brasil.png" /></td><td></td>
</tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/topo_dnit.png" /></td><td></td></tr>
<tr ><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/centro1.png" /></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" height="218px" valign="middle" align="center" style="background:url(imagens/centro2.png) no-repeat center;">
<table border="0" width="1024px" height="45%" cellpadding="0" cellspacing="1">
<tr><td width="678" height="88"></td><td width="342" valign="bottom">
      <input type="text" name="usuario" size="30" style="height:25px;-moz-border-radius: 10px;-webkit-border-radius: 10px;"/>
   </td></tr></table>
    <table border="0" width="1024px" height="55%" cellpadding="0" cellspacing="1">
<tr><td width="678" height="38"></td><td width="342" valign="top">
  <input type="password" name="senha" size="30" style="height:25px; -moz-border-radius: 10px;-webkit-border-radius: 10px;" />
</td></tr>
<tr><td width="678"></td><td width="342" valign="top" align="center">
  <input type="submit" value="ENTRAR" name="entrar" class="botao01"/>
</td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/centro3l.png" /></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/rodape1.png" /></td><td></td></tr>

</table>
</form>
</body>
</html>
