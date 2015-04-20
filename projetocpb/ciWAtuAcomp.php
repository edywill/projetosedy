<?php
session_start();
require "conectsqlserverci.php";
include "mb.php";
$numCi=$_POST['solic'];
$solicitacao=$numCi;
$user=$_POST['user'];
$justificativa=trim(utf8_decode($_POST['justificativa']));
//$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
$_SESSION['justAcompCiS']=$_POST['justificativa'];
$countError=0;
$errorMsg='';
$i = 0;
$quebra = chr(13).chr(10);
				if(empty($_POST['anexant'])){
				$endArquivo='';
				}else{
					$endArquivo=str_replace(" ","",utf8_decode($_POST['anexant']));
					}
$solicitacaoAcomp=str_pad($_POST['solic'], 8, " ", STR_PAD_LEFT);
$justificativa=str_replace("?","-",$justificativa);
$justificativa=str_replace("'","\"",$justificativa);
$justificativa=addslashes($justificativa);
$justificativa=str_replace("\\\\","\\",$justificativa).$endArquivo;
$valida=0;
if(strlen($justificativa)<2000){
	$sqlConsAcomp="SELECT codigo_titulo FROM GEACOMP(nolock) WHERE embarque_pedido='".$solicitacaoAcomp."' AND codigo_titulo='801' ";
	$resSqlConsAcomp=odbc_exec($conCab, $sqlConsAcomp) or die("<p>".odbc_errormsg());
	$countSqlConsAcomp=odbc_num_rows($resSqlConsAcomp);
	if($countSqlConsAcomp<1){
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
   '".$user."',                     --  Usuario  char(3)
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
$resSqlInsAcomp=odbc_exec($conCab, $sqlInsAcomp) or die("<p>".odbc_errormsg());
		if($resSqlInsAcomp){
			$valida=1;
			}
		}else{
		$updateCi=odbc_exec($conCab,"UPDATE GEACOMP SET historico='".$justificativa."'
							          WHERE tipo_acompanham= 'R'
									  AND codigo_titulo='801'
									  AND rtrim(ltrim(embarque_pedido))='".$numCi."'") or die(odbc_error());
		if($updateCi){
			$valida=1;
			}
}
if($valida==1){
		 unset($_SESSION['numCiAcomp']);
		 unset($_SESSION['justAcompCiS']);
         unset($_SESSION['readOnlyAcomp']);
		?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Acompanhamento Atualizado com Sucesso!")
window.location="ciWResCons.php";
</SCRIPT>
<?php 
	}else{
		?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Ocorreu um erro. Tente Novamente!")
window.location="ciWResCons.php";
</SCRIPT>
<?php 
		}
		}else{
	?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Erro[1]: O texto possui mais de 2000 caracteres.")
window.location="ciWAcomp.php";
</SCRIPT>
<?php		
			}
		?>