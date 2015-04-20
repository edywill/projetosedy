<?php
$nome=$_POST["func"];
$login2=$_POST["login"];
$cigam=$_POST['cigam'];
if (preg_match("/@/",$login2)) {
	$email=$login2;    
} else {
    $email=$login2."@cpb.org.br";
}


include "function.php";
$nome2=convertem($nome, 1);
$modulos[]=0;
$cont=0;
if(isset($_POST['gest'])){
	$cont++;
	$modulos[$cont]='gest';
	}
if(isset($_POST['presi'])){
	$cont++;
	$modulos[$cont]='presi';
	}
if(isset($_POST['rh'])){
	$cont++;
	$modulos[$cont]='rh';
	}
if(isset($_POST['prestcont'])){
	$cont++;
	$modulos[$cont]='prest';
	}
if(isset($_POST['conv'])){
	$cont++;
	$modulos[$cont]='conv';
	}
if(isset($_POST['aquis'])){
	$cont++;
	$modulos[$cont]='aquis';
	}
if(isset($_POST['atletas'])){
	$cont++;
	$modulos[$cont]='atletas';
	}
inserirFuncionario($nome2,$login2,$email,$cigam,$modulos,$cont);

?>