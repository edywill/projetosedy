<html>

<head>

<title>Enviando formulário POST com PHP e AJAX</title>
<link id="ui-theme" rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.0/themes/ui-lightness/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="http://pontikis.github.com/jui_alert/v2.0.0/jquery.jui_alert.css"/>
<!-- custom classes -->
<!-- Carrega o arquivo 'script.js' ao iniciar a página! //-->
<style>
.container1 {
  width: 40%;
  margin: 20px;
}
 
.container2 {
  width: 50%;
  margin: 20px;
}
 
.container3 {
  width: 60%;
  margin: 20px;
}
 
.message2 {
  font-size: 13px;
  font-family: Arial, sans-serif;
  letter-spacing: 1px;
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://pontikis.github.com/jui_alert/v2.0.0/jquery.jui_alert.min.js"></script>
<script type="text/javascript" src="http://pontikis.github.com/jui_alert/v2.0.0/i18n/en.js"></script>
<script language="javascript" src="script.js" type="text/javascript"></script>

</head>

<body>

<table cellpadding="2" cellspacing="0" width="50%">
<form action="processar.php" method="post" onsubmit="setarCampos(this); enviarForm('processar.php', campos, 'divResultado'); return false;"> 

<tr><td>Nome</td><td><input name="txtNome" id="txtNome" type="text"></td></tr>

<tr><td>Email</td><td><input name="txtEmail" id="txtEmail" type="text"></td></tr>

<tr><td></td><td><input type="submit" value="Enviar">&nbsp;<input type="reset" value="Limpar"></td></tr>

</form>

</table>
<div id="divResultado">

</div>
<script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {

campos = "txtNome="+encodeURI(document.getElementById('txtNome').value).
toUpperCase()+"&txtEmail="+encodeURI(document.getElementById('txtEmail').value);

}

</script>

</body>
</htm>
