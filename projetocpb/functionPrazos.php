	<?php 
	//Buscar setor do gestor
    function buscaSetorPrazos($codigoGestor){
        require "conectsqlserverci.php";
		$sqlBuscaSetor="select  emp.cd_setor
    from GEUSUARI usu (nolock)
    inner join GEEMPRES emp (nolock) on emp.cd_empresa = usu.campo20
    where usu.cd_usuario = '".$codigoGestor."'";
        $resBuscaSetor = odbc_exec($conCab, $sqlBuscaSetor) or die(odbc_error());
        $arrayBuscaSetor=odbc_fetch_array($resBuscaSetor);
        return $arrayBuscaSetor;
        }
    //Buscar Controle de aprovaçã0/rejeição
	function buscaControleAprovado(){
		require "conectsqlserverci.php";
		$sqlBuscaControleAprovado="select par.ctrl_prz_gestor,
       apr.sit_solicitacao,
       apr.situac_item_sol,      
       par.tit_prz_justificado,
       par.tit_prz_rejeicao
from TEPARAMVERBA par (nolock)
left join COCSO apr (nolock) on apr.controle = par.ctrl_prz_gestor";
		$resBuscaControleAprovado = odbc_exec($conCab, $sqlBuscaControleAprovado) or die(odbc_error());
    	$arrayBuscaControleAprovado=odbc_fetch_array($resBuscaControleAprovado);
    	return $arrayBuscaControleAprovado;
		}

    //Busca os controles do gestor
    function buscaControlesPrazos($setorGestor){
        require "conectsqlserverci.php";
        $sqlBuscaControles="select seto.ctrl_prz_inferior,
           seto.ctrl_prz_rejeitado,
           rep.sit_solicitacao,
           rep.situac_item_sol
    from TECTRLORGM seto (nolock)
    left join COCSO rep (nolock) on rep.controle = seto.ctrl_prz_rejeitado
    where seto.organograma = '".$setorGestor."'";
    $resBuscaControles = odbc_exec($conCab, $sqlBuscaControles) or die(odbc_error());
    $arrayBuscaControles=odbc_fetch_array($resBuscaControles);
    return $arrayBuscaControles;
        }
    //Busca os controles do presidente
    function buscaControlesPrazosPresidente(){
        require "conectsqlserverci.php";
        $sqlBuscaControlesP="select par.ctrl_prz_gestor,
       par.ctrl_prz_aprov_presidente,
       apr.sit_solicitacao,
       apr.situac_item_sol,      
       par.tit_prz_justificado,
       par.tit_prz_rejeicao
from TEPARAMVERBA par (nolock)
left join COCSO apr (nolock) on apr.controle = par.ctrl_prz_aprov_presidente";
    $resBuscaControlesP = odbc_exec($conCab, $sqlBuscaControlesP) or die(odbc_error());
    $arrayBuscaControlesP=odbc_fetch_array($resBuscaControlesP);
    return $arrayBuscaControlesP;
        }
   //Busca outros controles do presidente
   function buscaControleRejPres($solicRej){
	    require "conectsqlserverci.php";
        $sqlBuscaControlesRejP="select ctrl_prz_rejeitado,
       rej.sit_solicitacao,
       rej.situac_item_sol
from TESOLJUST jus (nolock)
inner join TECTRLORGM seto (nolock) on seto.organograma = jus.setor_gestor
left join COCSO rej (nolock) on rej.controle = ctrl_prz_rejeitado
where jus.solicitacao = ".$solicRej."
and jus.tipo = 'G'";
    $resBuscaControlesRejP = odbc_exec($conCab, $sqlBuscaControlesRejP) or die(odbc_error());
    $arrayBuscaControlesRejP=odbc_fetch_array($resBuscaControlesRejP);
    return $arrayBuscaControlesRejP;
	   }
   //Busca as CIs do Gestor que estão pendentes
	function listaCiPrazosGestor($ctrlInfGestorLista,$userGestorPrazos,$setorGestorPrazos){
		include "mb.php";
		require "conectsqlserverci.php";
		$sqlListaCiGestor="select ci.Solicitacao, ci.Desc_cond_pag,ci.Data
						  from COSOLICI ci (nolock)
						  where ci.situacao not in ('L','C')
						  and exists(select 1
									 from TEITEMSOLPRZBLOQ bloq (nolock)
									 where bloq.solicitacao = ci.solicitacao
									 and bloq.bloqueado = 1)
						  and exists(select 1
									 from COISOLIC ici (nolock)
									 where ici.cd_solicitacao = ci.solicitacao
									 and ici.cd_especie_esto = 'E'
									 and ici.campo65 in ('".$ctrlInfGestorLista."'))";
		$resListaCiGestor = odbc_exec($conCab, $sqlListaCiGestor) or die(odbc_error());
		
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='50'>Solicitar Aprova&ccedil;&atilde;o</th><th width='50'>Recusar CI</th><th width='50'>Visualizar CI</th></tr>";
		while($objPrazGestor=odbc_fetch_object($resListaCiGestor)){
		
		$SQLConsItemCIV = "SELECT 
										COISOLIC.Quantidade,COISOLIC.Pr_unitario,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objPrazGestor->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='ciWFPrazoGestJust.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$userGestorPrazos."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objPrazGestor->Solicitacao."' size='40' type='hidden' /><input name='setorGestor' id='setorGestor' value='".$setorGestorPrazos."' size='40' type='hidden' /><input name='tipo' id='tipo' value='A' size='40' type='hidden' />".$objPrazGestor->Solicitacao."</td><td>".date('d/m/Y',strtotime($objPrazGestor->Data))."</td><td>".$nomeCompleto."</td><td>".$objPrazGestor->Desc_cond_pag."</td><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td><td><input name='enviar5' class='button' type='submit' value='Solicitar Aprov.' /></form></td><form action='ciWFPrazoGestJust.php' method='post' name='form4.id_CIItens' ><td><input name='setorGestor' id='setorGestor' value='".$setorGestorPrazos."' size='40' type='hidden' /><input name='user_ci' id='user_ci' value='".$userGestorPrazos."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objPrazGestor->Solicitacao."' size='40' type='hidden' /><input name='tipo' id='tipo' value='R' size='40' type='hidden' /><input name='enviar6' class='button' type='submit' value='Recusar CI' /></td><td> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' ><input name='id_ciImpressao' id='id_ciImpressao' value='".$objPrazGestor->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='button' type='submit' value='Visualizar CI' /></form></td></tr>";
			}
			echo "</table></div>";
		}
	//Busca as CIs do presidente que estão pendentes
	function listaCiPrazosPresidente($ctrlGestorP){
		include "mb.php";
		require "conectsqlserverci.php";
		$sqlListaCiPresidente="select ci.Solicitacao, ci.Desc_cond_pag,ci.Data,jus.justificativa
from COSOLICI ci (nolock)
inner join TESOLJUST jus (nolock) on jus.tipo = 'G'
                                     and jus.solicitacao = ci.solicitacao
where ci.situacao not in ('L','C')
--devemos considerar apenas CI's cujo prazo de entrega esteja bloqueado
and exists(select 1
           from TEITEMSOLPRZBLOQ bloq (nolock)
           where bloq.solicitacao = ci.solicitacao
           and bloq.bloqueado = 1)
--devemos considerar apenas CI's que sejam do setor do gestor
and exists(select 1
           from COISOLIC ici (nolock)
           where ici.cd_solicitacao = ci.solicitacao
           and ici.cd_especie_esto = 'E'
           --controle aplicado após o gestor ter justificado o prazo inconsistente
           and ici.campo65 in ('".$ctrlGestorP."'))";
		$resListaCiPres = odbc_exec($conCab, $sqlListaCiPresidente) or die(odbc_error());
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='60'>Justificativa Gestor</th><th width='50'>Aprovar CI</th><th width='50'>Recusar CI</th><th width='50'>Visualizar CI</th></tr>";
		while($objPrazPres=odbc_fetch_object($resListaCiPres)){
		
		$SQLConsItemCIV = "SELECT 
										COISOLIC.Quantidade,COISOLIC.Pr_unitario,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objPrazPres->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='ciWFPrazoPresJust.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='AWP' size='40' type='hidden' />
			<input name='id_ci' id='id_ci' value='".$objPrazPres->Solicitacao."' size='40' type='hidden' />
			<input name='tipo' id='tipo' value='A' size='40' type='hidden' />".$objPrazPres->Solicitacao."</td>
			<td>".date('d/m/Y',strtotime($objPrazPres->Data))."</td>
			<td>".$nomeCompleto."</td><td>".$objPrazPres->Desc_cond_pag."</td>
			<td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td>
			<td>".$objPrazPres->justificativa."</td>
			<td><input name='enviar5' class='button' type='submit' value='Aprovar CI' />
			</form></td><form action='ciWFPrazoPresJust.php' method='post' name='form4.id_CIItens' ><td>
			<input name='user_ci' id='user_ci' value='AWP' size='40' type='hidden' />
			<input name='id_ci' id='id_ci' value='".$objPrazPres->Solicitacao."' size='40' type='hidden' />
			<input name='tipo' id='tipo' value='R' size='40' type='hidden' />
			<input name='enviar6' class='button' type='submit' value='Recusar CI' /></td>
			<td> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' >
			<input name='id_ciImpressao' id='id_ciImpressao' value='".$objPrazPres->Solicitacao."' size='40' type='hidden' />
			<input name='enviar7' class='button' type='submit' value='Visualizar CI' /></form></td></tr>";
			}
			echo "</table></div>";
		}
    //Inclui o acompanhamento da solicitação
	function incluiAcompanhamento($solicAcomp,$stGestAcomp,$justAcomp,$tipoAcompJust){
		require "conectsqlserverci.php";
		include "mb.php";
		$sqlJustificativa="insert into TESOLJUST
   (
   solicitacao,
   tipo,
   setor_gestor,
   justificativa,
   data,
   hora
   )
values
   (
    ".$solicAcomp.",
	'".$tipoAcompJust."',
	'".trim($stGestAcomp)."',
	'".trim($justAcomp)."',
    convert(date,getdate(),103),
    CAST('".date("His")."' AS VARCHAR))";
		$resJustificativa = odbc_exec($conCab, $sqlJustificativa);
		if($resJustificativa){
			return 1;
			}
		}
	//Função para atualizar os itens quando aprovados
    function atualizaItensApr($ctrlAprovGestItens,$aprSitSolicItens,$usuarioItens,$solicitacaoItens,$controlesInfItens,$justItensAp,$tituloAprItens){
		require "conectsqlserverci.php";
		$sqlContaItens=odbc_exec($conCab,"SELECT cd_solicitacao,sequencia,campo65 FROM COISOLIC (nolock) WHERE cd_solicitacao='".$solicitacaoItens."'");
		$contItens=0;
		while($objContaItens=odbc_fetch_object($sqlContaItens)){
		$sqlAtItensApr="update COISOLIC
						set campo65 = '".$ctrlAprovGestItens."',
							situacao = '".$aprSitSolicItens."',
							usuario_modific = '".$usuarioItens."',
							dt_modificacao = dbo.CGFC_DATAATUAL()
						where cd_especie_esto = 'E'
						and cd_solicitacao = '".$solicitacaoItens."'
						and campo65 in ('".$controlesInfItens."')";
		$resAtItensApr = odbc_exec($conCab, $sqlAtItensApr);
		$controleAnteriorItensAp=$objContaItens->campo65;
		$sequenciaItensAp=$objContaItens->sequencia;
		$controleNovoItensAp=$ctrlAprovGestItens;
		acompanhamentoItens($controleAnteriorItensAp,$controleNovoItensAp,$solicitacaoItens,$sequenciaItensAp,$usuarioItens);
		acompanhamentoItensJust($solicitacaoItens,$sequenciaItensAp,$usuarioItens,$justItensAp,$tituloAprItens);
		$contItens++;
		}
		if($contItens<>0){
			return 1;
			}
	}
	//Função para atualizar a capa da solicitacao quando aprovada
    function atualizaSolicApr($ctrlAprovGestSolic,$aprSitSolic,$usuarioSolic,$solicitacaoId,$justSolic,$tituloApr){
		require "conectsqlserverci.php";
		$sqlControleAp=odbc_exec($conCab,"SELECT campo27 FROM COSOLICI (nolock) WHERE solicitacao='".$solicitacaoId."'");
		$arrayControleAp=odbc_fetch_array($sqlControleAp);
		$controleAnteriorCapaAp=$arrayControleAp['campo27'];
		$controleNovoCapaAp=$ctrlAprovGestSolic;
		acompanhamentoCapa($controleAnteriorCapaAp,$controleNovoCapaAp,$solicitacaoId,$usuarioSolic);
		acompanhamentoCapaJust($solicitacaoId,$usuarioSolic,$justSolic,$tituloApr);
		$sqlAtSolicApr="update COSOLICI
						set campo27 = '".$ctrlAprovGestSolic."',
							situacao = '".$aprSitSolic."',
							usuario_modific = '".$usuarioSolic."',
							dt_modificacao = dbo.CGFC_DATAATUAL()
						where solicitacao = '".$solicitacaoId."'";
		$resAtSolicApr = odbc_exec($conCab, $sqlAtSolicApr);
		if($resAtSolicApr<>0){
			return 1;
			}
	}
	//Função para atualizar os itens quando recusados
    function atualizaItensRec($rejControle,$rejContItens,$usuarioItensRec,$solicitacaoItensRec,$controlesInfItensRec,$tituloRecItens,$justItensRec){
		require "conectsqlserverci.php";
		$sqlContaItensRec=odbc_exec($conCab,"SELECT cd_solicitacao,campo65,sequencia FROM COISOLIC (nolock) WHERE cd_solicitacao='".$solicitacaoItensRec."'");
		$contItensRec=0;
		while($objContaItensRec=odbc_fetch_object($sqlContaItensRec)){
		$controleAnteriorItensRec=$objContaItensRec->campo65;
		$sequenciaItensRec=$objContaItensRec->sequencia;
		$controleNovoItensRec=$rejControle;
		acompanhamentoItens($controleAnteriorItensRec,$controleNovoItensRec,$solicitacaoItensRec,$sequenciaItensRec,$usuarioItensRec);
		acompanhamentoItensJust($solicitacaoItensRec,$sequenciaItensRec,$usuarioItensRec,$justItensRec,'507');
		$sqlAtItensRec="update COISOLIC
						set campo65 = '".$rejControle."',
							situacao = '".$rejContItens."',
							usuario_modific = '".$usuarioItensRec."',
							dt_modificacao = dbo.CGFC_DATAATUAL()
						where cd_especie_esto = 'E'
						and cd_solicitacao = '".$solicitacaoItensRec."'
						and campo65 in ('".$controlesInfItensRec."')";
		$resAtItensRec = odbc_exec($conCab, $sqlAtItensRec);
		$contItensRec++;
		}
		if($contItensRec<>0){
			return 1;
			}
	}
	//Função para atualizar a capa da solicitacao quando aprovada
    function atualizaSolicRec($rejControleSolic,$rejSitContSolic,$usuarioSolicRec,$solicitacaoRec,$justCapaRec,$tituloRecCapa){
		require "conectsqlserverci.php";
		$sqlControleRec=odbc_exec($conCab,"SELECT campo27 FROM COSOLICI (nolock) WHERE solicitacao='".$solicitacaoRec."'");
		$arrayControleRec=odbc_fetch_array($sqlControleRec);
		$controleAnteriorCapaRec=$arrayControleRec['campo27'];
		$controleNovoCapaRec=$rejControleSolic;
		acompanhamentoCapa($controleAnteriorCapaRec,$controleNovoCapaRec,$solicitacaoRec,$usuarioSolicRec);
		acompanhamentoCapaJust($solicitacaoRec,$usuarioSolicRec,$justCapaRec,$tituloRecCapa);
		$sqlAtSolicRec="update COSOLICI
						set campo27 = '".$rejControleSolic."',
							situacao = '".$rejSitContSolic."',
							usuario_modific = '".$usuarioSolicRec."',
							dt_modificacao = dbo.CGFC_DATAATUAL()
						where solicitacao = '".$solicitacaoRec."'";
		$resAtSolicRec = odbc_exec($conCab, $sqlAtSolicRec);
		if($resAtSolicRec<>0){
			return 1;
			}
	}
	//Função para buscar dados do controle
	function buscaDadosControle($controleBuscaFunction){
		require "conectsqlserverci.php";
		$SQLConsContrCI = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol,
							  COCSO.controle
					   FROM COCSO WITH(nolock)
					   WHERE controle = '".$controleBuscaFunction."'";
				$resConsContrCI = odbc_exec($conCab, $SQLConsContrCI);
				$arrayConsContrCI = odbc_fetch_array($resConsContrCI);
		return $arrayConsContrCI;
		}
	//Inserir acompanhamento dos itens da solicitacao
	function acompanhamentoItens($controleAnteriorItens,$controleNovoItens,$solicitacaoItens,$sequenciaItens,$usuarioItens){
		require "conectsqlserverci.php";
				$dataCiItens=date("d.m.y");
				$horaCiItens=date("H:i:s");
				$horaSessaoCiItens=date("His");
				
				$arrayConsContrCIAntItens=buscaDadosControle($controleAnteriorItens);
				$descContCIItem=mb_convert_encoding($arrayConsContrCIAntItens['descricao'],"UTF-8","ISO-8859-1");
				
				$arrayConsContrCIItens=buscaDadosControle($controleNovoItens);
				$descContCIItemNovo=mb_convert_encoding($arrayConsContrCIItens['descricao'],"UTF-8","ISO-8859-1");
				
				$historicoCiItens="O controle do item da solicitação foi alterado de ".$controleAnteriorItens." - ".rtrim($descContCIItem)." para ".$controleNovoItens." - ".rtrim($descContCIItemNovo)." . Alteração realizada pelo usuário ".strtoupper($usuarioItens)." em ".$dataCiItens." às ".$horaCiItens.".";
			$converterHistoricoCiItens=mb_convert_encoding($historicoCiItens,"ISO-8859-1","UTF-8");
			$ciUpdateItensSol=str_pad($solicitacaoItens, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeq=str_pad($sequenciaItens, 3, "0", STR_PAD_LEFT);
			$ciUpdateItens=$ciUpdateItensSol."/".$ciUpdateItensSeq;
			
			$insertAcompItens="insert into GEACOMP
   (
   cd_empresa,
   embarque_pedido,
   contato_os_lanc,
   sequencia_item,
   tipo_acompanham,
   codigo_titulo,
   dt_prevista,
   dt_realizada,
   hora_prevista,
   hora_realizada,
   usuario,
   sessao,
   campo13,
   campo14,
   campo15,
   campo16,
   campo17,
   campo18,
   campo19,
   campo20,
   campo21,
   campo22,
   campo23,
   campo24,
   campo25,
   campo26,
   campo27,
   campo28,
   campo29,
   campo30,
   campo31,
   campo32,
   campo33,
   campo34,
   campo35,
   campo36,
   campo37,
   campo38,
   campo39,
   campo40,
   campo41,
   sequencia_conta,
   contato,
   data,
   hora,
   dt_repr1,
   dt_repr2,
   cd_contatante,
   historico
   )
values
   (
   '      ',                     --  Cd_empresa  char(6)
   '".$ciUpdateItens."',               --  Embarque_pedido  char(12)
   ".$solicitacaoItens.",                          --  Contato_os_lanc  int 
   ".$sequenciaItens.",                            --  Sequencia_item  int 
   'R',                          --  Tipo_acompanham  char(1)
   '802',                        --  Codigo_titulo  char(3)
   NULL,                         --  Dt_prevista  datetime 
   NULL,                         --  Dt_realizada  datetime 
   NULL,                         --  Hora_prevista  char(6)
   NULL,                         --  Hora_realizada  char(6)
   '".$usuarioItens."',                        --  Usuario  char(3)
   0,                            --  Sessao  int 
   NULL,                         --  Campo13  datetime 
   NULL,                         --  Campo14  datetime 
   NULL,                         --  Campo15  datetime 
   NULL,                         --  Campo16  datetime 
   NULL,                         --  Campo17  char(6)
   0,                            --  Campo18  float 
   0,                            --  Campo19  float 
   0,                            --  Campo20  float 
   0,                            --  Campo21  float 
   0,                            --  Campo22  float 
   0,                            --  Campo23  float 
   0,                            --  Campo24  float 
   0,                            --  Campo25  float 
   'N',                          --  Campo26  char(1)
   ' ',                          --  Campo27  char(1)
   ' ',                          --  Campo28  char(1)
   '  ',                         --  Campo29  char(2)
   '  ',                         --  Campo30  char(2)
   '  ',                         --  Campo31  char(2)
   '   ',                        --  Campo32  char(3)
   '   ',                        --  Campo33  char(3)
   '   ',                        --  Campo34  char(3)
   '      ',                     --  Campo35  char(6)
   '      ',                     --  Campo36  char(6)
   '      ',                     --  Campo37  char(6)
   '            ',               --  Campo38  char(12)
   1,                            --  Campo39  bit 
   0,                            --  Campo40  bit 
   0,                            --  Campo41  bit 
   0,                            --  Sequencia_conta  int 
   '',                           --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),    --  Data  datetime 
   '".$horaSessaoCiItens."',                     --  Hora  char(6)
   NULL,                         --  Dt_repr1  datetime 
   NULL,                         --  Dt_repr2  datetime 
   '      ',                     --  Cd_contatante  char(6)
   '".$converterHistoricoCiItens."')";
   $resAcompItens = odbc_exec($conCab, $insertAcompItens);
   
		}
		//Inserir acompanhamento com a justificativa no CIGAM
	function acompanhamentoItensJust($solicitacaoItensJust,$sequenciaItensJust,$usuarioItensJust,$justItens,$tituloItens){
		require "conectsqlserverci.php";
		$horaSessaoCiItensJust=date("His");
		$ciUpdateItensSolJust=str_pad($solicitacaoItensJust, 8, "0", STR_PAD_LEFT);
		$ciUpdateItensSeqJust=str_pad($sequenciaItensJust, 3, "0", STR_PAD_LEFT);
		$ciUpdateItensJust=$ciUpdateItensSolJust."/".$ciUpdateItensSeqJust;
		$sqlAcompItensJust="insert into GEACOMP
   (
   cd_empresa,
   embarque_pedido,
   contato_os_lanc,
   sequencia_item,
   tipo_acompanham,
   codigo_titulo,
   dt_prevista,
   dt_realizada,
   hora_prevista,
   hora_realizada,
   usuario,
   sessao,
   campo13,
   campo14,
   campo15,
   campo16,
   campo17,
   campo18,
   campo19,
   campo20,
   campo21,
   campo22,
   campo23,
   campo24,
   campo25,
   campo26,
   campo27,
   campo28,
   campo29,
   campo30,
   campo31,
   campo32,
   campo33,
   campo34,
   campo35,
   campo36,
   campo37,
   campo38,
   campo39,
   campo40,
   campo41,
   sequencia_conta,
   contato,
   data,
   hora,
   dt_repr1,
   dt_repr2,
   cd_contatante,
   historico
   )
values
   (
   '      ',                     --  Cd_empresa  char(6)
   '".$ciUpdateItensJust."',               --  Embarque_pedido  char(12)
   ".$solicitacaoItensJust.",                          --  Contato_os_lanc  int 
   ".$sequenciaItensJust.",                            --  Sequencia_item  int 
   'R',                          --  Tipo_acompanham  char(1)
   '".str_replace(" ","",$tituloItens)."',                        --  Codigo_titulo  char(3)
   NULL,                         --  Dt_prevista  datetime 
   NULL,                         --  Dt_realizada  datetime 
   NULL,                         --  Hora_prevista  char(6)
   NULL,                         --  Hora_realizada  char(6)
   '".$usuarioItensJust."',                        --  Usuario  char(3)
   0,                            --  Sessao  int 
   NULL,                         --  Campo13  datetime 
   NULL,                         --  Campo14  datetime 
   NULL,                         --  Campo15  datetime 
   NULL,                         --  Campo16  datetime 
   NULL,                         --  Campo17  char(6)
   0,                            --  Campo18  float 
   0,                            --  Campo19  float 
   0,                            --  Campo20  float 
   0,                            --  Campo21  float 
   0,                            --  Campo22  float 
   0,                            --  Campo23  float 
   0,                            --  Campo24  float 
   0,                            --  Campo25  float 
   'N',                          --  Campo26  char(1)
   ' ',                          --  Campo27  char(1)
   ' ',                          --  Campo28  char(1)
   '  ',                         --  Campo29  char(2)
   '  ',                         --  Campo30  char(2)
   '  ',                         --  Campo31  char(2)
   '   ',                        --  Campo32  char(3)
   '   ',                        --  Campo33  char(3)
   '   ',                        --  Campo34  char(3)
   '      ',                     --  Campo35  char(6)
   '      ',                     --  Campo36  char(6)
   '      ',                     --  Campo37  char(6)
   '            ',               --  Campo38  char(12)
   1,                            --  Campo39  bit 
   0,                            --  Campo40  bit 
   0,                            --  Campo41  bit 
   0,                            --  Sequencia_conta  int 
   '',                           --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),    --  Data  datetime 
   '".trim($horaSessaoCiItensJust)."',                     --  Hora  char(6)
   NULL,                         --  Dt_repr1  datetime 
   NULL,                         --  Dt_repr2  datetime 
   '      ',                     --  Cd_contatante  char(6)
   '".trim($justItens)."')";
	$resAcompItensJust = odbc_exec($conCab, $sqlAcompItensJust);
		}
	//Inserir acompanhamento para Capa da CI
	function acompanhamentoCapa($controleAnteriorCapa,$controleNovoCapa,$solicitacaoCapa,$usuarioCapa){
		require "conectsqlserverci.php";
		       $dataCi=date("d.m.y");
				$horaCi=date("H:i:s");
				$horaSessaoCi=date("His");
				echo $controleAnteriorCapa;
				$arrayConsContrCIAnt=buscaDadosControle($controleAnteriorCapa);
				$descContCIAnt=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
				
				$arrayConsContrCI=buscaDadosControle($controleNovoCapa);
				$descContCI=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
				
				$historicoCi="O controle do item da solicitação foi alterado de ".$controleAnteriorCapa." - ".rtrim($descContCIAnt)." para ".$controleNovoCapa." - ".rtrim($descContCI)." . Alteração realizada pelo usuário ".strtoupper($usuarioCapa)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCi=mb_convert_encoding($historicoCi,"ISO-8859-1","UTF-8");
			$ciUpdateCapa=str_pad($solicitacaoCapa, 8, " ", STR_PAD_LEFT);
			
			$insertAcompCapa="insert into GEACOMP
   (
   cd_empresa,
   embarque_pedido,
   contato_os_lanc,
   sequencia_item,
   tipo_acompanham,
   codigo_titulo,
   dt_prevista,
   dt_realizada,
   hora_prevista,
   hora_realizada,
   usuario,
   sessao,
   campo13,
   campo14,
   campo15,
   campo16,
   campo17,
   campo18,
   campo19,
   campo20,
   campo21,
   campo22,
   campo23,
   campo24,
   campo25,
   campo26,
   campo27,
   campo28,
   campo29,
   campo30,
   campo31,
   campo32,
   campo33,
   campo34,
   campo35,
   campo36,
   campo37,
   campo38,
   campo39,
   campo40,
   campo41,
   sequencia_conta,
   contato,
   data,
   hora,
   dt_repr1,
   dt_repr2,
   cd_contatante,
   historico
   )
values
   (
   '      ',                     --  Cd_empresa  char(6)
   '".$ciUpdateCapa."',               --  Embarque_pedido  char(12)
   0,                          --  Contato_os_lanc  int 
   0,                            --  Sequencia_item  int 
   'R',                          --  Tipo_acompanham  char(1)
   '801',                        --  Codigo_titulo  char(3)
   NULL,                         --  Dt_prevista  datetime 
   NULL,                         --  Dt_realizada  datetime 
   NULL,                         --  Hora_prevista  char(6)
   NULL,                         --  Hora_realizada  char(6)
   '".$usuarioCapa."',                        --  Usuario  char(3)
   0,                            --  Sessao  int 
   NULL,                         --  Campo13  datetime 
   NULL,                         --  Campo14  datetime 
   NULL,                         --  Campo15  datetime 
   NULL,                         --  Campo16  datetime 
   NULL,                         --  Campo17  char(6)
   0,                            --  Campo18  float 
   0,                            --  Campo19  float 
   0,                            --  Campo20  float 
   0,                            --  Campo21  float 
   0,                            --  Campo22  float 
   0,                            --  Campo23  float 
   0,                            --  Campo24  float 
   0,                            --  Campo25  float 
   'N',                          --  Campo26  char(1)
   ' ',                          --  Campo27  char(1)
   ' ',                          --  Campo28  char(1)
   '  ',                         --  Campo29  char(2)
   '  ',                         --  Campo30  char(2)
   '  ',                         --  Campo31  char(2)
   '   ',                        --  Campo32  char(3)
   '   ',                        --  Campo33  char(3)
   '   ',                        --  Campo34  char(3)
   '      ',                     --  Campo35  char(6)
   '      ',                     --  Campo36  char(6)
   '      ',                     --  Campo37  char(6)
   '            ',               --  Campo38  char(12)
   1,                            --  Campo39  bit 
   0,                            --  Campo40  bit 
   0,                            --  Campo41  bit 
   0,                            --  Sequencia_conta  int 
   '',                           --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),    --  Data  datetime 
   '".$horaSessaoCi."',                     --  Hora  char(6)
   NULL,                         --  Dt_repr1  datetime 
   NULL,                         --  Dt_repr2  datetime 
   '      ',                     --  Cd_contatante  char(6)
   '".$converterHistoricoCi."')";
   $resAcompCapa = odbc_exec($conCab, $insertAcompCapa); 
		}
		
	//Inserir acompanhamento com justificativa para Capa da CI
	function acompanhamentoCapaJust($solicitacaoCapaJust,$usuarioCapaJust,$justCapa,$tituloCapa){
		require "conectsqlserverci.php";
		$horaSessaoCiCapaJust=date("His");
		$ciUpdateCapaJust=str_pad($solicitacaoCapaJust, 8, " ", STR_PAD_LEFT);
		$sqlAcompCapaJust="insert into GEACOMP
   (
   cd_empresa,
   embarque_pedido,
   contato_os_lanc,
   sequencia_item,
   tipo_acompanham,
   codigo_titulo,
   dt_prevista,
   dt_realizada,
   hora_prevista,
   hora_realizada,
   usuario,
   sessao,
   campo13,
   campo14,
   campo15,
   campo16,
   campo17,
   campo18,
   campo19,
   campo20,
   campo21,
   campo22,
   campo23,
   campo24,
   campo25,
   campo26,
   campo27,
   campo28,
   campo29,
   campo30,
   campo31,
   campo32,
   campo33,
   campo34,
   campo35,
   campo36,
   campo37,
   campo38,
   campo39,
   campo40,
   campo41,
   sequencia_conta,
   contato,
   data,
   hora,
   dt_repr1,
   dt_repr2,
   cd_contatante,
   historico
   )
values
   (
   '      ',                     --  Cd_empresa  char(6)
   '".$ciUpdateCapaJust."',               --  Embarque_pedido  char(12)
   0,                          --  Contato_os_lanc  int 
   0,                            --  Sequencia_item  int 
   'R',                          --  Tipo_acompanham  char(1)
   '".trim($tituloCapa)."',                        --  Codigo_titulo  char(3)
   NULL,                         --  Dt_prevista  datetime 
   NULL,                         --  Dt_realizada  datetime 
   NULL,                         --  Hora_prevista  char(6)
   NULL,                         --  Hora_realizada  char(6)
   '".$usuarioCapaJust."',                        --  Usuario  char(3)
   0,                            --  Sessao  int 
   NULL,                         --  Campo13  datetime 
   NULL,                         --  Campo14  datetime 
   NULL,                         --  Campo15  datetime 
   NULL,                         --  Campo16  datetime 
   NULL,                         --  Campo17  char(6)
   0,                            --  Campo18  float 
   0,                            --  Campo19  float 
   0,                            --  Campo20  float 
   0,                            --  Campo21  float 
   0,                            --  Campo22  float 
   0,                            --  Campo23  float 
   0,                            --  Campo24  float 
   0,                            --  Campo25  float 
   'N',                          --  Campo26  char(1)
   ' ',                          --  Campo27  char(1)
   ' ',                          --  Campo28  char(1)
   '  ',                         --  Campo29  char(2)
   '  ',                         --  Campo30  char(2)
   '  ',                         --  Campo31  char(2)
   '   ',                        --  Campo32  char(3)
   '   ',                        --  Campo33  char(3)
   '   ',                        --  Campo34  char(3)
   '      ',                     --  Campo35  char(6)
   '      ',                     --  Campo36  char(6)
   '      ',                     --  Campo37  char(6)
   '            ',               --  Campo38  char(12)
   1,                            --  Campo39  bit 
   0,                            --  Campo40  bit 
   0,                            --  Campo41  bit 
   0,                            --  Sequencia_conta  int 
   '',                           --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),    --  Data  datetime 
   '".$horaSessaoCiCapaJust."',                     --  Hora  char(6)
   NULL,                         --  Dt_repr1  datetime 
   NULL,                         --  Dt_repr2  datetime 
   '      ',                     --  Cd_contatante  char(6)
   '".trim($justCapa)."')";
	$resAcompCapaJust = odbc_exec($conCab, $sqlAcompCapaJust);
		}
		
    //Função que desbloqueia os itens da CI
	function desbloqueiaTabela($solicDesb){
		require "conectsqlserverci.php";
		$sqlDesb="update TEITEMSOLPRZBLOQ
set bloqueado = 0
where solicitacao = ".$solicDesb."
";
$desbloqueiaCi=odbc_exec($conCab,$sqlDesb);
		}
	?>
	