<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
include "../function.php";
$countUpdateCi=0;
$tipo=$_POST['tp'];
$idSav=$_POST['id'];
$numCi=$_POST['ci'];
$descricaoCiUpdate=utf8_decode($_POST['descci']);
$valida=0;
if($tipo=='recusa'){
	$status=utf8_decode('Devolvida');
	$updateSav=mysql_query("UPDATE savregistros SET situacao='".$status."' WHERE id='".$idSav."'");
	if(!$updateSav){
		$valida=1;
		}
	}else{
		$updateSav=mysql_query("UPDATE savregistros SET situacao='Aprovada' WHERE id='".$idSav."'");
		if(!$updateSav){
			$valida=1;
		}
		$ciUpdate=$numCi;
		$UserCiUpdate=trim($_SESSION['cigamSav']);
		$controleNovoCiUpdate='17';
		if($UserCiUpdate=='CAV'){
		$controleNovoCiUpdate='05';
		}
		$setorGestor=$_SESSION['setorGestSav'];
			
				$pgRetornoUp='sav';
				$idTipoUp='';
		if(!empty($controleNovoCiUpdate)){
			updateCi($ciUpdate,$_SESSION['usuario'],$descricaoCiUpdate,$controleNovoCiUpdate,$pgRetornoUp,$idTipoUp);
		   $countUpdateCi=1;
		   }
		}
if($valida==0){
if($countUpdateCi<1){
?>
       <script type="text/javascript">
       alert("Atualizado com sucesso!");
       window.location="aprovacaoGestor.php";
       </script>
       <?php
}
}else{
	?>
       <script type="text/javascript">
       alert("Erro ao atualizar registro. Tente novamente!");
       window.location="aprovacaoGestor.php";
       </script>
       <?php
	}
?>