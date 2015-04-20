<?php 
 $sqlUpdateItemLoc="UPDATE COISOLIC SET 
				 					pr_unitario=".(float)$valorTotal.",  
									dt_modificacao=dbo.CGFC_DATAATUAL ()
									WHERE Cd_solicitacao='".$solicitacao."'
									AND Sequencia='".$sqlConsultaLocExiste['Sequencia']."'";
   $resUpdateItemLoc = odbc_exec($conCab2, $sqlUpdateItemLoc) or die("<p>".odbc_errormsg());
	if(!$resUpdateItemLoc){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao Atualizar o registro.\\n';
		}
?>