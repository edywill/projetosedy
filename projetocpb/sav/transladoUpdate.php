<?php 
	$countLoc=0;
if($_SESSION['abrangenciaSav']=='Nacional'){
			 $cdMaterialLoc='800007003';//Cd_material locacao Nacional
			 $cdMaterialLocReduzido='80';//Cd_reduzido locacao nacional

}elseif($_SESSION['abrangenciaSav']=='Internacional'){
			  $cdMaterialLoc='800007003';//Cd_material locacao InterNacional
			 $cdMaterialLocReduzido='80';//Cd_reduzido locacao Internacional

	}
			 
		$sqlConsultaLocExiste=odbc_exec($conCab2,"SELECT Sequencia FROM COISOLIC (nolock) WHERE Cd_solicitacao='".$solicitacao."' AND Cd_material='".$cdMaterialLoc."'");
$countLocacaoUpd=0;
				 while($objLocExiste=odbc_fetch_object($sqlConsultaLocExiste)){
				 $sequenciaLoc=$objLocExiste->Sequencia;
				 //Update item e Teitemsoldiaria
				include "updateItemLoc.php";		
			$countLocacaoUpd++;
			}
			
			if($countLocacaoUpd<1){
		   //Inserir Item Diaria Novo
		   include "insertExclusivoTranslado.php";
	}
?>