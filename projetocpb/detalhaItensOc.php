<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>

<body>
<div id='box3'>
<?php 
header('Content-Type: text/html; charset=utf-8');
include "function.php";
$idOc=$_POST["id_ci"];
$seqOc=$_POST["seq_ci"];
$UserOcItensDetail=$_POST["userci"];
$idOcItensDetail=$_POST["idci"];
$dataOcItensDetail=$_POST["data_ci"];
$solicOcItensDetail=$_POST["solic_ci"];
$descOcItensDetail=$_POST["desc_ci"];
$valorOcItensDetail=$_POST["valor_ci"];
detalhamentoItensOc($idOc,$seqOc,$UserOcItensDetail, $idOcItensDetail,$dataOcItensDetail,$solicOcItensDetail,$descOcItensDetail,$valorOcItensDetail);
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");

//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>
</div>
</body>
</html>