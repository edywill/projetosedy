<?php 
if($_SESSION['abrangenciaSav']=='Nacional'){
			 
			 $cdMaterialPassagem='101001011';//Cd_material passagem Nacional
			 $cdMaterialPassagemReduzido='228';//Cd_reduzido passagem nacional

}elseif($_SESSION['abrangenciaSav']=='Internacional'){
			 $cdMaterialPassagem='101001009';//Cd_material passagem InterNacional
			 $cdMaterialPassagemReduzido='226';//Cd_reduzido passagem Internacional

	}
			 
		$sqlConsultaPasExiste=odbc_fetch_array(odbc_exec($conCab2,"SELECT Sequencia FROM COISOLIC(nolock) WHERE Cd_solicitacao='".$solicitacao."' AND Cd_material='".$cdMaterialPassagem."'"));
			 if(!empty($sqlConsultaPasExiste['Sequencia'])){
$sequenciaPas=$sqlConsultaPasExiste['Sequencia'];
				 //Update item e Teitemsoldiaria
				include "updateItemPas.php";
		//Item exclusivo de diária
		  //Atualizar Exclusivo
		  include "updateItemExcPas.php";
		
			}else{
		   //Inserir Item Diaria Novo
		   include "insertItemPasUpd.php";	 
		
		if($valida==0){
			include "updateItemExcPas.php";				
		}
	}
?>