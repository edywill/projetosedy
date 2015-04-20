<?php
require 'conexaoconv.php';
//include "mb.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$modalidade=$_POST['modal'];
$nome=$_POST['nome'];
$cidade=$_POST['cidade'];
$uf=$_POST['uf'];
$dtinicio=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$contador=0;
if(empty($modalidade)){
	?>
       <script type="text/javascript">
       alert("Por favor escolha uma modalidade");
       history.back();
       </script>
       <?php
	}elseif(empty($cidade)){
		?>
       <script type="text/javascript">
       alert("Cidade e um campo obrigatorio");
       history.back();
       </script>
       <?php
		}elseif(empty($nome)){
		?>
       <script type="text/javascript">
       alert("Por favor informe o nome do evento.");
       history.back();
       </script>
       <?php
		}elseif(empty($dtinicio)){
		?>
       <script type="text/javascript">
       alert("Por favor informe a data de inicio do evento.");
       history.back();
       </script>
       <?php
		}else{
if($_POST['validador']=="1"){
$sqlInsert = "INSERT INTO eventos (idmodalidade,nome,cidade,uf,dtinicio,dtfim) VALUES (".$modalidade.",'".$nome."','".$cidade."',".$uf.",'".$dtinicio."','".$dtfim."')";
$insertEvento = mysql_query($sqlInsert) or die(mysql_error());
if($insertEvento){
	$contador=1;
	}
    }elseif($_POST['validador']==2){
	$idEvento=$_POST['id'];
	$sqlUpdate = "UPDATE eventos SET idmodalidade=".$modalidade.",nome='".$nome."',cidade='".$cidade."',uf=".$uf.",dtinicio='".$dtinicio."',dtfim='".$dtfim."' WHERE id=".$idEvento."";
	$updateEvento = mysql_query($sqlUpdate) or die(mysql_error());
if($updateEvento){
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