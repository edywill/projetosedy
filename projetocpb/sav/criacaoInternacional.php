<?php 
//Cria o item de diaria
$situacao='P';
if($_SESSION['diariaSolSav']=='sim'){
			 $cdMaterialDiaria='101001005';//Cd_material diária Internacional
			 $cdMaterialDiariaReduzido='199';//Cd_reduzido diaria Internacional
			 include "insertItemDiaria.php";
			 
	if(!$resInsertItemDia){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao inserir o registro.\\n';
		}
		
		if($valida==0){
			atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaDia);
			include "insertExclusivoDiaria.php";
		if(!$resDiaNovo){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao criar o registro da diária.\\n';
			}		
		}
}
	//Verifica a existencia de cada tipo (passagem, hospedagem e transporte)
		//Inicio da Insercao de passagem
		if($_SESSION['passagemSav']=='sim'){
		  //Cria o item de diaria
			 $cdMaterialPassagem='101001009';//Cd_material passagem InterNacional
			 $cdMaterialPassagemReduzido='226';//Cd_reduzido passagem Internacional
			 include "insertItemPassagem.php";
			 
			 if(!$resInsertItemPas){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao inserir o registro.\\n';
		}
		if($valida==0){
			atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaPas);
			include "insertExclusivoPassagem.php";
			}	
		//Fim da insercao de Passagem
		//Insere Item de Hospedagem
		if($_SESSION['diariaSav']=='sim'){
		  //Cria o item de diaria
			 $cdMaterialHospedagem='101001013';//Cd_material passagem Nacional
			 $cdMaterialHospedagemReduzido='230';//Cd_reduzido passagem nacional
			 include "insertItemHospedagem.php";
			 if(!$resInsertItemHos){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao inserir o registro.\\n';
		}
		if($valida==0){
			atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaHos);
			include "insertExclusivoHospedagem.php";
			if($countErrorHot>0){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Problema ao inserir o registro exclusivo de hospedagem.\\n';
			  	}
			  }
			}
		//Fim do item de hospedagem
		
		//Insercao do item de locacao
		if($_SESSION['transladoSav']=='sim'){
		  //Cria o item de locacao
			 $countLoc=0;
			 $cdMaterialLoc='800007003';//Cd_material Loc InterNacional
			 $cdMaterialLocReduzido='80';//Cd_reduzido Loc Internacional
			 include "insertExclusivoTranslado.php";
			 atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaLoc);
	if($countLoc>0){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao inserir o registro de locação.\\n';
		}
	}
			}
?>