<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
.header_folha {
	font-size: small;
}
.negrito {
	font-weight: bold;
	font-size: 20px;
}
.grande {
	font-size: 15px;
}
.menor {
	font-size: 10px;
}
.small {
	font-size: small;
}
.pequeno{
	font-size: 13px;
	font-weight: bold;
}

</style>
<style media="print">
.botao {
display: none;
}
.botao {
display: none;
}
body{
	font:90% verdana; 
	color:#555;
}
#tabela table{
	font-family:verdana;
	
	border-collapse:collapse;
}



</style>


</head>

<body>
<div id='folha'>
<?php 
include 'function.php';
$loginFolha = $_POST['nome'];
$mes = $_POST['mes'];
$ano = $_POST['ano'];
$emailFolha=buscaEmail($loginFolha);

if(empty($mes)){
        alerta("Campo mês em branco, por favor escolha o mês.", "principal.php");
               }elseif(empty($ano)){
				    alerta("Campo ano em branco, por favor digite o ano.", "principal.php");
				   }

echo "<div id='link'><a href='javascript:;'  class='botao' onclick='window.print();return false;  '><strong>Imprimir</strong></a></div>";



montaCabecalho($emailFolha,$mes,$ano);
montaDias($mes,$ano,$emailFolha);
montaRodape($emailFolha);

echo "<div id='link'><a href='javascript:;'  class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";

function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');window.top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}
?>
</div>
</body>
</html>