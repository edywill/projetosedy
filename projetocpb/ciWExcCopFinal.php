<?php
session_start();
$teste=0;
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
$atualiza=0;
$solicitacao=$_POST['solicitacao'];
$sequencia=$_POST['sequencia'];
$usuario=$_POST['usuario'];
$retornar='ciWExcCopIns.php';
$tipo=trim($_POST['tipo']);
$valida=0;
$countError=0;
$errorMsg='';
if($_POST['tipo']=='rpa'){
	$rpa=1;
	if($teste==0){
	    $inicioRPA=converteData($_POST['inicioRpa']);
	}else{
		$inicioRPA=$_POST['inicioRpa'];
	}
		$_SESSION['inicioRpaCp']=$_POST['inicioRpa'];
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		if(empty($inicioRPA)){
				$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de inicial.\\n';	
			}
			if($teste==0){
		$fimRPA=converteData($_POST['fimRpa']);
			}else{
		$fimRPA=$_POST['fimRpa'];
			}
			$_SESSION['fimRpaCp']=$_POST['fimRpa'];
		$fimRPA=str_replace("'","\"",$fimRPA);
		if(empty($fimRPA)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if($fimRPA<$inicioRPA){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$_SESSION['vlRpaCp']=$_POST['valorRpa'];
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$valorRpa=str_replace("'","\"",$valorRpa);
		if(empty($valorRpa)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}

	}elseif($_POST['tipo']=='diaria'){
		$diaria=1;
		if($teste==0){
		$inicioDia=converteData($_POST['inicioDia']);
		}else{
		$inicioDia=$_POST['inicioDia'];
		}
		$_SESSION['inicioDiaCp']=$_POST['inicioDia'];
		$inicioDia=str_replace("'","\"",$inicioDia);
		if(empty($inicioDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';
			}
			if($teste==0){
		$fimDia=converteData($_POST['fimDia']);
			}else{
		$fimDia=$_POST['fimDia'];
			}
			$_SESSION['fimDiaCp']=$_POST['fimDia'];
		$fimDia=str_replace("'","\"",$fimDia);
		if(empty($fimDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if($fimDia<$inicioDia){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a final.\\n';
			}
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$_SESSION['vlDiaCp']=$_POST['valorDia'];
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;
		    if(empty($valorDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
		}elseif($_POST['tipo']=='passagem'){
			$passagem=1;
			if($teste==0){
			$inicioPas=converteData($_POST['inicioPas']);
			}else{
		$inicioPas=$_POST['inicioPas'];
			}
			$_SESSION['inicioPasCp']=$_POST['inicioPas'];
		$inicioPas=str_replace("'","\"",$inicioPas);
//Inicio da validação do campo Inicio (data)
		if(empty($inicioPas)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de partida.\\n';
			}
		//Fechou
		
        $horaPtPas=$_POST['horaPtPas'];
		$_SESSION['horaInicioCp']=$_POST['horaPtPas'];
		$horaPtPas=str_replace("'","\"",$horaPtPas);
		//Abriu
		if(empty($horaPtPas)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a hora de partida.\\n';
			}elseif($_POST['horaPtPas']>23){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Hora de partida inv\u00e1lida.\\n';	
			}else{
				
	      $minutoPtPas=$_POST['minutoPtPas'];
		  $_SESSION['minutoInicioCp']=$_POST['minutoPtPas'];
		  $minutoPtPas=str_replace("'","\"",$minutoPtPas);
	      
		  if(empty($minutoPtPas)){
					$minutoPtPas='00';
		  }elseif($minutoPtPas>59){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Minuto de partida inv\u00e1lido.\\n';	
			}else{
				
				$horaPtPas=$_POST['horaPtPas'].$minutoPtPas."00";
				$horaPtPas=str_replace("'","\"",$horaPtPas);
				}}
		
		//Ok
		
		$horaRetPas='';
		$_SESSION['horaFimCp']=$_POST['horaRetPas'];
		$_SESSION['minutoFimCp']=$_POST['minutoRetPas'];
				if(!empty($_POST['horaRetPas'])){
				   if($_POST['horaRetPas']>23){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Hora de retorno inv\u00e1lida.\\n';		
			}else{
				$minutoRetPas=$_POST['minutoRetPas'];
				$minutoRetPas=str_replace("'","\"",$minutoRetPas);
				
				if(empty($minutoRetPas)){
					$minutoRetPas='00';
				}elseif($_POST['minutoRetPas']>59){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Minuto de retorno inv\u00e1lido.\\n';		
			}else{
				   $horaRetPas=$_POST['horaRetPas'].$_POST['minutoRetPas']."00";		 
				   $horaRetPas=str_replace("'","\"",$horaRetPas);
				 }
			
			   }
 
				  				
			 }//Primeiro
		

//ok
		$_SESSION['fimPasCp']=$_POST['fimPas'];
		if(!empty($_POST['fimPas'])){
			if($teste==0){
	$fimPas="CAST('".converteData($_POST['fimPas'])."' AS DATETIME)";
	  }else{
	$fimPas="CAST('".$_POST['fimPas']."' AS DATETIME)";
	  }
		//$fimPas=str_replace("'","\"",$fimPas);
		
		if(empty($_POST['horaRetPas']) || empty($_POST['minutoRetPas'])){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a hora de retorno em viagens de ida e volta.\\n';	
			}elseif(converteData($_POST['fimPas'])==converteData($_POST['inicioPas'])){
				if($horaRetPas<$horaPtPas){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Em viagens no mesmo dia, a hora de retorno deve ser superior a de partida.\\n';	
			}
		 }elseif(converteData($_POST['fimPas'])<converteData($_POST['inicioPas'])){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data de retorno deve ser igual ou superior a de partida.\\n';	
			}
				}else{
			$fimPas="null";
		    }
        $valorPas=str_replace(".","",$_POST['valorPas']);
		$_SESSION['vlPasCp']=$_POST['valorPas'];
		$valorPas=str_replace(",",".",$valorPas);
		$valorPas=(float)$valorPas;
		$valorPas=str_replace("'","\"",$valorPas);
		$trechoPas=utf8_decode($_POST['trechoPas']);
		$_SESSION['trechoCp']=$_POST['trechoPas'];
		$trechoPas=str_replace("'","\"",$trechoPas);
		$obsPas=utf8_decode($_POST['obsPas']);
		$_SESSION['obsPasCp']=$_POST['obsPas'];
		$obsPas=str_replace("'","\"",$obsPas);
		    if(empty($valorPas)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';	
			}
			}elseif($_POST['tipo']=='hotel'){
				$hotel=1;
				if($teste==1){
				$inicioHot=$_POST['inicioHot'];
				}else{
		$inicioHot=converteData($_POST['inicioHot']);
				}
				$_SESSION['inicioHotCp']=$_POST['inicioHot'];
		$inicioHot=str_replace("'","\"",$inicioHot);
		if(empty($inicioHot)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';	
			}
		if($teste==1){
		$fimHot=$_POST['fimHot'];
		}else{
		$fimHot=converteData($_POST['fimHot']);
		}
		$_SESSION['fimHotCp']=$_POST['fimHot'];
		$fimHot=str_replace("'","\"",$fimHot);
		if(empty($fimHot)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';	
	   }
	   if($fimHot<$inicioHot){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';	
			}
				}
				
if($_POST['retorno']=='inserir'){
$retornarFinal='ciWInserirItens.php';
}else{
	$retornarFinal='ciWItens.php';
	}

if($valida==0){
if($tipo=='rpa'){
	for ($i = 0; $i < $_POST['contagem']; $i++) {
		if(isset($_POST['id'.$i.''])){
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
   CAST('".$inicioRPA."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimRPA."' AS DATETIME),    --  dt_fim  datetime 
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
			  }else{
		?>
       <script type="text/javascript">
       alert("Nenhum foi selecionado.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
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
			if(isset($_POST['id'.$i.''])){
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
	  }else{
			?>
       <script type="text/javascript">
       alert("Nenhum foi selecionado.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
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
				if(isset($_POST['id'.$i.''])){
	$sqlConsid="select MAX(id_registro) as id from TEITEMSOLHOTEL (nolock)";
	$rsConsid = odbc_exec($conCab,$sqlConsid) or die(odbc_error());
	$arrayConsid = odbc_fetch_array($rsConsid);
	$id=$arrayConsid['id']+1;
	$rlHotCop=$_POST['rlHot'.$i.''];
	if(empty($rlHotCop)){
		$rlHotCop=0;
		}
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
   ".$rlHotCop.",
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
			   }else{
			?>
       <script type="text/javascript">
       alert("Nenhum foi selecionado.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
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
			$contIncluir=0;
			for ($i = 0; $i < $_POST['contagem']; $i++) {
				if(isset($_POST['id'.$i.''])){
						$contIncluir++;
	if(isset($_POST['cadeirante'.$i.''])){ $cadeirantePas=1; }else{ $cadeirantePas=0;}
	
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
   '".$obsPas."',
   '".$trechoPas."', 
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
	   }
	   if($contIncluir==0){
					?>
       <script type="text/javascript">
       alert("Erro[1]: Nenhum foi selecionado.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php	
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
	$_SESSION['inicioRpaCp']='';
$_SESSION['inicioDiaCp']='';
$_SESSION['inicioPasCp']='';
$_SESSION['inicioHotCp']='';
$_SESSION['fimRpaCp']='';
$_SESSION['fimDiaCp']='';
$_SESSION['fimPasCp']='';
$_SESSION['fimHotCp']='';
$_SESSION['vlRpaCp']='';
$_SESSION['vlDiaCp']='';
$_SESSION['vlPasCp']='';
$_SESSION['horaInicioCp']='';
$_SESSION['minutoInicioCp']='';
$_SESSION['horaFimCp']='';
$_SESSION['minutoFimCp']='';
$_SESSION['obsPasCp']='';
$_SESSION['trechoCp']='';
	   ?>
       <script type="text/javascript">
       alert("Inserido com sucesso.");
       window.location="<?php echo $retornarFinal; ?>";
       </script>
       <?php
		}
}else{
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	}
?>