<?php 
 $sqlUpdateItemHos="UPDATE COISOLIC SET  
									dt_modificacao=dbo.CGFC_DATAATUAL ()
									WHERE Cd_solicitacao='".$solicitacao."'
									AND Sequencia='".$sqlConsultaHosExiste['Sequencia']."'";
   $resUpdateItemHos = odbc_exec($conCab2, $sqlUpdateItemHos) or die("<p>".odbc_errormsg());
	if(!$resUpdateItemHos){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao Atualizar o registro.\\n';
		}
?>