<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
<script type="text/javascript" src="../../../../ajax/funcs.js"></script>
<script src="../../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../../jqueryDown/jquery-1.9.0-ui.css" />
<script type='text/javascript' src='../../../../jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../../../../jquery.autocomplete.css" />
<link rel="stylesheet" href="../../../../jqueryDown/combo/jquery-ui.theme.min.css">
  <script src="../../../../jqueryDown/combo/jquery-1.10.2.js"></script>
  <script src="../../../../jqueryDown/combo/jquery-ui.js"></script>
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
    $( "#comboboxCidade" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#comboboxCidade" ).toggle();
    	});
    });
  </script>
<script type="text/javascript">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}

var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorHos() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
valor=document.getElementById('cidade').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consValorHos.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {
// Resposta retornada pelo busca.php
var resposta = req.responseText;
var myarr = resposta.split(":");
var myarrs=myarr[0].split("-");
var myarrd=myarr[1].split("-");
// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
//document.getElementById('resultado').innerHTML = resposta;
if(myarrs[1]=="int" || myarrd[1]=="int"){
document.getElementById('abrg').innerHTML="Internacional";
}else if(myarrs[1]=="nac" || myarrd[1]=="nac"){
	document.getElementById('abrg').innerHTML="Nacional";
	}else{
		document.getElementById('abrg').innerHTML="Local Inexistente";
		}
document.getElementById('idrefs').value= myarrs[2];
document.getElementById('idrefd').value= myarrd[2];

document.getElementById('vlunits').value= float2moeda(moeda2float(myarrs[0]));
document.getElementById('vlunitd').value= float2moeda(moeda2float(myarrd[0]));

document.getElementById('total').value= float2moeda(moeda2float(myarrs[0])*moeda2float(document.getElementById('qtdSingle').value)*moeda2float(document.getElementById('qtdDias').value)+moeda2float(myarrd[0])*moeda2float(document.getElementById('qtdDuplo').value)*moeda2float(document.getElementById('qtdDias').value));
}
}
req.send(null);
}

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorHosV(){
// Verificando Browser
if(window.XMLHttpRequest) {
reqv = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
reqv = new ActiveXObject("Microsoft.XMLHTTP");
}
valorv=document.getElementById('cidade').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var urlv = "consValorHos.php?valor="+valorv;

// Chamada do método open para processar a requisição
reqv.open("Get", urlv, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
reqv.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(reqv.readyState == 4 && reqv.status == 200) {
// Resposta retornada pelo busca.php
var respostav = reqv.responseText;
var myarrv = respostav.split(":");
var myarrsv=myarrv[0].split("-");
var myarrdv=myarrv[1].split("-");
// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
//document.getElementById('resultado').innerHTML = resposta;
if(myarrsv[1]=="int" || myarrdv[1]=="int"){
document.getElementById('abrg').innerHTML="Internacional";
}else if(myarrsv[1]=="nac" || myarrdv[1]=="nac"){
	document.getElementById('abrg').innerHTML="Nacional";
	}else{
		document.getElementById('abrg').innerHTML="Local Inexistente";
		}
document.getElementById('idrefs').value= myarrsv[2];
document.getElementById('idrefd').value= myarrdv[2];

document.getElementById('vlunits').value= float2moeda(moeda2float(myarrsv[0]));
document.getElementById('vlunitd').value= float2moeda(moeda2float(myarrdv[0]));

document.getElementById('total').value= float2moeda(moeda2float(myarrsv[0])*moeda2float(document.getElementById('qtdSingle').value)*moeda2float(document.getElementById('qtdDias').value)+moeda2float(myarrdv[0])*moeda2float(document.getElementById('qtdDuplo').value)*moeda2float(document.getElementById('qtdDias').value));
}
}
reqv.send(null);
}
// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorPasT() {
document.getElementById('total').value=float2moeda(moeda2float(document.getElementById('vlunits').value)*moeda2float(document.getElementById('qtdSingle').value)*moeda2float(document.getElementById('qtdDias').value)+moeda2float(document.getElementById('vlunitd').value)*moeda2float(document.getElementById('qtdDuplo').value)*moeda2float(document.getElementById('qtdDias').value));
}
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
  <script type='text/javascript' src='../../../../jquery_price.js'></script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#vlunits').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#vlunitd').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#total').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
<script type="text/javascript">
 function somenteNumeros (num) {
		var er = /[^0-9.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>
</head>

<body>
<div id="box3">
<?php 
require "../../../common/tagsConv.php";
require "../../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['id'])){
$idProj=$_POST['id'];
$id=$idProj;
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idEvento=$_POST['idEvento'];
$idItem=$_POST['idHos'];
$_SESSION['idItemSession']=$idItem;
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
$id=$idProj;
$idEvento=$_SESSION['idEventoSession'];
$idItem=$_SESSION['idItemSession'];
	}
include "../../projetos/detalhesProj.php";
echo "<br><h2>".$titMod."</h2>";
include "../../eventos/detalhesEventos.php";
echo "<h3>Atualizar Solicitação</h3>";
$sqlDadosHos=mysql_query("SELECT convhos.* FROM convhos WHERE convhos.id='".$idItem."'") or die(mysql_error());
$arrayDadosHos=mysql_fetch_array($sqlDadosHos);
$local=$arrayDadosHos['local'];
$abrg='';
$cidadeHos='';
if($arrayDadosHos['abrg']=='nac'){
	$abrg='Nacional';
	$cidadeHos=utf8_encode($arrayDadosHos['local']);
	}elseif($arrayDadosHos['abrg']=='inter'){
		$abrg='Internacional';
		$cidadeHos=utf8_encode($arrayDadosHos['local']);
		}else{
			$abrg='Local Inexistente';
			}
$dtfim=$arrayDadosHos['dtfim'];
$dtinicio=$arrayDadosHos['dtin'];
$qtdDias=$arrayDadosHos['qtddias'];
$qtdPes=$arrayDadosHos['qtdpes'];;
$qtdDuplo=$arrayDadosHos['qtdduplo'];
$qtdSingle=$arrayDadosHos['qtdsingle'];
$vlunits='0,00';
$vlunitd='0,00';
$total=$arrayDadosHos['total'];
$cidade=utf8_encode($local);
$titButton='Atualizar';
echo "<form action='updateHos.php' name='formProjConv' method='post'>";
echo "<input type='hidden' name='idproj' value='".$idProj."'/>
<input type='hidden' name='idHos' value='".$idItem."'/>
<input type='hidden' name='tipoId' value='".$tipoId."'/>
<input type='hidden' name='idEvento' value='".$idEvento."'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<div id='tabela'>";
include "cadastraNovoHos.php";
echo "</div></form>";
?>
<a href="../projec.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>