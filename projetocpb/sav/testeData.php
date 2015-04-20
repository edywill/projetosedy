<?php 
date_default_timezone_set('America/Sao_Paulo');
$inicio='26/11/2014';
$fim='05/12/2014';
$inicio = date_create_from_format('d/m/Y', $inicio);
$fim = date_create_from_format('d/m/Y', $fim);
$intervalo = $inicio->diff($fim);
echo $intervalo->d;
?>