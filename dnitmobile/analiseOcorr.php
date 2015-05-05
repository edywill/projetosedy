<?php 
date_default_timezone_set('America/Sao_Paulo');
require("valida.php");
$valida=0;
$mensagemErro='';
$counError=0;
if(!empty($_POST['idUser'])){
	//Verifica protocolo
	$protNovo='';
	$sqlAnoProt=odbc_fetch_array(odbc_exec($conCab,"SELECT ultprot FROM protano WHERE ano='".date('Y')."' ORDER BY ultprot DESC"));
	if(empty($sqlAnoProt['ultprot'])){
		$criaProtAno=odbc_exec($conCab,"INSERT INTO protano(ano,ultprot) VALUES(".date('Y').",'00000001')");
		if(!$criaProtAno){
			$counError++;
			$mensagemErro.="Erro[".$counError."]: Problema ao criar numero do protocolo.\\n";
			$valida=1;
			}
		$protNovo=date('Y')."00000001";
		}else{
			$protNovoSoma=(int)$sqlAnoProt['ultprot']+1;
			$protNovoUnico=str_pad($protNovoSoma, 8, "0", STR_PAD_LEFT);
			$atualizaProt=odbc_exec($conCab,"UPDATE protano SET ultprot='".$protNovoUnico."' WHERE ano='".date('Y')."'");
			$protNovo=date('Y').$protNovoUnico;
			if(!$atualizaProt){
				$counError++;
				$mensagemErro.="Erro[".$counError."]: Problema ao consultar o protocolo.\\n";
				$valida=1;
				}
			}
	$_SESSION['protocoloSession']=$protNovo;
	
	if($valida==0){
	//Criar protocolo
	$criaProtocolo=odbc_exec($conCab,"INSERT INTO protocolo (id,device_id,status_id,dt_criacao,id_analista) VALUES ('".$_SESSION['protocoloSession']."','".$_POST['idUser']."','2','".date('d/m/Y H:i:s')."','".$_SESSION['usuarioID']."')");
	if(!$criaProtocolo){
				$counError++;
				$mensagemErro.="Erro[".$counError."]: Problema ao criar o protocolo.\\n";
				$valida=1;
				}
	$atualizaOcorrencias=odbc_exec($conCab,"UPDATE report SET protocolo='".$_SESSION['protocoloSession']."',status_id='2' WHERE status_id<2 AND protocolo IS NULL AND device_id='".$_POST['idUser']."'");
	if(!$atualizaOcorrencias){
				$counError++;
				$mensagemErro.="Erro[".$counError."]: Problema ao atualizar as ocorrencias.\\n";
				$valida=1;
				}
	$sqlMaxAcomp=odbc_fetch_array(odbc_exec($conCab,"SELECT MAX(id) AS idmax FROM acompanhamento"));
	$novoIdAcomp=$sqlMaxAcomp['idmax']+1;
	$criaAcompanhamento=odbc_exec($conCab,"INSERT INTO acompanhamento (id,protocolo_id,analista_id,dt_criacao,andamento,mensagem) VALUES ('".$novoIdAcomp."','".$_SESSION['protocoloSession']."','".$_SESSION['usuarioID']."','".date('d/m/Y H:i:s')."','Criado Protocolo ".$_SESSION['protocoloSession']."','')");
	if(!$atualizaOcorrencias){
				$counError++;
				$mensagemErro.="Erro[".$counError."]: Problema ao criar o acompanhamento.\\n";
				$valida=1;
				}
		}
	}elseif(!empty($_POST['idProt'])){
		//Resgata dados do protocolo
		$_SESSION['protocoloSession']=trim($_POST['idProt']);
		}
	
	if(empty($_SESSION['protocoloSession'])){
			echo "<script>alert('Erro[1]: Selecione um protocolo!');top.location.href='principal.php';</script>";
		}else{
			$sqlProtocolo=odbc_fetch_array(
			odbc_exec($conCab,"SELECT
protocolo.device_id,
protocolo.status_id,
protocolo.dt_criacao,
protocolo.id_analista,
login.perfil,
login.nome AS analista,
device.name,
device.email,
device.android,
device.iphone,
tipostatus.descricao AS status 
FROM protocolo 
LEFT JOIN login ON protocolo.id_analista=login.id_login 
LEFT JOIN device ON protocolo.device_id=device.id 
INNER JOIN tipostatus ON protocolo.status_id=tipostatus.id 
WHERE protocolo.id='".$_SESSION['protocoloSession']."'"));
		if($valida==0){				
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" type="text/css" href="datatables/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="datatables/dataTables.jqueryui.css">
<link rel="stylesheet" href="colorbox.css" />
<script type="text/javascript" language="javascript" src="datatables/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/dataTables.jqueryui.js"></script>
<script src="jscolorb.js"></script>
<script>
			$(document).ready(function(){
				$(".iframe").colorbox({iframe:true, width:900, height:700});
				$(".iframe2").colorbox({iframe:true, width:900, height:700});
				
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 4, "desc" ]],
		"pagingType": "full_numbers"
    } );
} );

	</script>
    <script type="text/javascript">
function limitaCaractere(textareaId,limite,exibeRestante){
var caracterDigitado = document.getElementById(textareaId).value;
var caracterRestante = limite - caracterDigitado.length;
document.getElementById(exibeRestante).innerHTML = "<span style='color:green'>Você ainda pode digitar " + caracterRestante + " caracteres.</span>";
if(caracterDigitado.length == limite - 1)
document.getElementById(exibeRestante).innerHTML = "<span style='color:green'>Você ainda pode digitar " + caracterRestante + " caractere.</span>";
if(caracterDigitado.length >= limite){
document.getElementById(textareaId).value = document.getElementById(textareaId).value.substr(0, limite);
document.getElementById(exibeRestante).innerHTML = "<span style='color:red'>Você já atingiu o limite de caracteres permitido!</span>";
}
}
</script>
    <style type="text/css">
  .botao{
        font-size:12px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#06A62C;
        border:0px;
        width:80px;
        height:30px;
		border-radius:20px;
       }
</style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td></td>
<td colspan="2" width="1024px" align="center"></td><td></td>
</tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/topo_brasil.png" center top/></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><a href="principal.php" style="border:hidden"><img src="imagens/topo_dnit.png" center top/></a></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" valign="middle" align="center" style="background:url(imagens/topoceu.png) no-repeat center top">
<table border="0" cellpadding="0" cellspacing="0" width="1105px"><tr><td width="3%"></td>
<td height='130' colspan="2" align="left">
<h3><font color="#000066" style="padding-left:5em">Bem vindo <?php 
	echo utf8_encode($_SESSION['nomeUserSession']);
?></font></h3>
</td><td width="30%"></td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center" style="">

<table border="0" cellpadding="0" cellspacing="0" width="1104px" height="500">
<tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<?php 
include "menu.php";
?>
</td></tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top" align="center">
    <td height="34" valign="top" align="center">
<form name='atocorrencia' method="post" action="atocorrencia.php">
<table width="100%" cellpadding='0' cellspacing='0' border='1' name='tabelacadastro'>
  <thead>
   <tr bgcolor="#DCDBDB">
     <td colspan="4" align="right"><font size="+3" color="#000066"><strong>ANALISE DE OCORRÊNCIAS</strong></font></tr>			
			</thead>
            <?php 
			
			?>
			<tbody>
			<tr align="left">
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Protocolo:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php echo $_SESSION['protocoloSession']; ?></strong></td><th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Data de Criação:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php echo $sqlProtocolo['dt_criacao']; ?></strong></td></tr>
            
            <tr align="left">
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Status:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php echo utf8_encode($sqlProtocolo['status']); ?></strong></td>
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Analista:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php echo utf8_encode($sqlProtocolo['analista']); ?></strong></td></tr>
            <tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Dados Usuário</font></th></tr>
            <tr align="left">
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Usuário:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php
			if(!empty($sqlProtocolo['email'])){
				$nomeUsuario=utf8_encode($sqlProtocolo['name']);
				$emailUsuario=utf8_encode($sqlProtocolo['email']);
				$_SESSION['idUserSession']=$sqlProtocolo['device_id'];
				}else{
					$nomeUsuario='An&ocirc;nimo';
					$emailUsuario='';
					$_SESSION['idUserSession']='';
					$_SESSION['anonimoSession']=1;
					}
			 echo $nomeUsuario; ?></strong></td><th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">E-mail:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><?php echo $emailUsuario; ?></strong></td></tr>
           <tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Ocorrências Vinculadas</font></th></tr>
           <tr><td colspan="4">
           <table id="example" width="100%" cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
  <thead>
  			<tr bgcolor="#FFFFFF">	
            		<th width='15%' height="21">Rod./UF<br />KM</th>
                    <th width='10%'>Lat/Long<br />Mapa</th>				
					<th width='15%'>Ocorrências</th>
                    <th width='30%'>Detalhes da Ocorrência<br />(Ouvidoria)</th>
                    <th width='5%'>Foto</th>
					<th width='15%'>Data</th> 
                    <th width='10%'>Status</th> 
				</tr>				
			</thead>
            <tbody>
            <?php
			$tabela='';
			if($_SESSION['estadoSession']=='28' || $_SESSION['estadoSession']=='29'){
			$sqlOcorAnalise=odbc_exec($conCab,"SELECT report.*,estado.sigla FROM report LEFT JOIN estado ON report.estado_id=estado.id WHERE protocolo='".$_SESSION['protocoloSession']."'");
			}else{
				$sqlOcorAnalise=odbc_exec($conCab,"SELECT report.*,estado.sigla FROM report LEFT JOIN estado ON report.estado_id=estado.id WHERE protocolo='".$_SESSION['protocoloSession']."' AND report.estado_id='".$_SESSION['estadoSession']."'");
				}
			while($objOcorAnalise=odbc_fetch_object($sqlOcorAnalise)){
				$uf='';
				$estrada='N/D';
				$km='';
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
			if(!empty($objOcorAnalise->estrada_br)){
					$estrada=str_pad($objOcorAnalise->estrada_br, 3, "0", STR_PAD_LEFT);
					}				
				if(!empty($objOcorAnalise->sigla)){
					$uf="/".$objOcorAnalise->sigla;
					}
				if(!empty($objOcorAnalise->br_km)){
					$km="<br>".$objOcorAnalise->br_km;
					}
				$foto='';
				$statusOc="<font color='green'>Válido</font><br>";
				$opcaoInv="I";
				$iconeInv="<img src='imagens/invalida.png' alt='Marcar como inválida' title='Marcar como inválida' width='30px' height='30px'/>";
				if($objOcorAnalise->invalido=='1'){
					$statusOc="<font color='red'>Inválido</font><br>";
					$opcaoInv="V";
					$iconeInv="<img src='imagens/valida.png' alt='Marcar como válida' title='Marcar como válida' width='30px' height='30px'/>";
					}
				if(!empty($objOcorAnalise->photo)){
							$foto="<a class='iframe' href='foto.php?end=".$objOcorAnalise->photo."'><img src='imagens/cam.png' width='25px' height='25px'/></a>";
							}
			echo "<tr align='center'><td>".$estrada.$uf.$km."<br><a href='dadosManuais.php?id=".$objOcorAnalise->id."'><input type='button' name='bruf' value='Informar Manualmente'/></a></td><td align='center'>".$latLong."</td><td>".utf8_encode($ocorrenciasDesc)."</td><td>".utf8_encode($objOcorAnalise->messages)."</td><td>".$foto."</td><td>".$dtCriac."</td><td><strong>".$statusOc."</strong>
			<a href='atualizaOcorr.php?id=".$objOcorAnalise->id."&acao=".$opcaoInv."'>".$iconeInv."</a><a href='atualizaOcorr.php?id=".$objOcorAnalise->id."&acao=R'><img src='imagens/remove.png' width='30px' height='30px' alt='Remover deste protocolo' title='Remover deste protocolo'/></a>
			</td></tr>";
			}
            ?>
			</tbody>
            </table>
           </td></tr>
           <tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Atualizar Análise</font></th></tr>
            <tr align="left">
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Alterar Status:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong>
			<select name="status">
            <option value="" selected="selected">Selecione o Novo Status</option>
			<?php 
			$sqlStatusProtocolos=odbc_exec($conCab,"SELECT id,descricao FROM tipostatus ORDER BY id");
			while($objStatusProtocolos=odbc_fetch_object($sqlStatusProtocolos)){
				if($objStatusProtocolos->id=='7'){
					if($_SESSION['perfilSession']=='adm' || $_SESSION['estadoSession']=='SD'){			
				echo "<option value='".$objStatusProtocolos->id."'>".utf8_encode($objStatusProtocolos->descricao)."</option>";
					}
				  }else{
					 echo "<option value='".$objStatusProtocolos->id."'>".utf8_encode($objStatusProtocolos->descricao)."</option>"; 
					  }
				}
			?>
            </select>
            </strong></td>
            <th width="15%" height="33" bgcolor="#DCDBDB"><font size="+1" color="#000066">Direcionar Para:</font></th>
            <td bgcolor="#FFFFFF" width="35%"><strong><select name="novoanalista">
            <option value="" selected="selected">Selecione novo analista</option>
			<?php 
			$sqlStatusProtocolos=odbc_exec($conCab,"SELECT id_login,nome FROM login ORDER BY nome");
			while($objStatusProtocolos=odbc_fetch_object($sqlStatusProtocolos)){
				echo "<option value='".$objStatusProtocolos->id_login."'>".utf8_encode($objStatusProtocolos->nome)."</option>";
				}
			?>
            </select></strong>
            </td></tr>
            <?php 
			if($_SESSION['perfilSession']=='adm' || $_SESSION['estadoSession']=='SD' ){
			?>  
            <tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Mensagem para Usuário:</font></th></tr>
            <tr align="center"><td colspan="4" width="15%" height="33" bgcolor="#DCDBDB">
            <a href="#" onclick="window.open('faq.php?id=<?php echo $_SESSION['protocoloSession'];?>', 'FAQ DNIT Móvel', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=870, HEIGHT=700');"><strong>BUSCAR RESPOSTA</strong></a></td></tr>
            <tr align="left"><td colspan="4" width="15%" height="33" bgcolor="#FFFFFF">
            <textarea name="mensagem" id="mensagem" cols="120" rows="15" alt="Preencha esse campo para enviar mensagem ao usuário!" title="Preencha esse campo para enviar mensagem ao usuário!"><?php echo $_SESSION['mensagemSession']; ?></textarea></td></tr>
            <?php 
			}else{
				echo "<input type='hidden' name='mensagem' value=''/>";
				}
			?>
            <tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Mensagem de Acompanhamento:</font></th></tr>
            <tr align="left"><td colspan="4" width="15%" height="33" bgcolor="#FFFFFF">
            <textarea name="mensagemAc" id="mensagemAc" cols="120" rows="15" alt="Preencha esse campo para registrar informação adicional! Essa mensagem não irá para o usuário!" title="Preencha esse campo para registrar informação adicional! Essa mensagem não irá para o usuário!" onkeyup="limitaCaractere('mensagemAc',4000,'exibeLimite');"><?php echo $_SESSION['mensagemAcSession']; ?></textarea>
            <div align="center"><strong><span id="exibeLimite"></span></strong></div>
</td></tr>
            <tr align="left"><td height="33" colspan="2"><a href="principal.php"><input type="button" name="voltar" value='<<Voltar'/></a></td><td align="right" colspan="2"><input class="botao" type="submit" name="atualiza" value='Atualizar'/></td></tr>
		    </tbody>
            </table>
            </form>
            
<table width="100%" cellpadding='0' cellspacing='0' border='1' name='tabelacadastro'>
<tr align="left"><th colspan="4" width="15%" height="33" bgcolor="#DCDBDB"><font color="#000066" size="+1">Acompanhamentos:</font></th></tr>
<tr><th bgcolor="#DCDBDB" width="15%"><font color="#000066">Data</font></th><th bgcolor="#DCDBDB" width="20%"><font color="#000066">Analista</font></th><th bgcolor="#DCDBDB" width="50%"><font color="#000066">Andamento</font></th><th bgcolor="#DCDBDB" width="15%"><font color="#000066">Mensagem</font></th></tr>
<?php 
$sqlAcompanhamentos=odbc_exec($conCab,"SELECT acompanhamento.id AS idacomp,acompanhamento.dt_criacao,acompanhamento.andamento,acompanhamento.mensagem,login.nome FROM acompanhamento LEFT JOIN login ON acompanhamento.analista_id=login.id_login WHERE acompanhamento.protocolo_id='".$_SESSION['protocoloSession']."'");
while($objAcompanhamentos=odbc_fetch_object($sqlAcompanhamentos)){
	$mensagem='-';
	if(!empty($objAcompanhamentos->mensagem)){
	$mensagem="<a class='iframe2' href='mensagem.php?msg=".$objAcompanhamentos->mensagem."'><input type='button' name='mensagem' value='Mensagem'/></a>";
	}
	echo "<tr bgcolor='#FFFFFF'><td>".$objAcompanhamentos->dt_criacao."</td><td><font size='-1'>".utf8_encode($objAcompanhamentos->nome)."</font></td><td><font size='-1'>".utf8_encode($objAcompanhamentos->andamento)."</font></td><td>".utf8_encode($mensagem)."</td></tr>";
	}
?>
</table>
            </td></tr></table>
</td></tr>
<tr>
<td colspan="3" align="left" height="150px" style="background:url(imagens/rodapecentro.png) no-repeat">
</td></tr>
</table>
</td><td></td></tr>

</table>
<?php
			}else{
				echo "<script>alert('".$mensagemErro."<br>Tente Novamente.');top.location.href='principal.php';</script>";
				}
	}
?>
</body>
</html>