<?php 
include "valida.php";
$id=$_GET['cod'];

$execAtualiza=odbc_exec($conCab,"DELETE FROM login WHERE id_login='".$id."'");
if($execAtualiza){
	?>
    <script>alert('Deletado com Sucesso!');top.location.href='admin.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='admin.php';</script>";
		}
?>