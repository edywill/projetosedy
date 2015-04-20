<?php 
include "valida.php";
date_default_timezone_set('America/Sao_Paulo');
$id=$_SESSION['protocoloSession'];
$valida=0;
$mensagemErro='';
$counError=0;

//Atualiza Ocorrência
$status=$_POST['status'];
$anonimo=$_SESSION['anonimoSession'];
$novoanalista=$_POST['novoanalista'];
$mensagem=$_POST['mensagem'];
$_SESSION['mensagemSession']=$mensagem;

if((empty($status)) && (empty($novoanalista)) && empty($mensagem)){
	$counError++;
	$mensagemErro.="Erro[".$counError."]: Necessario alterar alguma informacao.\\n";
	$valida=1;
}

if($valida==0){
	$atStatus='';
	if(!empty($status)){
		$atStatus=" status_id='".$status."'";
		}
	$atAnalista='';
	if(!empty($novoanalista)){
		if(!empty($atStatus)){
			$atAnalista.=",";
			}
		$atAnalista.=" id_analista='".$novoanalista."'";
		}
		if(!empty($atAnalista) || !empty($atStatus)){
		$sqlUpdateProtocolo=odbc_exec($conCab,"UPDATE protocolo SET ".$atStatus.$atAnalista." WHERE id='".$id."'");
		if(!$sqlUpdateProtocolo){
			$counError++;
			$mensagemErro.="Erro[".$counError."]: Problema ao atualizar o registro.\\n";
			$valida=1;
			}
		if(!empty($atStatus)){
			//Altera status dos reports
			$sqlReportsProtocolo=odbc_exec($conCab,"UPDATE report SET status_id='".$status."' WHERE protocolo='".$id."'");
			if(!$sqlReportsProtocolo){
			$counError++;
			$mensagemErro.="Erro[".$counError."]: Problema ao atualizar as ocorrencias.\\n";
			$valida=1;
				}
			}
		}
//Grava acompanhamento
$montaMensagem='';
$situacao='';
if(!empty($mensagem)){
	$sqlProtocoloMensagem=odbc_fetch_array(odbc_exec($conCab,"SELECT status_id FROM protocolo WHERE id='".$id."'"));
	if(empty($status)){
		$status=$sqlProtocoloMensagem['status_id'];
		}
			$sqlSituacao=odbc_fetch_array(odbc_exec($conCab,"SELECT descricao FROM tipostatus WHERE id='".$status."'"));
			$situacao=utf8_encode($sqlSituacao['descricao']);
$dadosUsuario=odbc_fetch_array(odbc_exec($conCab,"SELECT name,email FROM device WHERE id='".$_SESSION['idUserSession']."'"));
$montaMensagem.='<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<table border="0" width="100%" height="100%">
<tr>
  <td height="134">Prezado(a) <strong>'.utf8_encode($dadosUsuario["name"]).'</strong>,</td></tr>
<tr><td height="59"><p>Obrigado por contribuir com a melhoria das rodovias federais por meio do aplicativo DNIT Móvel.</p><p>Suas ocorrências listadas abaixo, foram registradas sob o nº de protocolo : <strong>'.$_SESSION['protocoloSession'].'</strong> junto a Ouvidoria do DNIT.</p></td></tr>
<tr><td>';
$montaMensagem.="<table width='100%' cellpadding='0' cellspacing='0' border='1' class='display' name='tabela2'>
  <thead>
  			<tr bgcolor='#FFFFFF'>	
            		<th width='15%' height='21'>Rod./UF<br />KM</th>
                    <th width='15%'>Lat/Long<br />Mapa</th>				
					<th width='20%'>Ocorrências</th>
                    <th width='30%'>Detalhes da Ocorrência<br />(Ouvidoria)</th>
                    <th width='5%'>Foto</th>
					<th width='15%'>Data</th> 
				</tr>				
			</thead>
            <tbody>";
$sqlOcorAnalise=odbc_exec($conCab,"SELECT report.*,estado.sigla FROM report LEFT JOIN estado ON report.estado_id=estado.id WHERE protocolo='".$_SESSION['protocoloSession']."'");
			while($objOcorAnalise=odbc_fetch_object($sqlOcorAnalise)){
				$uf='';
				$estrada='N/D';
				$km='';
				if(!empty($sqlOcorAnalise['estrada_br'])){
					$estrada=str_pad($sqlOcorAnalise['estrada_br'], 3, "0", STR_PAD_LEFT);
					}				
				if(!empty($sqlOcorAnalise['sigla'])){
					$uf="/".$sqlOcorAnalise['sigla'];
					}
				if(!empty($sqlOcorAnalise['br_km'])){
					$km="<br>".$sqlOcorAnalise['br_km'];
					}
				$foto='';
				if(!empty($objOcorAnalise->photo)){
							$foto="<a class='iframe' href='http://dnitmovel.traky.com.br/upload/".$objOcorAnalise->photo."' target='_blank'><input type='button' name='foto' value='Foto'/></a>";
							}
			$ocorrenciasDesc='';
			$sqlTiposOcorrencias=odbc_exec($conCab,"SELECT category.title FROM category_has_report LEFT JOIN category ON category_has_report.category_id=category.id WHERE category_has_report.report_id='".$objOcorAnalise->id."' ORDER BY category.title");
			$countTipos=0;
			while($objTiposOcorrencias=odbc_fetch_object($sqlTiposOcorrencias)){
				if($countTipos==0){
				$ocorrenciasDesc.=$objTiposOcorrencias->title;
				}else{
					$ocorrenciasDesc.="<br>".$objTiposOcorrencias->title;
					}
					$countTipos++;
				}
			$local='';
			$latLong='SEM GPS';
			if(!empty($objOcorAnalise->latitude) && !empty($objOcorAnalise->longitude)){
			$local = "<a href='https://www.google.com.br/maps/place/".$objOcorAnalise->latitude.",".$objOcorAnalise->longitude."' target='_blank'>MAPA</a>";
			$latLong="<font size='-1'>".number_format($objOcorAnalise->latitude,3)."/".number_format($objOcorAnalise->longitude,3)."<br>".$local."</font>";
			}
			$dtCriac='-';
		if(!empty($objOcorAnalise->datetime_2) || $objOcorAnalise->datetime_2<>'null' ){
			$dtCriac=$objOcorAnalise->datetime_2;
				}
			$montaMensagem.="<tr align='center'><td>".$estrada.$uf.$km."</td><td align='center'>".$latLong."</td><td>".utf8_encode($ocorrenciasDesc)."</td><td>".utf8_encode($objOcorAnalise->messages)."</td><td>".$foto."</td><td>".$dtCriac."</td></tr>";
			}
			$montaMensagem.='</tbody>
            </table>';

$montaMensagem.='<br><br></td></tr>
<tr><td height="21">Esse protocolo encontra-se atualmente na situação: <strong>'.$situacao.'</strong>.</td></tr>
<tr><td height="21">Segue abaixo, mensagem da Ouvidoria do DNIT, a respeito do andamento do protocolo:</td></tr>
<tr><td><i>"'.$mensagem.'"</i></td></tr>
<tr><td></td></tr>';
if($status<>7){
$montaMensagem.='<tr><td height="21">Daremos maiores informações a respeito da solução dos problemas listados o mais breve possível.</td></tr>';
}
$montaMensagem.='<tr><td height="21">Agradecemos sua contribuição,</td></tr>
<tr><td></td></tr>
<tr>
  <td height="125"><strong>DNIT Móvel - Ouvidoria DNIT<br>
Departamento Nacional de Infraestrutura em Transportes - DNIT</strong></td></tr>
</table>
</body>
</html>';	
	
	}
	
$andamentoAcomp="Protocolo atualizado.";
if(!empty($_POST['status'])){
	$novaSituacao=odbc_fetch_array(odbc_exec($conCab,"SELECT descricao FROM tipostatus WHERE id='".$_POST['status']."'"));
	$andamentoAcomp.=" Status alterado para: ".utf8_encode($novaSituacao['descricao']).".";
	}
if(!empty($novoanalista)){
	$novaAnalista=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM login WHERE id_login='".$novoanalista."'"));
	$andamentoAcomp.=" Encaminhada para analista: ".utf8_encode($novaAnalista['nome']).".";
	}
	$sqlMaxAcomp=odbc_fetch_array(odbc_exec($conCab,"SELECT MAX(id) AS idmax FROM acompanhamento"));
	$novoIdAcomp=$sqlMaxAcomp['idmax']+1;
	$criaAcompanhamento=odbc_exec($conCab,"INSERT INTO acompanhamento (id,protocolo_id,analista_id,dt_criacao,andamento,mensagem) VALUES ('".$novoIdAcomp."','".$_SESSION['protocoloSession']."','".$_SESSION['usuarioID']."','".date('d/m/Y H:i:s')."','".utf8_decode($andamentoAcomp)."','".addslashes(utf8_decode($mensagem))."')");
include "functionEmail.php";
if(!empty($mensagem) && $anonimo<>1){
$validaEmail=enviaEmail(strtolower($dadosUsuario['email']),$dadosUsuario['name'],"[DNIT Móvel] - Protocolo ".$_SESSION['protocoloSession']."",$montaMensagem,'','');

if($validaEmail<>1){
			$counError++;
			$mensagemErro.="Erro[".$counError."]: Problema enviar o e-mail.".$validaEmail."\\n";
			$valida=1;
	}
 }
}	

if($valida==0){
	?>
    <script>alert('Atualizado com Sucesso!');top.location.href='analiseOcorr.php';</script>
    <?php
	}else{
		echo "<script>alert('".$mensagemErro."<br>Tente Novamente.');top.location.href='analiseOcorr.php';</script>";
		}
?>