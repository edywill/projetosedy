<?php
require 'conexaoconv.php';
//include "mb.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$modalidade=$_POST['modal'];
$funcao=$_POST['funcao'];
$quantidade=$_POST['quantidade'];
$um=$_POST['um'];
$vlUnit=$_POST['vlUnit'];
$vlTot=$_POST['vlTot'];
if(empty($modalidade)){
	?>
       <script type="text/javascript">
       alert("Por favor escolha uma modalidade");
       history.back();
       </script>
       <?php
	}elseif(empty($funcao)){
		?>
       <script type="text/javascript">
       alert("A especificação é obrigatória.");
       history.back();
       </script>
       <?php
		}elseif(empty($quantidade)){
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
			}else{
$contador=0;
if($_POST['validador']=="1"){
$sqlInsert = "INSERT INTO rhpermanente (idmodalidade,funcao,quantidade,um,vlunit,vltot) VALUES (".$modalidade.",'".$funcao."','".$quantidade."','".$um."','".$vlUnit."','".$vlTot."')";
$insertPermanente = mysql_query($sqlInsert);
if($insertPermanente){
	$contador=1;
	}
    }elseif($_POST['validador']==2){
	$idPermanente=$_POST['id'];
	$sqlUpdate = "UPDATE rhpermanente SET idmodalidade=".$modalidade.",funcao='".$funcao."',quantidade='".$quantidade."',um='".$um."',vlunit='".$vlUnit."',vltot='".	$vlTot."' WHERE id=".$idPermanente."";
	$updatePermanente = mysql_query($sqlUpdate) or die(mysql_error());
if($updatePermanente){
	$contador=1;
	}
			}
if($contador==1){
	?>
       <script type="text/javascript">
       alert("Executado com sucesso");
       window.location="gestConv.php";
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
			}
?>