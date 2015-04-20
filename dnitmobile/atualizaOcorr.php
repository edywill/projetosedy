<?php 
include "valida.php";
$id=$_GET['id'];
$tipoacao=$_GET['acao'];
$valida=0;
if($tipoacao=='R'){
	$execAtualiza=odbc_exec($conCab,"UPDATE report 
SET protocolo=null,status_id='1' WHERE id='".$id."'");
	}elseif($tipoacao=='I'){
		$execAtualiza=odbc_exec($conCab,"UPDATE report 
SET invalido='1' WHERE id='".$id."'");
		}elseif($tipoacao=='V'){
		$execAtualiza=odbc_exec($conCab,"UPDATE report 
SET invalido=null WHERE id='".$id."'");
		}else{
			echo "<script>alert('Selecione uma acao!');top.location.href='analiseOcorr.php';</script>";
	$valida=1;
			}


if($execAtualiza){
	?>
    <script>alert('Atualizado com Sucesso!');top.location.href='analiseOcorr.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='analiseOcorr.php';</script>";
		}
?>