<?php
require "conectsqlserverci.php";
include "mb.php";
$valida=0;
$countError=0;
$errorMsg='';
$numCi=$_POST['numCi'];
$user=$_POST['userAc'];
$solic=$numCi;
$solicitacao=$numCi;
//$desc=mb_convert_encoding($_POST['desc'],"ISO-8859-1","UTF-8");
$desc=$_POST['desc'];
$desc=str_replace("'","\"",$desc);
//$local=mb_convert_encoding($_POST['local'],"ISO-8859-1","UTF-8");
$local=$_POST['local'];
$local=str_replace("'","",$local);
$gestor=$_POST['gestor'];
$arGestor = explode('-', $gestor);
$gestor=$arGestor[0];
$i = 0;
$quebra = chr(13).chr(10);
				if(empty($_POST['anexant'])){
				$endArquivo='';
				}else{
					$endArquivo=str_replace(" ","",$_POST['anexant']);
					}
				foreach ($_FILES['anexo']['name'] as $key => $nome){
					$arquivo = $_FILES['anexo'];
					$tamanho = 1024 * 1024 * 10;
					if($arquivo['size'][$i]>$tamanho){
								$valida=1;
								$countError++;
								$errorMsg.='Erro['.$countError.']: Arquivo superior a 10MB.\\n';
						}else{
					if(!empty($nome)){
					require("conectftp.php");  
	    if(!is_dir($cheqftp.'CIWEB\\'.$solicitacao)){
			 ftp_mkdir($con_id,'CIWEB\\'.$solicitacao);
				 }
		if(!is_dir('Anexos\\CIWEB\\'.$solicitacao)){
			  if(!is_dir('Anexos\\CIWEB')){
			  	mkdir('Anexos\\CIWEB', 0700);
			    }
			 mkdir('Anexos\\CIWEB\\'.$solicitacao, 0700);
			}
		  
        $caminho_absoluto = 'CIWEB\\'.$solicitacao."\\";
		$caminho_absoluto_web = 'Anexos\\'.$caminho_absoluto;
        if($tamanho>$arquivo['size'][$i]){
		if(!ftp_put( $con_id, $caminho_absoluto.$solicitacao."-".$i.str_replace(" ","",$arquivo['name'][$i]), $arquivo['tmp_name'][$i], FTP_BINARY ) || !move_uploaded_file($arquivo['tmp_name'][$i], $caminho_absoluto_web.$solicitacao."-".$i.str_replace(" ","",$arquivo['name'][$i]))){
									$valida=1;
					 				$countError++;
	    			 				$errorMsg.='Erro['.$countError.']: Problema ao fazer upload do(s) ANEXO(S).\\n'; 
																		  }
				    			    $endArquivo.=$quebra."<<An:W:\\Anexos_CI\\".$caminho_absoluto.$solicitacao."-".$i.str_replace(" ","",$arquivo['name'][$i]).">>";
							}else{
								$valida=1;
								$countError++;
								$errorMsg.='Erro['.$countError.']: Arquivo superior a 10MB.\\n';
								}
																			ftp_close($con_id);
									$i++;
									}
				}
			}

if($valida==0 && ($endArquivo<>'' || !empty($endArquivo) || $i>0)){
$solicitacaoAcomp=str_pad($solic, 8, " ", STR_PAD_LEFT);
$valida=0;
	$sqlConsAcomp="SELECT historico FROM GEACOMP(nolock) WHERE embarque_pedido='".$solicitacaoAcomp."' AND codigo_titulo='801' ";
	$resSqlConsAcomp=odbc_exec($conCab, $sqlConsAcomp) or die("<p>".odbc_errormsg());
	$arraySqlConsAcomp=odbc_fetch_array($resSqlConsAcomp);
	$countSqlConsAcomp=odbc_num_rows($resSqlConsAcomp);
	$quebra = chr(13).chr(10);
	$justificativa=str_replace($quebra.$quebra,"",preg_replace("'<<[^>]+>>'", "",$arraySqlConsAcomp['historico']));
	$justificativa=trim($justificativa).$endArquivo;
	if(strlen($justificativa)>2000){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Acompanhamento ultrapassou o limite de caracteres. Altere o texto ou exclua algum anexo..\\n';
		}
	if($countSqlConsAcomp<1 && $valida==0){
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
			$valida=0;
			}
		}elseif($countSqlConsAcomp>0 && $valida==0){
		//$stringAnexoI=substr($justItemAt, $posicao);
		//$anexoAnt=str_replace("<<","",str_replace(">>","",$anexoAnt));
		$updateCi=odbc_exec($conCab,"UPDATE GEACOMP SET historico='".$justificativa."'
							          WHERE tipo_acompanham= 'R'
									  AND codigo_titulo='801'
									  AND rtrim(ltrim(embarque_pedido))='".$numCi."'") or die(odbc_error());
		if($updateCi){
			$valida=0;
			}
		}
	}
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
if($gestor!=''){
				  $sqlConsGestor="select *
			  from GEEMPRES (nolock)
			  WHERE cd_empresa='".$gestor."'";
	$rsConsGestor = odbc_exec($conCab,$sqlConsGestor) or die(odbc_error());
	$contarConsGestor=odbc_num_rows($rsConsGestor);
	$sqlConsGestorAtivo="select 1
			  from GEEMPRES (nolock) 
			  where ativo = 1 AND 
			  cd_empresa='".$gestor."'";
	$rsConsGestorAtivo = odbc_exec($conCab,$sqlConsGestorAtivo) or die(odbc_error());
	$contarConsGestorAtivo=odbc_num_rows($rsConsGestorAtivo);
				  	if(empty($contarConsGestor)){
						$valida=1;
						$countError++;
						$errorMsg.='Erro['.$countError.']: Gestor inv\\u00e1lido.\\n';
		}
		
		if(empty($contarConsGestorAtivo)){
						$valida=1;
						$countError++;
						$errorMsg.='Erro['.$countError.']: Gestor inativo.\\n';
			}
				  
				  }else{
						$valida=1;
						$countError++;
						$errorMsg.='Erro['.$countError.']: Informe o gestor.\\n';
					  }

							  
	if(empty($desc)){
	   $valida=1;
	   $countError++;
	   $errorMsg.='Erro['.$countError.']: O campo descri\\u00e7\\u00e3o deve ser preenchido.\\n';
	}
	if($valida==0){
		$updateCi=odbc_exec($conCab,"update COSOLICI
set desc_cond_pag = '".$desc."',
    local_entrega = '".$local."',
    cod_cliente = '".$gestor."'
where solicitacao = ".$numCi."");
		if($updateCi){
		
		?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Solicitacao Atualizada com Sucesso!")
window.location="ciWResCons.php";
</SCRIPT>
<?php 
		}else{
			$valida=1;
	   		$countError++;
	   		$errorMsg.='Erro['.$countError.']: Ocorreu um erro de procesamento. Tente novamente\\n';
			}
	}else{
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWResCons.php";
       </script>
       <?php
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
</body>
</html>