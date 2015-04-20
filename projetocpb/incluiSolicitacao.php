<?php
include 'function.php';

$funcionario8=$_POST['func'];
$dataInicio=$_POST['data3'];
$dataFinal=$_POST['data4'];
$gestor=$_POST['comboGestores'];
$radio=$_POST['radio'];
if(!isset($_POST['ab10'])){
$abono="no";
}else{
	$abono=$_POST['ab10'];
	if($dataFinal>20){
	  	   alerta("Solicitar Abono Pecuniario apenas para pedidos iguais ou inferiores a 20 dias", "principal.php");
	}
	}


if(empty($dataInicio)){
        alerta("Campo Data Inicial em branco, por favor escolha o dia.", "principal.php");
               }elseif(empty($dataFinal)){
				    alerta("Campo Dia em branco, por favor escolha o dia.", "principal.php");
				   }elseif($dataFinal<10){
					   alerta("Quantidade de Dias n\u00e3o pode ser inferior a 10 dias.", "principal.php");
					   }elseif(empty($gestor)){
					    alerta("Por favor, selecione o seu gestor.", "principal.php");
					   }

inserirSolic($funcionario8,$dataInicio,$dataFinal,$gestor,$abono,$radio);

//Alerta
function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');window.top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}
?>