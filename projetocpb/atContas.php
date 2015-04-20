<?php
require 'conexaoconv.php';
//include "mb.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$idEvento=$_POST['idEvento'];
$sqlUpdProj = mysql_query("SELECT pcontas.id FROM pcontas,eventos,despesa WHERE pcontas.idevento=".$idEvento." AND eventos.id=pcontas.idevento AND despesa.id=pcontas.despesa ORDER BY pcontas.despesa") or die(mysql_error());
$cont=0;
$valid=0;
while($objUpdProj=mysql_fetch_object($sqlUpdProj)){
	$cont++;
	$nQuantidade="quantidade".$cont;
	$nUm="um".$cont;
	$nVlunit="vlUnit".$cont;
	$nVltot="vlTot".$cont;
	$nId="id".$cont;
	$nJust="just".$cont;
	
	$sqlContProj=mysql_query("UPDATE pcontas SET quantidade='".$_POST[$nQuantidade]."',um='".$_POST[$nUm]."',vlunit='".$_POST[$nVlunit]."',vltot='".$_POST[$nVltot]."',just='".$_POST[$nJust]."' WHERE id=".$_POST[$nId]."") or die(mysql_error());
	if($sqlContProj){
		$valid++;
		}
	}

if($valid==$cont){
	?>
       <script type="text/javascript">
       alert("Executado com sucesso");
       window.location="atValConvPrest.php";
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
      window.location="atValConvPrest.php";
       </script>
       <?php
			}
?>