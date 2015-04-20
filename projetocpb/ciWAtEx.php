<?php
require "conect.php";
require "conectsqlserverci.php";
odbc_autocommit($conCab,FALSE);
session_start();
$teste=0;
$countError=0;
$errorMsg='';
if(empty($_POST['valid'])){
	$retornar="ciWItensExclusivos.php";
	}else{
		$retornar="ciWItensExclusivosAt.php";
		}
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
$rpa=$_POST['rpa'];
$diaria=$_POST['diaria'];
$passagem=$_POST['passagem'];
$hotel=$_POST['hotel'];
$nova=$_POST['nova'];
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
$fimPas='null';
$horaRetPas='';
$valorPas='';
$trechoPas='';
if(isset($_POST['cadeirantePas'])){ $cadeirantePas=1; $_SESSION['cadeiranteS']=1;}else{ $cadeirantePas=0;}
$obsPas='';
$hotCod='';
$inicioHot='';
$fimHot='';
$rlHot='';
$cargoHot='';
$contador=0;
$validaErro=0;
if($nova==1){
	$contador=1;
	$tipo=$_POST['tipo'];
	if($tipo=='rpa'){
		//Recebendo o Beneficiário do RPA
		$rpaCod=trim($_POST['rpaCod']); 
		$_SESSION['codRpaS']=$rpaCod;
		$arRpaCod = explode('-', $rpaCod);
		$rpaCod=$arRpaCod[0];
		$rpaCod=str_replace("'","\"",$rpaCod);
		
        //Recebendo o cargo novo (caso houver) do beneficiário
		if(!empty($_POST['cargoRpa'])){
		$cargoRpa=$_POST['cargoRpa'];
		$_SESSION['cargoRpaS']=$cargoRpa;
		$cargoRpa=str_replace("'","\"",$cargoRpa);
		}
		
		//Recebendo o início do RPA
		if($teste==0){
		$inicioRPA=converteData($_POST['inicioRpa']);
		}else{
		$inicioRPA=$_POST['inicioRpa'];
		}
		$_SESSION['inicioRpaS']=$_POST['inicioRpa'];
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		
		//Recebendo final RPA
		if($teste==0){
		$fimRPA=converteData($_POST['fimRpa']);
			}else{
		$fimRPA=$_POST['fimRpa'];
		}
		$_SESSION['fimRpaS']=$_POST['fimRpa'];
		$fimRPA=str_replace("'","\"",$fimRPA);
		
		//Recebendo valor RPA
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$_SESSION['vlRpaS']=$_POST['valorRpa'];
		$valorRpa=str_replace("'","\"",$valorRpa);
		
		//Validando Beneficiario RPA
		if(empty($rpaCod)){
	   $countError++;
	   $errorMsg.='Erro['.$countError.']: Informe o benefici\\u00e1rio.\\n';
	   $validaErro=1;
			
			}else{
				$validaErro=0;
				$sqlConsrpaCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$rpaCod."'
							and ativo = 1";
	$rsConsrpaCodAtivo = odbc_exec($conCab,$sqlConsrpaCodAtivo) or die(odbc_error());
	$contarConsrpaCodAtivo=odbc_num_rows($rsConsrpaCodAtivo);
				if($contarConsrpaCodAtivo==0){
					$validaErro=1;
					 $countError++;
					 $errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inexistente. Selecione na lista.\\n';
					}else{
					$validaErro=0;
						}
			}
	//Valida Inicio RPA
	if(empty($inicioRPA)){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de in\\u00edcio.\\n';
			}
	   //Valida FIM RPA
	   if(empty($fimRPA)){
		   $validaErro=1;
		   $countError++;
		   $errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			
	//Valida inicio e fim do RPA (maior ou igual)
	if($fimRPA<$inicioRPA){
					$validaErro=1;
					 $countError++;
					 $errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
	
	//Valida Valor
	if($valorRpa=='0.00' || empty($valorRpa)){
		$validaErro=1;
		$countError++;
		 $errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
	//Inicia a inserção caso o validaErro seja 0
	if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
		$sqlConsidRPA="select MAX(id_registro) as id from TEITEMSOLRPA (nolock)";
		$rsConsidRPA = odbc_exec($conCab,$sqlConsidRPA) or die(odbc_error());
		$arrayConsidRPA = odbc_fetch_array($rsConsidRPA);
		$idRpaNova=$arrayConsidRPA['id']+1;
		$sqlRPANova="insert into TEITEMSOLRPA(
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
   ".$idRpaNova.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$rpaCod."',                     --  cd_empresa  char(6)
   CAST('".$inicioRPA."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimRPA."' AS DATETIME),    --  dt_fim  datetime 
   ".$valorRpa.",                         --  valor  float 
   0,                            --  cd_lancamento  float 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   '".$cargoRpa."'                   --  cargo varchar(40)
   )";
	$resRPANovo = odbc_exec($conCab, $sqlRPANova) or die("<p>".odbc_errormsg());
		//Atualizar o Valor do item em relação ao RPA
		$vlUnitRpa=0;
		$contRpaVl=0;
		$buscarVLUnitRPA=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLRPA (nolock)  WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
		//Faz um laço para calcular a média de valor e quantidade
		while($objValorRpa=odbc_fetch_object($buscarVLUnitRPA)){
			$contRpaVl++;
			$vlUnitRpa=($vlUnitRpa+$objValorRpa->valor);
			}
		$vlUnitRpa=$vlUnitRpa/$contRpaVl;
		//Atualiza o Item com os novos valores (Valor unitário médio e quantidade)
		$updItemRpaNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contRpaVl.", qt_saldo=".$contRpaVl.", pr_unitario='".(float)$vlUnitRpa."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
		//Verifica se as atualizações foram bem sucedidas
		if($resRPANovo && $updItemRpaNovo){
			//Da commit na transação
			if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['vlRpaS']='';
				  $_SESSION['fimRpaS']='';
				  $_SESSION['inicioRpaS']='';
				  $_SESSION['cargoRpaS']='';
				  $_SESSION['codRpaS']=''; 
			   //Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="<?php echo $retornar; ?>";
       				</script>
       				<?php
					  }
				 }
			}	
	//Fechamento item novo RPA
	}
	//Inicio do item novo Diaria
	elseif($tipo=='diaria'){
		//Recebe o beneficiario da Diaria
		$diaCod=trim($_POST['diaCod']);
		$_SESSION['codDiaS']=$diaCod;
		$ardiaCod = explode('-', $diaCod);
		$diaCod=$ardiaCod[0];
		$diaCod=str_replace("'","\"",$diaCod);
		
		//Recebe o cargo caso exista
		if(!empty($_POST['cargoDia'])){
		$cargoDia=$_POST['cargoDia'];
		$_SESSION['cargoDiaS']=$cargoDia;
		$cargoDia=str_replace("'","\"",$cargoDia);
		}
		
		//Recebe a data de in\\u00edcio
		if($teste==0){
		$inicioDia=converteData($_POST['inicioDia']);
		}else{
		$inicioDia=$_POST['inicioDia'];
		}
		$_SESSION['inicioDiaS']=$_POST['inicioDia'];
		$inicioDia=str_replace("'","\"",$inicioDia);
		
		//Recebe fim da diaria
			if($teste==0){
		$fimDia=converteData($_POST['fimDia']);
			}else{
		$fimDia=$_POST['fimDia'];
			}
		$_SESSION['fimDiaS']=$_POST['fimDia'];
		$fimDia=str_replace("'","\"",$fimDia);
		
		//Recebe o valor da diaria
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;
		$_SESSION['vlDiaS']=$_POST['valorDia'];
		
		//Inicia as validações - Beneficiario
		if(empty($diaCod)){
			$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe o benefici\\u00e1rio.\\n';
			}else{
				
				$validaErro=0;
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$diaCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				$sqlConsdiaCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$diaCod."'
							and ativo = 1";
				$rsConsdiaCodAtivo = odbc_exec($conCab,$sqlConsdiaCodAtivo) or die(odbc_error());
				$contarConsdiaCodAtivo=odbc_num_rows($rsConsdiaCodAtivo);
				if($contarConsdiaCodAtivo==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inativo.\\n';
					}else{
						$validaErro=0;
						}
				}
		//Valida inicio e fim da diaria
		if(empty($inicioDia)){
		$validaErro=1;
		$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';
			}
		if(empty($fimDia)){
			$validaErro=1;
			$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if($fimDia<$inicioDia){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
			//Valida valor da diaria
			if(empty($valorDia) || $valorDia=='0.00'){
				$validaErro=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
			//Caso o validaErro retorne 0 inicia as insercoes
			if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
				
			$sqlConsidDia="select MAX(id_registro) as id from TEITEMSOLDIARIAVIAGEM (nolock)";
			$rsConsidDia = odbc_exec($conCab,$sqlConsidDia) or die(odbc_error());
			$arrayConsidDia = odbc_fetch_array($rsConsidDia);
			$idDiaNova=$arrayConsidDia['id']+1;
		$sqlDiaNova="insert into TEITEMSOLDIARIAVIAGEM(
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
				   ".$idDiaNova.",                           --  id_registro  int 
				   ".$solicitacao.",                          --  cd_solicitacao  float 
				   ".$sequencia.",                            --  sequencia  real 
				   '".$diaCod."',                     --  cd_empresa  char(6)
				   CAST('".$inicioDia."' AS DATETIME),    --  dt_inicio  datetime 
				   CAST('".$fimDia."' AS DATETIME),    --  dt_fim  datetime 
				   ".$valorDia.",                         --  valor  float 
				   0,                            --  cd_lancamento  float 
				   '".$usuario."',                        --  usu_criacao  char(3)
				   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
				   '".date("His")."',                     --  hr_criacao  char(6)
				   '   ',                        --  usu_modificacao  char(3)
				   NULL,                       --  dt_modificacao  datetime 
				   'NULL',                       --  hr_modificacao  char(6)
				   '".$cargoDia."'                   --  cargo varchar(40)
				   )";
					$resDiaNovo = odbc_exec($conCab, $sqlDiaNova) or die("<p>".odbc_errormsg());
				//Atualiza o item conforme os exclusivos
				$vlUnitDia=0;
				$contDiaVl=0;
				$buscarVLUnitDia=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLDIARIAVIAGEM (nolock)  WHERE solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				//Inicia um laço para buscar os valores e quantidade
				while($objValorDia=odbc_fetch_object($buscarVLUnitDia)){
		$contDiaVl++;
		$vlUnitDia=($vlUnitDia+$objValorDia->valor);
		}
		$vlUnitDia=$vlUnitDia/$contDiaVl;
		//Atualiza o item
		$updItemDiaNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contDiaVl.", qt_saldo=".$contDiaVl.", pr_unitario='".(float)$vlUnitDia."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
		if($resDiaNovo && $updItemDiaNovo){
		//Da commit na transação
			if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['vlDiaS']='';
				  $_SESSION['fimDiaS']='';
				  $_SESSION['inicioDiaS']='';
				  $_SESSION['cargoDiaS']='';
				  $_SESSION['codDiaS']=''; 
			   //Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
      				 <script type="text/javascript">
       					alert("<?php echo $errorMsg; ?>");
       					window.location="<?php echo $retornar; ?>";
       				 </script>
       <?php
					  }
				 }
			}			
		//Fechamento do item novo Diaria
		}
		
		//Inicia o item novo 
		elseif($tipo=='passagem'){
			//recebe o beneficiario
			$pasCod=trim($_POST['pasCod']);
			$_SESSION['codPasS']=$_POST['pasCod'];
			$arpasCod = explode('-', $pasCod);
			$pasCod=$arpasCod[0];
			$pasCod=str_replace("'","\"",$pasCod);
		
		//Recebe o cargo do beneficiario
			if(!empty($_POST['cargoPas'])){
			$cargoPas=$_POST['cargoPas']; 
			$_SESSION['cargoPasS']=$_POST['cargoPas'];
			$cargoPas=str_replace("'","\"",$cargoPas);
			}
			
		//Recebe a data de in\\u00edcio passagem
		    if($teste==0){
				$inicioPas=converteData($_POST['inicioPas']);
			}else{
				$inicioPas=$_POST['inicioPas'];
			}
			
			$_SESSION['inicioPasS']=$_POST['inicioPas'];
			$inicioPas=str_replace("'","\"",$inicioPas);
		
		//Recebe hora e minuto de partida
			$horaPtPas=$_POST['horaPtPas'];
			$_SESSION['horaInicioS']=$_POST['horaPtPas'];
			$horaPtPas=str_replace("'","\"",$horaPtPas);
		
			$minutoPtPas=$_POST['minutoPtPas'];
			$_SESSION['minutoInicioS']=$_POST['minutoPtPas'];
			$minutoPtPas=str_replace("'","\"",$minutoPtPas);
		
		//Data de retorno Passagem
			if(!empty($_POST['fimPas'])){	
				
				$fimPas=$_POST['fimPas'];
				$_SESSION['fimPasS']=$_POST['fimPas'];
				$fimPas=str_replace("'","\"",$fimPas);
				if($teste==0){
					$fimPas="CAST('".converteData($fimPas)."' AS DATETIME)";
				}else{
					$fimPas="CAST('".$fimPas."' AS DATETIME)";
				}
			}
			
		//Recebe hora e minuto de retorno
			$horaRetPas=$_POST['horaRetPas'].$_POST['minutoRetPas']."00"; 
			$_SESSION['horaFimS']=$_POST['horaRetPas'];
			$horaRetPas=str_replace("'","\"",$horaRetPas);

			$minutoRetPas=$_POST['minutoRetPas']; 
			if(empty($_POST['minutoRetPas'])){
				$minutoRetPas='00';
				}else{
					$minutoRetPas=$_POST['minutoRetPas'];
					}
			$_SESSION['minutoFimS']=$_POST['minutoRetPas'];
			$minutoRetPas=str_replace("'","\"",$minutoRetPas);
		
		//Recebe o valor da passagem
			$valorPas=str_replace(".","",$_POST['valorPas']);
			$valorPas=str_replace(",",".",$valorPas);$_SESSION['vlPasS']=$_POST['valorPas'];
			$valorPas=str_replace("'","\"",$valorPas);
			
		//Recebe o trecho da passagem
			$trechoPas=$_POST['trechoPas']; 
			$_SESSION['trechoS']=$_POST['trechoPas'];
			$trechoPas=str_replace("'","\"",$trechoPas);
		
		//Recebe o observação da passgem	
			$obsPas=$_POST['obsPas']; 
			$_SESSION['obsPasS']=$_POST['obsPas'];
		    $obsPas=str_replace("'","\"",$obsPas);
		
		//Vincula a Hora Inicio
				$horaPtPas=$_POST['horaPtPas'].$minutoPtPas."00";
				$horaPtPas=str_replace("'","\"",$horaPtPas);
		
		//Inicia as validações - Beneficiario
		if(empty($pasCod)){
				$validaErro=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o passageiro.\\n';
			}else{
				$validaErro=0;
				//Inicio Validação Usuario
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$pasCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				$sqlConspasCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$pasCod."'
							and ativo = 1";
				$rsConspasCodAtivo = odbc_exec($conCab,$sqlConspasCodAtivo) or die(odbc_error());
				$contarConspasCodAtivo=odbc_num_rows($rsConspasCodAtivo);
				if($contarConspasCodAtivo==0 && $validaErro==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Passageiro inativo.\\n';
					}
			     }
			//Validação	 inicio Data
			if(empty($inicioPas)){
				$validaErro=1;
				$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';
			}
			//Validação de hora de inicio
			if(empty($horaPtPas)){
				$validaErro=1;
				$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a hora de partida.\\n';
                }elseif($_POST['horaPtPas']>23){
				$validaErro=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Hora de partida inv\\u00e1lida.\\n';
			   }
			//Validação de minuto de inicio
			if(empty($minutoPtPas)){
				$minutoPtPas='00';
		  }elseif($minutoPtPas>59){
			  $validaErro=1;
			  $countError++;
			  $errorMsg.='Erro['.$countError.']: Minuto de partida inv\\u00e1lido.\\n';
				}
				
				//Validacao de data de retorno
		       if(!empty($_POST['fimPas'])){
				   if(empty($_POST['horaRetPas'])){
				       $validaErro=1;
					   $countError++;
					   $errorMsg.='Erro['.$countError.']: Hora de retorno obrigat\\u00f3ria, caso informe a data de retorno.\\n';
						}elseif($_POST['horaRetPas']>23){
							$validaErro=1;
							$countError++;
							$errorMsg.='Erro['.$countError.']: Hora de retorno inv\\u00e1lida.\\n';
								}elseif($_POST['minutoRetPas']>59){
										$validaErro=1;
										$countError++;
										$errorMsg.='Erro['.$countError.']: Minuto de retorno inv\\u00e1lido.\\n';
										}elseif(converteData($_POST['fimPas'])<converteData($_POST['inicioPas'])){
						   				$validaErro=1;
										$countError++;
										$errorMsg.='Erro['.$countError.']: A data de retorno deve ser igual ou superior a de partida.\\n';
						   			}elseif($_POST['fimPas']==$_POST['inicioPas']){
										if($horaRetPas<$horaPtPas){
											$validaErro=1;
											$countError++;
											$errorMsg.='Erro['.$countError.']: Em caso de viagem no mesmo dia, a hora de retorno deve ser superior a de partida.\\n';										}
										}	   
					   				}
			//Validacao do valor
			if(empty($valorPas) || $valorPas=='0.00'){
					$validaErro=1;
					$countError++;
	       			$errorMsg.='Erro['.$countError.']: Informe o valor da passagem.\\n';				
			}
			//Verifica se o validaErro retorna 0 para iniciar as inclusoes
		    if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
			$sqlConsidPas="select MAX(id_registro) as id from TEITEMSOLPASSAGEM (nolock)";
			$rsConsidPas= odbc_exec($conCab,$sqlConsidPas) or die(odbc_error());
			$arrayConsidPas = odbc_fetch_array($rsConsidPas);
			$idPasNova=$arrayConsidPas['id']+1;
			$sqlPasNova="insert into TEITEMSOLPASSAGEM(
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
						   ".$idPasNova.",                           --  id_registro  int 
						   ".$solicitacao.",                          --  cd_solicitacao  float 
						   ".$sequencia.",                            --  sequencia  real 
						   '".$pasCod."',                     --  cd_empresa  char(6)
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
						   '".$cargoPas."'                   --  cargo varchar(40)
						   )";
				$resPasNovo = odbc_exec($conCab, $sqlPasNova) or die("<p>".odbc_errormsg());
				//Inicia para atualizar o valor do item
				$vlUnitPas=0;
				$contPasVl=0;
				$buscarVLUnitPas=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLPASSAGEM (nolock)  WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				//Faz laço para buscar media de valor unitario e quantidade
				while($objValorPas=odbc_fetch_object($buscarVLUnitPas)){
					 $contPasVl++;
					 $vlUnitPas=($vlUnitPas+$objValorPas->valor);
					}
					$vlUnitPas=$vlUnitPas/$contPasVl;
				//Atualiza o item
				$updItemPasNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contPasVl.", qt_saldo=".$contPasVl.", pr_unitario='".(float)$vlUnitPas."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
				//Verifica se as funções de atualização tiveram sucesso
				if($resPasNovo && $updItemPasNovo){
					//Da commit na transação
				  if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['codPasS']='';
  				  $_SESSION['cargoPasS']='';
				  $_SESSION['inicioPasS']='';
				  $_SESSION['fimPasS']='';
				  $_SESSION['vlPasS']='';
				  $_SESSION['horaInicioS']='';
				  $_SESSION['minutoInicioS']='';
				  $_SESSION['horaFimS']='';
				  $_SESSION['minutoFimS']='';
				  $_SESSION['obsPasS']='';
				  $_SESSION['cadeiranteS']='';
				  $_SESSION['trechoS']='';				  
			   //Caso ela não tenha sucesso
				}else{
					odbc_rollback($conCab);
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
					  }
				  }
			}
		//Fchamento do item novo passagem
		}
		//Inicia o item novo hotel
		elseif($tipo=='hotel'){
			//Recebe o hospede
			$hotCod=trim($_POST['hotCod']);  
			$_SESSION['codHotS']=$_POST['hotCod'];
			$arhotCod = explode('-', $hotCod);
			$hotCod=$arhotCod[0];
			$hotCod=str_replace("'","\"",$hotCod);
			
			//Inicio do Cargo Hotel
			if(!empty($_POST['cargoHot'])){
			$cargoHot=$_POST['cargoHot']; 
			$_SESSION['cargoHotS']=$_POST['cargoHot'];
			$cargoHot=str_replace("'","\"",$cargoHot);
			}
			
			//Recebe inicio Hotel
			if($teste==0){
				$inicioHot=converteData($_POST['inicioHot']);
			}else{
				$inicioHot=$_POST['inicioHot'];
			} 
			$_SESSION['inicioHotS']=$_POST['inicioHot'];
			$inicioHot=str_replace("'","\"",$inicioHot);
			
			//Recebe fim Hotel
			if($teste==0){
				$fimHot=converteData($_POST['fimHot']);
			}else{
				$fimHot=$_POST['fimHot'];	
			}
			$_SESSION['fimHotS']=$_POST['fimHot'];
			$fimHot=str_replace("'","\"",$fimHot);
			
			//Recebe a reserva hotel
			$rlHot=$_POST['rlHot']; 
			$_SESSION['rlHotS']=$_POST['rlHot'];
			$rlHot=str_replace("'","\"",$rlHot);
			
			//Inicia as validações Hotel
			if(empty($hotCod)){
			$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe o h\\u00f3spede.\\n';
			
			}else{
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$hotCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				$sqlConsHotCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$hotCod."'
							and ativo = 1";
				$rsConshotCodAtivo = odbc_exec($conCab,$sqlConsHotCodAtivo) or die(odbc_error());
				$contarConshotCodAtivo=odbc_num_rows($rsConshotCodAtivo);
				if($contarConshotCodAtivo==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: H\\u00f3spede inexiste ou inativo.\\n';
					}
				}
			
			//Valida Data inicial e final
			if(empty($inicioHot)){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a data de in\\u00edcio.\\n';
					}
		
		if(empty($fimHot)){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
	   }
	   if($fimHot<$inicioHot){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
			//Caso o validaErro retorne 0 inicio os inserts			
			if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
				$sqlConsidHot="select MAX(id_registro) as id from TEITEMSOLHOTEL (nolock)";
			$rsConsidHot = odbc_exec($conCab,$sqlConsidHot) or die(odbc_error());
			$arrayConsidHot = odbc_fetch_array($rsConsidHot);
			$idHotNova=$arrayConsidHot['id']+1;
		$sqlHotNova="insert into TEITEMSOLHOTEL(
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
					   ".$idHotNova.",                           --  id_registro  int 
					   ".$solicitacao.",                          --  cd_solicitacao  float 
					   ".$sequencia.",                            --  sequencia  real 
					   '".$hotCod."',                     --  cd_empresa  char(6)
					   '".$rlHot."',
					   CAST('".$inicioHot."' AS DATETIME),    --  dt_inicio  datetime 
					   CAST('".$fimHot."' AS DATETIME),    --  dt_fim  datetime 
					   '".$usuario."',                        --  usu_criacao  char(3)
					   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
					   '".date("His")."',                     --  hr_criacao  char(6)
					   '   ',                        --  usu_modificacao  char(3)
					   NULL,                       --  dt_modificacao  datetime 
					   'NULL',                       --  hr_modificacao  char(6)
					   '".$cargoHot."'                   --  cargo varchar(40)
					   )";
						$resHotNovo = odbc_exec($conCab, $sqlHotNova) or die("<p>".odbc_errormsg());
				//Inicia a contagem de quantos itens tem
				$contHotVl=0;
				$buscarVLUnitHot=odbc_exec($conCab,"SELECT sequencia FROM TEITEMSOLHOTEL (nolock)  WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				$contHotVl=odbc_num_rows($buscarVLUnitHot);
				//Atualiza o item
				$updItemHotNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contHotVl.", qt_saldo=".$contHotVl." WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
				//Verifica se as funções de atualização tiveram sucesso
				if($resHotNovo && $updItemHotNovo){
					//Da commit na transação
				  if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
			   		$_SESSION['codHotS']='';
					$_SESSION['cargoHotS']='';
				    $_SESSION['rlHotS']='';
					$_SESSION['fimHotS']='';
					$_SESSION['inicioHotS']='';
					//Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
       				<script type="text/javascript">
       					alert("<?php echo $errorMsg; ?>");
       					window.location="<?php echo $retornar; ?>";
       				</script>
       				<?php
					  }
				  }
				}
			//Fechamento do item novo hotel
			}
//Fechamento de item NOVO Geral
}
//Inicia a insercao de itens com RPA
elseif($rpa==1){
//Recebendo o Beneficiário do RPA
		$rpaCod=trim($_POST['rpaCod']); 
		$_SESSION['codRpaS']=$rpaCod;
		$arRpaCod = explode('-', $rpaCod);
		$rpaCod=$arRpaCod[0];
		$rpaCod=str_replace("'","\"",$rpaCod);
		
        //Recebendo o cargo novo (caso houver) do beneficiário
		if(!empty($_POST['cargoRpa'])){
		$cargoRpa=$_POST['cargoRpa'];
		$_SESSION['cargoRpaS']=$cargoRpa;
		$cargoRpa=str_replace("'","\"",$cargoRpa);
		}
		
		//Recebendo o início do RPA
		if($teste==0){
		$inicioRPA=converteData($_POST['inicioRpa']);
		}else{
		$inicioRPA=$_POST['inicioRpa'];
		}
		$_SESSION['inicioRpaS']=$_POST['inicioRpa'];
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		
		//Recebendo final RPA
		if($teste==0){
		$fimRPA=converteData($_POST['fimRpa']);
			}else{
		$fimRPA=$_POST['fimRpa'];
		}
		$_SESSION['fimRpaS']=$_POST['fimRpa'];
		$fimRPA=str_replace("'","\"",$fimRPA);
		
		//Recebendo valor RPA
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$_SESSION['vlRpaS']=$_POST['valorRpa'];
		$valorRpa=str_replace("'","\"",$valorRpa);
		
		//Validando Beneficiario RPA
		if(empty($rpaCod)){
			   $validaErro=1;
			   $countError++;
			   $errorMsg.='Erro['.$countError.']: Informe o benefici\\u00e1rio.\\n';
			}else{
				$validaErro=0;
				$sqlConsrpaCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$rpaCod."'
							and ativo = 1";
	$rsConsrpaCodAtivo = odbc_exec($conCab,$sqlConsrpaCodAtivo) or die(odbc_error());
	$contarConsrpaCodAtivo=odbc_num_rows($rsConsrpaCodAtivo);
				if($contarConsrpaCodAtivo==0){
					$validaErro=1;
					$countError++;
			   		$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inexistente ou inativo.\\n';
					
					}else{
					
					$validaErro=0;
					
					}
			}
	//Valida Inicio RPA
	if(empty($inicioRPA)){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Selecione a data de in\\u00edcio.\\n';			
			}
	   //Valida FIM RPA
	   if(empty($fimRPA)){
		   $validaErro=1;
		   $countError++;
		   $errorMsg.='Erro['.$countError.']: Selecione a data final.\\n';
			}
	//Valida inicio e fim do RPA (maior ou igual)
	if($fimRPA<$inicioRPA){
					$validaErro=1;
					$countError++;
			   		$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
	
	//Valida Valor
	if($valorRpa=='0.00' || empty($valorRpa)){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
	//Inicia a inserção caso o validaErro seja 0
	if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
		$sqlConsidRPA="select MAX(id_registro) as id from TEITEMSOLRPA (nolock)";
		$rsConsidRPA = odbc_exec($conCab,$sqlConsidRPA) or die(odbc_error());
		$arrayConsidRPA = odbc_fetch_array($rsConsidRPA);
		$idRpaNova=$arrayConsidRPA['id']+1;
		$sqlRPANova="insert into TEITEMSOLRPA(
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
   ".$idRpaNova.",                           --  id_registro  int 
   ".$solicitacao.",                          --  cd_solicitacao  float 
   ".$sequencia.",                            --  sequencia  real 
   '".$rpaCod."',                     --  cd_empresa  char(6)
   CAST('".$inicioRPA."' AS DATETIME),    --  dt_inicio  datetime 
   CAST('".$fimRPA."' AS DATETIME),    --  dt_fim  datetime 
   ".$valorRpa.",                         --  valor  float 
   0,                            --  cd_lancamento  float 
   '".$usuario."',                        --  usu_criacao  char(3)
   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
   '".date("His")."',                     --  hr_criacao  char(6)
   '   ',                        --  usu_modificacao  char(3)
   NULL,                       --  dt_modificacao  datetime 
   'NULL',                       --  hr_modificacao  char(6)
   '".$cargoRpa."'                   --  cargo varchar(40)
   )";
	$resRPANovo = odbc_exec($conCab, $sqlRPANova) or die("<p>".odbc_errormsg());
		//Atualizar o Valor do item em relação ao RPA
		$vlUnitRpa=0;
		$contRpaVl=0;
		$buscarVLUnitRPA=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLRPA (nolock)  WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
		//Faz um laço para calcular a média de valor e quantidade
		while($objValorRpa=odbc_fetch_object($buscarVLUnitRPA)){
			$contRpaVl++;
			$vlUnitRpa=($vlUnitRpa+$objValorRpa->valor);
			}
		$vlUnitRpa=$vlUnitRpa/$contRpaVl;
		//Atualiza o Item com os novos valores (Valor unitário médio e quantidade)
		$updItemRpaNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contRpaVl.", qt_saldo=".$contRpaVl.", pr_unitario='".(float)$vlUnitRpa."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
		//Verifica se as atualizações foram bem sucedidas
		if($resRPANovo && $updItemRpaNovo){
			//Da commit na transação
			if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['vlRpaS']='';
				  $_SESSION['fimRpaS']='';
				  $_SESSION['inicioRpaS']='';
				  $_SESSION['cargoRpaS']='';
				  $_SESSION['codRpaS']=''; 
			   //Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="<?php echo $retornar; ?>";
       				</script>
       				<?php
					  }
				 }
			}
//Finaliza a insercao de itens com RPA
}
//Inicia  a insercao de itens Diaria
elseif($diaria==1){
	//Recebe o beneficiario da Diaria
		$diaCod=trim($_POST['diaCod']);
		$_SESSION['codDiaS']=$diaCod;
		$ardiaCod = explode('-', $diaCod);
		$diaCod=$ardiaCod[0];
		$diaCod=str_replace("'","\"",$diaCod);
		
		//Recebe o cargo caso exista
		if(!empty($_POST['cargoDia'])){
		$cargoDia=$_POST['cargoDia'];
		$_SESSION['cargoDiaS']=$cargoDia;
		$cargoDia=str_replace("'","\"",$cargoDia);
		}
		
		//Recebe a data de in\\u00edcio
		if($teste==0){
		$inicioDia=converteData($_POST['inicioDia']);
		}else{
		$inicioDia=$_POST['inicioDia'];
		}
		$_SESSION['inicioDiaS']=$_POST['inicioDia'];
		$inicioDia=str_replace("'","\"",$inicioDia);
		
		//Recebe fim da diaria
			if($teste==0){
		$fimDia=converteData($_POST['fimDia']);
			}else{
		$fimDia=$_POST['fimDia'];
			}
		$_SESSION['fimDiaS']=$_POST['fimDia'];
		$fimDia=str_replace("'","\"",$fimDia);
		
		//Recebe o valor da diaria
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;$_SESSION['vlDiaS']=$_POST['valorDia'];
		
		//Inicia as validações - Beneficiario
		if(empty($diaCod)){
			$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Selecione o benefici\\u00e1rio.\\n';
			}else{
				$validaErro=0;
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$diaCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				$sqlConsdiaCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$diaCod."'
							and ativo = 1";
				$rsConsdiaCodAtivo = odbc_exec($conCab,$sqlConsdiaCodAtivo) or die(odbc_error());
				$contarConsdiaCodAtivo=odbc_num_rows($rsConsdiaCodAtivo);
				if($contarConsdiaCodAtivo==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio inexistente ou inativo.\\n';
					}else{
						$validaErro=0;
						}
				}
		//Valida inicio e fim da diaria
		if(empty($inicioDia)){
		$validaErro=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a data de in\\u00edcio.\\n';
			}
		if(empty($fimDia)){
			$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if($fimDia<$inicioDia){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
			//Valida valor da diaria
			if(empty($valorDia) || $valorDia=='0.00'){
				$validaErro=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
			//Caso o validaErro retorne 0 inicia as insercoes
			if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
				
			$sqlConsidDia="select MAX(id_registro) as id from TEITEMSOLDIARIAVIAGEM (nolock)";
			$rsConsidDia = odbc_exec($conCab,$sqlConsidDia) or die(odbc_error());
			$arrayConsidDia = odbc_fetch_array($rsConsidDia);
			$idDiaNova=$arrayConsidDia['id']+1;
		$sqlDiaNova="insert into TEITEMSOLDIARIAVIAGEM(
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
				   ".$idDiaNova.",                           --  id_registro  int 
				   ".$solicitacao.",                          --  cd_solicitacao  float 
				   ".$sequencia.",                            --  sequencia  real 
				   '".$diaCod."',                     --  cd_empresa  char(6)
				   CAST('".$inicioDia."' AS DATETIME),    --  dt_inicio  datetime 
				   CAST('".$fimDia."' AS DATETIME),    --  dt_fim  datetime 
				   ".$valorDia.",                         --  valor  float 
				   0,                            --  cd_lancamento  float 
				   '".$usuario."',                        --  usu_criacao  char(3)
				   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
				   '".date("His")."',                     --  hr_criacao  char(6)
				   '   ',                        --  usu_modificacao  char(3)
				   NULL,                       --  dt_modificacao  datetime 
				   'NULL',                       --  hr_modificacao  char(6)
				   '".$cargoDia."'                   --  cargo varchar(40)
				   )";
					$resDiaNovo = odbc_exec($conCab, $sqlDiaNova) or die("<p>".odbc_errormsg());
				//Atualiza o item conforme os exclusivos
				$vlUnitDia=0;
				$contDiaVl=0;
				$buscarVLUnitDia=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLDIARIAVIAGEM (nolock)  WHERE solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				//Inicia um laço para buscar os valores e quantidade
				while($objValorDia=odbc_fetch_object($buscarVLUnitDia)){
		$contDiaVl++;
		$vlUnitDia=($vlUnitDia+$objValorDia->valor);
		}
		$vlUnitDia=$vlUnitDia/$contDiaVl;
		//Atualiza o item
		$updItemDiaNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contDiaVl.", qt_saldo=".$contDiaVl.", pr_unitario='".(float)$vlUnitDia."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
		if($resDiaNovo && $updItemDiaNovo){
		//Da commit na transação
			if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['vlDiaS']='';
				  $_SESSION['fimDiaS']='';
				  $_SESSION['inicioDiaS']='';
				  $_SESSION['cargoDiaS']='';
				  $_SESSION['codDiaS']=''; 
			   //Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
					  }
				 }
			}			
	
	//Fim da insercao de itens Diaria
	}
	//Inicio da insercao de itens Passagem
	elseif($passagem==1){
		//recebe o beneficiario
			$pasCod=trim($_POST['pasCod']);
			$_SESSION['codPasS']=$_POST['pasCod'];
			$arpasCod = explode('-', $pasCod);
			$pasCod=$arpasCod[0];
			$pasCod=str_replace("'","\"",$pasCod);
		
		//Recebe o cargo do beneficiario
			if(!empty($_POST['cargoPas'])){
			$cargoPas=$_POST['cargoPas']; 
			$_SESSION['cargoPasS']=$_POST['cargoPas'];
			$cargoPas=str_replace("'","\"",$cargoPas);
			}
		//Recebe a data de in\\u00edcio passagem
		    if($teste==0){
				$inicioPas=converteData($_POST['inicioPas']);
			}else{
				$inicioPas=$_POST['inicioPas'];
			}
			$_SESSION['inicioPasS']=$_POST['inicioPas'];
			$inicioPas=str_replace("'","\"",$inicioPas);
		//Recebe hora e minuto de partida
			$horaPtPas=$_POST['horaPtPas'];
			$_SESSION['horaInicioS']=$_POST['horaPtPas'];
			$horaPtPas=str_replace("'","\"",$horaPtPas);
		    
			if(empty($_POST['minutoPtPas'])){
				$minutoPtPas='00';
				}else{
			$minutoPtPas=$_POST['minutoPtPas'];		
					}
			$_SESSION['minutoInicioS']=$_POST['minutoPtPas'];
			$minutoPtPas=str_replace("'","\"",$minutoPtPas);
		   
		//Data de retorno Passagem
			if(!empty($_POST['fimPas'])){	
				$fimPas=$_POST['fimPas'];
				$_SESSION['fimPasS']=$_POST['fimPas'];
				$fimPas=str_replace("'","\"",$fimPas);
				if($teste==0){
					$fimPas="CAST('".converteData($fimPas)."' AS DATETIME)";
				}else{
					$fimPas="CAST('".$fimPas."' AS DATETIME)";
				}
			}
		//Recebe hora e minuto de retorno
			$horaRetPas=$_POST['horaRetPas'].$_POST['minutoRetPas']."00"; 
			$_SESSION['horaFimS']=$_POST['horaRetPas'];
			$horaRetPas=str_replace("'","\"",$horaRetPas);
			
			if(empty($_POST['minutoRetPas'])){
			$minutoRetPas='00';	
				}else{
			$minutoRetPas=$_POST['minutoRetPas'];
			}
			$_SESSION['minutoFimS']=$_POST['minutoRetPas'];
			$minutoRetPas=str_replace("'","\"",$minutoRetPas);
		
		//Recebe o valor da passagem
			$valorPas=str_replace(".","",$_POST['valorPas']);
			$valorPas=str_replace(",",".",$valorPas);
			$_SESSION['vlPasS']=$_POST['valorPas'];
			$valorPas=str_replace("'","\"",$valorPas);
			
		//Recebe o trecho da passagem
			$trechoPas=$_POST['trechoPas']; 
			$_SESSION['trechoS']=$_POST['trechoPas'];
			$trechoPas=str_replace("'","\"",$trechoPas);
		
		//Recebe o observação da passgem	
			$obsPas=$_POST['obsPas']; 
			$_SESSION['obsPasS']=$_POST['obsPas'];
		    $obsPas=str_replace("'","\"",$obsPas);
		//Vincula a Hora Inicio
				$horaPtPas=$_POST['horaPtPas'].$minutoPtPas."00";
				$horaPtPas=str_replace("'","\"",$horaPtPas);
		
		//Inicia as validações - Beneficiario
		if(empty($pasCod)){
				$validaErro=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o passageiro';
				}else{
				$validaErro=0;
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$pasCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				//Inicio Validação Usuario
				$sqlConspasCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$pasCod."'
							and ativo = 1";
				$rsConspasCodAtivo = odbc_exec($conCab,$sqlConspasCodAtivo) or die(odbc_error());
				$contarConspasCodAtivo=odbc_num_rows($rsConspasCodAtivo);
				if($contarConspasCodAtivo==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Passageiro inexistente ou inativo.\\n';
					}
			   }
			//Validação	 inicio Data
			if(empty($inicioPas)){
				$validaErro=1;
					$countError++;
		$errorMsg.='Erro['.$countError.']: Informar data de partida.\\n';
			}
			//Validação de hora de inicio
			if(empty($horaPtPas)){
				$validaErro=1;
					$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a hora de partida.\\n';
                }elseif($_POST['horaPtPas']>23){
				$validaErro=1;
				$countError++;
		$errorMsg.='Erro['.$countError.']: Hora de partida inv\\u00e1lida.\\n';	
			}
			//Validação de minuto de inicio
			if($minutoPtPas>59){
			  $validaErro=1;
				$countError++;
		$errorMsg.='Erro['.$countError.']: Minuto de partida inv\\u00e1lido.\\n';		
				}
				
				//Validacao de data de retorno
		       if(!empty($_POST['fimPas'])){
				   if(empty($_POST['horaRetPas'])){
				       $validaErro=1;
						$countError++;
		$errorMsg.='Erro['.$countError.']: Necessario inforar a hora de retorno.\\n';	
							}elseif($_POST['horaRetPas']>23){
							$validaErro=1;
							$countError++;
							$errorMsg.='Erro['.$countError.']: Hora de retorno inv\\u00e1lida.\\n';
								
								}elseif($_POST['minutoRetPas']>59){
										$validaErro=1;
										$countError++;
										$errorMsg.='Erro['.$countError.']: Minuto de retorno inv\\u00e1lido.\\n';
										
										}elseif(converteData($_POST['fimPas'])<converteData($_POST['inicioPas'])){
						   				$validaErro=1;
										$countError++;
										$errorMsg.='Erro['.$countError.']: A data de retorno deve ser superior ou igual a de partida.\\n';
						   			}elseif($_POST['fimPas']==$_POST['inicioPas']){
										if($horaRetPas<$horaPtPas){
											$validaErro=1;
											$countError++;
											$errorMsg.='Erro['.$countError.']: Para passagens no mesmo dia, a hora de retorno deve ser superior a de partida.\\n';		
											}
										}	   
					   }
			//Validacao do valor
			if(empty($valorPas) || $valorPas=='0.00'){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';
			}
			//Verifica se o validaErro retorna 0 para iniciar as inclusoes
		    if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
				$sqlConsidPas="select MAX(id_registro) as id from TEITEMSOLPASSAGEM (nolock)";
			$rsConsidPas= odbc_exec($conCab,$sqlConsidPas) or die(odbc_error());
			$arrayConsidPas = odbc_fetch_array($rsConsidPas);
			$idPasNova=$arrayConsidPas['id']+1;
			$sqlPasNova="insert into TEITEMSOLPASSAGEM(
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
						   ".$idPasNova.",                           --  id_registro  int 
						   ".$solicitacao.",                          --  cd_solicitacao  float 
						   ".$sequencia.",                            --  sequencia  real 
						   '".$pasCod."',                     --  cd_empresa  char(6)
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
						   '".$cargoPas."'                   --  cargo varchar(40)
						   )";
				$resPasNovo = odbc_exec($conCab, $sqlPasNova) or die("<p>".odbc_errormsg());
				//Inicia para atualizar o valor do item
				$vlUnitPas=0;
				$contPasVl=0;
				$buscarVLUnitPas=odbc_exec($conCab,"SELECT valor FROM TEITEMSOLPASSAGEM (nolock)  WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				//Faz laço para buscar media de valor unitario e quantidade
				while($objValorPas=odbc_fetch_object($buscarVLUnitPas)){
					 $contPasVl++;
					$vlUnitPas=($vlUnitPas+$objValorPas->valor);
					}
					$vlUnitPas=$vlUnitPas/$contPasVl;
				//Atualiza o item
				$updItemPasNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contPasVl.", qt_saldo=".$contPasVl.", pr_unitario='".(float)$vlUnitPas."' WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
				//Verifica se as funções de atualização tiveram sucesso
				if($resPasNovo && $updItemPasNovo){
					//Da commit na transação
				  if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
				  $_SESSION['codPasS']='';
  				  $_SESSION['cargoPasS']='';
				  $_SESSION['inicioPasS']='';
				  $_SESSION['fimPasS']='';
				  $_SESSION['vlPasS']='';
				  $_SESSION['horaInicioS']='';
				  $_SESSION['minutoInicioS']='';
				  $_SESSION['horaFimS']='';
				  $_SESSION['minutoFimS']='';
				  $_SESSION['obsPasS']='';
				  $_SESSION['cadeiranteS']='';
				  $_SESSION['trechoS']='';				  
			   //Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
					   <script type="text/javascript">
                       alert("<?php echo $errorMsg; ?>");
                       window.location="<?php echo $retornar; ?>";
                       </script>
                     <?php
					  }
				  }
			}
		//Fechamento da insercao de itens passagem
		}
		//Inicio da insercao de item hotel
		elseif($hotel==1){
			//Recebe o hospede
			$hotCod=trim($_POST['hotCod']);  
			$_SESSION['codHotS']=$_POST['hotCod'];
			$arhotCod = explode('-', $hotCod);
			$hotCod=$arhotCod[0];
			$hotCod=str_replace("'","\"",$hotCod);
			
			//Inicio do Cargo Hotel
			if(!empty($_POST['cargoHot'])){
			$cargoHot=$_POST['cargoHot']; 
			$_SESSION['cargoHotS']=$_POST['cargoHot'];
			$cargoHot=str_replace("'","\"",$cargoHot);
			}
			
			//Recebe inicio Hotel
			if($teste==0){
				$inicioHot=converteData($_POST['inicioHot']);
			}else{
				$inicioHot=$_POST['inicioHot'];
			} 
			$_SESSION['inicioHotS']=$_POST['inicioHot'];
			$inicioHot=str_replace("'","\"",$inicioHot);
			
			//Recebe fim Hotel
			if($teste==0){
				$fimHot=converteData($_POST['fimHot']);
			}else{
				$fimHot=$_POST['fimHot'];	
			}
			$_SESSION['fimHotS']=$_POST['fimHot'];
			$fimHot=str_replace("'","\"",$fimHot);
			
			//Recebe a reserva hotel
			$rlHot=$_POST['rlHot']; 
			$_SESSION['rlHotS']=$_POST['rlHot'];
			$rlHot=str_replace("'","\"",$rlHot);
			
			//Inicia as validações Hotel
			if(empty($hotCod)){
			$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Informe o h\\u00f3spede.\\n';
			}else{
				$sqlBloqUser=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE status=1 AND cdempres='".$hotCod."'"));
				if($sqlBloqUser>0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Benefici\\u00e1rio com pendência no setor de Prestação de Contas.\\n';
					}
				$sqlConsHotCodAtivo="select 1
							from GEEMPRES (nolock) 
							where cd_empresa = '".$hotCod."'
							and ativo = 1";
				$rsConshotCodAtivo = odbc_exec($conCab,$sqlConsHotCodAtivo) or die(odbc_error());
				$contarConshotCodAtivo=odbc_num_rows($rsConshotCodAtivo);
				if($contarConshotCodAtivo==0){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: H\\u00f3spede inexistente ou inativo.\\n';
					}
				}
			//Valida Data inicial e final
			if(empty($inicioHot)){
					$validaErro=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a data de in\\u00edcio.\\n';
					}
		
		if(empty($fimHot)){
		$validaErro=1;
		$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
	   }
	   
	   if($fimHot<$inicioHot){
		$validaErro=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
			//Caso o validaErro retorne 0 inicio os inserts			
			if($validaErro==1){
				?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
				}else{
				$sqlConsidHot="select MAX(id_registro) as id from TEITEMSOLHOTEL (nolock)";
			$rsConsidHot = odbc_exec($conCab,$sqlConsidHot) or die(odbc_error());
			$arrayConsidHot = odbc_fetch_array($rsConsidHot);
			$idHotNova=$arrayConsidHot['id']+1;
		$sqlHotNova="insert into TEITEMSOLHOTEL(
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
					   ".$idHotNova.",                           --  id_registro  int 
					   ".$solicitacao.",                          --  cd_solicitacao  float 
					   ".$sequencia.",                            --  sequencia  real 
					   '".$hotCod."',                     --  cd_empresa  char(6)
					   '".$rlHot."',
					   CAST('".$inicioHot."' AS DATETIME),    --  dt_inicio  datetime 
					   CAST('".$fimHot."' AS DATETIME),    --  dt_fim  datetime 
					   '".$usuario."',                        --  usu_criacao  char(3)
					   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
					   '".date("His")."',                     --  hr_criacao  char(6)
					   '   ',                        --  usu_modificacao  char(3)
					   NULL,                       --  dt_modificacao  datetime 
					   'NULL',                       --  hr_modificacao  char(6)
					   '".$cargoHot."'                   --  cargo varchar(40)
					   )";
						$resHotNovo = odbc_exec($conCab, $sqlHotNova) or die("<p>".odbc_errormsg());
				//Inicia a contagem de quantos itens tem
				$contHotVl=0;
				$buscarVLUnitHot=odbc_exec($conCab,"SELECT sequencia FROM TEITEMSOLHOTEL (nolock)  WHERE cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'");
				$contHotVl=odbc_num_rows($buscarVLUnitHot);
				//Atualiza o item
				$updItemHotNovo=odbc_exec($conCab, "UPDATE COISOLIC SET quantidade=".$contHotVl.", qt_saldo=".$contHotVl." WHERE Cd_solicitacao='".$solicitacao."' AND sequencia='".$sequencia."'") or die("<p>".odbc_errormsg());
				//Verifica se as funções de atualização tiveram sucesso
				if($resHotNovo && $updItemHotNovo){
					//Da commit na transação
				  if(odbc_commit($conCab)){
				?>
			   <script type="text/javascript">
               alert("Item inserido com sucesso.");
               window.location="<?php echo $retornar; ?>";
               </script>
               <?php
			   //Unset nas sessoes
			   		$_SESSION['codHotS']='';
					$_SESSION['cargoHotS']='';
				    $_SESSION['rlHotS']='';
					$_SESSION['fimHotS']='';
					$_SESSION['inicioHotS']='';
					//Caso ela não tenha sucesso
				}else{
					?>
       			 <script type="text/javascript">
      			 alert("Erro[1]: Ocorreu um erro. Tente novamente.");
      			 window.location="<?php echo $retornar; ?>";
      			 </script>
      			 <?php
					}
			//Caso dê erro da Rollback
			}else{
				if(odbc_rollback($conCab)){
					?>
				   <script type="text/javascript">
                   alert("<?php echo $errorMsg; ?>");
                   window.location="<?php echo $retornar; ?>";
                   </script>
                   <?php
					  }
				  }
				}
			//fechamento item hotel
			}

?>
