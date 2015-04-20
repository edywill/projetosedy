<?php 
session_start();
$_SESSION['tpSav']=3;
$_SESSION['cotacaoDiaSav']=$_POST['cotacaoDolar'];
$_SESSION['cotacaoDataSav']=date("d/m/Y - h:iA");
		?>
       <script type="text/javascript">
       alert("Atualizado com sucesso.");
       window.location="complementaSav.php";
       </script>
       <?php
		?>