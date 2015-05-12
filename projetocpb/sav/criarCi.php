<?php 
$SQLUpSol = "UPDATE ESNSOLIC                                                     
                 SET CD_Ultima_SOLIC = CD_Ultima_SOLIC+1
				 WHERE Unico = ' '";
				$resUpSol = odbc_exec($conCab2, $SQLUpSol) or die("<p>".odbc_errormsg());
				if($resUpSol){
				//Pegando o número da CI
				$SQLUlSol = "SELECT Cd_ultima_solic 
			   FROM ESNSOLIC WITH(NOLOCK) 
			   WHERE Unico = ' '";
				$resUlSol = odbc_exec($conCab2, $SQLUlSol);
	 			$arrayUlSol = odbc_fetch_array($resUlSol);
                $solicitacao=$arrayUlSol['Cd_ultima_solic'];
				$_SESSION['numCiSav']=$solicitacao;
				}
$sqlConsSitControle="SELECT Sit_solicitacao
			   FROM COCSO WITH(NOLOCK)
			   WHERE controle = dbo.CGFC_BUSCA_CONFIGURACAO(490,null)";
$resConsSitControle = odbc_exec($conCab2, $sqlConsSitControle);
$arrayConsSitControle = odbc_fetch_array($resConsSitControle);
$situacao=$arrayConsSitControle['Sit_solicitacao'];
//Nacional
if($_SESSION['abrangenciaSav']=='Nacional'){
$SqlcidadeUf=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$arrayRegistro['origemida']."'"));
$cidadeUf=$SqlcidadeUf['municipio']."/".$SqlcidadeUf['uf'];
}else{
	$SqlcidadeUf=mysql_fetch_array(mysql_query("SELECT nome,iso FROM paises WHERE iso='".$arrayRegistro['origemida']."'"));
	$cidadeUf=$SqlcidadeUf['nome']."/".$SqlcidadeUf['iso'];
	}
$SQLCriaCi="insert into COSOLICI
   (
   solicitacao,
   cd_unid_negoc,
   cd_tipo_operaca,
   data,
   plano_mestre,
   respons_cotacao,
   contato,
   dt_prazo_entreg,
   local_entrega,
   plano_de_compra,
   cod_cliente,
   situacao,
   cd_condicao_pag,
   desc_cond_pag,
   projeto,
   impressa,
   cd_cancelamento,
   usuario_criacao,
   data_criacao,
   usuario_modific,
   dt_modificacao,
   sessao,
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
   campo42,
   campo43,
   campo44,
   campo45,
   campo46,
   campo47,
   campo48,
   campo49,
   campo50,
   campo51,
   campo52,
   campo53,
   campo54,
   campo55,
   usrsoli1,
   usrsoli2,
   usrsoli3,
   observacao
   )
values 
   (
   ".$solicitacao.",                                  --  Solicitacao  int 
   '".$unidadeNeg."',                                 --  cd_unid_negoc  char(3)
   '".$toperacao."',                                  --  Cd_tipo_operaca  char(5)
   dbo.CGFC_DATAATUAL (),	                          --  Data  datetime 
   '',                                                --  Plano_Mestre  char(12)
   '',                                                --  respons_cotacao  char(6)
   0,                                                 --  Contato  int 
   NULL,                                              --  Dt_prazo_entreg  datetime 
   '".strtoupper($cidadeUf)."',                                   --  Local_entrega  char(40)
   '',                                                --  Plano_de_compra  char(10)
   '".$gestor."',                                          --  Cod_cliente  char(6)
   '".$situacao."',                                               --  Situacao  char(1)
   '',                                                --  Cd_condicao_pag  char(3)
   '[SAV ".$numSav."]: ".$arrayRegistro['evento']."',  --  Desc_cond_pag  char(60)
   '',                                                --  Projeto  char(12)
   0,                                                 --  Impressa  bit 
   '   ',                                             --  Cd_cancelamento  char(3)
   '".$userCriac."',                                             --  Usuario_criacao  char(3)
   dbo.CGFC_DATAATUAL (),                         --  Data_criacao  datetime 
   '".$userCriac."',                                             --  Usuario_modific  char(3)
   dbo.CGFC_DATAATUAL (),                         --  Dt_modificacao  datetime 
   27733,                                             --  Sessao  int 
   ' ',                                               --  Campo23  char(1)
   ' ',                                               --  Campo24  char(1)
   ' ',                                               --  Campo25  char(1)
   ' ',                                               --  Campo26  char(1)
   dbo.CGFC_BUSCA_CONFIGURACAO(490,null),                                              --  Campo27  char(2)
   '  ',                                              --  Campo28  char(2)
   '".$userCriac."',                                             --  Campo29  char(3)
   '   ',                                             --  Campo30  char(3)
   '     ',                                           --  Campo31  char(5)
   '',                                          --  Campo32  char(6)
   '".$setor."',                                          --  Campo33  char(6)
   '',                                                --  Campo34  char(6)
   '',                                                --  Campo35  char(6)
   '',                                                --  Campo36  char(12)
   ' ',                                               --  Campo37  char(1)
   0,                                                 --  Campo38  float 
   0,                                                 --  Campo39  float 
   0,                                                 --  Campo40  float 
   dbo.CGFC_BUSCA_CONFIGURACAO(455,null),             --  Campo41  real 
   0,                                                 --  Campo42  real 
   0,                                                 --  Campo43  float 
   0,                                                 --  Campo44  float 
   0,                                                 --  Campo45  float 
   0,                                                 --  Campo46  float 
   0,                                                 --  Campo47  float 
   0,                                                 --  Campo48  bit 
   0,                                                 --  Campo49  bit 
   0,                                                 --  Campo50  bit 
   NULL,                                              --  Campo51  char(6)
   NULL,                                              --  Campo52  char(6)
   NULL,                                              --  Campo53  datetime 
   NULL,                                              --  Campo54  datetime 
   NULL,                                              --  Campo55  datetime 
   '',                                                --  Usrsoli1  char(20)
   NULL,                                              --  Usrsoli2  datetime 
   0,                                                 --  Usrsoli3  float 
   ''                                                 --  Observacao  char(201)
   )";
$resCriaCi = odbc_exec($conCab2, $SQLCriaCi) or die("<p>".odbc_errormsg());
?>