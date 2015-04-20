<?php 
 $valorPassagem=$valorPassagem/$countPassagem;
 $sqlUpdateItemPas="UPDATE COISOLIC SET 
				 					pr_unitario=".(float)$valorPassagem.",  
									dt_modificacao=dbo.CGFC_DATAATUAL ()
									WHERE Cd_solicitacao='".$solicitacao."'
									AND Sequencia='".$sqlConsultaPasExiste['Sequencia']."'";
   $resUpdateItemPas = odbc_exec($conCab2, $sqlUpdateItemPas) or die("<p>".odbc_errormsg());
	if(!$resUpdateItemPas){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao Atualizar o registro.\\n';
		}
?>