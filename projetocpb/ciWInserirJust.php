<?php

$iduser=$_POST['iduser'];
$solicitacao=$_POST['solic'];
$justificativa=$_POST['justificativa'];
require ("conexaomysql.php");
$pegarDadosUser=mysql_query("SELECT cigam,s1 FROM usuarios WHERE id=".$iduser."");
$arrayDados=mysql_fetch_array($pegarDadosUser);
$userCigam=$arrayDados['cigam'];
include "function.php";
if(!empty($justificativa)){

justificaCi($solicitacao,$justificativa,$userCigam);
}else{
	?>
       			<script type="text/javascript">
       			alert("Por favor, preencha uma justificativa!");
       			history.back();
       			</script>
    <?php
	}
?>