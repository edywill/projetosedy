<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$abrangencia=$_SESSION['abrangenciaSav'];
if($_SESSION['passagemSav']=='sim'){
		?>
	<div class="conteudo">
    
    	<form name="passagem" id="passagem" action="inserePassagem.php" method="post" onsubmit="setarCampos(this); enviarForm('inserePassagem.php', campos, 'divResultado'); return false;"> 
        
<h2 id="h2">INSERIR PASSAGEM AÉREA <?php echo strtoupper($abrangencia); ?></h2>

<?php 
if($_SESSION['idaeVoltaSav']==1){
	echo '<input type="checkbox" name="idaevolta" id="idaevolta" value="1"/>';
	}else{
		echo '<input type="checkbox" name="idaevolta" id="idaevolta" value="1" checked="checked" />';
		}
?>
<font size="-1">Ida e Volta</font><br />
<?php 
if($_SESSION['cadeiranteSav']==1){
	echo '<input type="checkbox" name="cadeirante" id="cadeirante" value="1"  checked="checked" />';
	}else{
		echo '<input type="checkbox" name="cadeirante" id="cadeirante" value="1"/>';
		}
?><font size="-1">Cadeirante?</font><br />

<table border="0" width="100%">
<tr><td width="50%">
<strong>Datas</strong>
<br />
<br />
<table border="0" width="100%">
<tr height='34'><td>
<strong>Ida:</strong></td><td><input type="text" class="input" name="dtida" id="dtida" size="20" readonly value='<?php echo $_SESSION['dtidaSav2']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr height='34'><td>
<div id='retorno'><strong>Volta:</strong></div></td><td><div id='retorno3'><input type="text" class="input" name="dtvolta" id="dtvolta" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav2']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></div>
</td></tr>
</table>

</td><td width="50%">
<strong>Trecho</strong>
<?php
echo $abrangencia;
?>
<br><br>
<table border="0" width="100%">
<?php 
if($_SESSION['abrangenciaSav']=='Internacional'){
echo "<tr height='34'><td><strong>Cidade Origem:</strong></td><td> <input type='text' class='input' name='cidorigem' id='cidorigem' size='40' onBlur='carregaVolta()' value='".utf8_encode($_SESSION['cidorigemPasSav'])."'/></td></tr>
<tr height='34'><td>
<strong>País </strong>"; 
}else{
	echo "<tr height='34'><td><input type='hidden' class='input' name='cidorigem' id='cidorigem' size='40' onBlur='carregaVolta()'/>";
	}
?><strong>Origem:</strong></td><td> <input type="text" class="input" name="origemida" id="origemida" size="40" value='<?php echo $_SESSION['origemidaSav2']; ?>' style="background: url(css/icone_lupa.png) no-repeat right;"/>
</td></tr>
<?php 
if($_SESSION['abrangenciaSav']=='Internacional'){

echo "<tr height='34'><td><strong>Cidade Destino:</strong></td><td> <input type='text' class='input' name='ciddestino' id='ciddestino' size='40' onBlur='carregaVolta()' value='".$_SESSION['ciddestinoPasSav']."'/></td></tr>
<tr height='34'><td>
<strong>País</strong> "; 
}else{
	echo "<tr height='34'><td><input type='hidden' class='input' name='ciddestino' id='ciddestino' size='40' onBlur='carregaVolta()'/>";
	}
?><strong>Destino:</strong></td><td> <input type="text" class="input" name="destinoida" id="destinoida" size="40" value='<?php echo $_SESSION['destinoidaSav2']; ?>' style="background: url(css/icone_lupa.png) no-repeat right;"/></td></tr>
</table>
</td></tr><tr><td>
<strong>Horário</strong><br /><br />
<table border="0" width="100%"><tr><td><strong>Ida:</strong></td><td>
<select name="horarioIda" id='horarioIda'>
<?php 
if(empty($_SESSION['horarioidaSav2']) || $_SESSION['horarioidaSav2']=='0'){
   echo "<option value='0' selected='selected'>Selecione</option>"; 
	echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
}else{
	if($_SESSION['horarioidaSav2']=='manha'){
		echo '<option value="manha" selected="selected">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
		}elseif($_SESSION['horarioidaSav2']=='tarde'){
			echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde" selected="selected">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
			}elseif($_SESSION['horarioidaSav2']=='noite'){
				echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite" selected="selected">Noite (18h01->3h)</option>';
				}
	}
?>
</select>
</td></tr>

<tr><td><div id='retorno2'><strong>Volta:</strong></div></td><td><div id='retorno4'>
<select name="horarioVolta" id='horarioVolta'>
<?php 
if(empty($_SESSION['horariovoltaSav2']) || $_SESSION['horariovoltaSav2']=='0'){
   echo "<option value='0' selected='selected'>Selecione</option>";
   echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
}else{
	if($_SESSION['horariovoltaSav2']=='manha'){
		echo '<option value="manha" selected="selected">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
		}elseif($_SESSION['horariovoltaSav2']=='tarde'){
			echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde" selected="selected">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h)</option>';
			}elseif($_SESSION['horariovoltaSav2']=='noite'){
				echo '<option value="manha">Manhã (6h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite" selected="selected">Noite (18h01->3h)</option>';
				}
	}
?>
</select></div>
</td></tr>

</table>
</td><td valign="middle">
<strong>Valor:</strong> R$ <input type="text" name="valorpass" id="valorpass" class="input" value='<?php echo $_SESSION['valorPasSav']; ?>'/>
</td></tr>
<tr><td colspan="4" align="right"> <input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
</table>
  </form>
  <br /><br />
  <script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {
	campos = "origemida="+encodeURI(document.getElementById('origemida').value)+"&destinoida="+encodeURI(document.getElementById('destinoida').value)+"&horarioIda="+encodeURI(document.getElementById('horarioIda').value)+"&horarioVolta="+encodeURI(document.getElementById('horarioVolta').value)+"&dtida="+encodeURI(document.getElementById('dtida').value)+"&dtvolta="+encodeURI(document.getElementById('dtvolta').value)+"&valorpass="+encodeURI(document.getElementById('valorpass').value)+"&cadeirante2="+encodeURI(document.getElementById('cadeirante').value)+"&idaevolta="+encodeURI(document.getElementById('idaevolta').value)+"&cidorigem="+encodeURI(document.getElementById('cidorigem').value)+"&ciddestino="+encodeURI(document.getElementById('ciddestino').value);

}

</script>
    </div>
    <?php
		}
	if(trim($_SESSION['diariaSav'])=='sim'){
		?>
    <div class="conteudo">
		<form action="insereHospedagem.php" name="hospedagem" method="post">
        <table border="1" width="100%">
<tr><th colspan="4">INSERIR HOSPEDAGEM</th></tr>
<tr>
<th width="15%">Datas:</th>
<td width="35%">
<br />Entrada:<input type="text" class="input" name="dtida" id="dtida2" size="20" readonly value='<?php echo $_SESSION['dtidaSav3']; ?>'/>
<div id='retorno'>
Saída:<input type="text" class="input" name="dtvolta" id="dtvolta2" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav3']; ?>'/>
</div>
</td><th width="15%">Localidade<br />
<?php
echo $abrangencia;
?></th><td width="35%"><?php
if($abrangencia=='Nacional'){
	echo "Cidade";
	}else{
		echo "Cidade: <input type='text' class='input' name='cidhos' id='cidhos' size='30' onBlur='carregaVolta()' value='".$_SESSION['cidHosSav']."'/><br>País";
		}
?>: <input type="text" class="input" name="destinoida2" id="destinoida2" size="30" value='<?php echo utf8_encode($_SESSION['destinoidaSav3']); ?>'/></td></tr>
<tr><th width="15%">Tipo Quarto:</th>
<td width="35%" colspan="3">
<select name="tipoQuarto">
<option selected="selected" value="Duplo">Duplo</option>
<option value="Single">Single</option>
</select>
</td></tr>
<tr><td colspan="4" align="right"><input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
  </table>
  </form>
  <br /><br />
    </div>
    <?php
		}
if($_SESSION['transladoSav']=='sim'){
		?>
    <div class="conteudo">
		<form action="insereTranslado.php" name="passagem" method="post">
        <table border="1" width="100%">
<tr><th colspan="4">INSERIR LOCAÇÃO DE VEÍCULO</th></tr>
<tr>
<th width="15%">Datas:</th>
<td width="35%">
<br />Início:<input type="text" class="input" name="dtida" id="dtida4" size="20" readonly value='<?php echo $_SESSION['dtidaSav4']; ?>'/>
Fim:<input type="text" class="input" name="dtvolta" id="dtvolta4" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav4']; ?>'/>
</td><th width="15%">Valor:</th><td width="35%">R$ <input type="text" name="valorpass" id="valorpass4" class="input" value='<?php echo $_SESSION['valorTransSav']; ?>'/></td></tr>
<tr><td colspan="4" align="right"><input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
  </table>
  </form>
  <br /><br />
		</div>
        <?php
		}
?>