<?php 
if(!isset($_SESSION)){
session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
<link rel="stylesheet" href="../../../jqueryDown/jquery-ui.css" />
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../../../jqueryDown/jquery-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-ui.css" /> 
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
    $( "#combobox" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
  </script>
<script language="Javascript">
function showDiv(div)
{
document.getElementById('nacional').style.display="none"
document.getElementById('internacional').style.display="none"

document.getElementById(div).style.visibility="visible"
}
</script>
<style>
.invisivel { display: none; }
.visivel { visibility: visible; }
</style>
<script>
  $(function() {
	  $( "#dtinicio" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#dtfim" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#cidade").autocomplete("suggest_trechos.php", {
		  width: 315,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>

</head>

<body>
<div id="box3">
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['idEv'])){
$idProj=$_POST['idproj'];
$id=$idProj;
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idEv=$_POST['idEv'];
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
$id=$idProj;
$idEv=$_SESSION['idEventoSession'];
	}
include "../projetos/detalhesProj.php";

echo "<br><h2>".$titMod."</h2><h3>Cadastro de Evento ".$titMod."</h3>";

$sqlDadosEv=mysql_query("SELECT conveventos.* FROM conveventos WHERE conveventos.id='".$idEv."'");
$arrayDadosEv=mysql_fetch_array($sqlDadosEv);
$nome=utf8_encode($arrayDadosEv['nome']);
$abrang=$arrayDadosEv['tipoloc'];
if($abrang=='nac'){
$uf=$arrayDadosEv['uf'];
$cidade=utf8_encode($arrayDadosEv['cidade']);
$sqlEstados=mysql_fetch_array(mysql_query("SELECT nome FROM estados WHERE uf='".$uf."'"));
$estado=$sqlEstados['nome'];
}else{
	$cidade=$arrayDadosEv['cidade'];
	$pais=$arrayDadosEv['pais'];
	}
$dtinicio=$arrayDadosEv['dtinicio'];
$dtfim=$arrayDadosEv['dtfim'];
$titButton='Atualizar';
echo "<form action='updateEvento.php' name='formProjConv' method='post'>";
echo "<input type='hidden' name='idproj' value='".$idProj."'/><input type='hidden' name='idevento' value='".$idEv."'/>

<input type='hidden' name='tipoId' value='".$tipoId."'/><div id='tabela'>";
include "../eventos/cadastraNovoEvento.php";

echo "</div></form>";
?>
<a href="listaEventos.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>