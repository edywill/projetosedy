<?php //Aqui colocamos o servidor em que está o nosso banco de dados, no nosso exemplo é a conexão com um servidor local, portanto localhost 

 $conCab = odbc_connect("DRIVER={SQL Server}; SERVER=10.100.10.198; DATABASE=db_dnitmovel;", "dnitmovel","dnitmovel");
//caso a conexão seja efetuada com sucesso, exibe uma mensagem ao usuário 
?>