<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$nomeCampo='';
$valida=0;
$countError=0;
$errorMsg='';
$_SESSION['provAtDescSession']='';
$_SESSION['provAtSession']='';
$_SESSION['projAtDescSession']='';
$_SESSION['projVlDescSession']='';
$_SESSION['provMaDescSession']='';
$_SESSION['provMaSession']='';
$_SESSION['anoMarcSession']='';
$_SESSION['marcaAtSession']='';
$_SESSION['posMarcSession']='';
if(empty($_SESSION['idAtletaSession']) && empty($_POST['atleta']) && empty($_POST['idAtleta']))
		{
					echo "teste";
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe o atleta.\\n';
		}else{
			    
				//Inserir
				if(!empty($_POST['atleta'])){
				$_SESSION['tipoAcao']='inserir';
				$_SESSION['classeSession']='';
				$_SESSION['idmodSession']=0;
				$_SESSION['descModSession']='Selecione';
				$_SESSION['categoriaSession']='';
				$_SESSION['bolsaSession']='';
				$_SESSION['dtatletaSession']='';
				$_SESSION['dtheroiSession']='';
				$_SESSION['primProvaSession']=0;
				$_SESSION['primProvaDescSession']='Selecione';
				$_SESSION['primProvaPosSession']='';
				$_SESSION['princProvaSession']=0;
				$_SESSION['princProvaDescSession']='Selecione';
				$_SESSION['mmarcprovaSession']=0;
				$_SESSION['mmarcprovaDescSession']='Selecione';
				$_SESSION['mmarcaPosSession']='';
				$_SESSION['mmarcaEventoSession']='';
				$_SESSION['atletaSession']=trim($_POST['atleta']);
				$_SESSION['patrocinioSession']=trim($_POST['patrocinio']);
				$sqlDadosReg=odbc_exec($conCab,"SELECT nome FROM atleta (nolock) WHERE upper(nome)=upper('".utf8_decode($_SESSION['atletaSession'])."')");
				$arrayDadosReg=odbc_num_rows($sqlDadosReg);
				if($arrayDadosReg>0){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Atleta encontra-se cadastrado.\\n';
					}else{
				$sqlIdAtleta=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM atleta (nolock)"));
				$idAtletaMax=$sqlIdAtleta['id']+1;
				$_SESSION['idAtletaSession']=$idAtletaMax;
				$sqlLigaIdAtleta=odbc_exec($conCab,"SET IDENTITY_INSERT atleta ON");
				$sqlInsertAtleta=odbc_exec($conCab,"INSERT INTO atleta(id,nome,patrocinio_id) VALUES (".$idAtletaMax.",'".utf8_decode($_SESSION['atletaSession'])."',".trim($_SESSION['patrocinioSession']).")");
                $sqlDesligaIdAtleta=odbc_exec($conCab,"SET IDENTITY_INSERT atleta OFF");
				
				$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
				$novoIdLog=$sqlConsIdLog['id']+1;
				$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
				$sqlInsertLog=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtletaMax.",'".utf8_decode($userCriac)."','".date("d/m/Y H:i:s")."','cadastro')");
				$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
				 
				 if(!$sqlInsertAtleta){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Erro ao cadastrar atleta. Tente Novamente.\\n';
					     }
					}
				}
				//Editar
				elseif(!empty($_POST['idAtleta'])){
				$_SESSION['tipoAcao']='editar';	
				$_SESSION['idAtletaSession']=$_POST['idAtleta'];
				$sqlDadosReg=odbc_exec($conCab,"SELECT atleta.*,
										 modalidade.id AS modid, 
										 modalidade.descricao AS moddesc,
										 patrocinio.patrocinio
										 FROM atleta (nolock) LEFT JOIN modalidade  (nolock) ON 
										 modalidade.id=atleta.id_modal
										 LEFT JOIN patrocinio (nolock) ON atleta.patrocinio_id=patrocinio.id
										 WHERE atleta.id='".$_SESSION['idAtletaSession']."'");
				$arrayDadosReg=odbc_fetch_array($sqlDadosReg);
				$_SESSION['atletaSession']=utf8_encode($arrayDadosReg['nome']);
				$_SESSION['patrocinioSession']=utf8_encode($arrayDadosReg['patrocinio']);
				$_SESSION['classeSession']=utf8_encode($arrayDadosReg['classe']);
				$_SESSION['idmodSession']=$arrayDadosReg['modid'];
				$_SESSION['descModSession']=utf8_encode($arrayDadosReg['moddesc']);
				$_SESSION['categoriaSession']=utf8_encode($arrayDadosReg['categoria']);
				$_SESSION['bolsaSession']=$arrayDadosReg['bolsaatual'];
				$_SESSION['dtatletaSession']=$arrayDadosReg['dtatleta'];
				$_SESSION['dtheroiSession']=$arrayDadosReg['dtheroi'];
				
				if(!empty($arrayDadosReg['pmelhormarcaprov']) || $arrayDadosReg['pmelhormarcaprov']<>0){
					$sqlPrimeiraProva=odbc_fetch_array(odbc_exec($conCab,"SELECT * FROM prova WHERE id=".$arrayDadosReg['pmelhormarcaprov'].""));
					$_SESSION['primProvaSession']=$sqlPrimeiraProva['id'];
					$_SESSION['primProvaDescSession']=utf8_encode($sqlPrimeiraProva['nome']);
					$_SESSION['primProvaPosSession']=utf8_encode($arrayDadosReg['pmelhormarcapos']);
				}else{
					$_SESSION['primProvaSession']='0';
					$_SESSION['primProvaDescSession']='Selecione';
					$_SESSION['primProvaPosSession']='';
					}
				if(!empty($arrayDadosReg['princprova']) || $arrayDadosReg['princprova']<>0){
					$sqlPricipalProva=odbc_fetch_array(odbc_exec($conCab,"SELECT * FROM prova WHERE id=".$arrayDadosReg['princprova'].""));
					$_SESSION['princProvaSession']=$sqlPricipalProva['id'];
					$_SESSION['princProvaDescSession']=utf8_encode($sqlPricipalProva['nome']);
				}else{
					$_SESSION['princProvaSession']='0';
					$_SESSION['princProvaDescSession']='Selecione';
					}
				if(!empty($arrayDadosReg['memarcprova']) || $arrayDadosReg['memarcprova']<>0){
					$sqlMelhorProva=odbc_fetch_array(odbc_exec($conCab,"SELECT * FROM prova WHERE id=".$arrayDadosReg['memarcprova'].""));
					$_SESSION['mmarcprovaSession']=$sqlMelhorProva['id'];
					$_SESSION['mmarcprovaDescSession']=utf8_encode($sqlMelhorProva['nome']);
					$_SESSION['mmarcaPosSession']=$arrayDadosReg['memarcapos'];
					$_SESSION['mmarcaEventoSession']=utf8_encode($arrayDadosReg['memarcaevento']);
					}else{
						$_SESSION['mmarcprovaSession']='0';
						$_SESSION['mmarcprovaDescSession']='Selecione';
						$_SESSION['mmarcaPosSession']='';
						$_SESSION['mmarcaEventoSession']='';
						}
				}
         
		 if($valida==1)
					{
				   ?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="index.php";
       				</script>
       				<?php
					}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("suggest_material_ordem.php", {
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
<script type='text/javascript' src='../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#bolsa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#mmarcpos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#pmelhormarcapos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#dtatleta').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
	$('#dtheroi').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
    });
	 </script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>DITEC - Atletas</h2>
<h3>Cadastro de Atletas de Alto Rendimento</h3> 
<br />
<div id='tabela'>
<form action="cadastraProvas.php" name="principal" method="post">
<table width="100%" border="0">
<tr><th colspan="2">DADOS DO ATLETA</th></tr>
<tr><th width="30%">Nome</th><td><input type="hidden" class="input" name="update" size="20" value="1"/><font size='3'><?php echo $_SESSION['atletaSession']; ?></font></td></tr>
<tr><th width="30%">Patrocínio</th><td><font size='3'><?php echo $_SESSION['patrocinioSession']; ?></font></td></tr>
<tr><th width="30%">Classe</th><td><input type="text" class="input" name="classe" size="20" value="<?php echo strtoupper($_SESSION['classeSession']) ?>"/></td></tr>
<tr><th width="30%">Modalidade</th><td>
<div id="select">
<select name="modalidade">
<?php 
echo "<option value='".$_SESSION['idmodSession']."' selected>".utf8_encode($_SESSION['descModSession'])."</option>";
$sqlModalidades=odbc_exec($conCab,"SELECT * FROM modalidade (nolock)");
while ($objModalidades=odbc_fetch_object($sqlModalidades)){
	if($objModalidades->id<>$_SESSION['idmodSession']){
		echo "<option value='".$objModalidades->id."'>".utf8_encode($objModalidades->descricao)."</option>";
		}
	}
?>
</select></div>
</td></tr>
<tr><th width="30%">Categoria</th><td><input type="text" class="input" name="categoria" size="20" value="<?php echo strtoupper($_SESSION['categoriaSession']) ?>"/></td></tr>
<tr><th width="30%">Bolsa Atual (R$)</th><td> <input type="text" class="input" name="bolsa" id='bolsa' size="20" value="<?php echo strtoupper($_SESSION['bolsaSession']) ?>"/></td></tr>
<tr><th width="30%">Entrada no Programa Caixa</th><td><font size='+0,5'>Atleta: <font><br/><input type="text" class="input" name="dtatleta" id="dtatleta" size="20" value="<?php echo strtoupper($_SESSION['dtatletaSession']) ?>"/><br /><br />Herói: <br/><input type="text" class="input" name="dtheroi" id="dtheroi" size="20" value="<?php echo strtoupper($_SESSION['dtheroiSession']) ?>"/>
</td></tr>
<tr><th width="30%">Melhor Resultado Ano Inicial</th><td>

<font size='+0,5'>Prova:</font> <br/>
<div id="select">
<select name="pmelhormarcaprova">
<?php 
echo "<option value='".$_SESSION['primProvaSession']."' selected>".utf8_encode($_SESSION['primProvaDescSession'])."</option>";
$sqlProvas=odbc_exec($conCab,"SELECT * FROM prova (nolock)");
while ($objProvas=odbc_fetch_object($sqlProvas)){
	if($objProvas->id<>$_SESSION['primProvaSession']){
		echo "<option value='".$objProvas->id."'>".utf8_encode($objProvas->nome)."</option>";
		}
	}
?>
</select></div>
<br /><br />
<font size='+0,5'>Posição/Ranking: </font><br/><input type="text" class="input" name="pmelhormarcapos" id="pmelhormarcapos" size="20" value="<?php echo strtoupper($_SESSION['primProvaPosSession']) ?>"/>
</td></tr>
<tr><th width="30%">Principal Prova</th><td>
<div id="select">
<select name="princprova">
<?php 
echo "<option value='".$_SESSION['princProvaSession']."' selected>".utf8_encode($_SESSION['princProvaDescSession'])."</option>";
$sqlPrincProvas=odbc_exec($conCab,"SELECT * FROM prova (nolock)");
while ($objPrincProvas=odbc_fetch_object($sqlPrincProvas)){
	if($objPrincProvas->id<>$_SESSION['princProvaSession']){
		echo "<option value='".$objPrincProvas->id."'>".utf8_encode($objPrincProvas->nome)."</option>";
		}
	}
?>
</select></div>
</td></tr>
<tr><th width="30%">Melhor Resultado da Vida</th><td>

<font size='+0,5'>Prova: </font><br/>
<div id="select">
<select name="mmarcprova">
<?php 
echo "<option value='".$_SESSION['mmarcprovaSession']."' selected>".utf8_encode($_SESSION['mmarcprovaDescSession'])."</option>";
$sqlmelhorProvas=odbc_exec($conCab,"SELECT * FROM prova (nolock)");
while ($objmelhorProvas=odbc_fetch_object($sqlmelhorProvas)){
	if($objmelhorProvas->id<>$_SESSION['mmarcprovaSession']){
		echo "<option value='".$objmelhorProvas->id."'>".utf8_encode($objmelhorProvas->nome)."</option>";
		}
	}
?>
</select></div>
<br /><br />
<font size='+0,5'>Posição/Ranking: </font><br/><input type="text" class="input" name="mmarcpos" id="mmarcpos" size="20" value="<?php echo strtoupper($_SESSION['mmarcaPosSession']) ?>"/>
<br /><br />
<font size='+0,5'>Evento: <font><br/><input type="text" class="input" name="mmarcevento" id="mmarcevento" size="20" value="<?php echo strtoupper($_SESSION['mmarcaEventoSession']) ?>"/>
</td></tr>
</table>
</div>
<table border="0" width="100%">
<tr><td width="30%"><a href="index.php"><input  type="button" class="buttonVerde" name='voltar' value="<<Voltar" /></a></td><td align="right"><input type="submit" class="button" value="Provas>>" /></td></tr>
</table>
</form>
</div>
</body>
</html>
<?php 
		}
	}
?>