<?php 
session_start();
require "../../conect.php";
$idReg=$_POST['idatu'];
$sqlItensOrdem=mysql_fetch_array(mysql_query("SELECT aquipedidoitem.*,aquimat.cdmat FROM aquipedidoitem LEFT JOIN aquimat ON aquimat.id=aquipedidoitem.idmat WHERE aquipedidoitem.id='".$idReg."'"));

$textoDeleteItem="Deletado item ".$sqlItensOrdem['cdmat']." com quantidade de ".$sqlItensOrdem['qtd']." ".$sqlItensOrdem['obs']." da OS: ".$sqlItensOrdem['idos'].".";
$insereLogItem=mysql_query("INSERT INTO aquilog VALUES ('','".date("d/m/Y H:i:s")."','I','".$_SESSION['userAquis']."','".$textoDeleteItem."')");

$sqlReg=mysql_query("DELETE FROM aquipedidoitem where id='".$idReg."'");

if($sqlReg){
?>
       <script type="text/javascript">
       alert("Item deletado com sucesso.");
       window.location="novaOrdem.php";
       </script>
       <?php
}else{
		?>
       <script type="text/javascript">
       alert("Erro ao deletar o arquivo.");
       window.location="novaOrdem.php";
       </script>
       <?php
	
	}
?>
