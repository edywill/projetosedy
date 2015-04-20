<?php
require 'conexaoconv.php';
//include "mb.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$quantidade=$_POST['quantidade'];
$um=$_POST['um'];
$vlUnit=$_POST['vlUnit'];
$vlTot=$_POST['vlTot'];
if(empty($quantidade)){
		?>
       <script type="text/javascript">
       alert("Por favor informe a quantidade.");
       history.back();
       </script>
       <?php
		}elseif(empty($um)){
		?>
       <script type="text/javascript">
       alert("Necessário selecionar uma unidade de medida");
       history.back();
       </script>
       <?php
		}elseif(empty($vlUnit)){
		?>
       <script type="text/javascript">
       alert("Necessário informar o valor unitario.");
       history.back();
       </script>
       <?php
			}elseif(empty($vlTot)){
		?>
       <script type="text/javascript">
       alert("Informe o valor total.");
       history.back();
       </script>
       <?php
			}elseif(empty($_POST['just'])){
		?>
       <script type="text/javascript">
       alert("Informe a justificativa para alteração.");
       history.back();
       </script>
       <?php
			}else{
$contador=0;
	$idPermanente=$_POST['id'];
	$sqlUpdate = "UPDATE prhpermanente SET quantidade='".$quantidade."',um='".$um."',vlunit='".$vlUnit."',vltot='".	$vlTot."',just='".$_POST['just']."' WHERE id=".$idPermanente."";
	$updatePermanente = mysql_query($sqlUpdate) or die(mysql_error());
if($updatePermanente){
	$contador=1;
	}
			}
if($contador==1){
	?>
       <script type="text/javascript">
       alert("Executado com sucesso");
       window.location="prestConv.php";
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
       history.back();
       </script>
       <?php
		}
?>