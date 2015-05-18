<?php 
session_start();
require "../../conexaomysql.php";
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela4').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 0, "desc" ]]
	});
});
</script>
<script type="text/javascript">
function  reescreveTabelas(valor){
// Verificando Browser
document.getElementById('usuarios').innerHTML="<br>Aguarde, carregando dados...<img src='../../imagens/loading.gif'/>";
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php?idgeren="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('usuarios').innerHTML=resposta;
}
}
req.send(null);
	}

</script>

</head>       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h3>AUTORIZACÕES</h3>   

<h4>Criação de Autorização Por Gerencial</h4> 
Selecione o Gerencial:
<select name="geren" id="geren" onchange="reescreveTabelas(this.value)">
<option selected="selected" value="0">Selecione</option>
<?php 
require "../../conectsqlserverci.php";
$sqlGerencial=odbc_exec($conCab,"select cg.Pcc_classific_c, cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)");
while($objGerencial=odbc_fetch_object($sqlGerencial)){
	echo "<option value='".$objGerencial->Pcc_classific_c."'>".$objGerencial->Pcc_classific_c."-".utf8_encode($objGerencial->Pcc_nome_conta)."</option>";
	}
?>
</select>
<div id="usuarios">
<h3>Relação de Autorizações em Lote</h3>
<table id="tabela4" width="100%"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'><strong>Aut.</strong></th>
					<th width='55%'><strong>Gerencial</strong></th>
                    <th width='10%'><strong>Qtd.<br /> Benef.</strong></th>
					<th width='15%'><strong>Ação</strong></th>
				</tr>				
			</thead>
            <tbody>
<?php 
$sqlRegistros=mysql_query("SELECT autorizacao,ano,gerencial FROM registros WHERE gerencial<>'' GROUP BY autorizacao,ano,gerencial") or die(mysql_error());
while($objRegistros=mysql_fetch_object($sqlRegistros)){
		$nomeGerencial=odbc_fetch_array(odbc_exec($conCab,"select cg.Pcc_classific_c, cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
AND cg.Pcc_classific_c='".$objRegistros->gerencial."'"));
	$sqlQtdRegistros=mysql_num_rows(mysql_query("SELECT idben FROM registros WHERE gerencial='".$objRegistros->gerencial."' AND autorizacao='".$objRegistros->autorizacao."' AND ano='".$objRegistros->ano."' GROUP BY idben"));
	$numBenef=$sqlQtdRegistros;
	$descGerencial=utf8_encode($nomeGerencial['Pcc_nome_conta']);
	$editar="<form action='autEmLote.php' method='post' name='editar'><input type='hidden' name='tp' value='edit'/><input type='hidden' name='id' value='".$objRegistros->autorizacao."/".$objRegistros->ano."'/><input type='hidden' name='geren' value='".$objRegistros->gerencial."'/><input type=image src='../../sav/css/iconeEditar.png' alt='Editar' title='Editar'/></form>";
	
echo "<tr><td align='center'><strong>".$objRegistros->autorizacao."/".$objRegistros->ano."</strong></td><td>".$objRegistros->gerencial."-".$descGerencial."</td><td align='center'>".$numBenef."</td><td align='center'>".$editar."</td></tr>";
}
?>        </tbody>
            </table>
</div>
</div>
</body>
</html>