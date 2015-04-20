<?php
require 'conexaoconv.php';
//include "mb.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$idEvento=$_POST['idEventoI'];

$despesa=$_POST['despesa'];
$etapa=$_POST['etapa'];
$especific=$_POST['especific'];
$quantidade=$_POST['quantidade'];
$um=$_POST['um'];
$vlunit=$_POST['vlUnit'];
$vltot=$_POST['vlTot'];
$contador=0;
if(empty($despesa)){
	?>
       <script type="text/javascript">
       alert("Por favor escolha o tipo de despesa");
       history.back();
       </script>
       <?php
	}elseif(empty($especific)){
		?>
       <script type="text/javascript">
       alert("É necessário preencher a especificação");
       history.back();
       </script>
       <?php
		}elseif(empty($quantidade)){
		?>
       <script type="text/javascript">
       alert("Quantidade é um campo obrigatório");
       history.back();
       </script>
       <?php
		}elseif(empty($vlunit)){
		?>
       <script type="text/javascript">
       alert("Por favor informe o valor unitário.");
       history.back();
       </script>
       <?php
		}else{
$sqlInsert = "INSERT INTO projecao (idevento,despesa,etapa,especific,quantidade,um,vlunit,vltot) VALUES (".$idEvento.",'".$despesa."','".$etapa."','".$especific."','".$quantidade."','".$um."','".$vlunit."','".$vltot."')";
$insertProj = mysql_query($sqlInsert) or die(mysql_error());
if($insertProj){
	$contador=1;
	    }
	
if($contador==1){
	?>
       <script type="text/javascript">
       alert("Executado com sucesso");
       window.location="atValConv.php";
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
       window.location="atValConv.php";
       </script>
       <?php
		}
			}
?>