<?php 
echo "Usuario: ".$idBenef;
$consultaPzentPassagem="Select
  					(ESPARPLA.Tempo_repos+ dbo.CGFC_DATAATUAL()) AS Pzent,
					 ESMATERI.Cd_reduzido
 				   From
  				   ESPARPLA WITH(NOLOCK) Inner Join
  				   ESMATERI WITH(NOLOCK) On ESMATERI.Cd_material = ESPARPLA.Cd_material
					Where
  					ESPARPLA.Tipo = 'P' AND
  					ESMATERI.Cd_reduzido='".$cdMaterialPassagemReduzido."'";
			$resultPzentPassagem = odbc_fetch_array(odbc_exec($conCab2, $consultaPzentPassagem));
			$prazoEntregaPassagem=str_replace(" 00:00:00.000","",$resultPzentPassagem['Pzent']);	
						$sqlNcmPas="Select
		  			 ESCLASFI.Ncm
					From
		  			 ESMATERI with (nolock) Inner Join
		  			 ESCLASFI with (nolock) On ESMATERI.Classificacao_f = ESCLASFI.Classificacao_f
					Where
		  			 ESMATERI.Cd_material = '".$cdMaterialPassagem."'";
	$resNcmPas = odbc_exec($conCab2, $sqlNcmPas);
	$arrayNcmPas = odbc_fetch_array($resNcmPas);
	$ncmPas=(int)$arrayNcmPas['Ncm'];
	$peIPIPas=0;
	if($incidenciaIPI==1){
	$sqlConsPeIPIPas="Select
					  ESMATERI.Pe_ipi
					From
					  ESMATERI WITH(NOLOCK)
					  where Cd_material='".$cdMaterialPassagem."'";
	$resConsPeIPIPas = odbc_exec($conCab2, $sqlConsPeIPIPas);
	$arrayConsPeIPIPas = odbc_fetch_array($resConsPeIPIPas);

	$peIPIPas=$arrayConsPeIPIPas['Pe_ipi'];
	}
	$sqlSequenciaPas="Select
  				   max(COISOLIC.Sequencia) as Seq
				   From
  				   COISOLIC WITH(NOLOCK)
				   WHERE
				   Cd_solicitacao='".$solicitacao."'";
	$resSequenciaPas= odbc_exec($conCab2, $sqlSequenciaPas);
	$arraySequenciaPas = odbc_fetch_array($resSequenciaPas);
	$sequenciaPas=$arraySequenciaPas['Seq']+1;
	$sqlSequenciaDiaPas="Select
  				   Max(COISOLIC.Seq_dia) as SeqDia
				   From
  				   COISOLIC WITH(NOLOCK)
				   WHERE
				   Cd_solicitacao='".$solicitacao."'
				   AND Cd_material='".$cdMaterialPassagem."'
				   AND Cd_unidade_de_n='".$unidadeNeg."'
				   AND Data=dbo.CGFC_DATAATUAL ()";
	$resSequenciaDiaPas = odbc_exec($conCab2, $sqlSequenciaDiaPas);
	$arraySequenciaDiaPas = odbc_fetch_array($resSequenciaDiaPas);
	$seqDiaPas=(int)$arraySequenciaDiaPas['SeqDia']+2;
	$sqlCGERENPas="SELECT cd_conta_gerenc,cd_contabil
				FROM ESMATERI WITH(NOLOCK)
				WHERE cd_material='".$cdMaterialPassagem."'";
	$rsCGERENPas = odbc_exec($conCab2,$sqlCGERENPas) or die(odbc_error());
	$arrayCGERENPas=odbc_fetch_array($rsCGERENPas);
	$cgerenPas=$arrayCGERENPas['cd_conta_gerenc'];
	$redcontPas=$arrayCGERENPas['cd_contabil'];
	$valorPassagem=$valorPassagem/$countPassagem;
	$sqlInsertItemPas="insert into COISOLIC
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
   '".$cdMaterialPassagem."',	                  --  Cd_material  char(20)
   '001',                                --  Cd_centro_armaz  char(4)
   ".(int)$countPassagem.",                     --  Quantidade  float 
   ".(int)$countPassagem.",                                    --  Qt_saldo  float 
   'E',                                   --  Cd_especie_esto  char(1)
   ".(float)$valorPassagem.",               --  Pr_unitario  float 
   ' ',                                   --  Documento  char(10)
   ' ',                                   --  Cd_ordem_compra  char(12)
   ' ',                                   --  Serie  char(5)
   0,                                     --  Nf  float 
   307,                                   --  p_nf  float 
   '',  				  				  --  Descricao  char(201)
   '".$idBenef."',                      --  Cd_solicitante  char(6)
   'N',                                   --  Atualiza  char(1)
   '".$situacao."',                                   --  Situacao  char(1)
   CAST('".$prazoEntregaPassagem."' AS DATETIME),             --  Dt_prazo_de_ent  datetime 
   0,                                     --  Plano  smallint 
   0,                                     --  Qt_pecas  float 
   0,                                     --  Qt_pecas_saldo  float 
   0,                                     --  Sequencia_ordem  int 
   '   ',                                 --  Usuario_modific  char(3)
   '".$toperacao."',                               --  Cd_tipo_operaca  char(5)
   '      ',                              --  Cfop  char(6)
   NULL,                                  --  Dt_embarque  datetime 
   '".$cgerenPas."',           				--  Cd_conta_gerenc  char(25)
   '".$incidenciaIPI."',                                   --  Incidencia_ipi  char(1)
   ".$peIPIPas.",                                     --  Pe_ipi  real 
   ' ',                                   --  Cd_origem  char(1)
   '    ',                                --  Cd_transferenci  char(4)
   0,                                     --  Pe_comissao  real 
   ".$ncmPas.",                                     --  Classificacao_f  float 
   0,                                     --  Qt_fabricada  float 
   0,                                     --  Qt_saldo_fabric  float 
   'R',                                   --  Tipo  char(1)
   '".$unidadeMedida."',                                 --  Cd_unidade_medi  char(3)
   NULL,                                  --  Hora_solicitaca  char(6)
   '      ',                              --  Cd_detalhe  char(6)
   NULL,                                  --  Hora_prazo  char(6)
   ".$sequenciaPas.",                                     --  Sequencia  int 
   '".$redcontPas."',                                 --  Campo41  float 
   0,                                     --  Campo42  float 
   NULL,                                  --  Dt_solicitar_na  datetime 
   NULL,                                  --  Campo45  datetime 
   '      ',                              --  Cd_cliente  char(6)
   0,                                     --  Sessao  int 
   '',                                    --  Observacao  char(201)
   '".$unidadeNeg."',                                 --  Cd_unidade_de_n  char(3)
   '      ',                              --  Cd_especif1  char(6)
   '      ',                              --  Cd_especif2  char(6)
   '".$userCriac."',                                 --  Usuario_criacao  char(3)
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
   dbo.CGFC_BUSCA_CONFIGURACAO(490,null),                                  --  Campo65  char(2)
   '  ',                                  --  Campo66  char(2)
   '   ',                                 --  Campo67  char(3)
   0,                                     --  Campo68  bit 
   0,                                     --  Campo69  bit 
   0,                                     --  Campo70  bit 
   ".$seqDiaPas.",                                     --  Seq_dia  float 
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
   $resInsertItemPas = odbc_exec($conCab2, $sqlInsertItemPas) or die("<p>".odbc_errormsg());
?>