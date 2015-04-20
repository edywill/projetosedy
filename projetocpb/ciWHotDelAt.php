<?php
require "conectsqlserverci.php";
session_start();
$solicitacao=$_GET['id'];

$sqlRPA=odbc_exec($conCab,"SELECT cd_solicitacao,sequencia FROM TEITEMSOLHOTEL(nolock) WHERE id_registro=".$solicitacao."") or die("<p>".odbc_errormsg());
$arrayRPA=odbc_fetch_array($sqlRPA);
$sqlRPAItem=odbc_exec($conCab,"SELECT quantidade FROM COISOLIC (nolock) WHERE Cd_solicitacao=".$arrayRPA['cd_solicitacao']." AND Sequencia=".$arrayRPA['sequencia']."") or die("<p>".odbc_errormsg());
$arrayRpaItem=odbc_fetch_array($sqlRPAItem);
$novaQtd=(float)$arrayRpaItem['quantidade']-1;
$updItem=odbc_exec($conCab,"UPDATE COISOLIC SET quantidade=".$novaQtd.", qt_saldo=".$novaQtd." WHERE Cd_solicitacao=".$arrayRPA['cd_solicitacao']." AND sequencia=".$arrayRPA['sequencia']."") or die("<p>".odbc_errormsg());
$delItem="DELETE FROM TEITEMSOLHOTEL WHERE id_registro='".$solicitacao."'";
$resdelItem=odbc_exec($conCab, $delItem) or die("<p>".odbc_errormsg()); 
 if($resdelItem){
?>
       <script type="text/javascript">
       alert("Exclu\u00eddo com sucesso");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
}else{
	?>
       <script type="text/javascript">
       alert("Ocorreu um erro.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
	}
?>
