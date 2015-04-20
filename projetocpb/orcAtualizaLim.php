<?php 
include "funcOrc.php";
if($_POST['insere']==0){
	atualizaConta(str_replace(',','.',$_POST['conta']),str_replace(',','.',$_POST['lei']),str_replace(',','.',$_POST['patcef']),str_replace(',','.',$_POST['patdiv']),str_replace(',','.',$_POST['siconv']),str_replace(',','.',$_POST['testesp']),str_replace(',','.',$_POST['timerio']),str_replace(',','.',$_POST['timesp']),str_replace(',','.',$_POST['jogosochi']),str_replace(',','.',$_POST['reserva']));
	}else{
		insereConta(str_replace(',','.',$_POST['conta']),str_replace(',','.',$_POST['lei']),str_replace(',','.',$_POST['patcef']),str_replace(',','.',$_POST['patdiv']),str_replace(',','.',$_POST['siconv']),str_replace(',','.',$_POST['testesp']),str_replace(',','.',$_POST['timerio']),str_replace(',','.',$_POST['timesp']),str_replace(',','.',$_POST['jogosochi']),str_replace(',','.',$_POST['reserva']));
		}

?>