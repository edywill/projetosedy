<?php 
$solicitacaoAcomp=str_pad($solicitacao, 8, " ", STR_PAD_LEFT);
		$justificativa=utf8_decode("Solicitação criada a partir da SAV do funcionário ");
		$justificativa.=$_SESSION['nomeSav']." para o evento ".$arrayRegistro['evento'].". 
		Objetivo: ";
		$justificativa.=$arrayRegistro['objetivo']."";
		if(!empty($arrayRegistro['observ'])){
			$justificativa.=utf8_decode("Observações: ");
			$justificativa.=$arrayRegistro['observ']."";
			}
		//$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
		$justificativa=str_replace("?","-",$justificativa);
		$justificativa=str_replace("'","\"",$justificativa);
		$justificativa=addslashes($justificativa);
		$justificativa=str_replace("\\\\","\\",$justificativa);
		//$justificativa=utf8_decode($justificativa);
$sqlInsAcomp="insert into GEACOMP
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
   '      ',                           --  Cd_empresa  char(6)
   '".$solicitacaoAcomp."',            --  Embarque_pedido  char(12). Veja os espaços a frente…
   0,                                  --  Contato_os_lanc  int 
   0,                                  --  Sequencia_item  int 
   'R',                                --  Tipo_acompanham  char(1)
   '801',                              --  Codigo_titulo  char(3)
   NULL,                               --  Dt_prevista  datetime 
   NULL,                               --  Dt_realizada  datetime 
   NULL,                               --  Hora_prevista  char(6)
   NULL,                               --  Hora_realizada  char(6)
   '".$userCriac."',                     --  Usuario  char(3)
   0,                                  --  Sessao  int 
   NULL,                               --  Campo13  datetime 
   NULL,                               --  Campo14  datetime 
   NULL,                               --  Campo15  datetime 
   NULL,                               --  Campo16  datetime 
   NULL,                               --  Campo17  char(6)
   0,                                  --  Campo18  float 
   0,                                  --  Campo19  float 
   0,                                  --  Campo20  float 
   0,                                  --  Campo21  float 
   0,                                  --  Campo22  float 
   0,                                  --  Campo23  float 
   0,                                  --  Campo24  float 
   0,                                  --  Campo25  float 
   'N',                                --  Campo26  char(1)
   ' ',                                --  Campo27  char(1)
   ' ',                                --  Campo28  char(1)

   '  ',                               --  Campo29  char(2)
   '  ',                               --  Campo30  char(2)
   '  ',                               --  Campo31  char(2)
   '   ',                              --  Campo32  char(3)
   '   ',                              --  Campo33  char(3)
   '   ',                              --  Campo34  char(3)
   '      ',                           --  Campo35  char(6)
   '      ',                           --  Campo36  char(6)
   '      ',                           --  Campo37  char(6)
   '            ',                     --  Campo38  char(12)
   1,                                  --  Campo39  bit 
   0,                                  --  Campo40  bit 
   0,                                  --  Campo41  bit 
   0,                                  --  Sequencia_conta  int 
   '',                                 --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),               --  Data  datetime 
   '".date("His")."',                  --  Hora  char(6)
   NULL,                               --  Dt_repr1  datetime 
   NULL,                               --  Dt_repr2  datetime 
   '      ',                           --  Cd_contatante  char(6)
   '".$justificativa."' 			   --  Historico  varchar(2001)
   )";
   $resSqlInsAcomp=odbc_exec($conCab2, $sqlInsAcomp) or die("<p>".odbc_errormsg());
?>