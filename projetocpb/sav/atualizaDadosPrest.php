<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$numSav=$_SESSION['numSav'];
$numproc=$_POST['proc'];
$naut=$_POST['aut'];
$numDiasDiaria=$_POST['qtd'];
$valorTotal=$_POST['vltot'];

$selectDadosDiaria=mysql_fetch_array(mysql_query("SELECT id FROM savdiarias WHERE idsav='".$numSav."'"));
if(empty($selectDadosDiaria['id'])){
$insereDadosDiaria=mysql_query("INSERT INTO savdiarias (idsav,nautor,qtddias,valortotal,numproc) VALUES ('".$numSav."','".$naut."','".$numDiasDiaria."','".$valorTotal."','".$numproc."')");
}else{
	$insereDadosDiaria=mysql_query("UPDATE savdiarias SET qtddias='".$numDiasDiaria."',valortotal='".$valorTotal."',numproc='".$numproc."',nautor='".$naut."' WHERE idsav='".$numSav."'");
	}
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