<?php
		  //$conCab = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=cigamteste;", "sa","abyz.");
		   $conCab2 = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=cigamteste;", "sa","abyz.");
		  //$conCab2 = odbc_connect("DRIVER={SQL Server}; SERVER=CPB174\SQLEXPRESS; DATABASE=CIGAM;", "sa","cigam");
		  if(!$conCab2){
			  ?>
       <script type="text/javascript">
       alert("Conexão com o servidor falhou! Tente Novamente!");
       history.back();
       </script>
       <?php
			  }
?>