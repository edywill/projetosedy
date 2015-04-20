<?php 
include "functionPrazos.php";
$solicitacao=$_POST['solicitacao'];
$setorGestor=$_POST['setorGestor'];
$controlesRej=buscaControleRejPres($solicitacao);
$rejControle=$controlesRej['ctrl_prz_rejeitado'];
$rejSitSolicitacao=$controlesRej['sit_solicitacao'];
$rejSitItem=$controlesRej['situac_item_sol'];
$controles=buscaControlesPrazos($setorGestor);
$justificativa=$_POST['justificativa'];
$comando=$_POST['comando'];
$usuario=$_POST['usuario'];
$acomp=0;
if(!empty($justificativa)){	
	if(incluiAcompanhamento($solicitacao,$setorGestor,$justificativa,"P")==1){
		//Busco as variÃ¡veis de controle com base no perfil da presidencia
$controles=buscaControlesPrazosPresidente();
//Crio as variÃ¡veis
$ctrlAprGestor=$controles['ctrl_prz_gestor'];
$ctrlAprovPres=$controles['ctrl_prz_aprov_presidente'];
$aprSitSolicitacao=$controles['sit_solicitacao'];
$aprtSitItem=$controles['situac_item_sol'];
$titAprovacao=$controles['tit_prz_justificado'];
$titRejeicao=$controles['tit_prz_rejeicao'];

	}else{ ?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php
		break;
	  }		
		if($comando=='A'){
			if(atualizaItensApr($ctrlAprovPres,$aprtSitItem,$usuario,$solicitacao,$ctrlAprGestor,$justificativa,$titAprovacao)==1){
				if(atualizaSolicApr($ctrlAprovPres,$aprSitSolicitacao,$usuario,$solicitacao,$justificativa,$titAprovacao)==1){
					desbloqueiaTabela($solicitacao);
					?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o enviada com sucesso!");
      	window.location.href = 'home.php';
       </script>
       <?php		
					}else{
					?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php			
						}
				}else{
					?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php		
					}
			//Se o comando for de reprovação
			}
			
			if($comando=='R'){
			if(atualizaItensRec($rejControle,$rejSitItem,$usuario,$solicitacao,$ctrlAprGestor,$justificativa,$titRejeicao)==1){
				if(atualizaSolicRec($rejControle,$rejSitSolicitacao,$usuario,$solicitacao,$justificativa,$titRejeicao)==1){
					//desbloqueiaTabela($solicitacao);
					?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o recusada com sucesso!");
      	window.location.href = 'home.php';
       </script>
       <?php		
					}else{
					?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php			
						}
				}else{
					?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o registro. Tente novamente!");
       history.back();
       </script>
       <?php	
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