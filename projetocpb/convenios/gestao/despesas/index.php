<?php 
if(!isset($_SESSION)){
session_start();
$_SESSION['idEvento']='';
}else{
	$_SESSION['idEvento']='';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript" src="../../../ajax/funcs.js"></script>
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" />
<script type='text/javascript' src='../../../jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../../../jquery.autocomplete.css" />
<link rel="stylesheet" href="../../../jqueryDown/combo/jquery-ui.theme.min.css">
  <script src="../../../jqueryDown/combo/jquery-1.10.2.js"></script>
  <script src="../../../jqueryDown/combo/jquery-ui.js"></script>
  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>
  <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Todos" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "Buscar", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " invalido" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#comboboxEvento" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#comboboxEvento" ).toggle();
		});
    });
    </script>
<script type="text/javascript"> 
function carregaEvento() {
	// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
valor=document.getElementById('comboboxEvento').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "guardaEvento.php?valor="+valor;
// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {
// Resposta retornada pelo busca.php
}
}
req.send(null);

	
}
</script>
</head>
<body>
<div id='box3'><br/>
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['tipoId'])){
$tipoId=$_POST['tipoId'];
$id=$_POST['id'];
$titMod=$_POST['titMod'];
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
	}
include "../projetos/detalhesProj.php";
echo "<br><h2>".$titMod."</h2><h3>Proje&ccedil;&otilde;es ".$titMod."</h3>";
echo "<table border='0'><tr><td>
Evento: 
<div class='ui-widget'>
<select name='evento' id='comboboxEvento'>
<option value='0' selected>Selecione</option>";
$sqlEventos=mysql_query("select id,nome
from conveventos 
where modal='".$tipoId."' ORDER BY nome");
while($objEventos=mysql_fetch_object($sqlEventos)){
	echo "<option value='".$objEventos->id."'>".utf8_encode($objEventos->nome)."</option>";
	}
echo "</select></div></td></tr></table>
";
include "../botoesTipo.php";

?>
<a href="../modalidades/index.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>