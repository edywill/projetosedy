<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
	$userCriac=$_SESSION['userAquis'];
	$countError=0;
	$errorMsg='';
	$valida=0;
	$id=$_POST['idinat'];
	$selectDadosGrupo=mysql_fetch_array(mysql_query("SELECT * FROM aquigrupo WHERE id='".$id."'"));
	$inativaGrupo=mysql_query("UPDATE aquigrupo SET inativo=1 WHERE id='".$id."'");
	$insertLog=mysql_query("INSERT INTO aquilog VALUES('','".date("d/m/Y H:i:s")."','G','".$userCriac."','Inativado Grupo de Despesa ".$selectDadosGrupo['codigo']."-".$selectDadosGrupo['descricao']."' )");
	if(!$inativaGrupo){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Problema ao atualizar o registro. '.mysql_error().'\\n';
	}

if($valida==1)
{
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="index.php";
       </script>
       <?php
		}else{
		?>
        <script type="text/javascript">
       alert("Inativado com sucesso!");
       window.location="index.php";
       </script>
        <?php
		}
?>