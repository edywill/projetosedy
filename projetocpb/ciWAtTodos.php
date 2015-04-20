<?php
require "conectsqlserverci.php";
$teste=0;
//session_start();
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

$solicitacao=$_POST['solicitacao'];
$usuario=$_POST['usuario'];
$sequencia=$_POST['sequencia'];
$id=$_POST['id'];
$rpaCod='';
$cargoRpa='';
$inicioRPA='';
$fimRPA='';
$valorRpa='';
$diaCod='';
$cargoDia='';
$inicioDia='';
$fimDia='';
$valorDia='';
$pasCod='';
$cargoPas='';
$inicioPas='';
$horaPtPas='';
$fimPas='';
$horaRetPas='';
$valorPas='';
$trechoPas='';
if(isset($_POST['cadeirantePas'])){ $cadeirantePas=1; }else{ $cadeirantePas=0;}
$obsPas='';
$hotCod='';
$inicioHot='';
$fimHot='';
$rlHot='';
$cargoHot='';
$rpa=0;
$hotel=0;
$diaria=0;
$passagem=0;
$contador=0;
$valida=0;
$countError=0;
$errorMsg='';
if($_POST['tipo']=='rpa'){
	$rpa=1;
	}elseif($_POST['tipo']=='dia'){
		$diaria=1;
		}elseif($_POST['tipo']=='hot'){
		$hotel=1;
		}elseif($_POST['tipo']=='pas'){
		$passagem=1;
		}
		
		if($rpa==1){
		$rpaCod=trim($_POST['rpaCod']);
		$arRpaCod = explode('-', $rpaCod);
		$rpaCod=$arRpaCod[0];
		$rpaCod=str_replace("'","\"",$rpaCod);
		if(empty($rpaCod)){
		
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o benefici\\u00e1rio.\\n';	
			}else{
				$sqlConsrpaCodAtivo2="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$rpaCod."'
							and ativo = 1";
	$rsConsrpaCodAtivo2 = odbc_exec($conCab,$sqlConsrpaCodAtivo2) or die(odbc_error());
	$contarConsrpaCodAtivo2=odbc_num_rows($rsConsrpaCodAtivo2);
				if($contarConsrpaCodAtivo2==0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inexistente ou inativo.\\n';					
					}
				}
		if(!empty($_POST['cargoRpa'])){
		$cargoRpa=$_POST['cargoRpa'];
		$cargoRpa=str_replace("'","\"",$cargoRpa);
		}
		if($teste==0){
		$inicioRPA=converteData($_POST['inicioRpa']);
		}else{
			$inicioRPA=$_POST['inicioRpa'];
			}
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		if(empty($inicioRPA)){
					
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';	
			}
			if($teste==0){
$fimRPA=converteData($_POST['fimRpa']);
}else{
			$fimRPA=$_POST['fimRpa'];
}
		$fimRPA=str_replace("'","\"",$fimRPA);
		if(empty($fimRPA)){
					
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe data final.\\n';	
		}
		if($fimRPA<$inicioRPA){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';	
			}
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$valorRpa=str_replace("'","\"",$valorRpa);
		    if(empty($valorRpa)){
					
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
			if($valida==0){
		    $vlAntRPA=$_POST['valorAnt'];
			$sqlRpaValor=odbc_exec($conCab,"select valor from TEITEMSOLRPA (nolock) where Cd_solicitacao=".$solicitacao." and Sequencia=".$sequencia."") or die(odbc_error());
			$totalRPA=0;
			$contador=0;
			while($objRpaValor=odbc_fetch_object($sqlRpaValor)){
				$totalRPA=$totalRPA+(float)$objRpaValor->valor;
				$contador++;
				}
			$valorFuturoRpa=(($totalRPA-(float)$vlAntRPA)+$valorRpa)/$contador;
            $updItem=odbc_exec($conCab,"UPDATE COISOLIC SET pr_unitario='".$valorFuturoRpa."' WHERE Cd_solicitacao=".$solicitacao." AND Sequencia=".$sequencia."") or die("<p>".odbc_errormsg());	
		$sqlRPA="UPDATE TEITEMSOLRPA SET cd_empresa='".$rpaCod."',
   dt_inicio=CAST('".$inicioRPA."' AS DATETIME),
   dt_fim=CAST('".$fimRPA."' AS DATETIME),
   valor=".$valorRpa.",
   usu_modificacao='".$usuario."',
   dt_modificacao=dbo.CGFC_DATAATUAL(),
   hr_modificacao='".date("His")."',
   cargo='".$cargoRpa."'
   WHERE id_registro='".$id."'";
	$resRPA = odbc_exec($conCab, $sqlRPA) or die("<p>".odbc_errormsg());	
		if($resRPA && $updItem){
		?>
       <script type="text/javascript">
       alert("Item Atualizado com sucesso.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
		    }}else{
				?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
				}
		}elseif($diaria==1){
		$diaCod=trim($_POST['diaCod']);
		$ardiaCod = explode('-', $diaCod);
		$diaCod=$ardiaCod[0];
		$diaCod=str_replace("'","\"",$diaCod);
		if(empty($diaCod)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o benefici\\u00e1rio.\\n';	
			}else{
				$sqlConsdiaCodAtivo2="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$diaCod."'
							and ativo = 1";
	$rsConsdiaCodAtivo2 = odbc_exec($conCab,$sqlConsdiaCodAtivo2) or die(odbc_error());
	$contarConsdiaCodAtivo2=odbc_num_rows($rsConsdiaCodAtivo2);
				if($contarConsdiaCodAtivo2==0){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inexistente ou inativo.\\n';	
					}
				}
		if(!empty($_POST['cargoDia'])){
		$cargoDia=$_POST['cargoDia'];
		$cargoDia=str_replace("'","\"",$cargoDia);
		}
		if($teste==0){
$inicioDia=converteData($_POST['inicioDia']);
}else{
			$inicioDia=$_POST['inicioDia'];
}
		
		$inicioDia=str_replace("'","\"",$inicioDia);
		if(empty($inicioDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe data inicialS.\\n';	
			}
			if($teste==0){
		$fimDia=converteData($_POST['fimDia']);
}else{
				$fimDia=$_POST['fimDia'];
}
		$fimDia=str_replace("'","\"",$fimDia);
		if(empty($fimDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';	
			}
		if($fimDia<$inicioDia){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';	
			}
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;
		$valorDia=str_replace("'","\"",$valorDia);
		    if(empty($valorDia)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';	
			}
			if($valida==0){
		    $vlAntDia=$_POST['valorAnt'];
			$sqlDiaValor=odbc_exec($conCab,"select valor from TEITEMSOLDIARIAVIAGEM (nolock) where solicitacao=".$solicitacao." and Sequencia=".$sequencia."") or die(odbc_error());
			$totalDia=0;
			$contador=0;
			while($objDiaValor=odbc_fetch_object($sqlDiaValor)){
				$totalDia=$totalDia+(float)$objDiaValor->valor;
				$contador++;
				}
			$valorFuturoDia=(($totalDia-(float)$vlAntDia)+$valorDia)/$contador;
			
			$updItem=odbc_exec($conCab,"UPDATE COISOLIC SET pr_unitario='".$valorFuturoDia."' WHERE Cd_solicitacao=".$solicitacao." AND Sequencia=".$sequencia."") or die("<p>".odbc_errormsg());
		$sqlDia="UPDATE TEITEMSOLDIARIAVIAGEM SET
   empresa='".$diaCod."',                     --  cd_empresa  char(6)
   dt_inicio= CAST('".$inicioDia."' AS DATETIME),    --  dt_inicio  datetime 
   dt_termino=CAST('".$fimDia."' AS DATETIME),
   valor=".$valorDia.",
   usu_modificacao='".$usuario."',
   dt_modificacao=dbo.CGFC_DATAATUAL(),
   hr_modificacao='".date("His")."',
   cargo='".$cargoDia."'
   WHERE id_registro='".$id."'";
	$resDia = odbc_exec($conCab, $sqlDia) or die("<p>".odbc_errormsg());	
		if($resDia && $updItem){
		?>
       <script type="text/javascript">
       alert("Item Atualizado com sucesso.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
		    }
			}else{
				?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
				}
		}elseif($passagem==1){
		 $pasCod=trim($_POST['pasCod']);
		 $arpasCod = explode('-', $pasCod);
		 $pasCod=$arpasCod[0];
		 $pasCod=str_replace("'","\"",$pasCod);
	
	
	if(empty($pasCod)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o passageiro.\\n';
			}else{
				//Inicio Validação Usuario
				$sqlConspasCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$pasCod."'
							and ativo = 1";
	$rsConspasCodAtivo = odbc_exec($conCab,$sqlConspasCodAtivo) or die(odbc_error());
	$contarConspasCodAtivo=odbc_num_rows($rsConspasCodAtivo);
				if($contarConspasCodAtivo==0){
								$valida=1;
								$countError++;
								$errorMsg.='Erro['.$countError.']: Passageiro inexistente ou inativo.\\n';
			}
				//Fim validação usuário
				
				}
				//Fim da validação do campo Usuario
		
		//Inicio da validação do campo Cargo		
		if(!empty($_POST['cargoPas'])){
		$cargoPas=$_POST['cargoPas'];
		$cargoPas=str_replace("'","\"",$cargoPas);
		}
		//Fim da validação do campo cargo
		if($teste==0){
		$inicioPas=converteData($_POST['inicioPas']);
		}else{
			$inicioPas=$_POST['inicioPas'];
			}
		$inicioPas=str_replace("'","\"",$inicioPas);

//Inicio da validação do campo Inicio (data)
		if(empty($inicioPas)){
								$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de partida.\\n';
			}
		//Fechou
		
        $horaPtPas=$_POST['horaPtPas'];
		$horaPtPas=str_replace("'","\"",$horaPtPas);
		//Abriu
		if(empty($horaPtPas)){
								$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe hora de partida.\\n';
			}elseif($_POST['horaPtPas']>23){
						$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Hora de partida inv\u00e1lida.\\n';	
			}else{
				
	      $minutoPtPas=$_POST['minutoPtPas'];
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
				}
			}
		
		//Ok
		
		$horaRetPas='';
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
		
		if(!empty($_POST['fimPas'])){
		
		$fimPas=$_POST['fimPas'];
		$fimPas=str_replace("'","\"",$fimPas);
		if($teste==0){
		$fimPas="CAST('".converteData($fimPas)."' AS DATETIME)";
		}else{
			$fimPas="CAST('".$fimPas."' AS DATETIME)";
			}
		if(empty($_POST['horaRetPas']) || empty($_POST['minutoRetPas'])){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a hora de retorno em viagens de ida e volta.\\n';
			}elseif($_POST['fimPas']==$_POST['inicioPas']){
				if($horaRetPas<$horaPtPas){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A hora de retorno deve ser superior a de partida em viagens no mesmo dia.\\n';
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
		$valorPas=str_replace(",",".",$valorPas);			
        $valorPas=(float)$valorPas;
		$valorPas=str_replace("'","\"",$valorPas);
		$trechoPas=$_POST['trechoPas'];
		$trechoPas=str_replace("'","\"",$trechoPas);
		$obsPas=$_POST['obsPas'];
		$obsPas=str_replace("'","\"",$obsPas);
		    if(empty($valorPas)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
			if($valida==0){
			$vlAntPas=$_POST['valorAnt'];
			$sqlPasValor=odbc_exec($conCab,"select valor from TEITEMSOLPASSAGEM (nolock) where Cd_solicitacao=".$solicitacao." and Sequencia=".$sequencia."") or die(odbc_error());
			$totalPas=0;
			$contador=0;
			while($objPasValor=odbc_fetch_object($sqlPasValor)){
				$totalPas=$totalPas+(float)$objPasValor->valor;
				$contador++;
				}
			$valorFuturoPas=(($totalPas-(float)$vlAntPas)+$valorPas)/$contador;
			$updItem=odbc_exec($conCab,"UPDATE COISOLIC SET pr_unitario='".$valorFuturoPas."' WHERE Cd_solicitacao=".$solicitacao." AND Sequencia=".$sequencia."") or die("<p>".odbc_errormsg());
		$sqlPasNova="UPDATE TEITEMSOLPASSAGEM SET
   cd_empresa='".$pasCod."',
   dt_partida=CAST('".$inicioPas."' AS DATETIME),
   hr_partida='".$horaPtPas."',
   dt_chegada=".$fimPas.",
   hr_chegada='".$horaRetPas."',
   cadeirante=".$cadeirantePas.",
   observacao='".$obsPas."',
   trecho='".$trechoPas."',
   usu_modificacao='".$usuario."',
   dt_modificacao=dbo.CGFC_DATAATUAL(),
   hr_modificacao='".date("His")."',
   valor=".$valorPas.",
   cargo='".$cargoPas."'
   WHERE id_registro='".$id."'";
	$resPasNovo = odbc_exec($conCab, $sqlPasNova) or die("<p>".odbc_errormsg());	
		if($resPasNovo && $updItem){
		?>
       <script type="text/javascript">

       alert("Item Atualizado com sucesso.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
		    }}else{
				?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
				}
		}elseif($hotel==1){
		$hotCod=trim($_POST['hotCod']);
		$arhotCod = explode('-', $hotCod);
		$hotCod=$arhotCod[0];
		$hotCod=str_replace("'","\"",$hotCod);
		if(empty($hotCod)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o h\\u00f3spede.\\n';
			}else{
				$sqlConsHotCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$hotCod."'
							and ativo = 1";
	$rsConshotCodAtivo = odbc_exec($conCab,$sqlConsHotCodAtivo) or die(odbc_error());
	$contarConshotCodAtivo=odbc_num_rows($rsConshotCodAtivo);
				if($contarConshotCodAtivo==0){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: H\\u00f3spede inexistente ou inativo.\\n';
					}
				}
		if(!empty($_POST['cargoHot'])){
		$cargoHot=$_POST['cargoHot'];
		$cargoHot=str_replace("'","\"",$cargoHot);
		}
		if($teste==0){
		$inicioHot=converteData($_POST['inicioHot']);	
			}else{
				$inicioHot=$_POST['inicioHot'];
				}
		
		$inicioHot=str_replace("'","\"",$inicioHot);
		if(empty($inicioHot)){
					$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe data inicial.\\n';
			}
			if($teste==0){
		$fimHot=converteData($_POST['fimHot']);
			}else{
				$fimHot=$_POST['fimHot'];
				}
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
		$rlHot=$_POST['rlHot'];
		$rlHot=str_replace("'","\"",$rlHot);
			if($valida==0){
		$sqlHot="UPDATE TEITEMSOLHOTEL
		SET cd_empresa='".$hotCod."',
   reserva='".$rlHot."',
   dt_entrada=CAST('".$inicioHot."' AS DATETIME),    --  dt_inicio  datetime 
   dt_saida=CAST('".$fimHot."' AS DATETIME),    --  dt_fim  datetime
   usu_modificacao='".$usuario."',
   dt_modificacao=dbo.CGFC_DATAATUAL(),
   hr_modificacao='".date("His")."',
   cargo='".$cargoHot."'
   WHERE id_registro='".$id."'
   ";
	$resHot = odbc_exec($conCab, $sqlHot) or die("<p>".odbc_errormsg());	
		if($resHot){
		?>
       <script type="text/javascript">
       alert("Item Atualizado com sucesso.");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
		    }
			}else{
				?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="ciWItensExclusivosAt.php";
       </script>
       <?php
				}
		}
		?>
