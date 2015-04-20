<?php

require "../../conexaomysql.php";

$cia=$_GET['id'];

$sql = "delete from cia
    where id ='$cia'";

$qr = mysql_query($sql) or die(mysql_error());

$msg="Companhia não pode ser excluída!";

if ($qr == true){
    $msg = "Compainha Excluída!";
}

header ("Location:cadciaaerea.php?msg=$msg");

?>


