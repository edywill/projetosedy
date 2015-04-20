<?php
require "conect.php";
require "conectsqlserverci.php";
$id=$_POST['id'];
$user=trim(($_POST['user']);
$existeSql=odbc_exec($conCab,"SELECT Cd_usuario FROM GEUSUARI (nolock) WHERE Cd_usuario='".$user."'");
$contarSql=odbc_num_rows(existeSql);

if($contarSql>0){

$sqlUpd=mysql_query("UPDATE usuarios SET cigam='".strtoupper($user)."' WHERE id='".trim($id)."'");
if($sqlUpd){
	    ?>
       <script type="text/javascript">
       alert("Usuario Atualizado com Sucesso");
       window.location="home.php";
       </script>
       <?php
	}else{
		?>
		<script type="text/javascript">
       alert("Ocorreu um erro! Tente novamente!");
       window.location="userCigam.php?id=<?php echo $id;?>";
       </script>
       <?php
		}

}else{
	?>
       <script type="text/javascript">
       alert("Usuario nao encontrado no CIGAM, por favor verifique com o setor responsavel.");
       window.location="userCigam.php?id=<?php echo $id;?>";
       </script>
       <?php
	}
?>