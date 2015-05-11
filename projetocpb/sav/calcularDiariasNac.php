<?php 

if($_SESSION['passagemSav']=='sim'){
	        $numDiasDiaria=0;
			$countPassagem=0;
			$numDiasPassagem=0;
			$arrayDataPassagemIda[]=0;
			$arrayDataPassagemVolta[]=0;
			$arrayValorPassagem[]=0;
			$arrayHoraPassagemIda[]=0;
			$arrayHoraPassagemVolta[]=0;
			$arrayTipoPassagem[]=0;
			$arrayPassagemValorDec[]=0;
	
	$countTotalPassagem=mysql_num_rows($sqlPassagem);
 while($objPassagem=mysql_fetch_object($sqlPassagem)){
			$destinoReferencia=$objPassagem->destino;
			$dataReferencia=$objPassagem->dtida;
			if($_SESSION['diariaSav']=='sim'){
				$sqlHospedagemReferencia=mysql_query("SELECT destino,dtida,dtvolta FROM savhospedagem WHERE idsav='".$numSav."'");
				while($objHospedagemReferencia=mysql_fetch_object($sqlHospedagemReferencia)){
				if($objHospedagemReferencia->dtida==$objPassagem->dtida && $objHospedagemReferencia->destino<>$destinoReferencia){
					$destinoReferencia=$objHospedagemReferencia->destino;
					if($objHospedagemReferencia->dtvolta<>$objPassagem->dtvolta){
					$dataReferencia=$objHospedagemReferencia->dtida;
					  }
					}
				}
			}
 $sqlValorDia=mysql_query("SELECT valor FROM savtabeladianac		 WHERE municipio='".$destinoReferencia."' AND classe='".$arrayClasse['classe']."'");			$arrayValorDia=mysql_fetch_array($sqlValorDia);
$arrayDatasPassagemIda[$countPassagem]=$objPassagem->dtida;
$arrayHoraPassagemIda[$countPassagem]=$objPassagem->horarioida;

if($countTotalPassagem==1 && $objPassagem->tipo==1){
	
	if($_SESSION['diariaSav']=='sim'){
				$sqlHospedagemReferencia2=mysql_fetch_array(mysql_query("SELECT destino,dtida,dtvolta FROM savhospedagem WHERE idsav='".$numSav."'"));
	$arrayDatasPassagemVolta[$countPassagem]=$sqlHospedagemReferencia2['dtvolta'];
					$arrayHoraPassagemVolta[$countPassagem]='manha';
	}else{
		$queryInicial=mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'") or die(mysql_error());
		$sqlRegistroInicial=mysql_fetch_array($queryInicial);
		$arrayDatasPassagemVolta[$countPassagem]=$sqlRegistroInicial['dtvolta'];
		$arrayHoraPassagemVolta[$countPassagem]=$sqlRegistroInicial['horariovolta'];
		}
}else{
	$arrayDatasPassagemVolta[$countPassagem]=$objPassagem->dtvolta;
					$arrayHoraPassagemVolta[$countPassagem]=$objPassagem->horariovolta;
	}
	
$arrayTipoPassagem[$countPassagem]=$objPassagem->tipo;
		if(!empty($arrayValorDia)){
					$arrayValorPassagem[$countPassagem]=(float)$arrayValorDia['valor'];
					}else{
						$sqlValorGeralRef=mysql_fetch_array(mysql_query("SELECT valor FROM savtabeladianac 											 WHERE municipio='9999' AND classe='".$arrayClasse['classe']."'"));
						$arrayValorPassagem[$countPassagem]=(float)$sqlValorGeralRef['valor'];
						}
					$arrayPassagemValorDec[$countPassagem]=str_replace(",",".",str_replace(".","",$objPassagem->valor));				
					$countPassagem++;
			//while
			}
			
			//Fim do laço de busca de dados
			$valorTotal=0;
			$valorPassagem=0;
			for($i=0;$i<$countPassagem;$i++){
				$qtdDias=0;
				$diasUteis=0;
				$valorVR=0;
				$valorTotalTrecho=0;
				$extraDia=0;
				$intervalo=0;
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
					 if($qtdDias>0){
					 $diasUteis=DiasUteis($arrayDatasPassagemIda[$i], $arrayDatasPassagemIda[$i+1]);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 }elseif(date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>0 && date("w", dataToTimestamp($arrayDatasPassagemIda[$i]))<>6){
							  $diasUteis=1;
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
					  if($extraDia==0){
						 if($diasUteis>0){
					 		$diasUteis=$diasUteis-1;
						 }
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
					 $numDiasDiaria=$numDiasDiaria+$qtdDias;		
					 $valorTotal=$valorTotal+$valorTotalTrecho;
				}elseif($countPassagem==1){
					//Quando for apenas IDA
					$inicio = date_create_from_format('d/m/Y',$arrayDatasPassagemIda[$i]);
					$fim = date_create_from_format('d/m/Y', $arrayDatasPassagemVolta[$i]);
					if($arrayDatasPassagemIda[$i]==$arrayDatasPassagemVolta[$i]){
						$qtdDias=1+$extraDia;
						}else{
					$intervalo = $inicio->diff($fim);
					$qtdDias=($intervalo->d)+$extraDia;
						}
					
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
	if($extraDia==0){
						 if($diasUteis>0){
					 		$diasUteis=$diasUteis-1;
						 }
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
							  $numDiasDiaria=$numDiasDiaria+$qtdDias;
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
					 if($extraDia==0){
						 if($diasUteis>0){
					 		$diasUteis=$diasUteis-1;
						 }
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
							  $numDiasDiaria=$numDiasDiaria+$qtdDias;
					$valorTotal=$valorTotal+$valorTotalTrecho;
					}
				}else{
					if($arrayHoraPassagemVolta[$i]=='tarde'){
						 $extraDia=0.5;
						 }elseif($arrayHoraPassagemVolta[$i]=='noite'){
							 $extraDia=1;
							 }
							 $inicio = date_create_from_format('d/m/Y',$arrayDatasPassagemIda[$i]);
					$fim = date_create_from_format('d/m/Y', $arrayDatasPassagemVolta[$i]);
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
	if($extraDia==0){
						 if($diasUteis>0){
					 		$diasUteis=$diasUteis-1;
						 }
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
							  $numDiasDiaria=$numDiasDiaria+$qtdDias;
					 $valorTotal=$valorTotal+$valorTotalTrecho;
					  					 
					}
			    }			
//(1 if)
}else{
	$countPassagem=0;
	$valorPassagem=0;
	$valorTotal=0;
	$_SESSION['passagemSav']='nao';
	
	if($_SESSION['diariaSav'] == 'sim'){
		$sqlHospedagemReferencia=mysql_query("SELECT * FROM savhospedagem WHERE idsav='".$numSav."'");
		$extraDia=0;
				while($objHospedagemReferencia=mysql_fetch_object($sqlHospedagemReferencia)){
				$inicio = date_create_from_format('d/m/Y',$objHospedagemReferencia->dtida);
					$fim = date_create_from_format('d/m/Y',$objHospedagemReferencia->dtvolta);
					$intervalo = $inicio->diff($fim);
					$qtdDias=($intervalo->d)+$extraDia;
					 $diasUteis=DiasUteis($objHospedagemReferencia->dtida, $objHospedagemReferencia->dtvolta);
					  if($diasUteis<0){
						 $diasUteis=0;
						 }
					 if($objHospedagemReferencia->dtida<>$objHospedagemReferencia->dtvolta){
					   if($diasUteis==0){
						 if( date("w", dataToTimestamp($objHospedagemReferencia->dtida))<>0 && date("w", dataToTimestamp($objHospedagemReferencia->dtida))<>6){
							 $diasUteis=1;
							 }
						 if(date("w", dataToTimestamp($objHospedagemReferencia->dtvolta))<>0 && date("w", dataToTimestamp($objHospedagemReferencia->dtvolta))<>6){
							  $diasUteis=1;
							 }
					   }
						 }else{
							  if(date("w", dataToTimestamp($objHospedagemReferencia->dtvolta))<>0 && date("w", dataToTimestamp($objHospedagemReferencia->dtvolta))<>6){
							  	$diasUteis=$diasUteis+1;
							   }
							 }
						 if($diasUteis>0){
					 		$diasUteis=$diasUteis-1;
						 }
					$sqlValorVr=mysql_query("SELECT * FROM savvalorvr");
					$numDiasDiaria=0;
					while($objValorVr=mysql_fetch_object($sqlValorVr)){
	$arrayVigenciaVr=explode("/",$objValorVr->vigencia);
	$arrayDataAtVr=explode("/",$objHospedagemReferencia->dtvolta);
	if(strtotime($arrayDataAtVr[2]."-".$arrayDataAtVr[1]."-".$arrayDataAtVr[0]) >= strtotime($arrayVigenciaVr[2]."-".$arrayVigenciaVr[1]."-".$arrayVigenciaVr[0])){
		$valorVRRef=$objValorVr->valor;
		  }
	}
$sqlValorDia=mysql_query("SELECT valor FROM savtabeladianac		 WHERE municipio='".$objHospedagemReferencia->destino."' AND classe='".$arrayClasse['classe']."'");			
$arrayValorDia=mysql_fetch_array($sqlValorDia);
	if(!empty($arrayValorDia)){
					$arrayValorPassagem=(float)$arrayValorDia['valor'];
					}else{
						$sqlValorGeralRef=mysql_fetch_array(mysql_query("SELECT valor FROM savtabeladianac 											 WHERE municipio='9999' AND classe='".$arrayClasse['classe']."'"));
						$arrayValorPassagem=(float)$sqlValorGeralRef['valor'];
						}				 
	$valorVR=$diasUteis*$valorVRRef;
					 if($_SESSION['diariaSav'] == 'sim'){
					 $valorTotalTrecho=(($arrayValorPassagem/2)*$qtdDias)-$valorVR;
					     }else{
							 $valorTotalTrecho=($arrayValorPassagem*$qtdDias)-$valorVR;
							 }
					 $numDiasDiaria=$numDiasDiaria+$qtdDias;
					 $valorTotal=$valorTotal+$valorTotalTrecho;
					}
		}else{
			
	$sqlValorDia=mysql_query("SELECT valor FROM savtabeladianac 
											 WHERE municipio='".$arrayRegistro['destinoida']."' AND classe='".$arrayClasse['classe']."'");
	 			$arrayValorDia=mysql_fetch_array($sqlValorDia);
				$numDiasDiaria=$numDiasGeral;
				$valorTotal=($numDiasGeral*$arrayValorDia['valor'])-$descontoVR;
	}
}
?>