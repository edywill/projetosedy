<?php 
require "conectsqlserverci.php";
$ci=$_GET['ci'];
$sqlJust="Select
  TESOLJUST.justificativa
From
  TESOLJUST (nolock)
  where solicitacao=".$ci."";
$resListaJust = odbc_exec($conCab, $sqlJust) or die(odbc_error());
$arrayLista=odbc_fetch_array($resListaJust);
echo "<html>
<body>
<strong>CI Nº: ".$ci."</strong>
<textarea name='just' cols='4' rows='5'>".$arrayLista['justificativa']."</textarea>
</body>
</html>";
?>
