<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_SESSION['idAtletaSession'];

$sqlDeletaProva=odbc_exec($conCab,"DELETE FROM provasatleta WHERE id='".$_GET['id']."'") or die(mysql_error());

if($sqlDeletaProva){$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".$userCriac."','".date("d/m/Y H:i:s")."','Exclui Prova ".utf8_decode($_GET['descr'])."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
?>
       				<script type="text/javascript">
       				alert("Excluido com sucesso");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("Ocorreu um erro. Tente novamente");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}
?>