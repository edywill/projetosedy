<?php 
		$cotacaoDia=$_SESSION['cotacaoDiaSav'];
		$dataCotacao=$_SESSION['cotacaoDataSav'];
		$sqlCotacao=mysql_query("INSERT INTO savcotacao VALUES ('".$numSav."','".$dataCotacao."','".(float)str_replace(",",".",$cotacaoDia)."')");
		$numDiasPassagem=0;
		if($_SESSION['passagemSav']=='sim'){
		
		$arrayDataPassagemIda[]=0;
		$arrayDataPassagemVolta[]=0;
		$arrayValorPassagem[]=0;
		$arrayHoraPassagemIda[]=0;
		$arrayHoraPassagemVolta[]=0;
		$arrayTipoPassagem[]=0;
		$arrayPassagemValorDec[]=0;
		$countPassagem=0;
		$countTotalPassagem=mysql_num_rows($sqlPassagem);
			while($objPassagem=mysql_fetch_object($sqlPassagem)){
					$destinoReferencia=$objPassagem->destino;
				if($_SESSION['diariaSav']=='sim'){
				$sqlHospedagemReferencia=mysql_query("SELECT destino,dtida,dtvolta FROM savhospedagem WHERE idsav='".$numSav."'");
				while($objHospedagemReferencia=mysql_fetch_object($sqlHospedagemReferencia)){
				if($objHospedagemReferencia->dtida==$objPassagem->dtida && $objHospedagemReferencia->destino<>$destinoReferencia){
					$destinoReferencia=$objHospedagemReferencia->destino;
					}
				}
				}
					$sqlValorDia=mysql_query("SELECT valor FROM savtabeladiaint 
											 WHERE pais='".$destinoReferencia."' AND classe='".$arrayClasse['classe']."'");
	 				$arrayValorDia=mysql_fetch_array($sqlValorDia);
					$arrayDatasPassagemIda[$countPassagem]=$objPassagem->dtida;
					$arrayHoraPassagemIda[$countPassagem]=$objPassagem->horarioida;
					if($countTotalPassagem==1 || $objPassagem->tipo==1){
	if($_SESSION['diariaSav']=='sim'){
				$sqlHospedagemReferencia2=mysql_fetch_array(mysql_query("SELECT destino,dtida,dtvolta FROM savhospedagem WHERE idsav='".$numSav."'"));
	$arrayDatasPassagemVolta[$countPassagem]=$sqlHospedagemReferencia2['dtvolta'];
					$arrayHoraPassagemVolta[$countPassagem]='manha';
	}else{
	$arrayDatasPassagemVolta[$countPassagem]=$objPassagem->dtvolta;
					$arrayHoraPassagemVolta[$countPassagem]=$objPassagem->horariovolta;

	}
}else{
	$arrayDatasPassagemVolta[$countPassagem]=$objPassagem->dtvolta;
					$arrayHoraPassagemVolta[$countPassagem]=$objPassagem->horariovolta;
	}
					$arrayTipoPassagem[$countPassagem]=$objPassagem->tipo;
					
					$arrayValorPassagem[$countPassagem]=(float)$arrayValorDia['valor']*$cotacaoDia;
					$arrayPassagemValorDec[$countPassagem]=(float)str_replace(",",".",str_replace(".","",$objPassagem->valor));
			$countPassagem++;
			}
			$valorTotal=0;
			$valorPassagem=0;
			for($i=0;$i<$countPassagem;$i++){
				$qtdDias=0;
				$diasUteis=0;
				$valorVR=0;
				$valorTotalTrecho=0;
				$extraDia=0;
				$valorPassagem=$valorPassagem+(float)$arrayPassagemValorDec[$i];
				if($arrayTipoPassagem[$i]==1){
					 if($arrayDatasPassagemIda[$i]<>end($arrayDatasPassagemIda)){
					 if($arrayHoraPassagemIda[$i+1]=='tarde'){
						 $extraDia=0.5;
						 }elseif($arrayHoraPassagemIda[$i+1]=='noite'){
							 $extraDia=1;
							 }
					 $inicio = date_create_from_format('d/m/Y', $arrayDatasPassagemIda[$i]);
					 $fim = date_create_from_format('d/m/Y', $arrayDatasPassagemIda[$i+1]);
					 $intervalo = $inicio->diff($fim);
					 $qtdDias=($intervalo->d)+$extraDia;
					 $diasUteis=DiasUteis($arrayDatasPassagemIda[$i], $arrayDatasPassagemIda[$i+1]);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 if($arrayDatasPassagemIda[$i+1]<>$arrayDatasPassagemIda[$i]){
					   if($diasUteis==0){
						if( date("w", dataToTimestamp($arrayDatasPassagemIda[$i+1]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i+1]))<>6){
							 $diasUteis=1;
							 }
						  if(date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							  $diasUteis=1;
							  }
					   }
					   		}else{
								if(date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							  		$diasUteis=$diasUteis+1;
							  		}
								}
					 if($extraDia==0 && $diasUteis>0){
					 	$diasUteis=$diasUteis-1;
					 }
					$sqlValorVr=mysql_query("SELECT * FROM savvalorvr");
					 while($objValorVr=mysql_fetch_object($sqlValorVr)){
	$arrayVigenciaVr=explode("/",$objValorVr->vigencia);
	$arrayDataAtVr=explode("/",$arrayDatasPassagemIda[$i]);
	if(strtotime($arrayDataAtVr[2]."-".$arrayDataAtVr[1]."-".$arrayDataAtVr[0]) >= strtotime($arrayVigenciaVr[2]."-".$arrayVigenciaVr[1]."-".$arrayVigenciaVr[0])){
		$valorVRRef=$objValorVr->valor;
		  }
	}

					 
					 $valorVR=$diasUteis*$valorVRRef;
					 if($_SESSION['diariaSav'] == 'sim'){

					 $valorTotalTrecho=(($arrayValorPassagem[$i]/2)*$qtdDias)-$valorVR;
					     }else{
							 $valorTotalTrecho=($arrayValorPassagem[$i]*$qtdDias)-$valorVR;
							 }
					 
					 $valorTotal=$valorTotal+$valorTotalTrecho;
					 }elseif($countPassagem==1){
						 $inicio = date_create_from_format('d/m/Y',$arrayDatasPassagemIda[$i]);
					 $fim = date_create_from_format('d/m/Y',$arrayDatasPassagemVolta[$i]);
					 $intervalo = $inicio->diff($fim);
					 $qtdDias=($intervalo->d)+$extraDia;
					 $diasUteis=DiasUteis($arrayDatasPassagemIda[$i], $arrayDatasPassagemVolta[$i]);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 if($arrayDatasPassagemIda[$i]<>$arrayDatasPassagemVolta[$i]){
						if($diasUteis==0){
						if( date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							 $diasUteis=1;
							 }
						  if(date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>6){
							  $diasUteis=1;
							  }
						}
						}else{
							if(date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>6){
							  	$diasUteis=$diasUteis+1;
							  }
							}
					 if($extraDia==0 && $diasUteis>0){
					 	$diasUteis=$diasUteis-1;
					 }
					 $sqlValorVr=mysql_query("SELECT * FROM savvalorvr");
					 while($objValorVr=mysql_fetch_object($sqlValorVr)){
	$arrayVigenciaVr=explode("/",$objValorVr->vigencia);
	$arrayDataAtVr=explode("/",$arrayDatasPassagemVolta[$i]);
	if(strtotime($arrayDataAtVr[2]."-".$arrayDataAtVr[1]."-".$arrayDataAtVr[0]) >= strtotime($arrayVigenciaVr[2]."-".$arrayVigenciaVr[1]."-".$arrayVigenciaVr[0])){
		$valorVRRef=$objValorVr->valor;
		  }
	}

					 
					 $valorVR=$diasUteis*$valorVRRef;
					 if($_SESSION['diariaSav'] == 'sim'){
					 $valorTotalTrecho=(($arrayValorPassagem[$i]/2)*$qtdDias)-$valorVR;
					     }else{
							 $valorTotalTrecho=($arrayValorPassagem[$i]*$qtdDias)-$valorVR;
							 }
					 $valorTotal=$valorTotal+$valorTotalTrecho;
						 }elseif($arrayTipoPassagem[$i-1]==2){
					 if($arrayHoraPassagemIda[$i]=='tarde'){
						 $extraDia=0.5;
						 }elseif($arrayHoraPassagemIda[$i]=='noite'){
							 $extraDia=1;
							 }
					 $inicio = date_create_from_format('d/m/Y', $arrayDatasPassagemVolta[$i-1]);
					 $fim = date_create_from_format('d/m/Y', $arrayDatasPassagemIda[$i]);
					 $intervalo = $inicio->diff($fim);
					 $qtdDias=($intervalo->d)+$extraDia;
					 $diasUteis=DiasUteis($arrayDatasPassagemVolta[$i-1], $arrayDatasPassagemIda[$i]);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 if($arrayDatasPassagemVolta[$i-1]<>$arrayDatasPassagemIda[$i]){
						if($diasUteis==0){
						if( date("w", dataToTimestamp($arrayDatasPassagemVolta[$i-1]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemVolta[$i-1]))<>6){
							 $diasUteis=1;
							 }
						  if(date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							  $diasUteis=1;
							  }
						}
						}else{
							if(date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							  $diasUteis=$diasUteis+1;
							  }
							}
					 if($extraDia==0 && $diasUteis>0){
					 $diasUteis=$diasUteis-1;
					 }
					$sqlValorVr=mysql_query("SELECT * FROM savvalorvr");
					 while($objValorVr=mysql_fetch_object($sqlValorVr)){
	$arrayVigenciaVr=explode("/",$objValorVr->vigencia);
	$arrayDataAtVr=explode("/",$arrayDatasPassagemIda[$i]);
	if(strtotime($arrayDataAtVr[2]."-".$arrayDataAtVr[1]."-".$arrayDataAtVr[0]) >= strtotime($arrayVigenciaVr[2]."-".$arrayVigenciaVr[1]."-".$arrayVigenciaVr[0])){
		$valorVRRef=$objValorVr->valor;
		  }
	}

					 
					 $valorVR=$diasUteis*$valorVRRef;
					 if($_SESSION['diariaSav'] == 'sim'){
					 $valorTotalTrecho=(($arrayValorPassagem[$i]/2)*$qtdDias)-$valorVR;
					     }else{
							 $valorTotalTrecho=($arrayValorPassagem[$i]*$qtdDias)-$valorVR;
							 }
					$valorTotal=$valorTotal+$valorTotalTrecho;
						 }
				  }else{
					 if($arrayHoraPassagemVolta[$i]=='tarde'){
						 $extraDia=0.5;
						 }elseif($arrayHoraPassagemVolta[$i]=='noite'){
							 $extraDia=1;
							 }
					 $inicio = date_create_from_format('d/m/Y',$arrayDatasPassagemIda[$i]);
					 $fim = date_create_from_format('d/m/Y',$arrayDatasPassagemVolta[$i]);
					 $intervalo = $inicio->diff($fim);
					 $qtdDias=($intervalo->d)+$extraDia;
					 $diasUteis=DiasUteis($arrayDatasPassagemIda[$i], $arrayDatasPassagemVolta[$i]);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 if($arrayDatasPassagemIda[$i]<>$arrayDatasPassagemVolta[$i]){
						if($diasUteis==0){
						if( date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							 $diasUteis=1;
							 }
						  if(date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>6){
							  $diasUteis=1;
							  }
						}
						}else{
							if(date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemVolta[$i]))<>6){
							  	$diasUteis=$diasUteis+1;
							  }
							}
					 if($extraDia==0 && $diasUteis>0){
					 	$diasUteis=$diasUteis-1;
					 }
					 $sqlValorVr=mysql_query("SELECT * FROM savvalorvr");
					 while($objValorVr=mysql_fetch_object($sqlValorVr)){
	$arrayVigenciaVr=explode("/",$objValorVr->vigencia);
	$arrayDataAtVr=explode("/",$arrayDatasPassagemVolta[$i]);
	if(strtotime($arrayDataAtVr[2]."-".$arrayDataAtVr[1]."-".$arrayDataAtVr[0]) >= strtotime($arrayVigenciaVr[2]."-".$arrayVigenciaVr[1]."-".$arrayVigenciaVr[0])){
		$valorVRRef=$objValorVr->valor;
		  }
	}

					 
					 $valorVR=$diasUteis*$valorVRRef;
					 if($_SESSION['diariaSav'] == 'sim'){
					 $valorTotalTrecho=(($arrayValorPassagem[$i]/2)*$qtdDias)-$valorVR;
					     }else{
							 $valorTotalTrecho=($arrayValorPassagem[$i]*$qtdDias)-$valorVR;
							 }
					 $valorTotal=$valorTotal+$valorTotalTrecho;
					  }
				}
				}else{
	$countPassagem=0;
	$valorPassagem=0;
	$valorTotal=0;
					//Caso não haja passagem
					$sqlValorDia=mysql_query("SELECT valor FROM savtabeladiaint 
											 WHERE pais='".$arrayRegistro['destinoida']."' AND classe='".$arrayClasse['classe']."'");
	 				$arrayValorDia=mysql_fetch_array($sqlValorDia);
					$valorTotal=($numDiasGeral*($arrayValorDia['valor']*$cotacaoDia))-$descontoVR;
					}
?>