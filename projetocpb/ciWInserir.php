<?php
require "conectsqlserverci.php";
session_start();
$justificativa='';
$valida=0;
$countError=0;
$errorMsg='';
$quebra = chr(13).chr(10);
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
if(empty($_SESSION['justCapa']) || empty($_SESSION['del'])){
		$usuario=$_POST['user'];
		$_SESSION['userCi']=$usuario;	
		$toperacao=str_pad("200", 5, " ", STR_PAD_RIGHT);
		$desc=mb_convert_encoding($_POST['desc'],"ISO-8859-1","UTF-8");
		$_SESSION['descInicio']=$_POST['desc'];
		$desc=str_replace("'","\"",$desc);
		$local=mb_convert_encoding($_POST['local'],"ISO-8859-1","UTF-8");
		$_SESSION['localInicio']=$_POST['local'];
		$local=str_replace("'","",$local);
		$setor="";
		$gestor=$_POST['gestor'];
		$_SESSION['gestorInicio']=$gestor;
		
		$arGestor = explode('-', $gestor);
		$gestor=$arGestor[0];
		$tgCigam="0";
		$unidadeNeg="001";
		$controle="03";
	
	if(empty($desc)){
	   $valida=1;
	   $countError++;
	   $errorMsg.='Erro['.$countError.']: O campo descri\\u00e7\\u00e3o deve ser preenchido.\\n';
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
		
		if(empty($contarConsGestorAtivo)&&$valida==0){
			$valida=1;
			$countError++;
	    	$errorMsg.='Erro['.$countError.']: Gestor inativo.\\n';
			}
				$solicitacao=0;
			if(!empty($contarConsGestor)){
	        	if(!empty($contarConsGestorAtivo) && $valida==0){
				$SQLUpSol = "UPDATE ESNSOLIC                                                     
                 SET CD_Ultima_SOLIC = CD_Ultima_SOLIC+1
				 WHERE Unico = ' '";
				$resUpSol = odbc_exec($conCab, $SQLUpSol) or die("<p>".odbc_errormsg());
				if($resUpSol){
				//Pegando o número da CI
				$SQLUlSol = "SELECT Cd_ultima_solic 
			   FROM ESNSOLIC (nolock) 
			   WHERE Unico = ' '";
				$resUlSol = odbc_exec($conCab, $SQLUlSol);
	 			$arrayUlSol = odbc_fetch_array($resUlSol);
                $solicitacao=$arrayUlSol['Cd_ultima_solic'];
				$_SESSION['solicitacao']=$solicitacao;
				$i = 0;
				$endArquivo=$quebra;
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
		if(!ftp_put( $con_id, $caminho_absoluto.$solicitacao."-".$i.str_replace(" ","",utf8_decode($arquivo['name'][$i])), $arquivo['tmp_name'][$i], FTP_BINARY ) || !move_uploaded_file($arquivo['tmp_name'][$i], $caminho_absoluto_web.$solicitacao."-".$i.str_replace(" ","",utf8_decode($arquivo['name'][$i])))){
									$valida=1;
					 				$countError++;
	    			 				$errorMsg.='Erro['.$countError.']: Problema ao fazer upload do(s) ANEXO(S).\\n'; 
										  }
									$endArquivo.=$quebra."<<An:W:\\Anexos_CI\\".$caminho_absoluto.$solicitacao."-".$i.str_replace(" ","",$arquivo['name'][$i]).">>";
							}else{
								$valida=1;
								$countError++;
								$errorMsg.='Erro['.$countError.']: Arquivo superior a 2MB.\\n';
								}
																			ftp_close($con_id);
									$i++;
									}
						}
				}
				$sqlConsSitControle="SELECT Sit_solicitacao
			   FROM COCSO (nolock)
			   WHERE controle = dbo.CGFC_BUSCA_CONFIGURACAO(490,null)";
$resConsSitControle = odbc_exec($conCab, $sqlConsSitControle);
$arrayConsSitControle = odbc_fetch_array($resConsSitControle);
$situacao=$arrayConsSitControle['Sit_solicitacao'];
if($valida==0){
//Inicio da criação da CI
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
   '".mb_strtoupper($local)."',                                   --  Local_entrega  char(40)
   '',                                                --  Plano_de_compra  char(10)
   '".$gestor."',                                          --  Cod_cliente  char(6)
   '".$situacao."',                                               --  Situacao  char(1)
   '',                                                --  Cd_condicao_pag  char(3)
   '".mb_strtoupper($desc)."',  --  Desc_cond_pag  char(60)
   '',                                                --  Projeto  char(12)
   0,                                                 --  Impressa  bit 
   '   ',                                             --  Cd_cancelamento  char(3)
   '".$usuario."',                                             --  Usuario_criacao  char(3)
   dbo.CGFC_DATAATUAL (),                         --  Data_criacao  datetime 
   '".$usuario."',                                             --  Usuario_modific  char(3)
   dbo.CGFC_DATAATUAL (),                         --  Dt_modificacao  datetime 
   27733,                                             --  Sessao  int 
   ' ',                                               --  Campo23  char(1)
   ' ',                                               --  Campo24  char(1)
   ' ',                                               --  Campo25  char(1)
   ' ',                                               --  Campo26  char(1)
   dbo.CGFC_BUSCA_CONFIGURACAO(490,null),                                              --  Campo27  char(2)
   '  ',                                              --  Campo28  char(2)
   '".$usuario."',                                             --  Campo29  char(3)
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
$resCriaCi = odbc_exec($conCab, $SQLCriaCi) or die("<p>".odbc_errormsg());
}
					}else{
						$valida=1;
						$countError++;
	    				$errorMsg.='Erro['.$countError.']: Ocorreu uma falha de processamento. Tente novamente.\\n';
						}
				}
			}
		}else{
			$valida=1;
			$countError++;
	    	$errorMsg.='Erro['.$countError.']: Informe o gestor.\\n';
			}

}else{
$usuario=$_SESSION['userCi'];
$solicitacao=$_SESSION['solicitacao'];
$justificativa=$_SESSION['justCapa'];
$$linkArq=$_SESSION['linkArquivoIns'];
	}

if($valida==1){
?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWCriar.php";
       </script>
       <?php
}else{
	$sqlConsAcomp=odbc_exec($conCab,"SELECT historico FROM GEACOMP(nolock) WHERE ltrim(rtrim(embarque_pedido))='".$solicitacao."' AND codigo_titulo='801'");
	$arrayConsAcomp=odbc_fetch_array($sqlConsAcomp);
	if(!empty($arrayConsAcomp['historico'])){
		$justificativa=utf8_encode($arrayConsAcomp['historico']);
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
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
function limitaTextarea(valor) {
	quantidade = 1999;
	total = valor.length;

	if(total <= quantidade) {
		resto = quantidade- total;
		document.getElementById('contador').innerHTML = resto;
	} else {
		document.getElementById('justificativa').value = valor.substr(0, quantidade);
	}
}
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
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
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3'>
<br/>

<form action="ciWInserirItens.php" method="post" name="ciWCriar" onSubmit="this.elements['cont'].disabled=true;" enctype="multipart/form-data">
<input name="solic" type="hidden" size="10" value="<?php echo $solicitacao; ?>" /> 
<input name="user" type="hidden" size="10" value="<?php echo $usuario; ?>" />
<input name="anexo" type="hidden" value="<?php echo $endArquivo; ?>" /> 
<strong>CIWEB - CI Nº <font size="3" color="red"><?php echo $solicitacao; ?></strong></font><br />
<br />
<strong>JUSTIFICATIVA / ACOMPANHAMENTO DA CI:</strong>
  <textarea name="justificativa" id="justificativa" cols="100" rows="10" onKeyUp="limitaTextarea(this.value)"><?php echo $justificativa; ?></textarea><br />
  <strong>(Caracteres restantes: <span id="contador">2000</span>)</strong>
<br /><br />
<input name="cont" type="submit" class="buttonVerde" value="Continuar &gt;&gt;" />
</form>
</div>
</body>
</html>
<?php
}
?>