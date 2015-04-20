<?php 
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";

$sqlInsertPrest=mysql_query("INSERT INTO prestsav(savid,data,obs) values(".$_POST['sav'].",'".date("d/m/Y")."','".utf8_decode($_POST['obs'])."')");
if($sqlInsertPrest){
	echo "OK - <a href='prestUser.php'>Voltar</a>";
	}else{
		echo "Erro - <a href='prestUser.php'>Voltar</a>";
		}

?>