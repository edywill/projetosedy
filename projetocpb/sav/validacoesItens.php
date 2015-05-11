<?php 
if($_SESSION['passagemSav']=='sim'){
			    $passagem=1;
				$sqlPassagem=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			}
		if($_SESSION['diariaSav']=='sim'){
				$hospedagem=1;
			}
		if($_SESSION['transladoSav']=='sim'){
			$translado=1;
			}
?>