<?php 
if($_SESSION['abrangenciaSav']=='Nacional'){
			 
			 $cdMaterialHospedagem='101001013';//Cd_material hospedagem Nacional
			 $cdMaterialHospedagemReduzido='230';//Cd_reduzido hospedagem nacional

}elseif($_SESSION['abrangenciaSav']=='Internacional'){
			 $cdMaterialHospedagem='101001013';//Cd_material Hospedagem Internacional
			 $cdMaterialHospedagemReduzido='230';//Cd_reduzido Hospedagem Internacional

	}
			 
		$sqlConsultaHosExiste=odbc_fetch_array(odbc_exec($conCab2,"SELECT Sequencia FROM COISOLIC (nolock) WHERE Cd_solicitacao='".$solicitacao."' AND Cd_material='".$cdMaterialHospedagem."'"));
			 if(!empty($sqlConsultaHosExiste['Sequencia'])){
				 $sequenciaHos=$sqlConsultaHosExiste['Sequencia'];
				 //Update item e Teitemsoldiaria
				include "updateItemHos.php";
		//Item exclusivo de diária
		  //Atualizar Exclusivo
		  include "updateItemExcHos.php";
		
			}else{
		   //Inserir Item Diaria Novo
		   include "insertItemHosUpd.php";	 
		
		if($valida==0){
			include "updateItemExcHos.php";				
		}
	}
?>