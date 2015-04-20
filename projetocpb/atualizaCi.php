<?php 
include "function.php";
$idCi=$_POST["id_ci"];
$UserCi=$_POST["user_ci"];
$descricao=$_POST["desc_ci"];
$controle=$_POST["controle"];
$pgRetorno="ciweb";
$idTipo='IN';
updateCi($idCi,$UserCi,$descricao,$controle,$pgRetorno,$idTipo);
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");

//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>