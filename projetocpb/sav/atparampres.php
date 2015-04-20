<?php 
require "../conect.php";
$valor=$_POST['novovalor'];
$vigencia=$_POST['novavigencia'];
$futuro=$_POST['futuro'];
$valida=0;
if($futuro>1){
$sqlId=mysql_fetch_array(mysql_query("SELECT max(id) AS maxid FROM savdirex WHERE tipo=2"));
$updateValor=mysql_query("UPDATE savdirex SET nome='".utf8_decode($valor)."',dtalt='".$vigencia."' WHERE id='".$sqlId['maxid']."'");

if(!$sqlId){
	$valida=1;
	}

}else{
	$insertValorVr=mysql_query("INSERT INTO savdirex VALUES('','".$vigencia."','".utf8_decode($valor)."','2')");
	if(!$insertValorVr){
		$valida=1;
		}
	}

if($valida==1){
	?>
       <script type="text/javascript">
       alert("Problema ao atualizar registro");
       window.location="paramvr.php";
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Atualizado com sucesso!");
       window.location="parametros.php";
       </script>
       <?php
		}

?>