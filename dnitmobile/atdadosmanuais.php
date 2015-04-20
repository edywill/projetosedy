<?php 
include "valida.php";
$id=$_POST['id'];
$br=$_POST['br'];
$km=$_POST['km'];
$uf=$_POST['uf'];

$execAtualiza=odbc_exec($conCab,"UPDATE report 
SET estrada_br='".utf8_decode($br)."', br_km='".$km."',estado_id='".trim($uf)."' WHERE id='".$id."'");
if($execAtualiza){
	?>
    <script>alert('Atualizado com Sucesso!');top.location.href='analiseOcorr.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='dadosManuais.php?id=".$id."';</script>";
		}
?>