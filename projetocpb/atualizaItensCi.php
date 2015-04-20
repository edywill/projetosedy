<?php 
header('Content-Type: text/html; charset=utf-8');
include "function.php";
$idCi=$_POST["id_ci"];
$UserCi=$_POST["user_ci"];
$SeqCi=$_POST["seq_ci"];

updateItensCi($idCi,$UserCi,$SeqCi);
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");

//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>