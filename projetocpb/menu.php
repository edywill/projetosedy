<?php
	//Funções
function montaMenu($usuarioCk){
    include "conect.php";
	include "conectsqlserverci.php";
	include "functionPrazos.php";
	require "somarDatas.php";
	$teste=1;
	if($teste==1){
	 $conCab2 = odbc_connect("DRIVER={SQL Server}; SERVER=CPB174\SQLEXPRESS; DATABASE=CIGAM;", "sa","cigam");
	// $conCab2 = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=cigamteste;", "sa","abyz.");
	}else{
	$conCab2 = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=cigam;", "sa","abyz.");
	}
	$resultado =  mysql_query("SELECT * FROM usuarios WHERE usuario = '".$usuarioCk."'") or die(mysql_error());
    $resultadom = mysql_fetch_array($resultado);
	$modulos=mysql_query("SELECT * FROM modulo WHERE user='".$resultadom['id']."'") or die(mysql_error());
	$gest=0;
	$convenios=0;
	$rh=0;
	$prestcont=0;
	$presidencia=0;
	$aquisic=0;
	$atletas=0;
	if($modulos){
		while($modObjs=mysql_fetch_object($modulos)){
		if($modObjs->mod=='gest'){
			$gest=1;
			}
		if($modObjs->mod=='conv'){
			$convenios=1;
			}
		if($modObjs->mod=='rh'){
			$rh=1;
			}
		if($modObjs->mod=='prest'){
			$prestcont=1;
			}
		if($modObjs->mod=='aquis'){
			$aquisic=1;
			}
		if($modObjs->mod=='presi'){
			$presidencia=1;
			}
		if($modObjs->mod=='atletas'){
			$atletas=1;
			}
		  }
		}
	$perfilE="Usuario";
	$status=$resultadom['status'];
	$nome=utf8_encode($resultadom['nome']);
	$cigam=$resultadom['cigam'];
	if(empty($cigam)){
		$slcUserCigam=odbc_exec($conCab2,"Select
  GEEMPRES.Nome_completo,
  GEUSUARI.Cd_usuario
From
  GEUSUARI with(nolock) Inner Join
  GEEMPRES with(nolock) On GEUSUARI.Campo20 = GEEMPRES.Cd_empresa
  WHERE GEEMPRES.Nome_completo='".$resultadom['nome']."'");
		$arrayUserCigam=odbc_fetch_array($slcUserCigam);
		$usuarioCigamMenu="A02";
		if(!empty($arrayUserCigam['Cd_usuario'])){
			$usuarioCigamMenu=$arrayUserCigam['Cd_usuario'];
			}
			$updUserCigam=mysql_query("UPDATE usuarios SET cigam='".$usuarioCigamMenu."' WHERE id='".$resultadom['id']."'");
		odbc_close($conCab2);
		}
		
	$menuConv='';
	$menuE='';
if($gest==1){
	$perfilE.="/Gestor";
	$menuE.="<strong>GESTOR</strong><br>
  <ul></li>
 		<li> <a href='gestFerias.php?usuario=".utf8_encode($nome)."' target='Frame1'>Aprovar Férias";
		$sqlFerias=mysql_query("SELECT status FROM solferias  WHERE status=1 and gestor='".$nome."'") or die(mysql_error());
		$numFerias=mysql_num_rows($sqlFerias);
		if($numFerias>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$numFerias."</font></DIV></div>";
			}
			
		$menuE.="</a></li>
		<li> <a href='gest13.php?usuario=".utf8_encode($nome)."' target='Frame1'> Aprov. 1ª Parc. 13º";
		$sql13=mysql_query("SELECT status FROM sol13  WHERE status=1 and gestor='".$nome."'") or die(mysql_error());
		$num13=mysql_num_rows($sql13);
		if($num13>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$num13."</font></DIV></div>";
			}
		$menuE.="</a></li>
		<li> <a href='ciWeb.php?usuario=".utf8_encode($nome)."' target='Frame1'> Aprovar CI";
		$sqlCountCis=odbc_exec($conCab2,"Select 
  COSOLICI.Solicitacao,
  COSOLICI.Data,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Desc_cond_pag
From
  COSOLICI with (nolock)
  where
  COSOLICI.campo27='".$resultadom['controle']."'
  ORDER BY COSOLICI.Solicitacao DESC");
		$numCis=odbc_num_rows($sqlCountCis);
		if($numCis>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:3px; width:10px; color:white;'><font size='-2'>".$numCis."</font></DIV></div>";
			}
$sqlBuscaGEEMPRES=odbc_fetch_array(odbc_exec($conCab2,"SELECT campo20 FROM GEUSUARI with (nolock) where Cd_usuario='".$cigam."' "));
		$menuE.="</a> </li>
		<li> <a href='sav/aprovacaoGestor.php?usuario=".trim($sqlBuscaGEEMPRES['campo20'])."&cigam=".trim($cigam)."' target='Frame1'>Aprovar SAV";
		$sqlSav=mysql_query("SELECT situacao FROM savregistros  WHERE (situacao<>'Aprovada' AND situacao<>'Recusada') AND gestor='".$sqlBuscaGEEMPRES['campo20']."' AND numci<>0") or die(mysql_error());
		$numSav=mysql_num_rows($sqlSav);
		if($numSav>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$numSav."</font></DIV></div>";
			}
			
		$menuE.="</a></li>
		<li> <a href='ciWFPrazo.php?usuario=$nome' target='Frame1'>CI's Fora do Prazo";
		
		if(!empty($resultadom['cigam'])){
//Busco o setor do gestor
$setorGestor=buscaSetorPrazos($resultadom['cigam']);
//Busco as variÃ¡veis de controle com base no setor do gestor
$controles=buscaControlesPrazos($setorGestor['cd_setor']);
//Crio as variÃ¡veis
$ctrlInferiorGestor=$controles['ctrl_prz_inferior'];

		$sqlListaCiGestor=odbc_exec($conCab,"select ci.Solicitacao, ci.Desc_cond_pag,ci.Data
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
									 and ici.campo65 in ('".$ctrlInferiorGestor."'))");
		$numCiF=odbc_num_rows($sqlListaCiGestor);
		
		if($numCiF>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px' ><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:3px; color:white;'><font size='-2'>".$numCiF."</font></DIV></div>";
			}
		}
		$menuE.="</a></li>
		<li> <a href='prestcont/prestacao/aprovPrestGestor.php?usuario=".utf8_encode($nome)."' target='Frame1'>Prest. Contas</a><br></li>
	 </ul>";
	}
	
	if($rh==1){
		$perfilE.="/RH";
	    $menuE.= "<strong>RH</strong><br>
				  <ul><li><a href='cadastroUser.php' target='Frame1'>Cadastro de Usuário</a></li>
				  <ul><li><a href='listaUsuarios.php' target='Frame1'>Listar Usuários</a></li></ul>
				  <li><a href='cadastroDias.php' target='Frame1'>Cadastro Eventos</a></li>
				  <li><a href='rhFerias.php?usuario=$nome' target='Frame1'>Férias Aprovadas</a></li>
				  <li> <a href='rh13.php?usuario=$nome' target='Frame1'> 13º Aprovados</a></li>
				  <li> <a href='relCh.php' target='Frame1'> Relatório Cont. Cheque</a></li>
				  <li><a href='alterUsuario.php?usuario=$nome' target='Frame1'>Alterar Perfil Usuário</a><br></li>
				  </ul>";
		}
		if($presidencia==1){
				$perfilE.="/Presid&ecirc;ncia";
	            $menuE.= "<strong>Presidência</strong><br>
  							<ul></li>
 		<li> <a href='gestFerias.php?usuario=$nome' target='Frame1'>Aprovar/Recusar Férias";
		$sqlFerias=mysql_query("SELECT status FROM solferias  WHERE status=1 and gestor='".$nome."'") or die(mysql_error());
		$numFerias=mysql_num_rows($sqlFerias);
		if($numFerias>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$numFerias."</font></DIV></div>";
			}
			
		$menuE.="</a></li>
		<li> <a href='gest13.php?usuario=$nome' target='Frame1'> Ap/Rec. 1ª Parc. 13º";
		
		$sql13=mysql_query("SELECT status FROM sol13  WHERE status=1 and gestor='".$nome."'") or die(mysql_error());
		$num13=mysql_num_rows($sql13);
		if($num13>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$num13."</font></DIV></div>";
			}
			
		$menuE.="</a></li>
		<li> <a href='ciWeb.php?usuario=$nome' target='Frame1'> Aprovar CI";
		$sqlCountCis=odbc_exec($conCab2,"Select 
  COSOLICI.Solicitacao,
  COSOLICI.Data,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Desc_cond_pag
From
  COSOLICI with (nolock)
  where
  COSOLICI.campo27='".$resultadom['controle']."'
  ORDER BY COSOLICI.Solicitacao DESC");
		$numCis=odbc_num_rows($sqlCountCis);
		if($numCis>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:3px; color:white;'><font size='-2'>".$numCis."</font></DIV></div>";
			}
$sqlBuscaGEEMPRES=odbc_fetch_array(odbc_exec($conCab2,"SELECT campo20 FROM GEUSUARI (nolock) where Cd_usuario='".$cigam."' "));
		$menuE.="</a> </li>";
		$menuE.="<li> <a href='sav/aprovacaoGestor.php?usuario=".trim($sqlBuscaGEEMPRES['campo20'])."&cigam=".trim($cigam)."' target='Frame1'>Aprovar SAV";
		
		$sqlSav=mysql_query("SELECT situacao FROM savregistros  WHERE (situacao<>'Aprovada' AND situacao<>'Recusada')  AND gestor='".$sqlBuscaGEEMPRES['campo20']."' AND numci<>0") or die(mysql_error());
		$numSav=mysql_num_rows($sqlSav);
		if($numSav>0){
			$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$numSav."</font></DIV></div>";
			}
		echo "</a></li>";
	 echo "<br></ul>";
				}
					
					if($prestcont==1){
	            $menuE.= "<strong>Presta&ccedil;&atilde;o de Contas</strong><br>
  							<ul>
							<li><a href='sav/prestCont.php?usuario=$nome' target='Frame1'>Gestão SAV</a></li><li><a href='prestcont/index.php?usuario=$nome' target='Frame1'>Autoriza&ccedil;&otilde;es</a></li>
							<li> <a href='prestcont/passagens/boardingPass.php?usuario=$nome' target='Frame1'>Boarding Pass";

			$sqlRegBP=mysql_query("select registros.id,registros.datainicial,registros.datafinal,registros.idben from registros LEFT JOIN cia ON registros.idcia=cia.id where registros.bdpass=0 ORDER BY registros.datainicial") or die(mysql_error());
	    	$numRegistros=0;
			while($arrayBoarding=mysql_fetch_array($sqlRegBP)){
				$dataSomada='';
		  if(!empty($arrayBoarding['datafinal'])){
			    	if($arrayBoarding['datafinal']<>'0000-00-00'){ 
					if($arrayBoarding['datafinal']<>'1969-12-31'){
		$dataSomada=somar_data($arrayBoarding['datafinal'], 10, 0, 0);
			  }}}
			  if(empty($dataSomada)){
				 $dataSomada=somar_data($arrayBoarding['datainicial'], 10, 0, 0);
				  }
			if(strtotime(date("Y-m-d")) >= strtotime($dataSomada)){
				$queryBloqAut=mysql_query("SELECT * FROM prestbloqueados WHERE cdempres='".$arrayBoarding['idben']."' AND idaut='".$arrayBoarding['id']."'") or die (mysql_error());
				$sqlBloqAut=mysql_num_rows($queryBloqAut);
				if($sqlBloqAut==0){
				$insertIntoBloqueio=mysql_query("INSERT INTO prestbloqueados (cdempres,idaut,status) VALUES ('".$arrayBoarding['idben']."','".$arrayBoarding['id']."','1')");
				//insert do cigam
				}
				$numRegistros++;
				}	
			}
			if(!empty($numRegistros)){
					?>
       				<script type="text/javascript">
					   alert("Existe <?php echo $numRegistros; ?> Boarding Pass com prazo vencido.");
					   </script>
					   <?php
					$menuE.="<div style='position:relative; top:-30px; left:140px; right:-10px; width:10px;'><img src='imagens/alerta.png'/><DIV style='position:RELATIVE; top:-16px; left:4px; color:white;'><font size='-2'>".$numRegistros."</font></DIV></div>";
					}
		$menuE.="</a><br></li></ul>";	
					}
					if(empty($resultadom)){
						echo "<script>alert('Atencao! Logue novamente!');top.location.href='loginad.php';</script>"; 
						}
				
				if($convenios==1){
					$menuE.="<strong>Conv&ecirc;nios</strong><br>
  							<ul></li>
 						<li> <a href='convenios/gestao/gestConv.php?usuario=$nome' target='Frame1'>Gest&atilde;o de Conv&ecirc;nios</a><br></li></ul>";
						//echo "<li> <a href='convenios/prestConv.php?usuario=$nome' target='Frame1'>Presta&ccedil;&atilde;o de Contas</a></li>";
					}
		//Aquisições			
		if($aquisic==1){
		$perfilE.="/Aquisições";
	    $menuE.= "<strong>Aquisições</strong><br>
				  <ul>
				  <li><a href='aquisicoes/index.php?usuario=$nome' target='Frame1'>Cadastros</a></li>
				  <li><a href='aquisicoes/ordem/menu.php?usuario=$nome' target='Frame1'>Emitir Ordem</a></li>
				  <li><a href='aquisicoes/relatorios.php' target='Frame1'>Relatórios</a></li>
				  </ul>";
		}
	    //Atletas			
		if($atletas==1){
		$menuE.= "<strong>DITEC</strong><br>
				  <ul>
				  <li><a href='atletas/index.php?usuario=$nome' target='Frame1'>Atletas</a></li>
				  </ul>";
		}
		$sqlBoardingGeral=mysql_query("SELECT solicitacao,datafinal,datainicial,seq FROM registros WHERE bdpass=0 AND (datainicial+10)<='".date("Ymd")."'") or die(mysql_error());
		$numBoardingGeral=mysql_num_rows($sqlBoardingGeral);
		$countBdPas=0;
		if($numBoardingGeral>0){
		  while($arrayBoardingGeral=mysql_fetch_array($sqlBoardingGeral)){
			if($arrayBoardingGeral['datafinal'] == '' || $arrayBoardingGeral['datafinal']=='0000-00-00' || $arrayBoardingGeral['datafinal']=='1969-12-31'){
	          	$sqlConsCiBdPas=odbc_exec($conCab,"SELECT usu_criacao FROM TEITEMSOLPASSAGEM (nolock) WHERE usu_criacao='".$cigam."' AND Cd_solicitacao='".$arrayBoardingGeral['solicitacao']."' AND sequencia='".$arrayBoardingGeral['seq']."'") or die("<p>".odbc_errormsg());
				$arrayConsCiBdPas=odbc_fetch_array($sqlConsCiBdPas);
			  	if(!empty($arrayConsCiBdPas['Usuario_criacao'])){
				  $countBdPas++;
				  }
				}else{
					$sqlBoardingFGeral=mysql_query("SELECT datafinal,datainicial FROM registros WHERE bdpass=0 AND (datafinal+10)<='".date("Ymd")."'");
				    $numBoardingFGeral=mysql_num_rows($sqlBoardingFGeral);
				   if($numBoardingFGeral>0){
	                   
					   $sqlConsCiBdPas2=odbc_exec($conCab,"SELECT usu_criacao FROM TEITEMSOLPASSAGEM (nolock) WHERE usu_criacao='".$cigam."' AND Cd_solicitacao='".$arrayBoardingGeral['solicitacao']."' AND sequencia='".$arrayBoardingGeral['seq']."'") or die("<p>".odbc_errormsg());
					   $arrayConsCiBdPas2=odbc_fetch_array($sqlConsCiBdPas2);
						if(!empty($arrayConsCiBdPas2['Usuario_criacao'])){
				 			 $countBdPas++;
				  		}
					  }
					}
			    }
			}
			
			if($countBdPas>0 && $cigam<>'A02'){
				?>
			   <script type="text/javascript">
               alert("Existe(m) <?php echo $countBdPas; ?> Boarding Pass com prazo vencido(s) abertos pelo seu usuario. \nPor favor procure o setor de passagens para regularizar.");
               </script>
       		    <?php
			  }
		
		  echo "<div id='box'><p>Bem vindo <br>
		  <strong>".utf8_encode($resultadom['nome'])."</strong><br><br> 
		  <strong>Perfil:</strong> <font size='-1'>".$perfilE."</font> <br><br>
		    </p>
          <a href='principal.php' class='button'> Início</a>
		  <br/><br/><br/>
		  <div id='menu2'>
		  <ul>
		    <li> <a href='folha_selecao.php?usuario=$nome' target='Frame1'> Folha de Frequência</a> </li>
		    <li> <a href='recibo_selecao.php?usuario=$nome' target='Frame1'>Recibo de Pagamento</a></li>
		    <li> <a href='solferias.php?usuario=$nome' target='Frame1'> Solicitação de Férias</a></li> 
		    <li> <a href='sol13.php?usuario=$nome' target='Frame1'> Solic. 1ª Parc. 13º</a></li>
		    <li> <a href='ciWMenu.php?usuario=$nome' target='Frame1'> CI Web</a></li>
			<li> <a href='sav/index.php?usuario=$nome&cigam=$cigam' target='Frame1'> SAV</a><br></li>";
		 echo "</ul>
		 ".$menuConv."
		 ".$menuE."
		  </div>";
		  $_SESSION['cigamMenu']=$cigam;
			}
?>