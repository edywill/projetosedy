<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
//include "function.php";
include "mb.php";
require "conectsqlserverciprod.php";
require('conexaomysql.php');

$idCi=$_POST["id_ci"];
$resp=$_POST["resp"];
$controle=$_POST["controle"];

$selectCiWeb="SELECT idci FROM ciweb WHERE idci='".$idCi."'";
$resultadoCiWeb =  mysql_query($selectCiWeb) or die(mysql_error());
$arrayCiWeb=mysql_fetch_array($resultadoCiWeb);
if(empty($arrayCiWeb)){
$selectResp="INSERT INTO ciweb VALUES('','".$idCi."','".$resp."','".$controle."')";
$resultadoResp =  mysql_query($selectResp) or die(mysql_error());

if($resultadoResp){
	?>
       <script type="text/javascript">
	     alert("Atualizado com sucesso!");
         window.location.href = 'home.php';
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
	     alert("Ocorreu um erro. Tente novamente!");
        history.back();
       </script>
       <?php
		}
}else{
	$updtResp="UPDATE ciweb SET resp='".$resp."',situacao='".$controle."' WHERE idci='".$idCi."'";
	$updtResp1 =  mysql_query($updtResp) or die(mysql_error());

if($updtResp1){
	?>
       <script type="text/javascript">
	     alert("Atualizado com sucesso!");
         window.location.href = 'home.php';
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
	     alert("Ocorreu um erro. Tente novamente!");
        history.back();
       </script>
       <?php
		}
	
	
	}
//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>