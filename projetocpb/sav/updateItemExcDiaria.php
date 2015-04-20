<?php
$dtIdaDiariaSav=$arrayRegistro['dtida'];
$dtVoltaDiariaSav=$arrayRegistro['dtvolta'];
if($homolog==0){
	$dtIdaDiariaSav=converteData($arrayRegistro['dtida']);
$dtVoltaDiariaSav=converteData($arrayRegistro['dtvolta']);
	}

$updateTeItemSolDiaria=odbc_exec($conCab2,"UPDATE TEITEMSOLDIARIAVIAGEM SET 
										   dt_inicio=CAST('".$dtIdaDiariaSav."' AS DATETIME), 
				   						   dt_termino=CAST('".$dtVoltaDiariaSav."' AS DATETIME),
				   						   valor=".$valorTotal."
 WHERE id_registro='".$sqlItemDiariaExc['id_registro']."'")  or die("<p>".odbc_errormsg());
		
		if(!$updateTeItemSolDiaria){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao Atualizar o registro exclusivo.\\n';
			}
?>