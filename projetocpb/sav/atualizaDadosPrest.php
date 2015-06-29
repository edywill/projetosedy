<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$numSav=$_SESSION['numSav'];
$numproc=$_POST['proc'];
$numDiasDiaria=str_replace(",",".",$_POST['qtd']);
$valorTotal=str_replace(".","",$_POST['vltot']);
$valorTotal=str_replace(",",".",$valorTotal);

$selectDadosDiaria=mysql_fetch_array(mysql_query("SELECT id FROM savdiarias WHERE idsav='".$numSav."'"));
	$insereDadosDiaria=mysql_query("UPDATE savdiarias SET qtddias='".$numDiasDiaria."',valortotal='".$valorTotal."',numproc='".utf8_decode($numproc)."' WHERE idsav='".$numSav."'");
if(!$insereDadosDiaria){
	?>
       <script type="text/javascript">
       alert("Erro ao inserir o registro. Tente novamente.");
       window.location="dadosDiariaPrest.php";
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Atualizado com Sucesso!");
       window.location="prestCont.php";
       </script>
       <?php
		}

?>