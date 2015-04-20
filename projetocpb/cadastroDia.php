<?php
include 'function.php';

$dia=$_POST['dia'];
$mes=$_POST['mes'];
$ano=$_POST['ano'];
$status=$_POST['status'];
if($status=="Sabado"){
$idStatus=1;
}elseif ($status=="Domingo"){
	$idStatus=2;
	}elseif ($status=="Feriado"){
	     $idStatus=3;
	   }else{
		   $idStatus=4;
	   }

inserirDia($dia,$mes,$ano,$idStatus);

?>