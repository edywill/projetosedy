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
			$acaoAprov="'".date("d/m/Y H:i:s")."'";
			$campoAprov='apsuper';
				$insertAprov=mysql_query("INSERT INTO prestsavaprov(id,idprest,".$campoAprov.") VALUES('','".$idSav."',".$acaoAprov.")");
		$sqlAprovacao=mysql_query("SELECT * FROM prestsavaprov WHERE idprest='".$idSav."'");
		$super='';
		$updateSav=TRUE;
				$super=1;
				$status=utf8_decode('fi');
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
				$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		//Lembrar de atualizar os boardings Pass relativos à essa SAV e desbloquear o usuário, caso esteja bloqueado.
		$sqlDadosSav=mysql_fetch_array(mysql_query("SELECT savregistros.numci,registros.id AS idaut FROM prestsav LEFT JOIN savregistros ON savregistros.id=prestsav.savid
		LEFT JOIN registros ON savregistros.numci=registros.solicitacao WHERE prestsav.id='".$idSav."'"));
		$sqlRegistroBpPass=mysql_query("UPDATE registros SET bdpass WHERE solicitacao='".$sqlDadosSav['numci']."'");
	    $sqlCdEmpBloq=mysql_fetch_array(mysql_query("SELECT cdempres FROM prestbloqueados WHERE idaut='".$sqlDadosSav['idaut']."'"));
		$retiraBloqueio=mysql_query("DELETE FROM prestbloqueados WHERE idaut='".$sqlDadosSav['idaut']."'");
		$countBloqueios=mysql_num_rows(mysql_query("SELECT cdempres FROM prestbloqueados WHERE cdempres='".$sqlCdEmpBloq['cdempres']."'"));
		
		if($countBloqueios<1){
		$atualizaCigam=odbc_exec($conCab2,"DELETE FROM TE_BLOQUEIOBPASS WHERE Empresa='".trim($sqlCdEmpBloq['cdempres'])."'");
		//Faz contagem de bloqueios e caso ele não possua, exclui do CIGAM também
		}
		
		if(!$updateSav){
			$valida=1;
		  }
	}elseif($tipo=='envia'){
		$status=utf8_decode('pt');
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		if(!$updateSav){
			$valida=1;
		}
	}elseif($tipo=='apprest'){
		$status=utf8_decode('pg');
		$insertAprov=mysql_query("INSERT INTO prestsavaprov(id,idprest,apprest) ('','".$idSav."','".date("d/m/Y H:i:s")."')");
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
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