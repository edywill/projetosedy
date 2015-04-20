<?php
session_start();
require "conectsqlserverci.php";
include "mb.php";
$validador=0;
$teste=0;
$valida=0;
$quebra = chr(13).chr(10);
$countError=0;
$errorMsg='';
$_SESSION['validComp']='';
if(empty($_POST['idComp'])){
	$solicitacao=$_SESSION['solicitacao'];
	$usuario=$_SESSION['userCi'];
	$sequencia=$_SESSION['sequencia'];
	$validador=1;
	$gerenComp=$_SESSION['geremCompS'];
	$redcontComp=$_SESSION['redContCompS'];
	$prUnit=$_SESSION['prUnitSC'];
	}else{
		if($_SESSION['solicitacao']<>$_POST['solicitacao']){
		$_SESSION['validComp']=1;
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Voc\\u00ea iniciou uma nova CI neste navegador. Para continuar trabalhando na CI: '.$_POST["sol"].' utilize a op\\u00e7\\u00e3o Alterar CI. O item n\\u00e3oo foi inclu\\u00eddo! Voc\\u00ea sera direcionado para a CI atual: '.$_SESSION["solicitacao"].'';
	   }else{

$solicitacao=$_SESSION['solicitacao'];
$_SESSION['justItemS']=$_POST['justificativa'];
$descricao=$_POST['desc'];
$descricao=str_replace("'","\"",$descricao);
$descricao=addslashes($descricao);
$usuario=$_SESSION['userCi'];
$botao='';
$quantidade=$_POST['quantidade'];
$_SESSION['quantidadeItemS']=$quantidade;
$quantidade=str_replace("'","\"",$quantidade);
$quantidade=addslashes($quantidade);

$pr_unitario=str_replace(".","",$_POST['pr_unitario']);
$pr_unitario=str_replace(",",".",$pr_unitario);
$pr_unitario=str_replace("'","\"",$pr_unitario);
$_SESSION['precoUnitS']=$_POST['pr_unitario'];

$_SESSION['pzentS']=$_POST['pzent'];

$sqlUsuario="select Campo20, Nome
			from GEUSUARI (nolock)
			where cd_usuario = '".$usuario."' ";
	$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
	$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
$userSolic=$arraySqlUsuario['Campo20'];
$cdMaterial=trim($_POST['cdMaterial']);
$_SESSION['cdMaterialS']=$cdMaterial;
$arMaterial = explode('-', $cdMaterial);
$cdMaterial=$arMaterial[0];
$cdMaterial=str_replace("'","\"",$cdMaterial);
$unidadeMedida='';
$descMaterial='';
$sqlConsCdMat="Select
  ESMATERI.Cd_material,
  ESMATERI.Descricao,
  ESUMEDID.Cd_unidade_medi,
  ESUMEDID.Descricao As Descricao1
From
  ESUMEDID with (nolock) Inner Join
  ESMATERI with (nolock) On ESUMEDID.Cd_unidade_medi = ESMATERI.Cd_unidade_medi
  WHERE
  ESMATERI.Cd_reduzido = '".$cdMaterial."'";
		$rsConsCdMat = odbc_exec($conCab,$sqlConsCdMat) or die(odbc_error());
		$arrayConsCdMat = odbc_fetch_array($rsConsCdMat);
	    if(empty($arrayConsCdMat)){
			$_SESSION['validComp']=1;
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Material inv\\u00e1lido.\\n';
			
			}else{
			
			$cdMaterial=$arrayConsCdMat['Cd_material'];
			$unidadeMedida=$arrayConsCdMat['Cd_unidade_medi'];	
			$descMaterial=$arrayConsCdMat['Descricao'];
				}
		
	$sqlConsCdMatAtivo="select 1
						from ESMATERI (nolock) 
						where cd_material = '".$cdMaterial."'
						and tipo <> 'I'";
	$rsConsCdMatAtivo = odbc_exec($conCab,$sqlConsCdMatAtivo) or die(odbc_error());
	$contarConsCdMatAtivo=odbc_num_rows($rsConsCdMatAtivo);
	$sqlConsCdMatObs="select 1
					  from ESMATERI (nolock) 
					  where cd_material = '".$cdMaterial."'
					  and (tipo <> 'O' and dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 0 
     				  or dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 1)";
	$rsConsCdMatObs = odbc_exec($conCab,$sqlConsCdMatObs) or die(odbc_error());
	$contarConsCdMatObs=odbc_num_rows($rsConsCdMatObs);
if ($cdMaterial == "") {
		$_SESSION['validComp']=1;
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o material.\\n';	
	}
	
	if(empty($contarConsCdMatAtivo) && $valida==0){
			$_SESSION['validComp']=1;
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Material inativo.\\n';
			}
			
			if(empty($contarConsCdMatObs) && $valida==0){
			$_SESSION['validComp']=1;
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Material obsoleto.\\n';
			}
			
if(empty($quantidade) && $valida==0){
	$validarTipo=1;
	$sqlTipoMat=odbc_exec($conCab,"Select
  TEANALIVERMATERIAL.*
From
  TEANALIVERMATERIAL(nolock)
Where
  TEANALIVERMATERIAL.material='".$cdMaterial."'");
	   $arrayTipoMat=odbc_fetch_array($sqlTipoMat);
	   
	   if($arrayTipoMat['habilitar_rpa']=='1' || $arrayTipoMat['habilitar_hotel']=='1' ||$arrayTipoMat['habilitar_passagem']=='1'|| $arrayTipoMat['habilitar_diaria']=='1' || $arrayTipoMat['habilitar_auxilio_viagem']=='1' || $arrayTipoMat['habilitar_ajuda_custo']=='1'){
		   $validarTipo=0;
		   }else{
		$validarTipo=1;
		}
		
	if($validarTipo==0){
	$quantidade=0;
	}else{
		$_SESSION['validComp']=1;
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a quantidade para esse tipo de material.\\n';
		}
	}

if(empty($pr_unitario)){
$pr_unitario="0.00";
}
	$sqlCGEREN="SELECT cd_conta_gerenc,cd_contabil
				FROM ESMATERI (nolock)
				WHERE cd_material='".$cdMaterial."'";
	$rsCGEREN = odbc_exec($conCab,$sqlCGEREN) or die(odbc_error());
	$arrayCGEREN=odbc_fetch_array($rsCGEREN);
$cgeren=$arrayCGEREN['cd_conta_gerenc'];
$redcont=$arrayCGEREN['cd_contabil'];
    
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}
if($teste==1){
$pzent=$_POST['pzent'];
}else{
$pzent=converteData($_POST['pzent']);
}
$pzent=str_replace("'","\"",$pzent);
//$pzent=$pzent." 00:00:00.000";
//$pzent=date('D, d M Y h:i:s O', strtotime ($_POST['pzent']));
if(empty($pzent)){
	$_SESSION['validComp']=1;
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informar prazo de entrega.\\n';
}

$userSol=$_POST['userSol'];
$aruserSol = explode('-', $userSol);
$userSol=$aruserSol[0];
$userSol=str_replace("'","\"",$userSol);

	$sqlConsSitControle="SELECT Situac_Item_Sol
			   FROM COCSO (nolock)
			   WHERE controle = dbo.CGFC_BUSCA_CONFIGURACAO(490,null)";
	$resConsSitControle = odbc_exec($conCab, $sqlConsSitControle);
	$arrayConsSitControle = odbc_fetch_array($resConsSitControle);
$situacao=$arrayConsSitControle['Situac_Item_Sol'];
	$sqlConsToperacao="Select
  					   COSOLICI.Cd_tipo_operaca,
					   COSOLICI.cd_unid_negoc,
					   COSOLICI.Campo27
					   From
  					   COSOLICI (nolock)
  					   where Solicitacao=".$solicitacao."";
	$resConsToperacao = odbc_exec($conCab, $sqlConsToperacao);
	$arrayConsToperacao = odbc_fetch_array($resConsToperacao);
$toperacao=$arrayConsToperacao['Cd_tipo_operaca'];
	$sqlConsIncIpi="Select
					  GETOPERA.Incidencia_ipi,
					  GETOPERA.Pe_ipi
					From
					  GETOPERA (nolock)
					  Where Cd_tipo_operaca='".$toperacao."'";
	$resConsIncIpi = odbc_exec($conCab, $sqlConsIncIpi);
	$arrayConsIncIpi = odbc_fetch_array($resConsIncIpi);
$incidenciaIPI=$arrayConsIncIpi['Incidencia_ipi'];
$peIPI=0;
if($incidenciaIPI==1){
	$sqlConsPeIPI="Select
					  ESMATERI.Pe_ipi
					From
					  ESMATERI (nolock)
					  where Cd_material='".$cdMaterial."'";
	$resConsPeIPI = odbc_exec($conCab, $sqlConsPeIPI);
	$arrayConsPeIPI = odbc_fetch_array($resConsPeIPI);

	$peIPI=$arrayConsPeIPI['Pe_ipi'];
	}
	$sqlNcm="Select
		  ESCLASFI.Ncm
		From
		  ESMATERI with (nolock) Inner Join
		  ESCLASFI with (nolock) On ESMATERI.Classificacao_f = ESCLASFI.Classificacao_f
		Where
		  ESMATERI.Cd_material = '".$cdMaterial."'";
	$resNcm = odbc_exec($conCab, $sqlNcm);
	$arrayNcm = odbc_fetch_array($resNcm);
	$ncm=(int)$arrayNcm['Ncm'];

	$sqlSequencia="Select
  				   max(COISOLIC.Sequencia) as Seq
				   From
  				   COISOLIC (nolock)
				   WHERE
				   Cd_solicitacao='".$solicitacao."'";
	$resSequencia = odbc_exec($conCab, $sqlSequencia);
	$arraySequencia = odbc_fetch_array($resSequencia);
$sequencia=$arraySequencia['Seq']+1;
$_SESSION['sequencia']=$sequencia;
$endArquivo='';
$i=0;
foreach ($_FILES['anexo']['name'] as $key=>$nome){
			$arquivo = $_FILES['anexo'];
					$tamanho = 1024 * 1024 * 10;
					if($arquivo['size'][$i]>$tamanho){
								$valida=1;
								$countError++;
								$errorMsg.='Erro['.$countError.']: Arquivo superior a 10MB.\\n';
						}else{
			if(!empty($nome)){
			require("conectftp.php");
             if(!is_dir($cheqftp.'CIWEB\\'.$solicitacao.'\\'.$sequencia.'\\')){
			    if(!is_dir($cheqftp.'CIWEB\\'.$solicitacao.'\\')){
				ftp_mkdir($con_id,'CIWEB\\'.$solicitacao);
				   }
				   ftp_mkdir($con_id,'CIWEB\\'.$solicitacao.'\\'.$sequencia);
				 }
			 if(!is_dir('Anexos\\CIWEB\\'.$solicitacao.'\\'.$sequencia.'\\')){
			  if(!is_dir('Anexos\\CIWEB')){
			  	mkdir('Anexos\\CIWEB', 0700);
			    }
				if(!is_dir('Anexos\\CIWEB\\'.$solicitacao)){
			 		mkdir('Anexos\\CIWEB\\'.$solicitacao, 0700);
				}
				mkdir('Anexos\\CIWEB\\'.$solicitacao.'\\'.$sequencia, 0700);
			}  
        
		$caminho_absoluto = 'CIWEB\\'.$solicitacao.'\\'.$sequencia.'\\';
		$caminho_absoluto_web = 'Anexos\\'.$caminho_absoluto;
        if($tamanho>$arquivo['size'][$i]){
		if(!ftp_put( $con_id, $caminho_absoluto.$solicitacao."_".$sequencia."-".$i.str_replace(" ","",$arquivo['name'][$i]), $arquivo['tmp_name'][$i], FTP_BINARY) || !move_uploaded_file($arquivo['tmp_name'][$i], $caminho_absoluto_web.$solicitacao."_".$sequencia."-".$i.str_replace(" ","",$arquivo['name'][$i]))){
									$valida=1;
					 				$countError++;
	    			 				$errorMsg.='Erro['.$countError.']: Problema ao fazer upload do(s) ANEXO(S).\\n'; 
																		  }
																			  $endArquivo.=$quebra."<<An:W:\\Anexos_CI\\".$caminho_absoluto.$solicitacao."_".$sequencia."-".$i.str_replace(" ","",$arquivo['name'][$i]).">>";
		}else{
			$valida=1;
			$countError++;
	    	$errorMsg.='Erro['.$countError.']: Arquivos superiores a 10MB cada.\\n';
			}
																			  ftp_close($con_id);
	$i++;
			}
	}
}
$unidadeNeg=$arrayConsToperacao['cd_unid_negoc'];
$controle=$arrayConsToperacao['Campo27'];
	$sqlSequenciaDia="Select
  				   Max(COISOLIC.Seq_dia) as SeqDia
				   From
  				   COISOLIC (nolock)
				   WHERE
				   Cd_solicitacao='".$solicitacao."'
				   AND Cd_material='".$cdMaterial."'
				   AND Cd_unidade_de_n='".$unidadeNeg."'
				   AND Data=dbo.CGFC_DATAATUAL ()";
	$resSequenciaDia = odbc_exec($conCab, $sqlSequenciaDia);
	$arraySequenciaDia = odbc_fetch_array($resSequenciaDia);
$seqDia=(int)$arraySequenciaDia['SeqDia']+2;
if($valida==0){
$sqlInsertItem="insert into COISOLIC
   (
   cd_solicitacao,
   data,
   cd_material,
   cd_centro_armaz,
   quantidade,
   qt_saldo,
   cd_especie_esto,
   pr_unitario,
   documento,
   cd_ordem_compra,
   serie,
   nf,
   p_nf,
   descricao,
   cd_solicitante,
   atualiza,
   situacao,
   dt_prazo_de_ent,
   plano,
   qt_pecas,
   qt_pecas_saldo,
   sequencia_ordem,
   usuario_modific,
   cd_tipo_operaca,
   cfop,
   dt_embarque,
   cd_conta_gerenc,
   incidencia_ipi,
   pe_ipi,
   cd_origem,
   cd_transferenci,
   pe_comissao,
   classificacao_f,
   qt_fabricada,
   qt_saldo_fabric,
   tipo,
   cd_unidade_medi,
   hora_solicitaca,
   cd_detalhe,
   hora_prazo,
   sequencia,
   campo41,
   campo42,
   dt_solicitar_na,
   campo45,
   cd_cliente,
   sessao,
   observacao,
   cd_unidade_de_n,
   cd_especif1,
   cd_especif2,
   usuario_criacao,
   dt_modificacao,
   movimento_requi,
   projeto,
   dt_cotacao,
   campo57,
   campo58,
   campo59,
   campo60,
   campo61,
   campo62,
   campo63,
   campo64,
   campo65,
   campo66,
   campo67,
   campo68,
   campo69,
   campo70,
   seq_dia,
   campo72,
   campo73,
   campo74,
   campo75,
   campo76,
   campo77,
   campo78,
   usrsoli1,
   usrsoli2,
   usrsoli3,
   usrsoli4,
   usrsoli5,
   plano_mestre
   )
values
   (".$solicitacao.",                     --  Cd_solicitacao  int 
   dbo.CGFC_DATAATUAL (),	              --  Data  datetime 
   '".$cdMaterial."',	                  --  Cd_material  char(20)
   '001',                                --  Cd_centro_armaz  char(4)
   ".(int)$quantidade.",                     --  Quantidade  float 
   ".(int)$quantidade.",                                    --  Qt_saldo  float 
   'E',                                   --  Cd_especie_esto  char(1)
   ".(float)$pr_unitario.",                                  --  Pr_unitario  float 
   ' ',                                   --  Documento  char(10)
   ' ',                                   --  Cd_ordem_compra  char(12)
   ' ',                                   --  Serie  char(5)
   0,                                     --  Nf  float 
   307,                                   --  p_nf  float 
   '".$descricao."',  				  --  Descricao  char(201)
   '".$userSol."',                              --  Cd_solicitante  char(6)
   'N',                                   --  Atualiza  char(1)
   '".$situacao."',                                   --  Situacao  char(1)
   CAST('".$pzent."' AS DATETIME),             --  Dt_prazo_de_ent  datetime 
   0,                                     --  Plano  smallint 
   0,                                     --  Qt_pecas  float 
   0,                                     --  Qt_pecas_saldo  float 
   0,                                     --  Sequencia_ordem  int 
   '   ',                                 --  Usuario_modific  char(3)
   '".$toperacao."',                               --  Cd_tipo_operaca  char(5)
   '      ',                              --  Cfop  char(6)
   NULL,                                  --  Dt_embarque  datetime 
   '".$cgeren."',           --  Cd_conta_gerenc  char(25)
   '".$incidenciaIPI."',                                   --  Incidencia_ipi  char(1)
   ".$peIPI.",                                     --  Pe_ipi  real 
   ' ',                                   --  Cd_origem  char(1)
   '    ',                                --  Cd_transferenci  char(4)
   0,                                     --  Pe_comissao  real 
   ".$ncm.",                                     --  Classificacao_f  float 
   0,                                     --  Qt_fabricada  float 
   0,                                     --  Qt_saldo_fabric  float 
   'R',                                   --  Tipo  char(1)
   '".$unidadeMedida."',                                 --  Cd_unidade_medi  char(3)
   NULL,                                  --  Hora_solicitaca  char(6)
   '      ',                              --  Cd_detalhe  char(6)
   NULL,                                  --  Hora_prazo  char(6)
   ".$sequencia.",                                     --  Sequencia  int 
   '".$redcont."',                                 --  Campo41  float 
   0,                                     --  Campo42  float 
   NULL,                                  --  Dt_solicitar_na  datetime 
   NULL,                                  --  Campo45  datetime 
   '      ',                              --  Cd_cliente  char(6)
   0,                                     --  Sessao  int 
   '',                                    --  Observacao  char(201)
   '".$unidadeNeg."',                                 --  Cd_unidade_de_n  char(3)
   '      ',                              --  Cd_especif1  char(6)
   '      ',                              --  Cd_especif2  char(6)
   '".$usuario."',                                 --  Usuario_criacao  char(3)
   NULL,                                  --  Dt_modificacao  datetime 
   0,                                     --  Movimento_requi  int 
   '',                                    --  Projeto  char(12)
   NULL,                                  --  Dt_cotacao  datetime 
   NULL,                                  --  Campo57  datetime 
   NULL,                                  --  Campo58  datetime 
   '00:00 ',                              --  Campo59  char(6)
   '00:00 ',                              --  Campo60  char(6)
   '      ',                              --  Campo61  char(6)
   ' ',                                   --  Campo62  char(1)
   ' ',                                   --  Campo63  char(1)
   '  ',                                  --  Campo64  char(2)
   '".$controle."',                                  --  Campo65  char(2)
   '  ',                                  --  Campo66  char(2)
   '   ',                                 --  Campo67  char(3)
   0,                                     --  Campo68  bit 
   0,                                     --  Campo69  bit 
   0,                                     --  Campo70  bit 
   ".$seqDia.",                                     --  Seq_dia  float 
   0,                                     --  Campo72  float 
   0,                                     --  Campo73  float 
   0,                                     --  Campo74  float 
   0,                                     --  Campo75  float 
   0,                                     --  Campo76  float 
   0,                                     --  Campo77  float 
   0,                                     --  Campo78  float 
   '',                                    --  Usrsoli1  char(20)
   '',                                    --  Usrsoli2  char(20)
   '',                                    --  Usrsoli3  char(20)
   NULL,                                  --  Usrsoli4  datetime 
   0,                                     --  Usrsoli5  float 
   ''                                     --  Plano_mestre  char(12)
   )";
   $resInsertItem = odbc_exec($conCab, $sqlInsertItem) or die("<p>".odbc_errormsg());
if($resInsertItem){
	$validador=1;
if(!empty($_POST['justificativa']) || $endArquivo<>''){
$justificativa=$_POST['justificativa'];
$justificativa=str_replace("?","-",$justificativa);
$justificativa=str_replace("'","\"",$justificativa);
$justificativa=addslashes($justificativa);
$justificativa=str_replace("\\\\","\\",$justificativa);
$justificativa=$justificativa.$endArquivo;
if(strlen($justificativa)<2000){
			$ciUpdateItensSol=str_pad($solicitacao, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeq=str_pad($sequencia, 3, "0", STR_PAD_LEFT);
$embarque_pedido=$ciUpdateItensSol."/".$ciUpdateItensSeq;

$sqlInsertAcompItens="insert into GEACOMP
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
   '".$embarque_pedido."',               --  Embarque_pedido  char(12)
   ".$solicitacao.",                          --  Contato_os_lanc  int 
   ".$sequencia.",                            --  Sequencia_item  int 
   'R',                          --  Tipo_acompanham  char(1)
   '803',                        --  Codigo_titulo  char(3)
   NULL,                         --  Dt_prevista  datetime 
   NULL,                         --  Dt_realizada  datetime 
   NULL,                         --  Hora_prevista  char(6)
   NULL,                         --  Hora_realizada  char(6)
   '".$usuario."',                        --  Usuario  char(3)
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
   '".date("His")."',                     --  Hora  char(6)
   NULL,                         --  Dt_repr1  datetime 
   NULL,                         --  Dt_repr2  datetime 
   '      ',                     --  Cd_contatante  char(6)
   '".$justificativa."' 							 --  Historico  varchar(2001)
   )
";
$resInsertAcompItens = odbc_exec($conCab, $sqlInsertAcompItens) or die("<p>".odbc_errormsg());
}else{
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A justificativa ultrapassou 2000 caracteres.\\n';
			
	}
  }
 }
}
}
	}
if($validador==1){
$sqlCGEREN="Select
  it.Cd_conta_gerenc,
  it.Campo41,
  it.Pr_unitario
From
  COISOLIC it With(NoLock)
where it.cd_solicitacao='".$solicitacao."' and
      it.sequencia='".$sequencia."'";
	$rsCGEREN = odbc_exec($conCab,$sqlCGEREN) or die(odbc_error());
	$arrayCGEREN=odbc_fetch_array($rsCGEREN);
//$cgeren=trim($arrayCGEREN['Cd_conta_gerenc']);
$redcont= (int)$arrayCGEREN['Campo41'];
$prUnit=number_format($arrayCGEREN['Pr_unitario'],2, ',','.');

$sqlCGERENome="Select
    cg.Pcc_nome_conta,
	cg.Pcc_classific_c,
	cg.Cd_pcc_reduzid
From
  CCPCC cg With(nolock)
where 
substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
and cg.Pcc_classific_c='".trim($arrayCGEREN['Cd_conta_gerenc'])."'";
$rsCGERENome = odbc_exec($conCab,$sqlCGERENome) or die(odbc_error());
$arrayCGERENome=odbc_fetch_array($rsCGERENome);
$cgeren=trim($arrayCGERENome['Pcc_classific_c']);
$cgerenNome=trim($arrayCGERENome['Pcc_nome_conta']);
$redCont2=trim($arrayCGERENome['Cd_pcc_reduzid']);
$gerenComp='';
if(!empty($cgeren)){
$gerenComp=trim($cgeren)."-".trim($cgerenNome);
}

$selectRedCont="select cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where cg.Cd_pcc_reduzid = '".$redcont."'
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'";
$rsRedCont = odbc_exec($conCab,$selectRedCont) or die(odbc_error());
$arrayRedCont=odbc_fetch_array($rsRedCont);

$redcont3=trim($arrayRedCont['Cd_pcc_reduzid']);
$redcontNome=trim($arrayRedCont['Pcc_nome_conta']);
$redcontComp='';
if(!empty($redcont3)){
$redcontComp=trim($redcont3)."-".trim($redcontNome);
}
if(empty($_POST['idComp'])){
	$solicitacao=$_SESSION['solicitacao'];
	$usuario=$_SESSION['userCi'];
	$sequencia=$_SESSION['sequencia'];
	$validador=1;
	$gerenComp=$_SESSION['geremCompS'];
	$redcontComp=$_SESSION['redContCompS'];
	$prUnit=$_SESSION['prUnitSC'];
}
	if(empty($_SESSION['geremCompPadrao'])){
		$_SESSION['geremCompPadrao']='';
		}
		$vlPadrao=0;
if(empty($gerenComp)){
	$gerenComp=$_SESSION['geremCompPadrao'];
	$vlPadrao=1;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript" src="ajax/funcs.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
<script type="text/javascript">
 function somenteNumeros (num) {
		var er = /[^0-9.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>

<script type="text/javascript">
$().ready(function() {
    $("#cgeren").autocomplete("suggest_cgeren.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#redcont").autocomplete("suggest_redcont.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script>
function abrir(programa,janela)
{
   if(janela=="") janela = "janela";
   window.open(programa,janela,'height=350,width=640');
}
</script>
<script language=javascript> 
function janelaSecundaria (URL){ 
   window.open(URL,"janela1","width=400,height=300,scrollbars=NO") 
} 
</script> 
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
<script language="javascript">
/*----------------------------------------------------------------------------
Formatação para qualquer mascara
-----------------------------------------------------------------------------*/
function formatar(src, mask){
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
    src.value += texto.substring(0,1);
  }
}
</script>
<script type='text/javascript'>
function bloqueioTeclas()   // Verificação das Teclas
{
    var tecla=window.event.keyCode;
    var alt=window.event.altKey;      // Para Controle da Tecla ALT
    
    if (tecla==116)    //Evita feclar via Teclado através do ALT+F4
    {
        event.keyCode=0;
        event.returnValue=false;
    }
}
</script>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();" onLoad="document.ciWCriar.cgeren.focus();">
<div id='box3'>
<br/>
<strong>CIWEB  - Atualizar Solicita&ccedil;&atilde;o:</strong><br/><br/>
<strong>Cadastrar Dados Complementares</strong>

<p>
    <strong>CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></strong></font><br />
    Item Seq.:<?php echo $sequencia; ?>
  </p>
  
<form action="ciWAlteraDF.php" method="post" name="ciWCriar" onSubmit="this.elements['caditem'].disabled=true;"> 
  <table border="0"><tr><td COLSPAN='2'>
  <p><strong>ALTERAR DADOS FINANCEIROS</strong></p>
  </td></tr>
  <tr><td>
<strong>Conta Gerencial:</strong></td><td><input type="hidden" name="user" value="<?php echo $usuario; ?>"/><input type="hidden" name="solicitacao" value="<?php echo $solicitacao; ?>"/><input type="hidden" name="sequencia" value="<?php echo $sequencia; ?>"/> 
<input class="input" name="cgeren" id="cgeren" autofocus type="text" size="40"  value="<?php echo trim($gerenComp); ?>"/>
<input type="hidden" name="endereco" id="endereco" class="input" size="8" value="4"/><br /><br />
<input class="input" name="redcont" id="redcont" type="hidden" size="40"  value="<?php echo mb_convert_encoding($redcontComp, "UTF-8", mb_detect_encoding($redcontComp, "UTF-8, ISO-8859-1, ISO-8859-15", true)); ?>" />
<input class="input" name="pr_unitario" id="pr_unitario" type="hidden" size="8" value="<?php echo $prUnit; ?>" onKeyUp="somenteNumeros(this)">
</td></tr>
<tr><td></td><td><input  class="check" name="checkGeren" id="checkGeren" type="checkbox"
<?php 
if($vlPadrao==1){
	echo "checked='checked'";
}
?>
value="1"/> - Manter Conta Padr&atilde;o para a CI</td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Atualizar Dados" class="buttonVerde"/>
    </td></tr></table>
  </form>
  </p>
  </div>
</body>
</html>
<?php }else{
		$valida=1;
	}
	
	if($valida==1){
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWItens.php";
       </script>
       <?php
		}
	?>