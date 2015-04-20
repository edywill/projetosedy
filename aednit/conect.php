<?php
//Estabelecemos uma conexão com o Banco de Dados

//mysql_connect("Nome ou IP do servidor", "Usuário", "Senha");

$conn = mysql_connect("186.202.152.147", "aednit", "dnit14") or die("Impossível conectar");
//$conn = mysql_connect("localhost", "cpb_user", "rio2016") or die("Impossível conectar");
//Caso a conexão seja estabelecida corretamente, seleciona o Banco de Dados a ser usado

if($conn)

{

//mysql_select_db("bandareligare4", $conn);
mysql_select_db("aednit", $conn);

}


?>