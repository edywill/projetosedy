<?php 
session_start();
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
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

</div>
</div>
</body>
</html>