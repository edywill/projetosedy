<?php

require "../../conexaomysql.php";

$cia=$_POST['cia'];
$cia_desconto=0;
if(!empty($_POST['cia_desconto'])){
	$cia_desconto=str_replace(",",".",str_replace(".","",$_POST['cia_desconto']));
	}

$sql = "insert into cia
    (nome, desconto) values
    ('$cia', $cia_desconto);";


//$r = DataBaseSuporte::mysqlQuery($sql);
//DataBaseSuporte::close();

 $qr = mysql_query($sql) or die(mysql_error());

$msg="Companhia não Cadastrada!";

if ($qr == true){
    $msg = "Compainha Cadastrada!";
	?>
	<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
		alert ("Atualizado com sucesso!")
	</SCRIPT>
	<?php
}

header ("Location:cadciaaerea.php?msg=$msg");

?>


