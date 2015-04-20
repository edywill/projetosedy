<?php
include 'function.php';

$funcionario8=$_POST['func'];
$gestor9=$_POST['comboGestores'];

inserirSolic13($funcionario8,$gestor9);

//Alerta
function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');window.top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}
?>