<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
	$userCriac=$_SESSION['userAquis'];
	unset($_SESSION['idatumat']);
	$countError=0;
	$errorMsg='';
	$valida=0;
	if(!empty($_POST['criar'])){
		$_SESSION['grupoComp']='';
		$_SESSION['grupoCompDesc']='';
		$empresaPost=$_POST['empresa'];
		$sqlNomeEmpresa=odbc_fetch_array(odbc_exec($conCab,"SELECT Nome_completo FROM GEEMPRES where Cd_empresa='".$empresaPost."'"));
		$empresa=$empresaPost."-".utf8_encode($sqlNomeEmpresa['Nome_completo']);
		$_SESSION['empresaAquis']=$empresa;
		$proc=$_POST['proc'];
		$_SESSION['procAquis']=$proc;
		$dtinicio=$_POST['datainicial'];
		$_SESSION['dtinicioAquis']=$dtinicio;
		$dtfim=$_POST['datafinal'];
		$_SESSION['dtfimAquis']=$dtfim;		
		$_SESSION['materialComp']='';
		$_SESSION['materialCompDesc']='';
		$_SESSION['qtdMat']='';
		$_SESSION['vlunitMat']='';
		$arrayEmpresa=explode("-",$empresa);
			$idEmpresa=$arrayEmpresa[0];
			$arrayProc=explode("-",$proc);
			$idProc=$arrayProc[0];
		if(empty($idEmpresa)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe a empresa.\\n';
	}else{
		$sqlEmpresa=odbc_num_rows(odbc_exec($conCab,"SELECT Cd_empresa FROM GEEMPRES (nolock) WHERE Cd_empresa='".trim($idEmpresa)."'"));
		if($sqlEmpresa<1){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Empresa inexistente.\\n';
			}
		if(!empty($idProc)){
			$sqlProc=odbc_num_rows(odbc_exec($conCab,"SELECT projeto FROM GMPROCDOC (nolock) WHERE projeto='".trim($idProc)."'"));
		  if($sqlProc<1){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: O processo informado inexistente.\\n';
			  }
			}
		if(!empty($dtinicio)){
			if(!empty($dtfim)){
				if($dtinicio>$dtfim){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data inicial deve ser inferior a final.\\n';
					}
				}else{
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Ao informar a data inicial é necessário informar a final.\\n';
					}
			
			}elseif(!empty($dtfim)){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Ao informar a data final é necessário informar a inicial.\\n';
					
						}
		}
	if(empty($_POST['idregedit'])){
		if(empty($_SESSION['idRegAqui'])){
$consultaIdEmpresaDup=mysql_fetch_array(mysql_query("SELECT id FROM aquireg WHERE proc='".$idProc."' AND cdempres='".$idEmpresa."'"));
if(!empty($consultaIdEmpresaDup)){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Registro ja cadastrado no sistema, utilize a opção EDITAR.\\n';
	}
		}
if($valida==0 && empty($_SESSION['idRegAqui'])){
	$insertSrp=mysql_query("INSERT INTO aquireg (proc,cdempres,dtinicio,dtfim) VALUES ('".$idProc."','".$idEmpresa."','".$dtinicio."','".$dtfim."')") or die(mysql_error());
	if($insertSrp){
		$sqlIdEmpresa=mysql_query("SELECT id FROM aquireg WHERE proc LIKE '".$idProc."' AND cdempres='".$idEmpresa."'") or die (mysql_error());
		$consultaIdEmpresa=mysql_fetch_array($sqlIdEmpresa);
		$_SESSION['idRegAqui']=$consultaIdEmpresa['id'];
		}else{
			        $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Problemas ao inserir o registro.\\n';
			}
	}
	}else{
		$updateSrp=mysql_query("UPDATE aquireg SET proc='".$idProc."',cdempres='".$idEmpresa."',dtinicio='".$dtinicio."',dtfim='".$dtfim."' where id='".$_POST['idregedit']."'") or die(mysql_error());
	if($updateSrp){
		$_SESSION['idRegAqui']=$_POST['idregedit'];
		}else{
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Problemas ao atualizar o registro.\\n';
			}
		}
		}elseif(!empty($_SESSION['idRegAqui'])){
			$empresa=$_SESSION['empresaAquis'];
			$proc=$_SESSION['procAquis'];
			$dtinicio=$_SESSION['dtinicioAquis'];
			$dtfim=$_SESSION['dtfimAquis'];
			$arrayEmpresa=explode("-",$empresa);
			$idEmpresa=$arrayEmpresa[0];
			$arrayProc=explode("-",$proc);
			$idProc=$arrayProc[0];
			}
			
			
if($valida==1)
{
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="novoSrp.php";
       </script>
       <?php
		}else{
$sqlMaterial=mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
$countMat=mysql_num_rows($sqlMaterial);
$idatl=0;
if(!empty($_POST['idatu'])){
	$idatl=$_POST['idatu'];
	$sqlRegAt=mysql_fetch_array(mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.id AS idgroup,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.id='".$idatl."'"));
	$_SESSION['materialComp']=$sqlRegAt['cdmat'];
	$_SESSION['materialCompDesc']=utf8_encode($sqlRegAt['nome']);
	$_SESSION['grupoComp']=$sqlRegAt['idgroup'];
	$_SESSION['grupoCompDesc']=$sqlRegAt['codigo']."-".utf8_encode($sqlRegAt['descricao']);
	$_SESSION['qtdMat']=$sqlRegAt['quant'];
	$_SESSION['vlunitMat']=$sqlRegAt['vlunit'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../../jqueryDown/jquery-ui.js"></script>
<script language="javascript" src="../materiais/script.js" type="text/javascript"></script>
<script src="../../sav/jquerymensagem/jquery_jui_alert.js">
</script>
<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/icon.css">
	<script type="text/javascript" src="../jqueryDown/easy/jquery.easyui.min.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
  
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("../../suggest_material.php", {
		  width: 352,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<style>
    .sel { width: 70px; }
    
</style>
<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*1.2;
	obj.width=obj.width*1.2;
}
 
function diminui(obj){
	obj.height=obj.height/1.2;
	obj.width=obj.width/1.2;
}
//-->
</script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
	  $('#qtd').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
    });
	 </script>
     <script type="text/javascript" language="javascript">
function CarregaMateriais(codGrupo)
{
	// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "carregaMaterial.php?grupo="+codGrupo;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;
document.getElementById('materialAjax').innerHTML=resposta;
}
}
req.send(null);
}
</script>
<script type="text/javascript">
function  reescreveTabelas(){
	req=0;
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php";

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('mensagens').innerHTML=resposta;
}
}
req.send(null);
	}

</script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Registro de Preço</h3>  
<br />
<div id='tabela'>
<table width="100%" border="0">
<tr><th width="30%">Processo</th><td><?php echo $proc; ?></td></tr>
<tr><th width="30%">Empresa</th><td><?php echo $empresa; ?></td></tr>
<tr><th width="30%">Vigência</th><td><?php echo $dtinicio; ?> à <?php echo $dtfim; ?></td></tr>
</table>
<br />
<div id="mensagens">
<?php 
if($countMat>0){
?>
<h4>ITENS CADASTRADOS</h4>
<table border="1" width="100%">
<tr>
<th>GR. DESPESA</th><th>MATERIAL</th><th>QUANTIDADE</th><th>VALOR UNITARIO(R$)</th><th>EDITAR</th><th>DELETAR</th></tr>
<?php 
while($objMat=mysql_fetch_object($sqlMaterial)){
	echo "<tr><td>".$objMat->codigo."<br>".utf8_encode($objMat->descricao)."</td><td>".utf8_encode($objMat->nome)."</td><td>".$objMat->quant."</td><td>R$ ".$objMat->vlunit."</td><td><form action='insereItensSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}
?>
</table>
<?php 
		}
?>
</div>
<div id="divResultado"></div>
<br>
<form action="insereNovoItemSrp.php" id='insere' name="insere" method="post" onSubmit="setarCampos(this); enviarForm('insereNovoItemSrp.php', campos, 'divResultado'); return false;">
<h4>CADASTRAR ITEM</h4>
<table border="0" width="50%"><tr>
<th width="30%">Gr. Despesa</th><td>
<select name="grupo" id="grupo" onchange="CarregaMateriais(this.value)">
<?php 
if(!empty($_SESSION['grupoComp'])){
	echo "<option selected='selected' value='".$_SESSION['grupoComp']."'>".$_SESSION['grupoCompDesc']."</option>";
	}else{
		echo "<option selected='selected' value='0'>Selecione</option>";
		}
$SQLGrupo=mysql_query("SELECT * FROM aquigrupo WHERE inativo=0");
while($objGrupo=mysql_fetch_object($SQLGrupo)){
	echo "<option value='".$objGrupo->id."'>".$objGrupo->codigo."-".utf8_encode($objGrupo->descricao)."</option>";	
	}
?>
</select>
</td></tr><tr>
<th width="30%">Material</th><td>
<input type="hidden" name="idatl" id='idatl' value="<?php echo $idatl; ?>" />
<div id="materialAjax">
      	<select name="material" id="material">
      		<?php if(empty($_SESSION['materialComp'])){
            echo '<option value="">Selecione o Material</option>';
			}else{
				echo '<option value="'.$_SESSION['materialComp'].'">'.$_SESSION['materialCompDesc'].'</option>';
				} ?>
    	</select>
    </div>
</td></tr>
<tr>
<th width="30%">Quantidade</th><td><input type="text" size="20" name="qtd" id='qtd' class="input" value='<?php echo $_SESSION['qtdMat']; ?>'></td>
</tr><tr>
<th width="30%">Valor Unitário</th><td><input type="text" size="20" name="vlunit" id='vlunit' class="input" value='<?php echo $_SESSION['vlunitMat']; ?>'></td>
</tr>
<tr><td width="30%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="<?php 
if($idatl==0){
	echo 'Incluir';
	}else{
		echo 'Atualizar';
		}
?>" /></td></tr>
</table>
</form>
<script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {
	campos = "idatl="+encodeURI(document.getElementById('idatl').value)+"&qtd="+encodeURI(document.getElementById('qtd').value)+"&material="+encodeURI(document.getElementById('material').value)+"&vlunit="+encodeURI(document.getElementById('vlunit').value);
}
</script>
</div>
</div>
</body>
</html>
<?php 
		}
?>