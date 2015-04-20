<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
		$userCriac=$_SESSION['userAquis'];
$_SESSION['empresaAquis']='';
$_SESSION['procAquis']='';
$_SESSION['dtinicioAquis']='';
$criar=0;
		//Novo registro
		if(!empty($_GET['tipo'])){
			$tipo='cd';
			$criar=1;
			}elseif(!empty($_POST['tipo'])){
				$tipo=$_POST['tipo'];
				$criar=1;
			}
if($criar==1){			
			switch ($tipo) {
				case "cd":
        			$descTipo='Compra Direta';
        			break;
    			case "pr":
        			$descTipo='Pregão Eletrônico';
        			break;
    			case "co":
        			$descTipo='Carta Convite';
        			break;
				case "cr":
        			$descTipo='Concorrência';
        			break;
				default:
       				?>
       				<script type="text/javascript">
       				alert("Escolha um tipo de Licitação");
       				window.location="index.php";
       				</script>
       		<?php
}
$_SESSION['acaoSession']='criar';
$_SESSION['tipoLicSession']=$descTipo;
$_SESSION['tipoSession']=$tipo;
$_SESSION['licitSessionDesc']='';
$_SESSION['processoSession']='';
$_SESSION['processoSessionDesc']='';
$_SESSION['empresaSession']='';
$_SESSION['empresaSessionDesc']='';
$_SESSION['dataInicioSession']='';
$_SESSION['idosSession']='';
			}
			//Atualização
			elseif(!empty($_POST['idatu'])){
	$_SESSION['acaoSession']='atualizar';
	$sqlGeral=mysql_fetch_array(mysql_query("SELECT aquilic.*,aquiordemlic.idos FROM aquilic LEFT JOIN aquiordemlic ON aquilic.id=aquiordemlic.idreg WHERE aquilic.id='".$_POST['idatu']."'"));
	$_SESSION['idRegAqui']=$_POST['idatu'];
	$_SESSION['tipoSession']=$sqlGeral['tplicit'];
	switch ($_SESSION['tipoSession']) {
    			case "cd":
        			$descTipo='Compra Direta';
        			break;
    			case "pr":
        			$descTipo='Pregão Eletrônico';
        			break;
    			case "co":
        			$descTipo='Carta Convite';
        			break;
				case "cr":
        			$descTipo='Concorrência';
        			break;
				default:
					$descTipo="Indefinido";
					break;
	}
	$_SESSION['tipoLicSession']=$descTipo;
	$_SESSION['licitSessionDesc']=$sqlGeral['nlicit'];
	$_SESSION['processoSession']=$sqlGeral['proc'];
	$sqlProcesAtu=odbc_fetch_array(odbc_exec($conCab,"SELECT projeto, assunto FROM GMPROCDOC (nolock) WHERE projeto='".$_SESSION['processoSession']."'"));
	$_SESSION['processoSessionDesc']=$_SESSION['processoSession']."-".utf8_encode($sqlProcesAtu['assunto']);
	
	$_SESSION['empresaSession']=$sqlGeral['cdempres'];
	$sqlEmpresAtu=odbc_fetch_array(odbc_exec($conCab,"SELECT Cd_empresa,Nome_completo FROM GEEMPRES (nolock) WHERE Cd_empresa='".$_SESSION['empresaSession']."'"));
	$_SESSION['empresaSessionDesc']=utf8_encode($sqlEmpresAtu['Nome_completo']);
	
	$_SESSION['dataInicioSession']=$sqlGeral['dtinicio'];
	$_SESSION['idosSession']=$sqlGeral['idos'];
			}else{
				$_SESSION['acaoSession']='atualizar';
				}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../../ajax/funcs.js"></script>
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../../jquery.autocomplete.js'></script> 
	<link rel="stylesheet" type="text/css" href="../../jqueryDown/easy/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../../jqueryDown/easy/themes/icon.css">
	<script type="text/javascript" src="../../jqueryDown/easy/jquery.easyui.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../../jquery.autocomplete.css" />
  <script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../../suggest_projeto.php", {
		  width: 510,
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
<script type='text/javascript' src='../../../jquery_price.js'></script>
<style>
    .sel { width: 70px; }
    
</style>
<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style>
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
 <script type="text/javascript">
  function mostra(){
	  if(window.onload){
		  document.getElementById('lendo').style.display="none"
		  document.getElementById('conteudo').style.visibility="visible"
		  }
	  }
	  window.onload=mostra
  </script>
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
  <style type="text/css">
  .imgpos{
	  position:absolute;
	  left:50%;
	  top:50%;
	  margin-left:-110px;
	  margin-top:-60px;
	  width:200px;
	  height:200px;
	  z-index:2;
	  }
  </style>
</head>
       
<body>
<div id='box3' style="height:auto">
<div id='lendo'>
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Compra/Serviço - <u><?php 
echo $_SESSION['tipoLicSession'];
?>
</u>
</h3> 
Carregando dados...
<img src="../../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Compra/Serviço - <u><?php 
echo $_SESSION['tipoLicSession'];
?>
</u>
</h3>  
<br />
<div id='tabela'>
<form action="insereItensLic.php" name="insere" method="post">
<table width="100%" border="0">
<tr><th width="20%">Processo</th><td>
<input type="text" name="proc" id="proc" class="input" size="60" value="<?php echo $_SESSION['processoSessionDesc']; ?>" style="background: url(../../../sav/css/icone_lupa.png) no-repeat right;"/>
</td></tr>
<?php 
if($_SESSION['tipoSession']<>'cd'){
?>
<tr><th width="20%">Nº Licitação:</th><td>
<input type="text" name="licit" id="licit" class="input" size="30" value="<?php echo $_SESSION['licitSessionDesc']; ?>" maxlength="18"/>
</td></tr>
<?php 
}else{
echo '<input type="hidden" name="licit" id="licit" class="input" size="30" value=""/>';
}
?>
<tr><th width="20%">Empresa</th><td>
<select name='empresa' id='empresa' class="easyui-combobox">
<option value='<?php echo $_SESSION['empresaSession'];?>' selected="selected"><?php echo utf8_encode($_SESSION['empresaSessionDesc']); ?></option>
<?php 
$sqlEmpresa=odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock)");
while($objEmpresa=odbc_fetch_object($sqlEmpresa)){
	if($_SESSION['empresaSession']<>$objEmpresa->Cd_empresa){
	echo "<option value='".$objEmpresa->Cd_empresa."'>".utf8_encode($objEmpresa->Nome_completo)."</option>";
		}
	}
?>
</select>
<font size="-1" color="#FF0000">(*)Obrigatório</font></td></tr>
<tr><th width="20%">Prev. de Entrega</th><td><input type="text" name="datainicial" id="datainicial" class="input" size="20" readonly value='<?php echo $_SESSION['dataInicioSession']; ?>' style="background: url(../../../sav/css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr><td width="20%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="Continuar>>" /></td></tr>
</table>
</form>
</div>
</div>
</div>
</body>
</html>