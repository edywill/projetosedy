<?php
$subject= "Olá!"; // Assunto.
$to= "edywill@hotmail.com"; // Para.
$body= "Esse é o meu demo para ver se a função mail utilizando sendmail do PHP no XAMPP versão 1.7.3 funciona"; // corpo do texto.
if (mail($to,$subject,$body))
echo "e-mail enviado com sucesso!";
else
echo "e-mail não enviado!";
?>