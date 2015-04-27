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
		$status=utf8_decode('pt');
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
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
		$updateSav=mysql_query("UPDATE prestsav SET status='".$status."' WHERE id='".$idSav."'");
		//Lembrar de atualizar os boardings Pass relativos à essa SAV e desbloquear o usuário, caso esteja bloqueado.
		
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