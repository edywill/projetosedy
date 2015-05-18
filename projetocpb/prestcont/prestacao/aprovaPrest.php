<?php 
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
include "../../function.php";
$countUpdateCi=0;
$tipo=$_POST['tp'];
$idSav=$_POST['id'];
$retorno=$_POST['retorno'];
$valida=0;
if($tipo=='recusa'){
	$status=utf8_decode('rec');
	$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
	if(!$updateSav){
		$valida=1;
		}
	}elseif($tipo=='aprov'){
		$acaoAprov='';
		if($_SESSION['cigamSav']=='CAV'){
			$acaoAprov="'".date("d/m/Y H:i:s")."'";
			$campoAprov='apsuper';
			}else{
				$acaoAprov="'".date("d/m/Y H:i:s")."'";
				$campoAprov='appresi';
				}
				$insertAprov=mysql_query("INSERT INTO prestsavaprov(id,idprest,".$campoAprov.") ('','".$idSav."',".$acaoAprov.")");
		$sqlAprovacao=mysql_query("SELECT * FROM prestsavaprov WHERE idprest='".$idSav."'");
		$presi='';
		$super='';
		while($objAprov=mysql_fetch_object()){
			if(!empty($objAprov->appresi)){
				$presi=1;
				}
			if(!empty($objAprov->apsuper)){
				$super=1;
				}
			}
		$updateSav=TRUE;
		if($presi>0 && $super>0){	
		$status=utf8_decode('pt');
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		}
		if(!$updateSav){
			$valida=1;
		  }
	}elseif($tipo=='envia'){
		$status=utf8_decode('pg');
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		if(!$updateSav){
			$valida=1;
		}
	}elseif($tipo=='apprest'){
		$status=utf8_decode('fi');
		$insertAprov=mysql_query("INSERT INTO prestsavaprov(id,idprest,apprest) ('','".$idSav."','".date("d/m/Y H:i:s")."')");
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		//Lembrar de atualizar os boardings Pass relativos à essa SAV e desbloquear o usuário, caso esteja bloqueado.
		$sqlDadosSav=mysql_fetch_array(mysql_query("SELECT savregistros.numci,registros.id AS idaut FROM prestsav LEFT JOIN savregistros ON savregistros.id=prestsav.savid
		LEFT JOIN registros ON savregistros.numci=registros.solicitacao WHERE prestsav.id='".$idSav."'"));
		$sqlRegistroBpPass=mysql_query("UPDATE registros SET bdpass WHERE solicitacao='".$sqlDadosSav['numci']."'");
	    $retiraBloqueio=mysql_query("DELETE FROM prestbloqueados WHERE idaut='".$sqlDadosSav['idaut']."'");
		//Fazer contagem de bloqueios e caso ele não possua, excluir do CIGAM também
		
		if(!$updateSav){
			$valida=1;
		}
	}
if($valida==0){
?>
       <script type="text/javascript">
       alert("Atualizado com sucesso!");
       window.location="<?php echo $retorno;?>";
       </script>
       <?php
}else{
	?>
       <script type="text/javascript">
       alert("Erro ao atualizar registro. Tente novamente!");
       window.location="<?php echo $retorno;?>";
       </script>
       <?php
	}
?>