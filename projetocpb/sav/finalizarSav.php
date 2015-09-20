<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$valida=0;
$acao='';
$countError=0;
$errorMsg='';
$passagem=0;
$hospedagem=0;
$translado=0;
$erroPassagemIda=0;
$numSav=$_SESSION['numSav'];

//Passagem inicio
if($_SESSION['passagemSav']=='sim'){
			$sqlPassagem=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			$sqlPassagem2=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			$countPassagem=mysql_num_rows($sqlPassagem);
			$arrayTipo=mysql_fetch_array($sqlPassagem);
			if($countPassagem<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Necessario informar ao menos um item de passagem aerea.<br>';
				}else{
				if($countPassagem==1 && $arrayTipo['tipo']==1){
					//Não atualiza
					}else{
				$passagem=1;
				$dataIda='';
				$dataVolta='';
				$horarioVolta='';
	            $origemIda='';
				$destinoIda='';
				$horarioVoltaTemp='';
				$contador=0;
				while($objPassagem=mysql_fetch_object($sqlPassagem2)){									//Se for somente uma passagem
					if($countPassagem==1){
						if($objPassagem->tipo==2){
						$dataIda=$objPassagem->dtida;
						$dataVolta=$objPassagem->dtvolta;
						$horarioVolta=$objPassagem->horariovolta;
						$destinoIda=$objPassagem->destino;
						$origemIda=$objPassagem->origem;
						    }else{
								$dataIda=$objPassagem->dtida;
								//$dataVolta=$objPassagem->dtvolta;
								//$horarioVolta=$objPassagem->horariovolta;
								$destinoIda=$objPassagem->destino;
								$origemIda=$objPassagem->origem;
								$erroPassagemIda=1;
								}
						}else{
						//Caso sejam mais
						//Verifico se existe registro ou é o primeiro ciclo
							if($contador==0){
								if($objPassagem->tipo==2){
									$dataIda=$objPassagem->dtida;
									$dataVolta=$objPassagem->dtvolta;
									$horarioVolta=$objPassagem->horariovolta;
									$destinoIda=$objPassagem->destino;
									$origemIda=$objPassagem->origem;
						        }else{
								    $dataIda=$objPassagem->dtida;
								    $destinoIda=$objPassagem->destino;
								    $horarioVolta=$objPassagem->horarioida;
								    $origemIda=$objPassagem->origem;
								    $erroPassagemIda=1;
								 }
							   }else{
								  $dataVolta=$objPassagem->dtida;
								  $destinoIda=$objPassagem->destino;
								  $horarioVolta=$objPassagem->horarioida;
								  $erroPassagemIda=0;
								}
							$contador++;
							}
					} 
				$sqlRegistrosPas=mysql_fetch_array(mysql_query("SELECT dtida,dtvolta,destinoida,horariovolta FROM savregistros WHERE id='".$numSav."'"));
	if(empty($sqlRegistrosPas['dtida'])||empty($sqlRegistrosPas['dtvolta'])||empty($sqlRegistrosPas['horariovolta'])||empty($sqlRegistrosPas['destinoida'])){
		             //Atualiza tudo (ida, volta, horario ida, horario volta, cid origem, cid destino, origem e destino (ida e volta)
					 $updateRegistroPassagem="UPDATE savregistros SET dtida='".$dataIda."', dtvolta='".$dataVolta."',origemida='".$origemIda."',origemvolta='".$destinoIda."',destinoida='".$destinoIda."',destinovolta='".$origemIda."',horarioida='manha',horariovolta='".$horarioVolta."' WHERE id='".$numSav."'";
			$queryRegistroPassagem=mysql_query($updateRegistroPassagem);
			if(!$queryRegistroPassagem){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
					}else{
					//Atualiza somente dtida, dtvolta, horariovolta, destinoida e origemvolta
						$updateRegistroPassagem="UPDATE savregistros SET dtida='".$dataIda."', dtvolta='".$dataVolta."',origemvolta='".$destinoIda."',destinoida='".$destinoIda."',horariovolta='".$horarioVolta."' WHERE id='".$numSav."'";
			$queryRegistroPassagem=mysql_query($updateRegistroPassagem);
			if(!$queryRegistroPassagem){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
						}
				}
			  }
			}
//Passagem FIM
//HOspedagem Inicio
		if($_SESSION['diariaSav']=='sim'){
			$sqlHospedagem=mysql_query("SELECT * FROM savhospedagem WHERE idsav='".$numSav."' ORDER BY STR_TO_DATE(dtida,'%d/%m/%Y')");
			$countHospedagem=mysql_num_rows($sqlHospedagem);
			if($countHospedagem<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Caso a opcao de hospedagem seja marcada, necessario informar ao menos um registro.<br>';
				}else{
				$hospedagem=1;
				$dataIda='';
				$dataVolta='';
	            $origemIda='';
				$destinoIda='';
				$contador=0;
				while($objHospedagem=mysql_fetch_object($sqlHospedagem)){
					if($contador==0){
						$dataIda=$objHospedagem->dtida;
						$dataVolta=$objHospedagem->dtvolta;
	            		$origemIda=$objHospedagem->destino;
						$destinoIda=$objHospedagem->destino;	
						$erroPassagemIda=0;			
					}else{
						$destinoIda=$objHospedagem->destino;
						$dataVolta=$objHospedagem->dtvolta;
						$erroPassagemIda=0;
						}
				$contador++;
				}
				$sqlRegistrosHos=mysql_fetch_array(mysql_query("SELECT dtida,dtvolta,destinoida,horariovolta FROM savregistros WHERE id='".$numSav."'"));
	if((empty($sqlRegistrosHos['dtida'])||empty($sqlRegistrosHos['dtvolta'])||empty($sqlRegistrosHos['destinoida']))){
		             //Atualiza tudo (ida, volta, horario ida, horario volta, cid origem, cid destino, origem e destino (ida e volta)
					 $updateRegistroHospedagem="UPDATE savregistros SET dtida='".$dataIda."', dtvolta='".$dataVolta."',origemida='".$origemIda."',origemvolta='".$destinoIda."',destinoida='".$destinoIda."',destinovolta='".$origemIda."',horarioida='manha',horariovolta='manha' WHERE id='".$numSav."'";
			$queryRegistroHospedagem=mysql_query($updateRegistroHospedagem);
			if(!$queryRegistroHospedagem){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
					}else{
						$atualizaVolta='';
						if(empty($sqlRegistrosHos['horariovolta'])){
							$atualizaVolta="horariovolta='manha',";
							}
					//Atualiza somente destinoida e origemvolta
						$updateRegistroHospedagem="UPDATE savregistros SET origemvolta='".$destinoIda."',".$atualizaVolta." destinoida='".$destinoIda."' WHERE id='".$numSav."'";
			$queryRegistroHospedagem=mysql_query($updateRegistroHospedagem);
			if(!$queryRegistroHospedagem){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
						}
				}
			}
//Hospedagem FIM

//Transporte Inicio
		if($_SESSION['transladoSav']=='sim'){
			$sqlTranslado=mysql_query("SELECT * FROM savtranslado WHERE idsav='".$numSav."'");
			$countTranslado=mysql_num_rows($sqlTranslado);
			if($countTranslado<1){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Caso a opcao de transporte seja marcada, necessario informar ao menos um registro de locacao de veiculo.<br>';
				}else{
			$translado=1;
			$hospedagem=1;
				$dataIda='';
				$dataVolta='';
				$contador=0;
				while($objTranslado=mysql_fetch_object($sqlTranslado)){
						if($contador==0){
						$dataIda=$objTranslado->dtida;
						}
						$dataVolta=$objTranslado->dtvolta;
				        $contador++;
				}
			$sqlRegistrosTra=mysql_fetch_array(mysql_query("SELECT dtida,dtvolta,destinoida,horariovolta FROM savregistros WHERE id='".$numSav."'"));
	if(empty($sqlRegistrosTra['dtida'])||empty($sqlRegistrosTra['dtvolta'])||empty($sqlRegistrosTra['horariovolta'])||empty($sqlRegistrosTra['destinoida'])){
		$erroPassagemIda=1;
		             //Atualiza tudo (ida, volta, horario ida, horario volta, cid origem, cid destino, origem e destino (ida e volta)
					 
					}
				}
			}
//Transporte FIM

//Validação para somente diária
if($_SESSION['passagemSav']<>'sim' || $_SESSION['diariaSav'] <> 'sim' ||$_SESSION['transladoSav']<>'sim'){
	$sqlDadosDiaria=mysql_fetch_array(mysql_query("SELECT dtida,dtvolta,destinoida,horariovolta FROM savregistros WHERE id='".$numSav."'"));
	if(empty($sqlDadosDiaria['dtida'])||empty($sqlDadosDiaria['dtvolta'])||empty($sqlDadosDiaria['horariovolta'])||empty($sqlDadosDiaria['destinoida'])){
		$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Necessário informar os dados na aba Diária para cálculo da SAV.<br>';
		}
	}else{
		$sqlDadosDiaria=mysql_fetch_array(mysql_query("SELECT dtida,dtvolta,destinoida,horariovolta FROM savregistros WHERE id='".$numSav."'"));
	if(empty($sqlDadosDiaria['dtida'])||empty($sqlDadosDiaria['dtvolta'])||empty($sqlDadosDiaria['horariovolta'])||empty($sqlDadosDiaria['destinoida'])){
		        $valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Necessário informar os dados na aba Diária para cálculo da SAV.<br>';
		   }
		}
//Fim para validação somente diária


if($valida>0){
	echo $errorMsg;
	}else{
		echo "1";
	}
?>