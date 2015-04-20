<?php 
include "valida.php";
$id=$_POST['id'];
$nome=$_POST['nome'];
$email=$_POST['email'];

$execAtualiza=odbc_exec($conCab,"UPDATE device 
SET name='".utf8_decode($nome)."', email='".$email."' WHERE id='".$id."'");
if($execAtualiza){
	?>
    <script>alert('Atualizado com Sucesso!');top.location.href='usuarios.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='editarUser.php?iduser=".$id."';</script>";
		}
?>