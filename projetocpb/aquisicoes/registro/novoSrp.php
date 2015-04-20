<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$userCriac=$_SESSION['userAquis'];
		unset($_SESSION['empresaAquis']);
		unset($_SESSION['procAquis']);
		unset($_SESSION['dtinicioAquis']);
		unset($_SESSION['dtfimAquis']);
	    unset($_SESSION['idRegAqui']);
		unset($_SESSION['materialComp']);
		unset($_SESSION['qtdMat']);
		unset($_SESSION['vlunitMat']);
		$_SESSION['grupoComp']='';
		$_SESSION['grupoCompDesc']='';
		$processo='';
		$processoId='';
		$processoCompleto='';
        $empresaId='';
		$empresa='';
		$dtinicio='';
		$dtfim='';
		$criar="";
		if(!empty($_POST['idatu'])){
		$sqlRegAtu=mysql_fetch_array(mysql_query("SELECT * FROM aquireg WHERE id='".$_POST['idatu']."'"));
		if(empty($sqlRegAtu)){
			?>
       <script type="text/javascript">
       alert("Registro inexistente");
       window.location="index.php";
       </script>
       <?php
			}else{
		$sqlEmpresAtu=odbc_fetch_array(odbc_exec($conCab,"SELECT Cd_empresa,Nome_completo FROM GEEMPRES (nolock) WHERE Cd_empresa='".$sqlRegAtu['cdempres']."'"));
		$sqlProcesAtu=odbc_fetch_array(odbc_exec($conCab,"SELECT projeto, assunto FROM GMPROCDOC (nolock) WHERE projeto='".$sqlRegAtu['proc']."'"));
		$processoId=trim($sqlProcesAtu['projeto']);
		$processo=trim(utf8_encode($sqlProcesAtu['assunto']));
		
		if(!empty($processo)){
			$processoCompleto=$processoId."-".$processo;
			}
		$empresaId=trim($sqlEmpresAtu['Cd_empresa']);
		$empresa=trim(utf8_encode($sqlEmpresAtu['Nome_completo']));
		$dtinicio=trim($sqlRegAtu['dtinicio']);
		$dtfim=trim($sqlRegAtu['dtfim']);
		$criar="<input type='hidden' name='idregedit' id='idregedit' class='input' value='".$_POST['idatu']."'/>";
			}
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
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script> 
	<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../jqueryDown/easy/themes/icon.css">
	<script type="text/javascript" src="../jqueryDown/easy/jquery.easyui.min.js"></script>
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
<h3>Registro de Preço</h3> 
Carregando dados...
<img src="../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Registro de Preço</h3>  
<br />
Informe os dados da empresa e processo referente ao Registro de Preço:<br />
<div id='tabela'>
<form action="insereItensSrp.php" name="insere" method="post">
<table width="100%" border="0">
<tr><th width="20%">Processo</th><td>
<input type="text" name="proc" id="proc" class="input" size="60" value="<?php echo $processoCompleto; ?>" />
</td></tr>
<tr><th width="20%">Empresa</th><td><input type='hidden' name='criar' id='criar' class='input' value='1'/><?php echo $criar; ?>
<select name='empresa' id='empresa' class="easyui-combobox">
<option value='<?php echo $empresaId; ?>' selected="selected"><?php echo utf8_encode($empresa); ?></option>
<?php 
$sqlEmpresa=odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock)");
while($objEmpresa=odbc_fetch_object($sqlEmpresa)){
	echo "<option value='".$objEmpresa->Cd_empresa."'>".utf8_encode($objEmpresa->Nome_completo)."</option>";
	}
?>
</select>
<font size="-1" color="#FF0000">(*)Obrigatório</font></td></tr>
<tr><th width="20%">Vigência</th><td><input type="text" name="datainicial" id="datainicial" class="input" size="20" readonly value='<?php echo $dtinicio; ?>'/> à <input type="text" name="datafinal" id="datafinal" class="input" size="20" readonly value='<?php echo $dtfim; ?>'/></td></tr>
<tr><td width="20%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="Continuar>>" /></td></tr>
</table>
</form>
</div>
</div>
</div>
</body>
</html>