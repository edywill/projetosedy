<?php 
session_start();
require "../conectsqlserver.php";
require "../conect.php";
$_SESSION['tpSav']=3;
			$valida=0;
			$countError=0;
			$errorMsg='';
	$sqlExcluiPassagem=mysql_query("DELETE FROM savpassagem WHERE id='".$_GET['id']."'");
		if(!$sqlExcluiPassagem){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Problema ao excluir o registro, tente novamente.\\n';
		}

if($valida==1){
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="complementaSav.php";
       </script>
       <?php
		}else{	
			?>
       <script type="text/javascript">
       alert("Excluido com sucesso!");
       window.location="complementaSav.php";
       </script>
       <?php
			}
?>