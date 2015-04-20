<?php 
require "conectsqlserverci.php";
session_start();
$valida=0;
$countError=0;
$errorMsg='';
$_SESSION['quantidadeCiItenAt']=$_POST['quantidade'];
$_SESSION['prunitCiItenAt']=$_POST['pr_unitario'];
$_SESSION['pzentCiItenAt']=$_POST['pzent'];
$_SESSION['justCiItenAt']=$_POST['justificativa'];
unset($_SESSION['validComp']);
$solic=$_POST['solic'];
$_SESSION['solicCiItenAt']=$solic;

$sequencia=$_POST['seq'];
$_SESSION['sequenciaCiItenAt']=$sequencia;

$usuario=$_SESSION['userCi'];
$_SESSION['userCiItenAt']=$usuario;


$sqlUsuario="select Campo20, Nome
			from GEUSUARI (nolock)
			where cd_usuario = '".$usuario."' ";
	$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
	$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
$userSolic=$arraySqlUsuario['Campo20'];

$cdMaterial=trim($_POST['cdMaterial']);
$_SESSION['cdmaterialCiItenAt']=$cdMaterial;
$arMaterial = explode('-', $cdMaterial);
$cdMaterial=$arMaterial[0];
$cdMaterial=str_replace("'","\"",$cdMaterial);

if (is_numeric($cdMaterial)) { 
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
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o material.\\n';
	}
	if(empty($contarConsCdMatAtivo) && $valida==0){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Material inativo.';
			}
			
			if(empty($contarConsCdMatObs) && $valida==0){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Material obsoleto.\\n';
			}
}else{
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Material inv\\u00e1lido. Selecione na lista.\\n';
	}
$quantidade=$_POST['quantidade'];

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
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a quantidade para esse tipo de material.';
		}
	}
$quebra = chr(13).chr(10);
$pr_unitario=str_replace(".","",$_POST['pr_unitario']);
$pr_unitario=str_replace(",",".",$pr_unitario);
$pr_unitario=str_replace("'","\"",$pr_unitario);
if(empty($pr_unitario)){
	$pr_unitario="0.00";
	}
 if($valida==0){
$i=0;
$solicitacao=$solic;

if(empty($_POST['anexant'])){
				$endArquivo='';
				}else{
					$endArquivo=str_replace(" ","",$_POST['anexant']);
					}
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
$sqlItemUp=odbc_exec($conCab,"update COISOLIC
set cd_material = '".$cdMaterial."',
    quantidade = '".$quantidade."',
    qt_saldo = '".$quantidade."',
    pr_unitario = '".$pr_unitario."',
    usuario_modific = '".$_SESSION['userCiItenAt']."',
    dt_modificacao = dbo.CGFC_DATAATUAL()
where cd_especie_esto = 'E'
and quantidade = qt_saldo
and cd_solicitacao = '".$solicitacao."'
and sequencia = '".$sequencia."'");
if($sqlItemUp){
if(!empty($_POST['justificativa']) || ($endArquivo<>'' || !empty($endArquivo) || $i>0)){
$embarquePedido=$_POST['embarquePedido'];
$consultaAcomp=odbc_exec($conCab,"SELECT historico FROM GEACOMP WHERE tipo_acompanham='R'
					AND (codigo_titulo='802' OR codigo_titulo='803')
					AND embarque_pedido='".$embarquePedido."'");
$contarAcomp=odbc_num_rows($consultaAcomp);
$justificativa='';
if(strlen($_POST['justificativa'].$endArquivo)>1999){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A justificativa do item tem mais de 2000 caracteres. Altere o texto ou retire anexo.\\n';
	}

$justificativa=$_POST['justificativa'];
$justificativa=str_replace("?","-",$justificativa);
$justificativa=str_replace("'","\"",$justificativa);
$justificativa=addslashes($justificativa);
$justificativa=str_replace("\\\\","\\",$justificativa).$endArquivo;
//$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
	if($contarAcomp>0 && $valida==0){
$sqlAcomp=odbc_exec($conCab,"UPDATE GEACOMP set historico='".$justificativa."'
					WHERE tipo_acompanham='R'
					AND (codigo_titulo='802' OR codigo_titulo='803')
					AND embarque_pedido='".$embarquePedido."'");
     }else{
	 if($valida==0){
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
   '".$embarquePedido."',               --  Embarque_pedido  char(12)
   ".$solic.",                          --  Contato_os_lanc  int 
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
	 }
	}
	}
	}
}
if($_POST['volta']==2){
	$retornoIt="window.location='ciWItens.php';";
	}else{
		$retornoIt="window.location='ciWInserirItens.php';";
		}

if($valida==0){
?>
       <script type="text/javascript">
       alert("Item atualizado com sucesso.");
       <?php echo $retornoIt; ?>
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWAtuItens.php";
       </script>
       <?php
		}

?>