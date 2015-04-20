<?php 
 $sqlUpdateItemDia="UPDATE COISOLIC SET 
				 					pr_unitario=".(float)$valorTotal.",  
									dt_modificacao=dbo.CGFC_DATAATUAL ()
									WHERE Cd_solicitacao='".$solicitacao."'
									AND Sequencia='".$sqlConsultaDiariaExiste['Sequencia']."'";
   $resUpdateItemDia = odbc_exec($conCab2, $sqlUpdateItemDia) or die("<p>".odbc_errormsg());
	if(!$resUpdateItemDia){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao Atualizar o registro.\\n';
		}
?>