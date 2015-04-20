<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta interativa sem refresh com AJAX</title>
<script type="text/javascript">

var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscar_o_que_procura(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consultaCodigoMat.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Exibe a mensagem "Buscando usuario..." enquanto carrega

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('cdMaterialCodigo').value = resposta;

}
}
req.send(null);
}
</script>
</head>

<body>
<h1>Consulta sem refresh da pagina com AJAX</h1>
<br/>
detalhes do usuario:<input type="text" id="busca" onblur="buscarCodigos(this.value)" />
<input type="text" id="cdMaterialCodigo"/>

<br>
<p> Resultado encontrado: </p>
<form>
<tr>

<td>
<div id="resultado" align="left"> </div></td>

</tr>

</form>


</body>
</html>