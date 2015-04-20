<?php 
if($_SESSION['abrangenciaSav']=='Nacional'){
			 $cdMaterialDiaria='101001003';//Cd_material diária Nacional
			 $cdMaterialDiariaReduzido='197';//Cd_reduzido diaria nacional
			 $sqlConsultaDiariaExiste=odbc_fetch_array(odbc_exec($conCab2,"SELECT Sequencia FROM COISOLIC WITH(NOLOCK) WHERE Cd_solicitacao='".$solicitacao."' AND Cd_material='".$cdMaterialDiaria."'"));
			 if(!empty($sqlConsultaDiariaExiste['Sequencia'])){
				 $sequenciaDia=$sqlConsultaDiariaExiste['Sequencia'];
				 //Update item e Teitemsoldiaria
				include "updateItemDiaria.php";
		//Item exclusivo de diária
		$sqlItemDiariaExc=odbc_fetch_array(odbc_exec($conCab2,"SELECT id_registro FROM TEITEMSOLDIARIAVIAGEM WITH(NOLOCK) WHERE solicitacao='".$solicitacao."' AND sequencia='".$sqlConsultaDiariaExiste['Sequencia']."'"));
		if(!empty($sqlItemDiariaExc['id_registro'])){
		  //Atualizar Exclusivo
		  include "updateItemExcDiaria.php";
		}else{
			//Inserir Item exclusivo
			include "insertItemExcDiariaUpd.php";
				}
			}else{
		   //Inserir Item Diaria Novo
		   include "insertItemDiariaUpd.php";	 
		
		if($valida==0){
			include "insertItemDiariaExcUpd2.php";				
		}
	}
}elseif($_SESSION['abrangenciaSav']=='Internacional'){
			 $cdMaterialDiaria='101001005';//Cd_material diária Internacional
			 $cdMaterialDiariaReduzido='199';//Cd_reduzido diaria Internacional
			 $sqlConsultaDiariaExiste=odbc_fetch_array(odbc_exec($conCab2,"SELECT Sequencia FROM COISOLIC WITH(NOLOCK) WHERE Cd_solicitacao='".$solicitacao."' AND Cd_material='".$cdMaterialDiaria."'"));
			 if(!empty($sqlConsultaDiariaExiste['Sequencia'])){
				 $sequenciaDia=$sqlConsultaDiariaExiste['Sequencia'];
				 //Update item e Teitemsoldiaria
				include "updateItemDiaria.php";
		//Item exclusivo de diária
		$sqlItemDiariaExc=odbc_fetch_array(odbc_exec($conCab2,"SELECT id_registro FROM TEITEMSOLDIARIAVIAGEM WITH(NOLOCK) WHERE solicitacao='".$solicitacao."' AND sequencia='".$sqlConsultaDiariaExiste['Sequencia']."'"));
		if(!empty($sqlItemDiariaExc['id_registro'])){
		  //Atualizar Exclusivo
		  include "updateItemExcDiaria.php";
		}else{
			//Inserir Item exclusivo
			include "insertItemExcDiariaUpd.php";
				}
			}else{
		   //Inserir Item Diaria Novo
		   include "insertItemDiariaUpd.php";	 
		
		if($valida==0){
			include "insertItemDiariaExcUpd2.php";				
		 }
		}
	}
?>