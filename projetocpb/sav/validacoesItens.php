<?php 
if($_SESSION['passagemSav']=='sim'){
			$sqlPassagem=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			$countPassagem=mysql_num_rows($sqlPassagem);
			if($countPassagem<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Necessario informar ao menos um item de passagem aerea.\\n';
				}else{
				$passagem=1;
				}
			}
		if($_SESSION['diariaSav']=='sim'){
			$sqlHospedagem=mysql_query("SELECT id FROM savhospedagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			$countHospedagem=mysql_num_rows($sqlHospedagem);
			if($countHospedagem<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Caso a opcao de hospedagem seja marcada, necessario informar ao menos um registro.\\n';
				}else{
				$hospedagem=1;
				}
			}
		if($_SESSION['transladoSav']=='sim'){
			$sqlTranslado=mysql_query("SELECT id FROM savtranslado WHERE idsav='".$numSav."'");
			$countTranslado=mysql_num_rows($sqlTranslado);
			if($countTranslado<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Caso a opcao de translado seja marcada, necessario informar ao menos um registro de locacao de veiculo.\\n';
				}else{
			$translado=1;
				}
			}
?>