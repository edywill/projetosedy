<?php 
session_start();
require "../../conect.php";
$idOs=$_POST['idOrdem'];
$sqlDadosOrdem=mysql_fetch_array(mysql_query("SELECT * FROM aquiordem WHERE id='".$idOs."'"));

$montaLogOrdem="Deletado ordem de servi&ccedil;o n&ordm; ".$idOs.", com as seguintes informa&ccedil;&otilde;es: SRP ".$sqlDadosOrdem['idreg'].", Doc. Interno de Refer&ecirc;ncia: ".$sqlDadosOrdem['doc'].", Dados de Faturamento: ".$sqlDadosOrdem['fatura'].", Descri&ccedil;&atilde;o: ".$sqlDadosOrdem['descric'].", Valor R$".$sqlDadosOrdem['vlunit'].", Data de entrega ".$sqlDadosOrdem['dtentrega'].", Complemento ".$sqlDadosOrdem['comp'].", Emissor ".$sqlDadosOrdem['emissor']." e Evento ".$sqlDadosOrdem['evento'].".";
$insereLog=mysql_query("INSERT INTO aquilog VALUES ('','".date("d/m/Y H:i:s")."','O','".$_SESSION['userAquis']."','".$montaLogOrdem."')");

$sqlItensOrdem=mysql_query("SELECT aquipedidoitem.*,aquimat.cdmat FROM aquipedidoitem LEFT JOIN aquimat ON aquimat.id=aquipedidoitem.idmat WHERE aquipedidoitem.idos='".$idOs."'");

$textoDeleteItem="";
while($objItensOrdem=mysql_fetch_object($sqlItensOrdem)){
	$textoDeleteItem.="Deletado item ".$objItensOrdem->cdmat." com quantidade de ".$objItensOrdem->qtd." ".$objItensOrdem->obs." da OS: ".$idOs.".<br>";
	}
$insereLogItem=mysql_query("INSERT INTO aquilog VALUES ('','".date("d/m/Y H:i:s")."','I','".$_SESSION['userAquis']."','".$textoDeleteItem."')");

$sqlReg=mysql_query("DELETE FROM aquipedidoitem where idos='".$idOs."'");
$sqlReg=mysql_query("DELETE FROM aquiordem where id='".$idOs."'");


if($sqlReg){
?>
       <script type="text/javascript">
       alert("Ordem deletada com sucesso.");
       window.location="index.php";
       </script>
       <?php
}else{
		?>
       <script type="text/javascript">
       alert("Erro ao deletar o arquivo.");
       window.location="index.php";
       </script>
       <?php
	
	}
?>
