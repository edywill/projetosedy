<?php 
session_start();
require "conectsqlserverci.php";
include "mb.php";
$solicNum='';
$valida=0;
    if(!empty($_SESSION['numCi']) && empty($_POST['solic'])){
	$solicNum=$_SESSION['numCi'];
	}elseif(!empty($_GET['ci'])){
	$solicNum=$_GET['ci'];
	}

if(!empty($solicNum)){
	
$_SESSION['numCi']=$solicNum;
$queryCi="select sol.solicitacao,
       sol.cd_unid_negoc,
       sol.data,
       sol.desc_cond_pag,
       sol.local_entrega,
       sol.campo33 as setor,
       sol.campo27 as controle,
       sol.situacao,
       sol.campo32 as conta,
       sol.cod_cliente,
       --busca o nome completo da unidade de negócio
       (select un.nome_completo
        from GEUNIDNE un (nolock)
        where un.cd_unidade_de_n = sol.cd_unid_negoc) as nmUN,
       --busca a descrição do controle
       (select con.descricao
        from COCSO con (nolock)
        where con.controle = sol.campo27) as descControle,
        --busca a descrição da conta financeira
       (select cf.descricao
        from GFCONTA cf (nolock)
        where cf.cd_conta = sol.campo32) as descContaFinanc,
       --busca o nome completo do gestor
       (select emp.nome_completo
        from GEEMPRES emp (nolock)
        where emp.cd_empresa = sol.cod_cliente) as nmEmpresa
from COSOLICI sol (nolock)
where 
sol.solicitacao = '".$solicNum."'";
$sqlCi=odbc_exec($conCab,$queryCi) or die(odbc_error());
$contarResultados=odbc_num_rows($sqlCi);
$objResultados=odbc_fetch_array($sqlCi);	
    }else{
//caso seja único
$and='';
$buscaSol='';
if(!empty($_POST['solic']) || !empty($_POST['solicfim'])){
   if(empty($_POST['solic'])){
	   $buscaSol="sol.solicitacao = '".$_POST['solicfim']."'";
	   $and='and ';
	   }elseif(empty($_POST['solicfim'])){
			   $buscaSol="sol.solicitacao = '".$_POST['solic']."'";
		       $and='and ';
		   }else{
	$buscaSol="sol.solicitacao between ".$_POST['solic']." and ".$_POST['solicfim']."";		   
	$and='and ';
			   }
    }
//Tratamento para busca pela descrição
$buscaDesc='';
$desc2=preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['desc']));
if(!empty($desc2)){
	$buscaDesc=$and."sol.desc_cond_pag like '".preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['desc']))."'";
	$and='and ';
	}
//Busca pelo local
$buscaLocal='';
$local2=preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['local']));
if(!empty($local2)){
	$buscaLocal=$and."sol.local_entrega like '".preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['local']))."'";	
	$and='and ';
	}
//Busca pelo controle
$buscaCon='';
$contFim2=preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['controlefim']));
$contInc2=preg_replace('/[^[:alpha:]_]/', '',addslashes($_POST['controle']));
if(!empty($contInc2) || !empty($contFim2)){
   if(empty($_POST['controle'])){
	   $controle=addslashes($_POST['controlefim']);
	   $arControle = explode('-', $controle);
	   $controle=$arControle[0];
	   $buscaCon=$and."sol.campo27 ='".$controle."'";
	   $and='and ';
	   }elseif(empty($_POST['controlefim'])){
			    $controle=addslashes($_POST['controle']);
	   			$arControle = explode('-', $controle);
	   			$controle=$arControle[0];
	   			$buscaCon=$and."sol.campo27 ='".$controle."'";
		        $and='and ';
		   }else{
	        $controle1=addslashes($_POST['controle']);
	        $arControle1 = explode('-', $controle1);
	        $controle1=$arControle1[0];
			$controle2=addslashes($_POST['controlefim']);
	        $arControle2 = explode('-', $controle2);
	        $controle2=$arControle2[0];
	   $buscaCon=$and."sol.campo27 between '".$controle1."' and '".$controle2."'";		   
			   $and='and ';
			   }
    }
	//Busca pelo gestor
$buscaGestor='';
$gestor2=preg_replace('/[^[:alpha:]_]/', '',addslashes(trim($_POST['gestor'])));
if(!empty($gestor2)){
	$gestor=addslashes(trim($_POST['gestor']));
	$arGestor = explode('-', $gestor);
	$gestor=$arGestor[0];
	$buscaGestor=$and."sol.cod_cliente = '".$gestor."'";	
	$and='and ';
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
//$dtocorrencia=converteData($_POST['dtocorrencia']);
//$dtocorrencia=str_replace("'","\"",$dtocorrencia);

	//Busca pela Data
	$buscaData='';
if(!empty($_POST['dtinicio']) || !empty($_POST['dtfim'])){
   if(empty($_POST['dtinicio'])){
	   $dataFinal=converteData($_POST['dtfim'])." 00:00";
	   //$dataFinal=$_POST['dtfim']." 00:00";
	   $buscaData=$and."sol.data=CAST('".$dataFinal."' AS DATETIME)";
	   $and='and ';
	   }elseif(empty($_POST['dtfim'])){
			   //$dataInicial=$_POST['dtinicio']." 00:00";
			   $dataInicial=converteData($_POST['dtinicio'])." 00:00";
	   		   $buscaData=$and."sol.data=CAST('".$dataInicial."' AS DATETIME)";
		       $and='and ';
		   }else{
			   //$dataInicial=$_POST['dtinicio']." 00:00";
			   $dataInicial=converteData($_POST['dtinicio'])." 00:00";
			   //$dataFinal=$_POST['dtfim']." 00:00";
			   $dataFinal=converteData($_POST['dtfim'])." 00:00";
	$buscaData=$and."sol.data between CAST('".$dataInicial."' AS DATETIME) and CAST('".$dataFinal."' AS DATETIME)";		   
			   $and='and ';
			   }
}
//Buscando material
$buscaMaterial='';
$mat2=preg_replace('/[^[:alpha:]_]/', '',addslashes(trim($_POST['cdMaterial'])));
if(!empty($mat2)){
	$material=addslashes(trim($_POST['cdMaterial']));
	$arMaterial = explode('-', $material);
	$cdReduzido=$arMaterial[0];
	$selectMat=odbc_exec($conCab,"SELECT Cd_material FROM ESMATERI (nolock) WHERE Cd_reduzido='".$cdReduzido."'");
	$cdMaterial=odbc_fetch_array($selectMat);
	$buscaMaterial=$and."exists(select 1
           from COISOLIC its (nolock)
           where its.cd_solicitacao = sol.solicitacao
           and its.cd_especie_esto = 'E'
           and its.cd_material = '".$cdMaterial['Cd_material']."')";
	$and='and ';
	}
	
if(empty($buscaSol) and empty($buscaMaterial) and empty($buscaCon) and empty($buscaData) and empty($buscaLocal) and empty($buscaGestor) and empty($buscaDesc)){
			$valida=1;
			?>
       <script type="text/javascript">
       alert("Erro: Necessario informar um dos criterios de busca!");
       history.back();
       </script>
       <?php

	}else{
$queryCi="select sol.solicitacao,
       sol.cd_unid_negoc,
       sol.data,
       sol.desc_cond_pag,
       sol.local_entrega,
       sol.campo33 as setor,
       sol.campo27 as controle,
       sol.situacao,
       sol.campo32 as conta,
       sol.cod_cliente,
       --busca o nome completo da unidade de negócio
       (select un.nome_completo
        from GEUNIDNE un (nolock)
        where un.cd_unidade_de_n = sol.cd_unid_negoc) as nmUN,
       --busca a descrição do controle
       (select con.descricao
        from COCSO con (nolock)
        where con.controle = sol.campo27) as descControle,
        --busca a descrição da conta financeira
       (select cf.descricao
        from GFCONTA cf (nolock)
        where cf.cd_conta = sol.campo32) as descContaFinanc,
       --busca o nome completo do gestor
       (select emp.nome_completo
        from GEEMPRES emp (nolock)
        where emp.cd_empresa = sol.cod_cliente) as nmEmpresa,
	   --busca o nome completo do gestor
       (select emp2.nome_completo
        from GEEMPRES emp2 (nolock)
        where emp2.cd_empresa = sol.cod_cliente) as nmSolicitante,
	   --Busca o nome do solicitante
	   (select usu2.nome
        from GEUSUARI usu2 (nolock)
        where usu2.Cd_usuario = sol.Usuario_criacao) as nmCriador
from COSOLICI sol (nolock)
where 
".$buscaSol."
".$buscaDesc."
".$buscaLocal."
".$buscaCon."
".$buscaGestor."
".$buscaData."
".$buscaMaterial."";
$sqlCi=odbc_exec($conCab,$queryCi) or die("<p>".odbc_errormsg());
$contarResultados=odbc_num_rows($sqlCi);
$objResultados=odbc_fetch_array($sqlCi);
   }
}
if($valida==0){
if($contarResultados<1){
			?>
  <script type="text/javascript">
       alert("Erro: Nenhuma solicitacao encontrada!");
       history.back();
       </script>
       <?php
	}elseif($contarResultados==1){
		$readOnly='';
		if($objResultados['controle']<>'03'){
			$readOnly=" readonly='readonly' ";
			}
			$_SESSION['readOnly']=$readOnly;
		echo "<div id='controle' style=\"display: none;\">";
require ('conexaomysql.php');
$sqlUser=mysql_query("SELECT cigam,controle FROM usuarios WHERE cigam='".$_SESSION['userCiCigam']."'");
$arrayUser=mysql_fetch_array($sqlUser);
echo "</div>";
		$_SESSION['numCi']=$objResultados['solicitacao'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" /> 
<script type="text/javascript">
$().ready(function() {
    $("#gestor").autocomplete("suggest_gestor.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(e) {
    $('input').keydown(function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});
	$('input[type=file]').on("change", function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});
});
</script>
<style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>

<style type="text/css">
a:hover {
	background:#ff0; 
	color:#f00;
	}
</style>
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
<strong>CIWEB  - Atualizar Solicita&ccedil;&atilde;o:</strong><br/><br/>

  <strong>DADOS GERAIS GERAIS DA CI</strong>
<form  method="post" action="ciWAtu.php" enctype="multipart/form-data">
<table width='100%' border='0'> 
  <tr><td><input class="input" name="numCi" type="hidden" size="10" value="<?php echo $objResultados['solicitacao'];  ?>" />
		
        <strong>CI n&ordm;:<font size="3" color="red"><?php echo " ".$objResultados['solicitacao']; ?></strong></font><br/><br/></td><td><br/>
	</td></tr><tr><td>
		<strong>Data:<?php 
		echo " ".date("d/m/Y", strtotime($objResultados['data'])); ?></strong><br/><br/><br/></td>
</td></tr>
<tr><td>
	<strong>Descri&ccedil;&atilde;o:</strong> </td><td><br><input class="input" <?php echo $readOnly; ?> name="desc" type="text" size="80" maxlength="59" value="<?php echo trim($objResultados['desc_cond_pag']);?>" autofocus/><br/>
</td></tr>
<tr><td>
<strong>Local:</strong></td><td><br><input class="input" name="local" <?php echo $readOnly; ?> type="text" size="40" maxlength="39" value="<?php echo trim($objResultados['local_entrega']);?>"/><br/>
</td></tr>
<tr><td>
	<strong>Gestor:</strong></td><td><br><input class="input" name="gestor" id="gestor" <?php echo $readOnly; ?> type="text" size="40" value="<?php echo trim($objResultados['cod_cliente'])."-".trim($objResultados['nmEmpresa']);?>"/><br/>

</td></tr>
<br />
<tr>
		<td><br/><strong>Controle:</strong></td><td colspan="2"><br/><?php echo trim($objResultados['controle'])."-".trim($objResultados['descControle']);?></td>
		</tr>
        <tr>
<td>
  <strong>Anexo(s):</strong></td>
<td colspan="2">
<?php
echo "<div style='display:none'>";
$embarquePedido=trim($objResultados['solicitacao']);
$sqlAcomp=odbc_exec($conCab,"SELECT historico FROM GEACOMP (nolock) WHERE rtrim(ltrim(embarque_pedido))='".$embarquePedido."'");
$arrayAcomp=odbc_fetch_array($sqlAcomp);
$justItemAt=trim($arrayAcomp['historico']);
$posicao=explode("<<",$justItemAt);
$i=0;
$quebra=chr(13).chr(10);
$anexoAnt='';
echo "</div>";
foreach($posicao AS $pos){
	echo "<div style='display:none'>";
	require("conectftp.php");
	$stringAnexoI='';
	$stringAnexoArray='';
	$stringAnexoResult='';
    $stringAnexoCompara='';
	$stringAnexo='';
	$arrayPastasLocais='';
	$endFinal='';
	$array='';
	$cont='';
	
	$stringAnexoI[$i]=strstr($pos,"An:W");
	echo "</div>";
	if($stringAnexoI[$i]<>''){
		echo "<div style='display:none'>";
	$stringAnexo[$i]=str_replace(" ","",str_replace("An:W:\\Anexos_CI\\","",str_replace(">>","",str_replace("<br>","",$stringAnexoI[$i]))));
	$stringAnexoArray[$i]=explode("\\",$stringAnexo[$i]);
	$stringAnexoResult[$i]=end($stringAnexoArray[$i]);
//Verifica se o arquivo existe no FTP e na pasta local. Se não existir no FTP ele oculta o link, se não existir local ele da um ftp_get(), cria as pastas necessárias e salva o arquivo na pasta.
//Terá que verificar cada pasta se existe antes de criar
$stringAnexoCompara[$i]=str_replace("\\","/",$stringAnexo[$i]);
echo "</div>";
if(is_file(trim($cheqftp.$stringAnexoCompara[$i]))){
	if(!is_file('Anexos\\'.trim($stringAnexoCompara[$i]))){
	  if(!is_dir('Anexos\\'.str_replace($stringAnexoResult[$i],"",$stringAnexo[$i]))){
		  $arrayPastasLocais[$i]=explode("\\",str_replace($stringAnexoResult[$i],"",$stringAnexo[$i]));
		  $contPt[$i]=0;
		  $endFinal[$i]='Anexos\\';
		  while($array[$i][$cont[$i]]<>end($arrayPastasLocais[$i])){
			  $endFinal[$i].=$arrayPastasLocais[$i][$contPt[$i]]."\\";
			  if(!is_dir($endFinal[$i])){
				  mkdir($endFinal[$i], 0700);
				  }
			 $contPt[$i]++;
			 }
		  }
		  if(is_file(trim($cheqftp.$stringAnexoCompara[$i]))){
		  //Nesse ponto dou ftp_get e copio o arquivo para ca no endereço citado.
		  ftp_get($con_id, trim($stringAnexo[$i]),'Anexos\\'.$stringAnexo[$i], FTP_BINARY );
		  }
	  }  
	  echo "<a href='Anexos/".$stringAnexo[$i]."' target='_blank'><font size='-2'><strong>".$stringAnexoResult[$i]."</strong></a> - <a href='ciWdelAnexo.php?end=".$stringAnexoResult[$i]."&ci=".$objResultados['solicitacao']."&tp=1' onclick=\"return confirm('Deseja realmente remover esse arquivo?')\"><font color='red'>Remover</font></a></font><br>";
   	  $anexoAnt.=$quebra."<<".utf8_encode(str_replace($quebra,"",$stringAnexoI[$i]));
   }
  }
  $i++;
ftp_close($con_id);
}
  echo "<input type='hidden' name='anexant' value='".utf8_decode($anexoAnt)."' />";
$justItemAt=str_replace($quebra.$quebra,"",preg_replace("'<<[^>]+>>'", "",$justItemAt));
?>
<input name="anexo[]" id='anexo[]' type=file multiple /><br />
(Selecione os arquivos segurando CTRL ou Shift / Max de 10Mb por arquivo)
<input type="hidden" name="userAc" value="<?php echo trim($arrayUser['cigam']); ?>" />
</td></tr>

        <br />
		<td colspan='6'><br /><div align='right'>
        <?php 
        echo "<div id='btnat'>Sem altera&ccedil;&atilde;o</div><div id='btat' style='visibility:hidden'><input class=\"buttonVerde\" name=\"atualizar\" type=\"submit\" value=\"ATUALIZAR CI\" /></div>"; 
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
	</tr>
</table>
</form>

<br/><br/><br/>
<table width='100%' border='0'>
<tr><td align='center'><form action="imprimeCi.php" method="post" name="imp" id="imp" target="_blank">
<input type="hidden" name="id_ciImpressao" value="<?php echo trim($objResultados['solicitacao']); ?>" />
<input class="button" name="impressao" type="submit" value="Impress&atilde;o CI" /></form>
</td>

<td align='center'><form action="ciWAcomp.php" method="post">
<input type="hidden" name="numCi" value="<?php echo trim($objResultados['solicitacao']); ?>" />
<input type="hidden" name="user" value="<?php echo trim($arrayUser['cigam']); ?>" />
<input type="hidden" name="readOnly" value="<?php echo $readOnly; ?>" />
<input class="button" name="acomp" type="submit" value="Acompanhamentos" /></form></td>

<td align='center'>
<?php 
if(($arrayUser['controle']==$objResultados['controle']) || $readOnly==''){
	?>
<form action="ciWControle.php" method="post">
<input type="hidden" name="numCi" value="<?php echo trim($objResultados['solicitacao']); ?>" />
<input type="hidden" name="usuario" value="<?php echo trim($_SESSION['userCiCigam']); ?>" />
<input type="hidden" name="codControle" value="<?php echo trim($objResultados['controle']); ?>" />
<input type="hidden" name="descControle" value="<?php echo trim($objResultados['descControle']); ?>" />
<input type="hidden" name="descCi" value="<?php echo trim($objResultados['desc_cond_pag']); ?>" />
<input type="hidden" name="retorno" value="ciWResCons.php" />
<input class="button" name="controle" type="submit" value="Alterar Controle" /></form>
<?php 
}
?>
</td>

<td align='center'><form action="ciWItens.php" method="post">
<input type="hidden" name="solic" value="<?php echo trim($objResultados['solicitacao']); ?>" />
<input type="hidden" name="user" value="<?php echo trim($_SESSION['userCiCigam']); ?>" />
<input class="button" name="itens" type="submit" value="Atualizar Itens" />
</form></td>
</tr>
</table>

<?php 
	}else{
		if($contarResultados>50){
			?>
       <script type="text/javascript">
       alert("Mais de 50 ocorrencias encontradas. \nPor favor refine sua pesquisa!");
       history.back();
       </script>
       <?php
			}else{
		//Apresenta lista de Cis encontradas (limite de 25 resultados
		echo "<link href='css/estilo.css' rel='stylesheet' type='text/css' media='screen' /><div id='box3'><strong>Solicita&ccedil;&otilde;es Encontradas</strong><br/>";
		$sqlCiMais=odbc_exec($conCab,$queryCi) or die(odbc_error());
		echo "<div id='tabela3'><br/><table border=0 width='100%'><tr bgcolor='#658BF3'><td width='10%'><strong>Num. CI</strong></td><td width='40%'><strong>Descri&ccedil;&atilde;o</strong></td><td width='25%'><strong>Gestor</strong></td><td width='25%'><strong>Solicitante</strong></td><tr>";
		while($objVarios=odbc_fetch_object($sqlCiMais)){
			//echo "<br>";
			echo "<td bgcolor='#DCDCDC'><center><strong><a href='ciWResCons.php?ci=".$objVarios->solicitacao."'>".$objVarios->solicitacao." </strong></center></td><td bgcolor='white'>".$objVarios->desc_cond_pag."</td><td bgcolor='white'>".$objVarios->nmSolicitante."</td><td>".$objVarios->nmCriador."</td></a></tr>";
			};
			echo "</table></div></div>";
		}
	}
}
?>
</div>
</body>
</html>
