<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.titulo {
	font-size: 18px;
}
.titulo_footer {
	font-weight: bold;
	text-align: center;
}
-->
</style>

<style media="print">
.botao {
display: none;
}
</style>

</head>

<body>
<?php
header('Content-Type: text/html; charset=utf-8');
require "conect.php";
echo "<div id='link2'><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";
$sqlNome=mysql_query("SELECT nome FROM usuarios WHERE usuario='".$_GET['user']."'");
$array=mysql_fetch_array($sqlNome);
function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}
?>
<h1 align="center">D E C L A R A &Ccedil; &Atilde; O</h1>
<p align="center"><strong>&nbsp;</strong></p>
<p align="center"><strong>&nbsp;</strong></p>
<p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Declaro  para os devidos fins, que tendo tomado conhecimento da <strong>Conven&ccedil;&atilde;o Coletiva de Trabalho 2014/2015 </strong>de nossa categoria,  firmada entre a Federa&ccedil;&atilde;o Nacional de Cultura &ndash; FENAC e o Sindicato dos  Empregados em Entidades Culturais, Recreativas, de Assist&ecirc;ncia Social e de  Orienta&ccedil;&atilde;o e Forma&ccedil;&atilde;o Profissional de Bras&iacute;lia &ndash; SENALBA, venho me opor ao  desconto de <strong>2% (dois por cento)</strong> <strong>no m&ecirc;s</strong> <strong>de Maio e 2% no m&ecirc;s de Novembro / 2014 </strong> da Contribui&ccedil;&atilde;o Assistencial conforme  preceitua a <strong>Cl&aacute;usula 42&ordf;</strong> da  Conven&ccedil;&atilde;o em ep&iacute;grafe.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Por  ser verdade e para que produza seus efeitos, firmo a presente.</p><p></p><br /><br />
<p align="center">
Bras&iacute;lia  &ndash; DF,<?php
switch (date("m")){
 
case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;
}

echo "______ de _______________ de _________"; ?></p>
<br /><br /><br />
<p align="center">______________________________________________________</p>
<p align="center"><strong><?php echo $array['nome'];?></strong></p>

<?php echo "<div id='link2'><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";
?>
</body>
</html>
