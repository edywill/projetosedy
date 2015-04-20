<?php 
include "functionPrazos.php";
$solicitacao=$_POST['solicitacao'];
$setorGestor=$_POST['setorGestor'];
$controles=buscaControlesPrazos($setorGestor);
$justificativa=$_POST['justificativa'];
$comando=$_POST['comando'];
$usuario=$_POST['usuario'];
$acomp=0;
if(!empty($justificativa)){	
	if(incluiAcompanhamento($solicitacao,$setorGestor,$justificativa,"G")==1){
		$controleAprovado=buscaControleAprovado();
		$ctrlAprovGestor=$controleAprovado['ctrl_prz_gestor'];
		$aprSitSolicitacao=$controleAprovado['sit_solicitacao'];
		$aprSitItem=$controleAprovado['situac_item_sol'];
		$titAprovacao=$controleAprovado['tit_prz_justificado'];
		$titRejeicao=$controleAprovado['tit_prz_rejeicao'];
	}else{ ?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php
		break;
	  }		
		if($comando=='A'){
			if(atualizaItensApr($ctrlAprovGestor,$aprSitItem,$usuario,$solicitacao,$controles['ctrl_prz_inferior'],$justificativa,$titAprovacao)==1){
				if(atualizaSolicApr($ctrlAprovGestor,$aprSitSolicitacao,$usuario,$solicitacao,$justificativa,$titAprovacao)==1){
					?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o Enviada com sucesso!");
      	window.location.href = 'home.php';
       </script>
       <?php		
			//Se o comando for de reprovação
			 }
			}
		   }
			if($comando=='R'){
			if(atualizaItensRec($controles['ctrl_prz_rejeitado'],$controles['situac_item_sol'],$usuario,$solicitacao,$controles['ctrl_prz_inferior'],$justificativa,$titRejeicao)==1){
				if(atualizaSolicRec($controles['ctrl_prz_rejeitado'],$controles['sit_solicitacao'],$usuario,$solicitacao,$justificativa,$titRejeicao)==1){
					?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o recusada com sucesso!");
      	window.location.href = 'home.php';
       </script>
       <?php		
					   }
					 }
			       }
					  }else{
		?>
       <script type="text/javascript">
       alert("Informe uma justificativa.");
       history.back();
       </script>
       <?php
	   break;
	}
?>