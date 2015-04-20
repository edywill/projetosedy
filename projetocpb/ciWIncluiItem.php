<?php
require "conectsqlserverci.php";
session_start();
$solicitacao=$_SESSION['solicitacao'];
$descricao=$_POST['desc'];
$usuario=$_SESSION['userCi'];
	$sqlUsuario="select Campo20, Nome
			from GEUSUARI (nolock)
			where cd_usuario = '".$usuario."' ";
	$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
	$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
$userSolic=$arraySqlUsuario['Campo20'];
$cdMaterial=trim($_POST['cdMaterialCodigo']);
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
  ESMATERI.Cd_material = '".$cdMaterial."'";
		$rsConsCdMat = odbc_exec($conCab,$sqlConsCdMat) or die(odbc_error());
		$arrayConsCdMat = odbc_fetch_array($rsConsCdMat);
	    if(empty($arrayConsCdMat)){
			?>
       <script type="text/javascript">
       alert("Codigo do Material Inválido! Tente Novamente.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
			break;
			}else{
			//$cdMaterial=$arrayConsCdMat['Cd_material'];
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
		?>
       <script type="text/javascript">
       alert("Codigo do Material em Branco! Tente Novamente.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	   break;
	}elseif(empty($contarConsCdMatAtivo)){
			?>
       <script type="text/javascript">
       alert("Codigo do Material Inativo! Tente Novamente.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	   break;
			}elseif(empty($contarConsCdMatObs)){
			?>
       <script type="text/javascript">
       alert("Codigo do Material Obsoleto! Tente Novamente.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	   break;
			}

$quantidade=$_POST['quantidade'];
if(empty($quantidade)){
	?>
       <script type="text/javascript">
       alert("Informe a quantidade.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	   break;
	}
$pr_unitario=str_replace(",",".",$_POST['pr_unitario']);
if(empty($pr_unitario)){
	?>
       <script type="text/javascript">
       alert("Informe o preço unitario!");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	   break;
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
$pzent=converteData($_POST['pzent']);
//$pzent=$pzent." 00:00:00.000";
//$pzent=date('D, d M Y h:i:s O', strtotime ($_POST['pzent']));
if(empty($pzent)){
?>
       <script type="text/javascript">
       alert("Necessario preencher o prazo de entrega.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
break;
}
$userSol=$_POST['userSolCodigo'];
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
  				   Max(COISOLIC.Sequencia) as Seq
				   From
  				   COISOLIC (nolock)
				   WHERE
				   Cd_solicitacao='".$solicitacao."'";
	$resSequencia = odbc_exec($conCab, $sqlSequencia);
	$arraySequencia = odbc_fetch_array($resSequencia);
$sequencia=$arraySequencia['Seq']+1;
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
echo $cgeren;
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
 if(!empty($_POST['justificativa'])){
$justificativa=mb_convert_encoding($_POST['justificativa'],"ISO-8859-1","UTF-8");
$justificativa=str_replace("?","-",$justificativa);
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
   '802',                        --  Codigo_titulo  char(3)
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
 }
 if($resInsertItem){
?>
       <script type="text/javascript">
       alert("Item Inserido com sucesso.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
}else{
	?>
       <script type="text/javascript">
       alert("Ocorreu um erro ao inserir o item.");
       window.location="ciWInserirItens.php";
       </script>
       <?php
	break;
	}
?>
