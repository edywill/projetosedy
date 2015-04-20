<?php 
 header('Content-type: image/png');
 $servidor = "localhost"; 
//Aqui é o nome de usuário do seu banco de dados, root é o servidor inicial e básico de todo servidor, mas recomenda-se não usar o usuario root e sim criar um novo usuário 
$usuario = "windata1"; 
//Aqui colocamos a senha do usuário, por padrão o usuário root vem sem senha, mas é altamente recomenável criar uma senha para o usuário root, visto que ele é o que tem mais privilégios no servidor 
$senha ="12345"; 
$dbname="dnitmovel";
 $HndCon = odbc_connect("host=".$servidor." port=5432 dbname=".$dbname." user=".$usuario." password=".$senha."") or die ("Não foi possivel conectar ao servidor PostGreSQL"); 
 $HndRes=odbc_exec($HndCon,"SELECT info.foto FROM public.info where info.id='370'"); 
 $Linha=odbc_fetch_array($HndRes,0); 
//echo $Linha['foto'];
//echo "<img src='data:image/jpeg,".base64_decode($Linha['foto'])."' />";
echo base64_decode($Linha['foto']);
?> 