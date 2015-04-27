<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>BD</title>
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../suggest_processo.php", {
		  width: 380,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<style>
a.info{
	position:relative;
	z-index:24; background-color:#666;
	color:#FFF;
	text-decoration:none;
	cursor:pointer;
	}
a.info: hover{ z-index:25; background-color:#ff0; }
a.info: span { display:none;}
a.info: hover span{
	display:block;
	position:absolute;
	top:2em;
	left:2em;
	width:10em;
	border:1px solid #0cf;
	background-color:#555;
	color:#fff;
	}
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

</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>  
<div id="tabela">
<h3>Consultar Boarding Pass</h3>
    <form action="bdPesquisa.php" method="post">
    Informe um dos critérios de busca:<br />
    <strong>Nº da CI:</strong><input class='input' name="ci" type="text" size="5" />
    <br />
    <br />
    <strong>Processo/Evento:</strong><input class='input' name="proc" id='proc' type="text" size="50" />
    <br /><br />
      <input type="submit" class='button' value="PESQUISAR"/>
</form>
<div align="right"
>
<a href="../prestacao/prestContasRel.php"><input type="button" name="pend" value="Prestação de Contas" class="button" /></a>
<a href="gerenPendencias.php"><input type="button" name="pend" value="Gerenciar Pendências" class="button" /></a>
</div>
<h3>Relação de Boarding Pass Atraso</h3> 
<a href="../dadosBoardingPass.php" target="_blank">Exportar Excel</a>
<form action="registraBdpass.php" name="bdpass" method="post">
<table  width="100%">
<tr>
        <th width="6%">CI/ Aut.</th><th width="8%">Processo</th><th width="30%">Nome</th><th>Data</th><th width="12%">Localizador</th><th width="9%">CIA Aerea</th><th width="9%">Valor Final</th><th width="8%">Board. Pass</th>
    </tr>
    <?php 
	require "../../conectsqlserverciprod.php";
	require "../../conexaomysql.php";
	require "../../somarDatas.php";
	$sqlReg=mysql_query("select registros.id,registros.solicitacao, registros.autorizacao, registros.projeto, registros.idben, registros.datainicial, registros.datafinal, registros.localizador, cia.nome ,registros.vltot from registros LEFT JOIN cia ON registros.idcia=cia.id where registros.bdpass=0 ORDER BY registros.datainicial") or die(mysql_error());
	$countReg=mysql_num_rows($sqlReg);
	if($countReg<1){
		?>
       <script type="text/javascript">
       alert("Nao existe Boarding Pass pendente!");
       window.parent.location.reload();
       </script>
       <?php
		}
	$dt=0;
	$cor='';
	$count=0;
	$numRegistros=0;
	$idbenAnt='';
	while($objReg=mysql_fetch_object($sqlReg)){
		$cor='';
		$numRegistros=0;
		$sqlNome=odbc_exec($conCab,"SELECT Nome_completo FROM GEEMPRES (nolock) WHERE Cd_empresa='".$objReg->idben."'");
		$arrayNome=odbc_fetch_array($sqlNome);
		$sqlProc=odbc_exec($conCab,"select assunto
from GMPROCDOC (nolock) 
where (projeto LIKE '".$objReg->projeto."%')");
		$arrayProc=odbc_fetch_array($sqlProc);
		$sqlDataBd=odbc_exec($conCab,"select dt_partida,dt_chegada from teitemsolpassagem (nolock)
where cd_solicitacao='".$objReg->solicitacao."' AND cd_empresa='".$objReg->idben."'");
		$arrayDataBd=odbc_fetch_array($sqlDataBd);
		$dataSomada='';
		  if(!empty($objReg->datafinal)){
			    	if($objReg->datafinal<>'0000-00-00'){ 
					if($objReg->datafinal<>'1969-12-31'){
		$dataSomada=somar_data($objReg->datafinal, 10, 0, 0);
			  }}}
			  if(empty($dataSomada)){
				 $dataSomada=somar_data($objReg->datainicial, 10, 0, 0);
				  }
			if(strtotime(date("Y-m-d")) >= strtotime($dataSomada)){
				$sqlBloqAut=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE cdempres='".$objReg->idben."' AND idaut='".$objReg->id."'"));
				if($sqlBloqAut==0){
				$insertIntoBloqueio=mysql_query("INSERT INTO prestbloqueados (cdempres,idaut,status) VALUES ('".$objReg->idben."','".$objReg->id."','1')");
				//insert do cigam
				}
				$numRegistros++;
				}
				if($idbenAnt==$objReg->idben){
			$tipoPas='VOLTA';
			$dataPassagem=date('d/m/Y',strtotime($objReg->datafinal));
			}else{
				$tipoPas='IDA';
				$dataPassagem=date('d/m/Y',strtotime($objReg->datainicial));
				}
$idbenAnt=$objReg->idben;		
		if($numRegistros>0){
				$count++;
				$cor="bgcolor='yellow'";
		echo "<tr ".$cor."><td>".$objReg->solicitacao."<br>".$objReg->autorizacao."</td><td><span title='".mb_convert_encoding($arrayProc['assunto'],"UTF-8","ISO-8859-1")."'>".$objReg->projeto."</span></td><td>".trim(utf8_encode($arrayNome['Nome_completo']))."</td><td>".$tipoPas.": ".$dataPassagem."</td><td>".$objReg->localizador."</td><td>".$objReg->nome."</td><td>".$objReg->vltot."</td><td><input type='checkbox' name='bdpass[]' value='".$objReg->id."'/></td></tr>";
			}
			
		}
	?>
    <tr><td colspan="8" align="right"><input class="button" type="submit" name="button" value="Atualizar" /></td></tr>
    </table>
    </form>
  </div>
</div>
</body>
</html>