<?php 
$itens=$_REQUEST['bdpass'];
require "../../conexaomysql.php";
$valida=0;
$cont=count($itens);
foreach($itens AS $item) {
   $sql=mysql_query("UPDATE registros SET bdpass=1 WHERE id='".$item."'");
	if($sql){
		$valida++;
		}
}
if($valida==$cont){
	?>
       <script type="text/javascript">
       alert("Atualização efetuada!");
       window.parent.location.reload();
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente Novamente!");
       window.location("boardingPass.php");
       </script>
       <?php
		}
?>