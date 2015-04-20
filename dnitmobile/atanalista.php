<?php 
include "valida.php";
$id=$_POST['id'];
$nome=$_POST['nome'];
$email=$_POST['email'];
$usuario=$_POST['usuario'];
$senha=$_POST['senha'];
$pefil=$_POST['perfil'];
$estado=$_POST['estado'];
$senhaAt='';
if(!empty($senha)){
	$senhaAt=",senha='".$senha."'";
	}

$execAtualiza=odbc_exec($conCab,"UPDATE login 
SET nome='".utf8_decode($nome)."', email='".$email."',usuario='".trim($usuario)."',perfil='".$pefil."',estado='".$estado."' ".$senhaAt." WHERE id_login='".$id."'");
if($execAtualiza){
	?>
    <script>alert('Atualizado com Sucesso!');top.location.href='admin.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='editarAnalista.php?iduser=".$id."';</script>";
		}
?>