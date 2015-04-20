<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
	$userCriac=$_SESSION['userAquis'];
	$countError=0;
	$errorMsg='';
	$valida=0;
	$id=0;
	$endereco='index.php';
if(!empty($_POST['idinat'])){
	$id=$_POST['idinat'];
}elseif(!empty($_POST['idinat2'])){
	$id=$_POST['idinat2'];
	}
	$selectDadosGrupo=mysql_fetch_array(mysql_query("SELECT * FROM aquicadmat WHERE id='".$id."'"));
	if(!empty($_POST['idinat2'])){
	   $endereco='novoMat.php';
	   $_SESSION['idGrupoSession']=$selectDadosGrupo['grupo'];
		$sqlDadoGrupo2=mysql_fetch_array(mysql_query("SELECT * FROM aquigrupo WHERE id='".$selectDadosGrupo['grupo']."'"));
				$_SESSION['dadosGrupoSession']=$sqlDadoGrupo2['codigo'].'-'.utf8_encode($sqlDadoGrupo2['descricao']);
	}
	$inativaGrupo=mysql_query("UPDATE aquicadmat SET inativo=1 WHERE id='".$id."'");
	$insertLog=mysql_query("INSERT INTO aquilog VALUES('','".date("d/m/Y H:i:s")."','M','".$userCriac."','Inativado Material ".$selectDadosGrupo['nome']."' )");
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
       window.location="<?php echo $endereco; ?>";
       </script>
       <?php
		}else{
		?>
        <script type="text/javascript">
       alert("Inativado com sucesso!");
       window.location="<?php echo $endereco; ?>";
       </script>
        <?php
		}
?>