<?php 
session_start();
if(empty($_SESSION['usuario'])){
	alerta("Efetue o login.", "index.php");
	}else{
		require ("conexaobd/conectbd.php");
		}
function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'],$_SESSION['usuario']);
 
}
?>