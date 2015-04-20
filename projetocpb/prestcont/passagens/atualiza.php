<?php

require "../../conexaomysql.php";

$cia=$_POST['id'];
$nome=$_POST['nome'];
$desc=0;
if(!empty($_POST['desconto'])){
$desc=$_POST['desconto'];
}

$sql = "update cia set nome = '".$nome."' , desconto = ".str_replace(",",".",str_replace(".","",$desc))."  
    where id ='$cia'";

$qr = mysql_query($sql) or die(mysql_error());

$msg="Companhia não pode ser atualizada!";

if ($qr){
	?>
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
		alert ("Atualizado com sucesso!")
	</SCRIPT>
<?php
}

header ("Location:cadciaaerea.php?msg=$msg");

?>