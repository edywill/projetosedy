<?php
require "conectsqlserverci.php";
session_start();
$solicitacao=$_GET['id'];
$sqlLancamento=odbc_exec($conCab, "SELECT cd_lancamento FROM TEITEMSOLRPA (nolock) WHERE cd_lancamento>0 AND id_registro='".$solicitacao."'");
$numRows=odbc_num_rows($sqlLancamento);
if($numRows<1){
$sqlRPA=odbc_exec($conCab,"SELECT cd_solicitacao,sequencia,valor FROM TEITEMSOLRPA(nolock) WHERE id_registro=".$solicitacao."") or die("<p>".odbc_errormsg());
$arrayRPA=odbc_fetch_array($sqlRPA);
$sqlRPAItem=odbc_exec($conCab,"SELECT quantidade,pr_unitario FROM COISOLIC (nolock) WHERE Cd_solicitacao=".$arrayRPA['cd_solicitacao']." AND Sequencia=".$arrayRPA['sequencia']."") or die("<p>".odbc_errormsg());
$arrayRpaItem=odbc_fetch_array($sqlRPAItem);
$valorItemRpa=(float)$arrayRpaItem['pr_unitario']*$arrayRpaItem['quantidade'];
$valorRpa=(float)$arrayRPA['valor'];
$novaQtd=(float)$arrayRpaItem['quantidade']-1;
if($novaQtd==0){
$novoValorItem=0;	
	}else{
$novoValorItem=($valorItemRpa-$valorRpa)/$novaQtd;
}
$updItem=odbc_exec($conCab,"UPDATE COISOLIC SET quantidade=".$novaQtd.", qt_saldo=".$novaQtd.", pr_unitario=".$novoValorItem." WHERE Cd_solicitacao=".$arrayRPA['cd_solicitacao']." AND sequencia=".$arrayRPA['sequencia']."") or die("<p>".odbc_errormsg());

$delItem="DELETE FROM TEITEMSOLRPA WHERE id_registro='".$solicitacao."'";
$resdelItem=odbc_exec($conCab, $delItem) or die("<p>".odbc_errormsg()); 
 if($resdelItem && $updItem){
?>
       <script type="text/javascript">
       alert("Exclu\u00eddo com sucesso");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
}else{
	?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao excluir o item.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
	}
}else{
	?>
       <script type="text/javascript">
       alert("O item possui lan\u00e7amento financeiro vinculado.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
	}
?>
