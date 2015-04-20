<?php 
include "valida.php";
$nome=$_POST['nome'];
$email=$_POST['email'];
$usuario=$_POST['usuario'];
$senha=$_POST['senha'];
$perfil=$_POST['perfil'];
$estado=$_POST['estado'];
$selectUsuarioEmail=odbc_num_rows(odbc_exec($conCab,"SELECT id_login FROM login WHERE usuario='".$usuario."' OR email='".$email."'"));
if($selectUsuarioEmail<1){
	$selectMaxId=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id_login) as idmax FROM login"));
	$novoId=$selectMaxId['idmax']+1;
$execAtualiza=odbc_exec($conCab,"INSERT INTO login (id_login,nome,email,usuario,senha,perfil,estado) VALUES ('".$novoId."','".utf8_decode($nome)."','".utf8_decode($email)."','".utf8_decode($usuario)."','".utf8_decode($senha)."','".utf8_decode($perfil)."','".$estado."')");
if($execAtualiza){
	?>
    <script>alert('Criado com Sucesso!');top.location.href='admin.php';</script>
    <?php
	}else{
		echo "<script>alert('Ocorreu um erro. Tente novamente!');top.location.href='novoAnalista.php';</script>";
		}
}else{
	echo "<script>alert('Usuario encontra-se cadastrado.');top.location.href='admin.php';</script>";
	}

?>