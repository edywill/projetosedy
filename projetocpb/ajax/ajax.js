// JavaScript Document
function getXmlHttp() {
    var xmlhttp;
    try {
        xmlhttp = new XMLHttpRequest();
    } catch (ee) {
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }
    }
    return xmlhttp;
}
var request = getXmlHttp();

function cadastra() {
    var mt = document.getElementById('matricula').value;
    //var md = document.getElementById('modalidade').value;
	var tm = document.getElementById('turma').value;
    var url = "cadastra.php?matricula=" + mt + "&turma=" + tm;
    request.open('GET', url, true);
    request.setRequestHeader("Content-Type",
            "application/x-www-form-urlencoded");
    document.forms[0].reset();
    request.send(null);
    request.onreadystatechange = statusAlterado;
}

function apagar(id, rowIndex) {
    if (confirm('Tem certeza que deseja excluir este registro?')) {
        document.getElementById("tabela").deleteRow(rowIndex);
        request.open("POST", 'apagar.php?Deletar=Ok&id=' + id, false);
        request.send(null);
    }
}

function statusAlterado() {
    if (request.readyState == 4) {
        document.getElementById("resultados").innerHTML = request.responseText;
    }
}