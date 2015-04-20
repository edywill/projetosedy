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
.mensagem {
display: none;
}
body{
	font:90% arial; 

}
</style>

</head>

<body>
<?php
header('Content-Type: text/html; charset=utf-8');
echo "<div id='outro' style='display: none;'>";
include 'function.php';
if($_POST["mesCh"]=='13-1'){
	$mesCh='51';
	}elseif($_POST["mesCh"]=='13-2'){
		$mesCh='52';
	}else{
$mesCh=$_POST["mesCh"];
}
$anoCh=$_POST["anoCh"];
$loginRec=$_POST["nomeCh"]; //esse dado vem do Post oculto, baseado na comparaÃ§Ã£o com o login.
$loginRecibo=buscaEmail($loginRec);
echo "</div>";
if(empty($mesCh)){
        alerta("Campo mês em branco, por favor escolha o mês.", "principal.php");
               }elseif(empty($anoCh)){
				    alerta("Campo ano em branco, por favor digite o ano.", "principal.php");
				   }

echo "<br><br><br>
    
	<div style='border:solid 2px;  background-color:#658BF3;  -webkit-border-radius: 30px 0px 30px 0px;  padding: 0px 17px 0px 17px; box-shadow: 5px 5px 3px 2px #AFB2B0;' id='msnsagem' class='mensagem'>
		<p align='justify' style='color:white;'>A assinatura do contracheque não será mais obrigatória. A visualização será a comprovação de que você está ciente do valor recebido. 
		Caso não esteja de acordo, entre em contato com o RH.</p>
    </div>
	<br>
	<div id='link2'><a href='javascript:;' class='botao' onclick='window.print();return false'>
		<strong>Imprimir</strong></a>
	</div>";

if($mesCh=='51' || $mesCh=='52'){
	montaCentroContCheq13($anoCh,$loginRecibo,$mesCh);	
	}else{
montaCabecalhoContCheq($mesCh,$anoCh,$loginRecibo);
montaCentroContCheq($mesCh,$anoCh,$loginRecibo);
escreveRodapeContCheq($mesCh,$anoCh,$loginRecibo);
}

echo "<div id='link2'><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";

function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}
?>
</body>
</html>
