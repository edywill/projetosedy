<?php 
require "../conect.php";
$valor=$_POST['novovalor'];
$vigencia=$_POST['novavigencia'];
$futuro=$_POST['futuro'];
$valida=0;
if($futuro>1){
$sqlId=mysql_fetch_array(mysql_query("SELECT max(id) AS maxid FROM savvalorvr"));
$updateValor=mysql_query("UPDATE savvalorvr SET valor='".str_replace(",",".",$valor)."',vigencia='".$vigencia."' WHERE id='".$sqlId['maxid']."'");

if(!$sqlId){
	$valida=1;
	}

}else{
	$insertValorVr=mysql_query("INSERT INTO savvalorvr VALUES('','".str_replace(",",".",$valor)."','".$vigencia."','".date("d/m/Y")."','A')");
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