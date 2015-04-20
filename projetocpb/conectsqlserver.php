<?php
		  $conCab = odbc_connect("DRIVER={SQL Server}; SERVER=CPB174\SQLEXPRESS; DATABASE=META;", "sa","cigam");
		   //$conCab = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=META;", "sa","abyz.");		  
		   $conCabErro=0;
		   if(!$conCab){
			  ?>
       <script type="text/javascript">
       alert("Conexão com o servidor falhou! Tente Novamente!");
       history.back();
       </script>
       <?php
	   $conCabErro=1;
			  }
?>