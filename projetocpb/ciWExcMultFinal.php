<?php
session_start();
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}

include "mb.php";
require "conectsqlserverci.php";
require('conexaomysql.php');
$teste=0;
$atualiza=0;
$solicitacao=$_POST['solicitacao'];
$sequencia=$_POST['sequencia'];
$usuario=$_POST['usuario'];
if($teste==1){
$inicioRpa=$_POST['inicioRpa'];
$fimRpa=$_POST['fimRpa'];
$inicioDia=$_POST['inicioDia'];
$fimDia=$_POST['fimDia'];
$inicioPas=$_POST['inicioPas'];
$inicioHot=$_POST['inicioHot'];
$fimHot=$_POST['fimHot'];
}else{
$inicioRpa=converteData($_POST['inicioRpa']);
$fimRpa=converteData($_POST['fimRpa']);
$inicioDia=converteData($_POST['inicioDia']);
$fimDia=converteData($_POST['fimDia']);
$inicioPas=converteData($_POST['inicioPas']);
$inicioHot=converteData($_POST['inicioHot']);
$fimHot=converteData($_POST['fimHot']);
	}
$valorRpa=(float)$_POST['valorRpa'];
$valorDia=(float)$_POST['valorDia'];
$horaPtPas=$_POST['horaPtPas'];
if($_POST['fimPas']=='null'){
	$fimPas='null';
}else{
	  if($teste==0){
	$fimPas="CAST('".converteData($_POST['fimPas'])."' AS DATETIME)";
	  }else{
	$fimPas="CAST('".$_POST['fimPas']."' AS DATETIME)";
	  }
	}
$horaRetPas=$_POST['horaRetPas'];
$valorPas=(float)$_POST['valorPas'];
$trechoPas=$_POST['trechoPas'];
$obsPas=$_POST['obsPas'];
//$retornar='ciWExcMult.php';
$tipo=trim($_POST['tipoIns']);
if($_POST['retorno']=='inserir'){
$retornar='ciWInserirItens.php';
}else{
	$retornar='ciWItens.php';
	}
if($tipo=='rpa'){
	for ($i = 0; $i < $_POST['contagem']; $i++) {
	$sqlConsid="select MAX(id_registro) as id from TEITEMSOLRPA (nolock)";
	$rsConsid = odbc_exec($conCab,$sqlConsid) or die(odbc_error());
	$arrayConsid = odbc_fetch_array($rsConsid);
	$id=$arrayConsid['id']+1;
	$sql="insert into TEITEMSOLRPA(
   id_registro,
   cd_solicitacao,
   sequencia,
   cd_empresa,
   dt_inicio,
   dt_fim,
   valor,
   cd_lancamento,
   usu_criacao,
   dt_criacao,
   hr_criacao,
   usu_modificacao,
   dt_modificacao,
   hr_modificacao,
   cargo
   )
values
   (
   ".$id.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$_POST['id'.$i.'']."',                     --  cd_empresa  char(6)
   CAST('".$inicioRpa."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimRpa."' AS DATETIME),    --  dt_fim  datetime 
   '".$valorRpa."',                         --  valor  float 
   0,                            --  cd_lancamento  float 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   '".utf8_decode($_POST['cargo'.$i.''])."'                   --  cargo varchar(40)
   )";
	$res = odbc_exec($conCab, $sql) or die("<p>".odbc_errormsg());   
	   if($res){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
	   }
	$sqlCount="select valor from TEITEMSOLRPA (nolock) WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'";
	$rsCount = odbc_exec($conCab,$sqlCount) or die(odbc_error());
	$novoValor=0;
	$contarRegistros=0;
	while($objCount=odbc_fetch_object($rsCount)){
		$contarRegistros++;
		$novoValor=(float)$objCount->valor+$novoValor;
		}
		$novoValor=$novoValor/$contarRegistros;
	$updItem=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade='".$contarRegistros."', qt_saldo='".$contarRegistros."', pr_unitario='".$novoValor."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());	
	if($updItem){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
	}elseif($tipo=='diaria'){
		for ($i = 0; $i < $_POST['contagem']; $i++) {
	$sqlConsid="select MAX(id_registro) as id from TEITEMSOLDIARIAVIAGEM (nolock)";
	$rsConsid = odbc_exec($conCab,$sqlConsid) or die(odbc_error());
	$arrayConsid = odbc_fetch_array($rsConsid);
	$id=$arrayConsid['id']+1;
	$sql="insert into TEITEMSOLDIARIAVIAGEM(
   id_registro,
   solicitacao,
   sequencia,
   empresa,
   dt_inicio,
   dt_termino,
   valor,
   lancamento,
   usu_criacao,
   dt_criacao,
   hr_criacao,
   usu_modificacao,
   dt_modificacao,
   hr_modificacao,
   cargo
   )
values
   (
   ".$id.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$_POST['id'.$i.'']."',                     --  cd_empresa  char(6)
   CAST('".$inicioDia."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimDia."' AS DATETIME),    --  dt_fim  datetime 
   '".$valorDia."',                         --  valor  float 
   0,                            --  cd_lancamento  float 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   '".utf8_decode($_POST['cargo'.$i.''])."'                   --  cargo varchar(40)
   )";
	$res = odbc_exec($conCab, $sql) or die("<p>".odbc_errormsg());   
	   if($res){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
	   }
	$sqlCount="select valor from TEITEMSOLDIARIAVIAGEM (nolock) WHERE solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'";
	$rsCount = odbc_exec($conCab,$sqlCount) or die(odbc_error());
	$novoValor=0;
	$contarRegistros=0;
	while($objCount=odbc_fetch_object($rsCount)){
		$contarRegistros++;
		$novoValor=(float)$objCount->valor+$novoValor;
		}
		$novoValor=$novoValor/$contarRegistros;
		$updItem=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade='".$contarRegistros."', qt_saldo='".$contarRegistros."', pr_unitario='".$novoValor."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());	
	if($updItem){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
		}elseif($tipo=='hotel'){
			for ($i = 0; $i < $_POST['contagem']; $i++) {
	$sqlConsid="select MAX(id_registro) as id from TEITEMSOLHOTEL (nolock)";
	$rsConsid = odbc_exec($conCab,$sqlConsid) or die(odbc_error());
	$arrayConsid = odbc_fetch_array($rsConsid);
	$id=$arrayConsid['id']+1;
	$sql="insert into TEITEMSOLHOTEL(
   id_registro,
   cd_solicitacao,
   sequencia,
   cd_empresa,
   reserva,
   dt_entrada,
   dt_saida,
   usu_criacao,
   dt_criacao,
   hr_criacao,
   usu_modificacao,
   dt_modificacao,
   hr_modificacao,
   cargo
   )
values
   (
   ".$id.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$_POST['id'.$i.'']."',                     --  cd_empresa  char(6)
   '".$_POST['rlHot'.$i.'']."',
   CAST('".$inicioHot."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimHot."' AS DATETIME),    --  dt_fim  datetime 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   '".utf8_decode($_POST['cargo'.$i.''])."'                   --  cargo varchar(40)
   )";
	$res = odbc_exec($conCab, $sql) or die("<p>".odbc_errormsg());   
	   if($res){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
	   }
	$sqlCount="select id_registro as id from TEITEMSOLHOTEL (nolock) WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'";
	$rsCount = odbc_exec($conCab,$sqlCount) or die(odbc_error());
	$contarRegistros = odbc_num_rows($rsCount);
	
	$updItem=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade='".$contarRegistros."', qt_saldo='".$contarRegistros."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());	
	if($updItem){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
			}elseif($tipo=='passagem'){
		for ($i = 0; $i < $_POST['contagem']; $i++) {
	if(isset($_POST['cadeirante'.$i.''])){ 
	$cadeirantePas=1; 
	}else{ 
	$cadeirantePas=0;
	}
	
	$sqlConsid="select MAX(id_registro) as id from TEITEMSOLPASSAGEM (nolock)";
	$rsConsid = odbc_exec($conCab,$sqlConsid) or die(odbc_error());
	$arrayConsid = odbc_fetch_array($rsConsid);
	$id=$arrayConsid['id']+1;
	
	$sql="insert into TEITEMSOLPASSAGEM(
   id_registro,
   cd_solicitacao,
   sequencia,
   cd_empresa,
   dt_partida,
   hr_partida,
   dt_chegada,
   hr_chegada,
   cadeirante,
   observacao,
   trecho,
   usu_criacao,
   dt_criacao,
   hr_criacao,
   usu_modificacao,
   dt_modificacao,
   hr_modificacao,
   valor,
   cargo
   )
values
   (
   ".$id.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$_POST['id'.$i.'']."',                     --  cd_empresa  char(6)
   CAST('".$inicioPas."' AS DATETIME),    --  dt_inicio  datetime 
   '".$horaPtPas."',   --hr_partida
   ".$fimPas.",    --  dt_fim  datetime 
   '".$horaRetPas."',   --hr_retorno
   ".$cadeirantePas.", 
   '".utf8_decode($obsPas)."',
   '".utf8_decode($trechoPas)."', 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   ".$valorPas.",--  valor  float
   '".utf8_decode($_POST['cargo'.$i.''])."'                   --  cargo varchar(40)
   )";
	$res = odbc_exec($conCab, $sql) or die("<p>".odbc_errormsg());   
	   if($res){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
	   }
	$sqlCount="select valor from TEITEMSOLPASSAGEM (nolock) WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'";
	$rsCount = odbc_exec($conCab,$sqlCount) or die(odbc_error());
	$novoValor=0;
	$contarRegistros=0;
	while($objCount=odbc_fetch_object($rsCount)){
		$contarRegistros++;
		$novoValor=(float)$objCount->valor+$novoValor;
		}
		$novoValor=$novoValor/$contarRegistros;
		$updItem=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade='".$contarRegistros."', qt_saldo='".$contarRegistros."', pr_unitario='".$novoValor."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());	
	if($updItem){
		   $atualiza++;
		   }else{
			   $atualiza=0;
			   }
			  }

if($atualiza>0){
	require "conexaomysql.php";
	mysql_query("DELETE FROM cimulttemp WHERE ci='".$solicitacao."' AND seq='".$sequencia."'");
	unset($_SESSION['sequenciaMult']);
	unset($_SESSION['solicitacaoMult']);
	unset($_SESSION['usuarioMult']);
	unset($_SESSION['retornoMult']);
unset($_SESSION['inicioRpaMx']);
unset($_SESSION['inicioDiaMx']);
unset($_SESSION['inicioPasMx']);
unset($_SESSION['inicioHotMx']);
unset($_SESSION['fimRpaMx']);
unset($_SESSION['fimDiaMx']);
unset($_SESSION['fimPasMx']);
unset($_SESSION['fimHotMx']);
unset($_SESSION['vlRpaMx']);
unset($_SESSION['vlDiaMx']);
unset($_SESSION['vlPasMx']);
unset($_SESSION['horaInicioMx']);
unset($_SESSION['minutoInicioMx']);
unset($_SESSION['horaFimMx']);
unset($_SESSION['minutoFimMx']);
unset($_SESSION['obsPasMx']);
unset($_SESSION['trechoMx']);
?>
       <script type="text/javascript">
       alert("Inserido com sucesso.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
		}

?>