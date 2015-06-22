	<?php 
//include 'db_connect.php';
//Função para montagem do cabeçalho da folha de ponto
function montaCabecalho($funcionario,$mes, $ano){
		  require('conectsqlserver.php');
		  $SQLCab = "Select
						  dbo.RHESCALAS.DESCRICAO20 As DESCRICAO201,
						  dbo.RHESCALAS.DESCRICAO40 As DESCRICAO401,
						  dbo.RHESCALAS.DESCRICAO60,
						  dbo.RHPESSOAS.NOME,
						  dbo.RHPESSOAS.PESSOA,
						  dbo.RHSETORES.DESCRICAO40,
						  dbo.RHSETORES.DESCRICAO20,
						  dbo.RHCARGOS.DESCRICAO20 As DESCRICAO202,
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS Inner Join
						  dbo.RHCONTRATOS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
						  dbo.RHESCALAS On dbo.RHCONTRATOS.ESCALA = dbo.RHESCALAS.ESCALA Inner Join
						  dbo.RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
                          dbo.RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$funcionario."') 
						  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resCab = odbc_exec($conCab, $SQLCab);
	      $array_resultado = odbc_fetch_array($resCab);
		 if(empty($array_resultado)){
			 if($conCabErro==0){
             ?>
			   <script type="text/javascript">
               alert("Voc\u00ea n\u00e3o possui cadastro para esse m\u00eas.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
			 }
			 }
		else{
			if($mes=='12'){
				$mesP='1';
				$anoP=$ano+1;
				}else{
					$mesP=$mes+1;
					$anoP=$ano;
					}
			$mesAtual=$ano."/".$mes."/01 00:00:00.000";
			if($mesP<>2){
			$fimMesAtual=$anoP."/".$mesP."/30 00:00:00.000";
			}else{
				$fimMesAtual=$anoP."/".$mesP."/28 00:00:00.000";
				}
			$cargoCont=$array_resultado["DESCRICAO202"];
			$sqlCountC=odbc_exec($conCab,"Select 
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.DATAHORAALTERACAO < '".$fimMesAtual."' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultado['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOATUAL)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			$arrayCountC=odbc_num_rows($sqlCountC);
			if($arrayCountC<1){
				$sqlCountC2=odbc_exec($conCab,"Select TOP 1 
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultado['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOANTERIOR)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO ASC") or die("<p>".odbc_errormsg());
			$arrayCountC2=odbc_fetch_array($sqlCountC2);
			$cargoCont=$arrayCountC2["CONTEUDOANTERIOR"];
				}else{
			$sqlContCargo=odbc_exec($conCab,"Select TOP 1
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.DATAHORAALTERACAO < '".$fimMesAtual."' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultado['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOATUAL)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			$arrayContCargo=odbc_fetch_array($sqlContCargo);
			if(!empty($arrayContCargo['CONTEUDOATUAL'])){
				 $cargoCont=$arrayContCargo["CONTEUDOATUAL"];
				}else{
					$sqlContCargoInicio=odbc_exec($conCab,"Select TOP 1
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOANTERIOR = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultado['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOANTERIOR)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			
			$arrayContCargoInicio=odbc_fetch_array($sqlContCargoInicio);
			if(!empty($arrayContCargoInicio)){
				$cargoCont=$arrayContCargoInicio["CONTEUDOANTERIOR"];
						}
				}
			}
	echo "<table width='631' border='1' cellspacing='0' cellpadding='0'>";
    echo "<tr>";
    echo "<td colspan='2' align='center' class='negrito'><img src='imagens/logo_cpb1.png' width='204' height='36' />Ficha de Frequência</td>";
    echo "<td width='203' align='center' class='grande'><strong>Período:</strong><br /> <span class='menor'>26/".$mes."/".$ano." a 25/".($mesP)."/".$anoP."</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width='83'><span class='small'><strong>Empresa:</strong></span></td>";
    echo "<td width='337'><span class='small'>COMITÊ PARAOLÍMPICO BRASILEIRO</span></td>";
    echo "<td><span class='small'><strong>CNPJ</strong>: 00.700.114/0001-44</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><span class='small'><strong>Endereço: </strong></span></td>";
    echo "<td><span class='small'>SBN QD 02 BLOCO F 14 ANDAR</span></td>";
    echo "<td><span class='small'><strong>Atividade:</strong> 9319199</span></td>";
    echo "</tr>";	
    echo "<tr>";
    echo "<td><span class='small'><strong>Cidade:</strong></span></td>";
    echo "<td><span class='small'>Brasília</span></td>";
    echo "<td><span class='small'><strong>Estado:</strong> DF</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><span class='small'><strong>Nome:</strong></span></td>";
    echo "<td><span class='small'>".$array_resultado["NOME"]."</span></td>";
    echo "<td><span class='small'><strong>Código:</strong> 001/".$array_resultado["PESSOA"]."</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><span class='small'><strong>Departamento:</strong></span></td>";
    echo "<td><span class='small'>".$array_resultado["DESCRICAO20"]."</span></td>";
    echo "<td><span class='small'><strong>Cargo:</strong>".$cargoCont."</span></td>";
    echo "</tr>";
    /*echo "<tr>";
    echo "<td><span class='small'><strong>Horário:</strong></span></td>";
    echo "<td colspan='2'><span class='small'>".$array_resultado["DESCRICAO60"]."</span></td>";
    echo "</tr>";*/
    echo "</table>";
}}
//Função para montagem da grade de dias, fazendo comparações com o mês e estatus do dia
function montaDias($mes,$ano,$funcionario){
	$dia=26;
	echo "<div id='fonte'><table width='631' border='2' cellspacing='0' cellpadding='0'>";
    echo "<tr bgcolor='#E4E2E2'>";
    echo "<td width='40' rowspan='2' align='center'><span class='pequeno'><strong>Dia</strong></span></td>";
    echo "<td width='68' rowspan='2' align='center'><span class='pequeno'><strong>Entrada</strong></span></td>";
    echo "<td colspan='2' align='center'><span class='pequeno'><strong>Intervalo</strong></span></td>";
    echo "<td width='67' rowspan='2' align='center'><span class='pequeno'><strong>Saída</strong></span></td>";
    echo "<td colspan='3' align='center'><span class='pequeno'><strong>Horas Extras</strong></span></td>";
    echo "<td width='119' rowspan='2' align='center'><span class='pequeno'><strong>Rubrica</strong></span></td>";
    echo "</tr>";
    echo "<tr bgcolor='#E4E2E2'>";
    echo "<td width='62' align='center'><span class='pequeno'><strong>Saída</strong></span></td>";
    echo "<td width='57' align='center'><span class='pequeno'><strong>Entrada</strong></span></td>";
    echo "<td width='65' align='center'><span class='pequeno'><strong>Início</strong></span></td>";
    echo "<td width='66' align='center'><span class='pequeno'><strong>Término</strong></span></td>";
    echo "<td width='67' align='center'><span class='pequeno'><strong>Total</strong></span></td>";
    echo "</tr>";
	if($mes==1||$mes==3||$mes==5||$mes==7||$mes==8||$mes==10||$mes==12){
	   for($dia=26;$dia<=31;$dia=$dia+1){
		   $diaStatus=consultaStatus($dia,$mes,$ano);
		   if($diaStatus==1){
			   echo "<tr bgcolor='#666666'>";
               echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
               echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>SÁBADO</span></td>";
               echo "</tr>";
			   }elseif($diaStatus==2){
				   echo "<tr bgcolor='#666666'>";
                   echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                   echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>DOMINGO</span></td>";
                   echo "</tr>";
			       }elseif($diaStatus==3){
				      echo "<tr bgcolor='#666666'>";
                      echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                      echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>FERIADO</span></td>";
                      echo "</tr>";
			          }elseif($diaStatus==4){
				         echo "<tr bgcolor='#666666'>";
                         echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                         echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>RECESSO</span></td>";
                         echo "</tr>";
			             }else{
							    echo"<tr>";
								echo"<td><span class='pequeno'>".$dia."</span></td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
							    echo"</tr>";
							  }
			
		   }
	} elseif($mes==4||$mes==6||$mes==9||$mes==11){
		$dia=26;
		for($dia=26;$dia<=30;$dia=$dia+1){
		   $diaStatus=consultaStatus($dia,$mes,$ano);
		   if($diaStatus==1){
			   echo "<tr bgcolor='#666666'>";
               echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
               echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>SÁBADO</span></td>";
               echo "</tr>";
			   }elseif($diaStatus==2){
				   echo "<tr bgcolor='#666666'>";
                   echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                   echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>DOMINGO</span></td>";
                   echo "</tr>";
			       }elseif($diaStatus==3){
				      echo "<tr bgcolor='#666666'>";
                      echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                      echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>FERIADO</span></td>";
                      echo "</tr>";
			          }elseif($diaStatus==4){
				         echo "<tr bgcolor='#666666'>";
                         echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                         echo "<td colspan='8' bgcolor='#E4E2E2'>RECESSO</span></td>";
                         echo "</tr>";
			             }else{
							    echo"<tr>";
								echo"<td><span class='pequeno'>".$dia."</span></td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
							    echo"</tr>";
							  }
			
		   }
	} else{
		$dia=26;
		for($dia=26;$dia<=28;$dia=$dia+1){
		   $diaStatus=consultaStatus($dia,$mes,$ano);
		   if($diaStatus==1){
			   echo "<tr bgcolor='#666666'>";
               echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
               echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>SÁBADO</span></td>";
               echo "</tr>";
			   }elseif($diaStatus==2){
				   echo "<tr bgcolor='#666666'>";
                   echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                   echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>DOMINGO</span></td>";
                   echo "</tr>";
			       }elseif($diaStatus==3){
				      echo "<tr bgcolor='#666666'>";
                      echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                      echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>FERIADO</span></td>";
                      echo "</tr>";
			          }elseif($diaStatus==4){
				         echo "<tr bgcolor='#666666'>";
                         echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                         echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>RECESSO</span></td>";
                         echo "</tr>";
			             }else{
							    echo"<tr>";
								echo"<td><span class='pequeno'>".$dia."</span></td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
							    echo"</tr>";
							  }
			
		   }
		   }
   $dia=1;
   for($dia=1;$dia<=25;$dia=$dia+1){
	   if($mes=='12'){
		   $mesP2=1;
		   $anoP2=$ano+1;
		   }else{
			   $mesP2=$mes+1;
			   $anoP2=$ano;
			   }
           $diaStatus=consultaStatus($dia,$mesP2,$anoP2);
		   if($diaStatus==1){
			   echo "<tr bgcolor='#666666'>";
               echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
               echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>SÁBADO</span></td>";
               echo "</tr>";
			   }elseif($diaStatus==2){
				   echo "<tr bgcolor='#666666'>";
                   echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                   echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>DOMINGO</span></td>";
                   echo "</tr>";
			       }elseif($diaStatus==3){
				      echo "<tr bgcolor='#666666'>";
                      echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                      echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>FERIADO</span></td>";
                      echo "</tr>";
			          }elseif($diaStatus==4){
				         echo "<tr bgcolor='#666666'>";
                         echo "<td bgcolor='#E4E2E2'><span class='pequeno'>".$dia."</span></td>";
                         echo "<td colspan='8' bgcolor='#E4E2E2'><span class='pequeno'>RECESSO</span></td>";
                         echo "</tr>";
			             }else{
							    echo"<tr>";
								echo"<td><span class='pequeno'>".$dia."</span></td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
							    echo"</tr>";
							  }
			
		   }
echo "</table>";
}
//Funcao de buscar email
function buscaEmail($loginFolha){
    require('conexaomysql.php');
	$resulemail = mysql_query("SELECT * FROM usuarios WHERE usuario = '".$loginFolha."'") or die(mysql_error());
	$array_de_conteudoEmail = mysql_fetch_array($resulemail);
	return $array_de_conteudoEmail["email"];
}
//Função de consulta estatus do dia no banco de dados
function consultaStatus($dia,$mes,$ano){
    require('conexaomysql.php');
	$resultado1 = mysql_query("SELECT * FROM statusdia WHERE dia = ".$dia." and mes = ".$mes." and ano = ".$ano) or die(mysql_error());
	$array_de_conteudo = mysql_fetch_array($resultado1);
	$diaStatus=$array_de_conteudo["status"];
	return $diaStatus;
	mysql_close($conexao);
	}

//Função para cadastrar o evento do dia no banco	
function inserirDia($dia,$mes,$ano,$idStatus){
	require('conexaomysql.php');
	
	$comandosql1="INSERT INTO statusdia VALUES ('','".$dia."','".$mes."' ,'".$ano."','".$idStatus."')";
	$comandosql2="SELECT * FROM statusdia  WHERE dia=".$dia." and mes=".$mes." and ano=".$ano;
	$consulta = mysql_query($comandosql2);
	$contar = mysql_num_rows($consulta);
	if($contar>='1') {
		?>
       <script type="text/javascript">
       alert("Existe evento cadastrado nesse dia. Exclua para alterar.");
       history.back();
       </script>
       <?php 
	   }else{
	$inserir=mysql_query($comandosql1);
	if ($inserir) {
     	?>
       <script type="text/javascript">
       alert("Cadastro efetuado com sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: cadastroDias.html');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("N\u00e3o foi possível deletar o evento. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: cadastroDias.html');
	          }
	   }
	mysql_close($conexao);
	}
	
//Função para excluir o evento do dia no banco	
function excluirDia($diax,$mesx,$anox){
	require('conexaomysql.php');
	$comandosql="DELETE FROM statusdia WHERE (dia='".$diax."' and mes='".$mesx."' and ano='".$anox."')";
    $delete=mysql_query($comandosql);
	if ($delete) {
     	?>
       <script type="text/javascript">
       alert("Evento deletado com sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: cadastroDias.html');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Evento n\u00e3o deletado ou n\u00e3o existe. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: cadastroDias.html');
	      }
	mysql_close($conexao);
	}

//Função para desenhar o rodapé
function montaRodape($nome){
	require('conectsqlserver.php');
		  $SQLRod = "Select
						  dbo.RHESCALAS.DESCRICAO20 As DESCRICAO201,
						  dbo.RHESCALAS.DESCRICAO40 As DESCRICAO401,
						  dbo.RHESCALAS.DESCRICAO60,
						  dbo.RHPESSOAS.NOME,
						  dbo.RHPESSOAS.PESSOA,
						  dbo.RHSETORES.DESCRICAO40,
						  dbo.RHSETORES.DESCRICAO20,
						  dbo.RHCARGOS.DESCRICAO20 As DESCRICAO202,
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS Inner Join
						  dbo.RHCONTRATOS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
						  dbo.RHESCALAS On dbo.RHCONTRATOS.ESCALA = dbo.RHESCALAS.ESCALA Inner Join
						  dbo.RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
                          dbo.RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome."')
						  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resRod = odbc_exec($conCab, $SQLRod);
	      $array_resultadoRod = odbc_fetch_array($resRod);
 echo "<table width='631' border='1' cellspacing='0' cellpadding='0'>";
 echo " <tr>";
 echo "   <td width='302'><strong>Total de Horas: </strong></td>";
 echo "    <td><strong>Total de Horas Extras: </strong></td>";
 echo "  </tr>";
 echo " <tr>";
 echo "   <td valign='top'><p><span class='pequeno'>Concordo com os registros das horas trabalhadas.</span><br />";
 echo "     ____________________________________<br />";
 echo "     <strong>".$array_resultadoRod["NOME"]."</strong></p></td>";
 echo "   <td valign='top'><span class='pequeno'>Observações:</span><br />";
 //echo "     ____________________________________<br>";
 echo "     __________________________</p></td>";
 echo " </tr>";
 echo "</table></div>";
 }

 //Inicia funções relacionadas ao ContraCheque
 
 //Função para montagem do cabeçalho do documento
 function montaCabecalhoContCheq($mesCh,$anoCh,$nome_funcCh){
	 echo "<div id='outro' style='display: none;'>";
	 include "mb.php";
	 require('conectsqlserver.php');
     $SQLCht = "Select
						  dbo.RHESCALAS.DESCRICAO20 As DESCRICAO201,
						  dbo.RHESCALAS.DESCRICAO40 As DESCRICAO401,
						  dbo.RHESCALAS.DESCRICAO60,
						  dbo.RHPESSOAS.PESSOA,
						  dbo.RHPESSOAS.NOME,
						  dbo.RHSETORES.DESCRICAO40,
						  dbo.RHSETORES.DESCRICAO20,
						  dbo.RHCARGOS.DESCRICAO20 As DESCRICAO202,
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS Inner Join
						  dbo.RHCONTRATOS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
						  dbo.RHESCALAS On dbo.RHCONTRATOS.ESCALA = dbo.RHESCALAS.ESCALA Inner Join
						  dbo.RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
                          dbo.RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')
						  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resCht = odbc_exec($conCab, $SQLCht);
	      $array_resultadoCht = odbc_fetch_array($resCht);
		  if(empty($array_resultadoCht)){
             ?>
			   <script type="text/javascript">
               alert("Voc\u00ea n\u00e3o possui documento cadastrado para esse m\u00eas.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
  else{
	  		$mesAtual=$anoCh."/".$mesCh."/30 00:00:00.000";
			if($mesCh=='02'){
				$mesAtual=$anoCh."/".$mesCh."/28 00:00:00.000";
				}
			$cargoCont=$array_resultadoCht["DESCRICAO202"];
			$sqlCountC=odbc_exec($conCab,"Select 
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.DATAHORAALTERACAO < '".$mesAtual."' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultadoCht['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOATUAL)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			$arrayCountC=odbc_num_rows($sqlCountC);
			if($arrayCountC<1){
				$sqlCountC2=odbc_exec($conCab,"Select TOP 1 
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultadoCht['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOANTERIOR)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO ASC") or die("<p>".odbc_errormsg());
			$arrayCountC2=odbc_fetch_array($sqlCountC2);
			if(!empty($arrayCountC2["CONTEUDOANTERIOR"])){
			$cargoCont=$arrayCountC2["CONTEUDOANTERIOR"];
			}
				}else{
			$sqlContCargo=odbc_exec($conCab,"Select TOP 1
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOATUAL = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.DATAHORAALTERACAO < '".$mesAtual."' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultadoCht['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOATUAL)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			$arrayContCargo=odbc_fetch_array($sqlContCargo);
			if(!empty($arrayContCargo['CONTEUDOATUAL'])){
				 $cargoCont=$arrayContCargo["CONTEUDOATUAL"];
				}else{
					$sqlContCargoInicio=odbc_exec($conCab,"Select TOP 1
  RHCONTRATOS.DATAULTALTCARGO,
  RHALTERACOESCONTRATO.CODIGOATUAL,
  RHALTERACOESCONTRATO.DATAHORAALTERACAO,
  RHCARGOS.DESCRICAO20,
  RHPESSOAS.NOME,
  RHCONTRATOS.DATAADMISSAO,
  RHALTERACOESCONTRATO.CONTEUDOANTERIOR,
  RHALTERACOESCONTRATO.CONTEUDOATUAL
From
  RHPESSOAS With(NoLock) Left Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHALTERACOESCONTRATO With(NoLock) On RHALTERACOESCONTRATO.UNIDADE =
    RHCONTRATOS.UNIDADE And RHALTERACOESCONTRATO.CONTRATO = RHCONTRATOS.CONTRATO
  Inner Join
  RHCARGOS With(NoLock) On RHALTERACOESCONTRATO.CODIGOANTERIOR = RHCARGOS.CARGO
Where
  RHALTERACOESCONTRATO.CODIGOATUAL <> '' And
  RHALTERACOESCONTRATO.CODIGOANTERIOR <> '' And
  RHPESSOAS.PESSOA = '".$array_resultadoCht['PESSOA']."' AND                    
  EXISTS
    (SELECT DESCRICAO20 
     FROM RHCARGOS (nolock)
     WHERE DESCRICAO20=RHALTERACOESCONTRATO.CONTEUDOANTERIOR)
	ORDER BY RHALTERACOESCONTRATO.DATAHORAALTERACAO DESC") or die("<p>".odbc_errormsg());
			
			$arrayContCargoInicio=odbc_fetch_array($sqlContCargoInicio);
			if(!empty($arrayContCargoInicio["CONTEUDOANTERIOR"])){
				$cargoCont=$arrayContCargoInicio["CONTEUDOANTERIOR"];
						}
				}
			}
		$sqlRegLeitCh=mysql_query("SELECT * FROM listach WHERE pessoa='".$array_resultadoCht["PESSOA"]."' AND mes='".$mesCh."/".$anoCh."'");
		$numeroRegLeitCh=mysql_num_rows($sqlRegLeitCh);
		if($numeroRegLeitCh<1){
			$inserieRegLeitCh=mysql_query("INSERT INTO listach(pessoa,mes,dtvisualiza) values ('".$array_resultadoCht["PESSOA"]."','".$mesCh."/".$anoCh."','".date("d/m/Y H:i:s")."')");
			}
			echo "</div>";
			echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
			echo "  <col width='64' span='10' />";
			echo "  <tr>";
			echo "    <td colspan='7'><strong class='titulo'>DEMONSTRATIVO DE PAGAMENTO</strong></td>";
			echo "    <td colspan='3' width='267'><strong>Folha Mensal de ".$mesCh."/".$anoCh."</strong></td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'>COMITE PARAOL&Iacute;MPICO BRASILEIRO</td>";
			echo "    <td colspan='2'>CPB</td>";
			echo "    <td colspan='3'>CNPJ: 00700114/0001-44</td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'><strong>".$array_resultadoCht["NOME"]." </strong></td>";
			echo "    <td colspan='2'><strong>001/".$array_resultadoCht["PESSOA"]."</strong></td>";
			echo "    <td colspan='3'><strong>".$cargoCont."</strong></td>";
			echo "  </tr>";
			echo "</table>";
		odbc_close($conCab);	
	 }}
//Montar estrutura do centro do contracheque com os lançementos	 
function montaCentroContCheq($mesCh,$anoCh,$nome_funcCh){
	echo "<div id='outro' style='display: none;'>";
	$dataatual=date("y")."-".date("m")."-".date("d")." 00:00:00.000";
	if($mesCh<10){
		if($mesCh==4||$mesCh==6||$mesCh==9){
			$data=$anoCh."-0".$mesCh."-30 00:00:00.000";
		}elseif($mesCh==2){
			$data=$anoCh."-0".$mesCh."-28 00:00:00.000";
		}else{
			$data=$anoCh."-0".$mesCh."-31 00:00:00.000";
			}
	}else{
		if($mesCh==11){
			$data=$anoCh."-".$mesCh."-30 00:00:00.000";
		}else{
			$data=$anoCh."-".$mesCh."-31 00:00:00.000";
			}
	}
	include "mb.php";
	require('conectsqlserver.php');
		  $SQLChC = "Select
					  dbo.RHVDBFOLHA.VDB,
					  dbo.RHVDBFOLHA.CONTRATO,
					  dbo.RHCONTRATOS.CONTRATO As CONTRATO1,
					  dbo.RHVDBFOLHA.DATAFOLHA,
					  dbo.RHPESSOAS.NOME,
					  dbo.RHCONTRATOS.PESSOA,
					  dbo.RHCONTRATOS.DATAADMISSAO,
					  dbo.RHVDB.VDB As VDB1,
					  dbo.RHVDB.DESCRICAO30,
					  dbo.RHVDB.DESCRICAO15,
					  dbo.RHVDBFOLHA.HORASQUANTIDADE,
					  dbo.RHVDBFOLHA.VALOR,
					  dbo.RHVDBFOLHA.ORIGEMVDB,
					  dbo.RHVDBFOLHA.TIPOINFOFOLHA,
					  dbo.RHVDB.TIPOVDB,
					  dbo.RHPESSOAS.EMAILCORPORATIVO,
					  dbo.RHCONTRATOS.DATARESCISAO
					From
					  dbo.RHVDBFOLHA Left Join
					  dbo.RHCONTRATOS On dbo.RHVDBFOLHA.CONTRATO = dbo.RHCONTRATOS.CONTRATO Inner Join
					  dbo.RHPESSOAS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
					  dbo.RHVDB On dbo.RHVDBFOLHA.VDB = dbo.RHVDB.VDB
					  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')
					  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resChC = odbc_exec($conCab, $SQLChC);
		  echo "</div>";
echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
echo "  <tr>";
echo "    <td width='80' align='center'><u>Cod.</u></td>";
echo "    <td width='407' align='center'><u>Descri&ccedil;&atilde;o</u></td>";
echo "    <td width='108' align='center'><u>Hrs/Qtde</u></td>";
echo "    <td width='108' align='center'><u>Vencimentos</u></td>";
echo "    <td width='108' align='center'><u>Descontos</u></td>";
echo "  </tr>";
while($array_resultadoChC = odbc_fetch_array($resChC)){
	if($array_resultadoChC["DATAADMISSAO"]>$data){
             ?>
			   <script type="text/javascript">
               alert("Voc\u00ea possui recibo para esse m\u00eas. Verifique com o RH.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
  else{
	if ($data==$array_resultadoChC["DATAFOLHA"]){
		if ($array_resultadoChC["TIPOVDB"]=="V"){
			if($array_resultadoChC["HORASQUANTIDADE"]==0){
			echo"    <tr>"; 
			echo"    <td align='center'>".$array_resultadoChC["VDB"]."</td>";
			echo"    <td>".$array_resultadoChC["DESCRICAO30"]."</td>";
			echo"    <td align='right'></td>";
			echo"    <td align='right'>".number_format($array_resultadoChC["VALOR"],2, ',', '.')."</td>";
			echo"    <td></td>";
			echo"    </tr>";
			}else{
				echo"    <tr>"; 
			echo"    <td align='center'>".$array_resultadoChC["VDB"]."</td>";
			echo"    <td>".$array_resultadoChC["DESCRICAO30"]."</td>";
			echo"    <td align='right'>".number_format($array_resultadoChC["HORASQUANTIDADE"],0, ',', '.')."</td>";
			echo"    <td align='right'>".number_format($array_resultadoChC["VALOR"],2, ',', '.')."</td>";
			echo"    <td></td>";
			echo"    </tr>";
				}}
			if ($array_resultadoChC["TIPOVDB"]=="D"){
				if($array_resultadoChC["HORASQUANTIDADE"]==0){
						echo"    <tr>";
						echo"    <td align='center'>".$array_resultadoChC["VDB"]."</td>";
						echo"    <td>".$array_resultadoChC["DESCRICAO30"]."</td>";
						echo"    <td align='right'></td>";
						echo"    <td></td>";
						echo"    <td align='right'>".number_format($array_resultadoChC["VALOR"],2, ',', '.')."</td>";
						echo"    </tr>";
						}else{
							echo"    <tr>";
						echo"    <td align='center'>".$array_resultadoChC["VDB"]."</td>";
						echo"    <td>".$array_resultadoChC["DESCRICAO30"]."</td>";
						echo"    <td align='right'>".number_format($array_resultadoChC["HORASQUANTIDADE"],0, ',', '.')."</td>";
						echo"    <td></td>";
						echo"    <td align='right'>".number_format($array_resultadoChC["VALOR"],2, ',', '.')."</td>";
						echo"    </tr>";
							}
						}
		}}}
echo "</table>";
}
//Montar estrutura do centro do contracheque com os lançementos	 
function montaCentroContCheq13($anoCh13,$nome_funcCh13,$tipoCh13){
	echo "<div id='outro' style='display: none;'>";
	include "mb.php";
	require('conectsqlserver.php');
	$textoMes='';
	if($tipoCh13==51){
		$textoMes='1&ordf; Parc. 13&ordm;';
		}else{
			$textoMes='2&ordf; Parc. 13&ordm;';
			}
		  $SQLCht13 = "Select
						  dbo.RHESCALAS.DESCRICAO20 As DESCRICAO201,
						  dbo.RHESCALAS.DESCRICAO40 As DESCRICAO401,
						  dbo.RHESCALAS.DESCRICAO60,
						  dbo.RHPESSOAS.NOME,
						  dbo.RHPESSOAS.PESSOA,
						  dbo.RHSETORES.DESCRICAO40,
						  dbo.RHSETORES.DESCRICAO20,
						  dbo.RHCARGOS.DESCRICAO20 As DESCRICAO202,
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS Inner Join
						  dbo.RHCONTRATOS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
						  dbo.RHESCALAS On dbo.RHCONTRATOS.ESCALA = dbo.RHESCALAS.ESCALA Inner Join
						  dbo.RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
                          dbo.RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh13."')
						AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resCht13 = odbc_exec($conCab, $SQLCht13);
	      $array_resultadoCht13 = odbc_fetch_array($resCht13);
		  if(empty($array_resultadoCht13)){
             ?>
			   <script type="text/javascript">
               alert("Voc\u00ea n\u00e3o possui documento cadastrado para esse m\u00eas.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
  else{
	  echo "</div>";
			echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
			echo "  <col width='64' span='10' />";
			echo "  <tr>";
			echo "    <td colspan='7'><strong class='titulo'>DEMONSTRATIVO DE PAGAMENTO</strong></td>";
			echo "    <td colspan='3' width='267'><strong>".$textoMes."/".$anoCh13."</strong></td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'>COMITE PARAOL&Iacute;MPICO BRASILEIRO</td>";
			echo "    <td colspan='2'>CPB</td>";
			echo "    <td colspan='3'>CNPJ: 00700114/0001-44</td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'><strong>".$array_resultadoCht13["NOME"]." </strong></td>";
			echo "    <td colspan='2'><strong>001/".$array_resultadoCht13["PESSOA"]."</strong></td>";
			echo "    <td colspan='3'><strong>".$array_resultadoCht13["DESCRICAO202"]."</strong></td>";
			echo "  </tr>";
			echo "</table>";	
	 }
		  $SQLChC13Data = "Select
					  dbo.RHVDBFOLHA.DATAFOLHA
					From
					  dbo.RHVDBFOLHA Left Join
					  dbo.RHCONTRATOS On dbo.RHVDBFOLHA.CONTRATO = dbo.RHCONTRATOS.CONTRATO Inner Join
					  dbo.RHPESSOAS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
					  dbo.RHVDB On dbo.RHVDBFOLHA.VDB = dbo.RHVDB.VDB
					  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh13."')
					  AND dbo.RHVDB.VDB='".$tipoCh13."'
					  AND dbo.RHVDBFOLHA.DATAFOLHA like '%".$anoCh13."%'
					  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resChC13Data = odbc_exec($conCab, $SQLChC13Data);
		  $array_resultadoChC13Data = odbc_fetch_array($resChC13Data);
		  $SQLChC13 = "Select
					  dbo.RHVDBFOLHA.VDB,
					  dbo.RHVDBFOLHA.CONTRATO,
					  dbo.RHCONTRATOS.CONTRATO As CONTRATO1,
					  dbo.RHVDBFOLHA.DATAFOLHA,
					  dbo.RHPESSOAS.NOME,
					  dbo.RHCONTRATOS.PESSOA,
					  dbo.RHCONTRATOS.DATAADMISSAO,
					  dbo.RHVDB.VDB As VDB1,
					  dbo.RHVDB.DESCRICAO30,
					  dbo.RHVDB.DESCRICAO15,
					  dbo.RHVDBFOLHA.HORASQUANTIDADE,
					  dbo.RHVDBFOLHA.VALOR,
					  dbo.RHVDBFOLHA.ORIGEMVDB,
					  dbo.RHVDBFOLHA.TIPOINFOFOLHA,
					  dbo.RHVDB.TIPOVDB,
					  dbo.RHPESSOAS.EMAILCORPORATIVO
					From
					  dbo.RHVDBFOLHA Left Join
					  dbo.RHCONTRATOS On dbo.RHVDBFOLHA.CONTRATO = dbo.RHCONTRATOS.CONTRATO Inner Join
					  dbo.RHPESSOAS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
					  dbo.RHVDB On dbo.RHVDBFOLHA.VDB = dbo.RHVDB.VDB
					  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh13."')
					        AND dbo.RHVDBFOLHA.DATAFOLHA ='".$array_resultadoChC13Data['DATAFOLHA']."'
							AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
          $resChC13 = odbc_exec($conCab, $SQLChC13);
echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
echo "  <tr>";
echo "    <td width='80' align='center'><u>Cod.</u></td>";
echo "    <td width='407' align='center'><u>Descri&ccedil;&atilde;o</u></td>";
echo "    <td width='108' align='center'><u>Hrs/Qtde</u></td>";
echo "    <td width='108' align='center'><u>Vencimentos</u></td>";
echo "    <td width='108' align='center'><u>Descontos</u></td>";
echo "  </tr>";
if($tipoCh13==51){
	$SQLChR13 = "Select
				  RHVDBFOLHA.VDB,
				  RHVDBFOLHA.CONTRATO,
				  RHCONTRATOS.CONTRATO As CONTRATO1,
				  RHVDBFOLHA.DATAFOLHA,
				  RHPESSOAS.NOME,
				  RHCONTRATOS.PESSOA,
				  RHVDB.VDB As VDB1,
				  RHVDB.DESCRICAO30,
				  RHVDB.DESCRICAO15,
				  RHVDBFOLHA.HORASQUANTIDADE,
				  RHVDBFOLHA.VALOR,
				  RHVDBFOLHA.ORIGEMVDB,
				  RHVDBFOLHA.TIPOINFOFOLHA,
				  RHVDB.TIPOVDB,
				  RHCONTRATOS.CONTACORRENTE,
				  RHCONTRATOS.BANCO,
				  RHBANCOS.DESCRICAO40 As DESCRICAOBANCO,
				  RHBANCOS.BANCO As BANCO1,
				  RHBANCOS.AGENCIA As AGENCIA1,
				  RHBANCOS.NROBANCO As NROBANCO1,
				  RHBANCOS.DIGITOAGENCIA,
				  RHBANCOS.NROAGENCIA,
				  RHPESSOAS.EMAILCORPORATIVO
				From
				  RHVDBFOLHA Left Join
				  RHCONTRATOS On RHVDBFOLHA.CONTRATO = RHCONTRATOS.CONTRATO Inner Join
				  RHPESSOAS On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
				  RHVDB On RHVDBFOLHA.VDB = RHVDB.VDB Inner Join
				  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
				  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh13."')
				  AND dbo.RHVDBFOLHA.DATAFOLHA ='".$array_resultadoChC13Data['DATAFOLHA']."'
				  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
	$resChR13 = odbc_exec($conCab, $SQLChR13);
	$array_resultadoChR13 = odbc_fetch_array($resChR13);
    $valor131=0;
	        while($array_resultadoChC13 = odbc_fetch_array($resChC13)){
			if($array_resultadoChC13["TIPOVDB"]=='V' && $array_resultadoChC13["VDB"]=='51' || $array_resultadoChC13["VDB"]=='152' || $array_resultadoChC13["VDB"]=='154' || $array_resultadoChC13["VDB"]=='156'){
			$valor131=$valor131+$array_resultadoChC13["VALOR"];
			echo"    <tr>"; 
			echo"    <td align='center'>".$array_resultadoChC13["VDB"]."</td>";
			echo"    <td>".$array_resultadoChC13["DESCRICAO30"]."</td>";
			echo"    <td align='right'></td>";
			echo"    <td align='right'>".number_format($array_resultadoChC13["VALOR"],2, ',', '.')."</td>";
			echo"    <td></td>";
			echo"    </tr>";
			  }
			}
			echo "</table>";
    echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr align='right'>";
	echo "    <td width='134'>Sal&aacute;rio p/ M&ecirc;s</td>";
	echo "    <td width='134'>Base INSS</td>";
	echo "    <td width='134'>Base IRRF</td>";
	echo "    <td width='126'>FGTS</td>";
	echo "    <td width='134'>Total Venctos</td>";
	echo "    <td width='135'>Total Descontos</td>";
	echo "  </tr>";
	echo "  <tr align='right'>";
	$vctos13=0;
	$dctos13=0;
	        echo "    <td>".number_format($valor131,2, ',', '.')."</td>";
	        echo "    <td>".number_format($valor131,2, ',', '.')."</td>";
			echo "    <td>".number_format("0",2, ',', '.')."</td>";
			echo "    <td>".number_format("0",2, ',', '.')."</td>";
			echo "    <td>".number_format($valor131,2, ',', '.')."</td>";
			echo "    <td>".number_format("0",2, ',', '.')."</td>";
	$conta13=$array_resultadoChR13["CONTACORRENTE"];
	$banco13=substr($array_resultadoChR13["DESCRICAOBANCO"], 0, -15);
	$agencia13=$array_resultadoChR13["NROAGENCIA"];
	$digitoAg13=$array_resultadoChR13["DIGITOAGENCIA"];
	//$liquido13 = $vctos13-$dctos13;
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='659'>Depositado na Conta: ".$conta13."<br />";
	echo "  ".$banco13."";
	echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ag&ecirc;ncia: ".$agencia13."-".$digitoAg13."</td>";
	echo "    <td width='170' align='right'><strong>L &iacute; q u i d o<br />".number_format($valor131,2, ',', '.')."</strong></td>";
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='845'>Recebi o valor l&iacute;quido deste recibo,<br />";
	echo "      correspondente a discrimina&ccedil;&atilde;o acima<br />";
	echo "      do qual dou plena e total "; 
	echo "quita&ccedil;&atilde;o.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/_____/______ ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ass._________________________________</td>";
	echo "  </tr>";
	echo "</table>";
	}else{
while($array_resultadoChC13 = odbc_fetch_array($resChC13)){
		if ($array_resultadoChC13["TIPOVDB"]=="V"){
			if($array_resultadoChC13["HORASQUANTIDADE"]==0){
			echo"    <tr>"; 
			echo"    <td align='center'>".$array_resultadoChC13["VDB"]."</td>";
			echo"    <td>".$array_resultadoChC13["DESCRICAO30"]."</td>";
			echo"    <td align='right'></td>";
			echo"    <td align='right'>".number_format($array_resultadoChC13["VALOR"],2, ',', '.')."</td>";
			echo"    <td></td>";
			echo"    </tr>";
			}else{
				echo"    <tr>"; 
			echo"    <td align='center'>".$array_resultadoChC13["VDB"]."</td>";
			echo"    <td>".$array_resultadoChC13["DESCRICAO30"]."</td>";
			echo"    <td align='right'>".number_format($array_resultadoChC13["HORASQUANTIDADE"],0, ',', '.')."</td>";
			echo"    <td align='right'>".number_format($array_resultadoChC13["VALOR"],2, ',', '.')."</td>";
			echo"    <td></td>";
			echo"    </tr>";
				}}
			if ($array_resultadoChC13["TIPOVDB"]=="D"){
				if($array_resultadoChC13["HORASQUANTIDADE"]==0){
						echo"    <tr>";
						echo"    <td align='center'>".$array_resultadoChC13["VDB"]."</td>";
						echo"    <td>".$array_resultadoChC13["DESCRICAO30"]."</td>";
						echo"    <td align='right'></td>";
						echo"    <td></td>";
						echo"    <td align='right'>".number_format($array_resultadoChC13["VALOR"],2, ',', '.')."</td>";
						echo"    </tr>";
						}else{
							echo"    <tr>";
						echo"    <td align='center'>".$array_resultadoChC13["VDB"]."</td>";
						echo"    <td>".$array_resultadoChC13["DESCRICAO30"]."</td>";
						echo"    <td align='right'>".number_format($array_resultadoChC13["HORASQUANTIDADE"],0, ',', '.')."</td>";
						echo"    <td></td>";
						echo"    <td align='right'>".number_format($array_resultadoChC13["VALOR"],2, ',', '.')."</td>";
						echo"    </tr>";
							}
						}
		}
echo "</table>";
$SQLChR13 = "Select
				  RHVDBFOLHA.VDB,
				  RHVDBFOLHA.CONTRATO,
				  RHCONTRATOS.CONTRATO As CONTRATO1,
				  RHVDBFOLHA.DATAFOLHA,
				  RHPESSOAS.NOME,
				  RHCONTRATOS.PESSOA,
				  RHVDB.VDB As VDB1,
				  RHVDB.DESCRICAO30,
				  RHVDB.DESCRICAO15,
				  RHVDBFOLHA.HORASQUANTIDADE,
				  RHVDBFOLHA.VALOR,
				  RHVDBFOLHA.ORIGEMVDB,
				  RHVDBFOLHA.TIPOINFOFOLHA,
				  RHVDB.TIPOVDB,
				  RHCONTRATOS.CONTACORRENTE,
				  RHCONTRATOS.BANCO,
				  RHBANCOS.DESCRICAO40 As DESCRICAOBANCO,
				  RHBANCOS.BANCO As BANCO1,
				  RHBANCOS.AGENCIA As AGENCIA1,
				  RHBANCOS.NROBANCO As NROBANCO1,
				  RHBANCOS.DIGITOAGENCIA,
				  RHBANCOS.NROAGENCIA,
				  RHPESSOAS.EMAILCORPORATIVO
				From
				  RHVDBFOLHA Left Join
				  RHCONTRATOS On RHVDBFOLHA.CONTRATO = RHCONTRATOS.CONTRATO Inner Join
				  RHPESSOAS On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
				  RHVDB On RHVDBFOLHA.VDB = RHVDB.VDB Inner Join
				  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
				  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh13."')
				  AND dbo.RHVDBFOLHA.DATAFOLHA ='".$array_resultadoChC13Data['DATAFOLHA']."'
				  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL";
	$resChR13 = odbc_exec($conCab, $SQLChR13);
    echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr align='right'>";
	echo "    <td width='134'>Sal&aacute;rio p/ M&ecirc;s</td>";
	echo "    <td width='134'>Base INSS</td>";
	echo "    <td width='134'>Base IRRF</td>";
	echo "    <td width='126'>FGTS</td>";
	echo "    <td width='134'>Total Venctos</td>";
	echo "    <td width='135'>Total Descontos</td>";
	echo "  </tr>";
	echo "  <tr align='right'>";
	$vctos13=0;
	$dctos13=0;
	while($array_resultadoChR13 = odbc_fetch_array($resChR13)){
	   if($array_resultadoChR13["VDB"]=="401"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR13["VDB"]=="451"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR13["VDB"]=="461"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR13["VDB"]=="474"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR13["VDB"]=="491"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
		  $vctos13=$array_resultadoChR13["VALOR"];
	      }
	   if($array_resultadoChR13["VDB"]=="492"){
	      echo "    <td>".number_format($array_resultadoChR13["VALOR"],2, ',', '.')."</td>";
		  $dctos13=$array_resultadoChR13["VALOR"];
	      }
	$conta13=$array_resultadoChR13["CONTACORRENTE"];
	$banco13=substr($array_resultadoChR13["DESCRICAOBANCO"], 0, -15);
	$agencia13=$array_resultadoChR13["NROAGENCIA"];
	$digitoAg13=$array_resultadoChR13["DIGITOAGENCIA"];
	$liquido13 = $vctos13-$dctos13;
	}
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='659'>Depositado na Conta: ".$conta13."<br />";
	echo "  ".$banco13."";
	echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ag&ecirc;ncia: ".$agencia13."-".$digitoAg13."</td>";
	echo "    <td width='170' align='right'><strong>L i q u i d o<br />".$liquido13."</strong></td>";
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='845'>Recebi o valor l&iacute;quido deste recibo,<br />";
	echo "      correspondente a discrimina&ccedil;&atilde;o acima<br />";
	echo "      do qual dou plena e total "; 
	echo "quita&ccedil;&atildeo.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/_____/______ ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ass._________________________________</td>";
	echo "  </tr>";
	echo "</table>";
}}
//Escreve o rodapé do contra cheque
function escreveRodapeContCheq($mesCh,$anoCh,$nome_funcCh){
	if($mesCh<10){
		if($mesCh==4||$mesCh==6||$mesCh==9){
			$data=$anoCh."-0".$mesCh."-30 00:00:00.000";
		}elseif($mesCh==2){
			$data=$anoCh."-0".$mesCh."-28 00:00:00.000";
		}else{
			$data=$anoCh."-0".$mesCh."-31 00:00:00.000";
			}
	}else{
		if($mesCh==11){
			$data=$anoCh."-".$mesCh."-30 00:00:00.000";
		}else{
			$data=$anoCh."-".$mesCh."-31 00:00:00.000";
			}
	}
	require('conectsqlserver.php');
	$SQLChR = "Select
				  RHVDBFOLHA.VDB,
				  RHVDBFOLHA.CONTRATO,
				  RHCONTRATOS.CONTRATO As CONTRATO1,
				  RHVDBFOLHA.DATAFOLHA,
				  RHPESSOAS.NOME,
				  RHCONTRATOS.PESSOA,
				  RHVDB.VDB As VDB1,
				  RHVDB.DESCRICAO30,
				  RHVDB.DESCRICAO15,
				  RHVDBFOLHA.HORASQUANTIDADE,
				  RHVDBFOLHA.VALOR,
				  RHVDBFOLHA.ORIGEMVDB,
				  RHVDBFOLHA.TIPOINFOFOLHA,
				  RHVDB.TIPOVDB,
				  RHCONTRATOS.CONTACORRENTE,
				  RHCONTRATOS.BANCO,
				  RHBANCOS.DESCRICAO40 As DESCRICAOBANCO,
				  RHBANCOS.BANCO As BANCO1,
				  RHBANCOS.AGENCIA As AGENCIA1,
				  RHBANCOS.NROBANCO As NROBANCO1,
				  RHBANCOS.DIGITOAGENCIA,
				  RHBANCOS.NROAGENCIA,
				  RHPESSOAS.EMAILCORPORATIVO
				From
				  RHVDBFOLHA Left Join
				  RHCONTRATOS On RHVDBFOLHA.CONTRATO = RHCONTRATOS.CONTRATO Inner Join
				  RHPESSOAS On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
				  RHVDB On RHVDBFOLHA.VDB = RHVDB.VDB left Join
				  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
				  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')
				  AND dbo.RHCONTRATOS.DATARESCISAO IS NULL 
				  ORDER BY RHVDBFOLHA.VDB
				  ";
	$resChR = odbc_exec($conCab, $SQLChR);
    echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr align='right'>";
	echo "    <td width='134'>Sal&aacute;rio p/ M&ecirc;s</td>";
	echo "    <td width='134'>Base INSS</td>";
	echo "    <td width='134'>Base IRRF</td>";
	echo "    <td width='126'>FGTS</td>";
	echo "    <td width='134'>Total Venctos</td>";
	echo "    <td width='135'>Total Descontos</td>";
	echo "  </tr>";
	echo "  <tr align='right'>";
	$vctos=0;
	$dctos=0;
	while($array_resultadoChR = odbc_fetch_array($resChR)){
	 if ($data==$array_resultadoChR["DATAFOLHA"]){
	   if($array_resultadoChR["VDB"]=="401"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR["VDB"]=="451"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR["VDB"]=="461"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR["VDB"]=="474"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
	      }
	   if($array_resultadoChR["VDB"]=="491"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
		  $vctos=$array_resultadoChR["VALOR"];
	      }
	   if($array_resultadoChR["VDB"]=="492"){
	      echo "    <td>".number_format($array_resultadoChR["VALOR"],2, ',', '.')."</td>";
		  $dctos=$array_resultadoChR["VALOR"];
	      }
	 }
	$conta=$array_resultadoChR["CONTACORRENTE"];
	$banco=substr($array_resultadoChR["DESCRICAOBANCO"], 0, -15);
	$agencia=$array_resultadoChR["NROAGENCIA"];
	$digitoAg=$array_resultadoChR["DIGITOAGENCIA"];
	$liquido = $vctos-$dctos;
	}
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='659'>Depositado na Conta: ".$conta."<br />";
	echo "  ".$banco."";
	echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ag&ecirc;ncia: ".$agencia."-".$digitoAg."</td>";
	echo "    <td width='170' align='right'><strong>L &iacute; q u i d o<br />".$liquido."</strong></td>";
	echo "  </tr>";
	echo "</table>";
	}

//Montar combobox
function montaCombo($nome, $rs, $valor, $descricao){
   	echo("<div id='select'><select name='$nome' class='combo'>");
	echo("<option value=''>--Selecione--</option>");
	while ($obj = mysql_fetch_object($rs)){			
		echo("<option value='".$obj->$valor."' > ". $obj->$descricao." </option>");
	}
	echo("</select></div>");
}

//COnverter cadastro de usuário em maisculo
function convertem($term, $tp) { 
    if ($tp == "1") $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); 
    elseif ($tp == "0") $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ"); 
    return $palavra; 
}

//Incluir funcioinário
function inserirFuncionario($nome3,$login2,$email,$cigamId,$modId,$contMod){
	//Comparação com os dados do SIGAM
//$loginInsert=strstr($login2,"@",true);
	$loginInsert=$login2;
	require('conectsqlserver.php');
		  $SQLCab9 = "Select
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$email."')";
          $resCab9 = odbc_exec($conCab, $SQLCab9);
	      $array_resultado9 = odbc_fetch_array($resCab9);
		  
		  if(empty($array_resultado9)){
             ?>
			   <script type="text/javascript">
               alert("Usu\u00e1rio n\u00e3o cadastrado no CIGAM com os dados informados.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	}else {
	require('conexaomysql.php');
	require ('conectsqlserverci.php');
	$consultaUsuarioCigam=odbc_exec($conCab,"SELECT Cd_usuario FROM GEUSUARI (nolock) WHERE nome='".$nome3."'");
	$consultaArrayUsuarioCigam=odbc_fetch_array($consultaUsuarioCigam);
	$userCigam='A02';
	if(!empty($consultaArrayUsuarioCigam)){
		$userCigam=$consultaArrayUsuarioCigam['Cd_usuario'];
		}else{
			$userCigam=trim($cigamId);
			}
	$insertFunc="INSERT INTO usuarios VALUES ('','".$nome3."','".$email."' ,'".$loginInsert."','12345','3','','".$userCigam."',0,0,0)";
	$consultaDuplo = "SELECT * FROM usuarios WHERE usuario='".$loginInsert."'";
	$consultaDexec = mysql_query($consultaDuplo) or die(mysql_error());
	$contarDuplo=mysql_num_rows($consultaDexec);
	if($contarDuplo>='1') {
		?>
       <script type="text/javascript">
       alert("Existe um usu\u00e1rio com o mesmo login no sistema. Por favor verificar.");
       history.back();
       </script>
       <?php 
	   }else{
		$inserirFunc=mysql_query($insertFunc);
	     if ($inserirFunc) {
			 $sqlUserInst=mysql_query("SELECT id FROM usuarios WHERE usuario='".$loginInsert."'");
			 $arrayUserInst=mysql_fetch_array($sqlUserInst);
			  while($contMod>0){
				 $insertMod=mysql_query("INSERT INTO modulo VALUES ('','".$arrayUserInst['id']."','".$modId[$contMod]."')") or die(mysql_error());
				 $contMod--;
				 }
     	  ?>
          <script type="text/javascript">
          alert("Funcion\u00e1rio Cadastrado com Sucesso!");
          window.location.href = 'home.php';
          </script>
       <?php
       header('Localização: principal.php');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("Erro ao inserir o usu\u00e1rio. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	          }
	   }
	}
}
//Função para cadastrar solicitação de 13
function inserirSolic13($funcionarioIns13,$gestor13){
	require('conexaomysql.php');
	$gestorQ13 = mysql_query("SELECT * FROM gestores WHERE id = ".$gestor13) or die(mysql_error());
	$gestorA13 = mysql_fetch_array($gestorQ13);	
	$insertSol13="INSERT INTO sol13 VALUES ('','".$funcionarioIns13."','".date("d/m/y")."' ,'".$gestorA13["nome"]."','1')";
	$inserir213=mysql_query($insertSol13) or die(mysql_error());
	if ($inserir213) {
     	?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o cadastrada com sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: sol13.php');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("N\u00e3o foi possível inserir a solicita\u00e7\u00e3o. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: sol13.php');
	          }
	   }


//Função para cadastrar solicitação de férias
function inserirSolic($funcionario8,$dataInicio,$dataFinal,$gestor,$abono,$radio){
	require('conexaomysql.php');
	echo $funcionario8;
	$gestorQ = mysql_query("SELECT * FROM gestores WHERE id = ".$gestor) or die(mysql_error());
	$gestorA = mysql_fetch_array($gestorQ);	
	$insertSol="INSERT INTO solferias VALUES ('','".utf8_decode($funcionario8)."','".$dataInicio."' ,'".$dataFinal."','".$gestorA["nome"]."','1','".$abono."','1','".$radio."')";
	$comandosql3="SELECT * FROM solferias  WHERE funcionario='".$funcionario8."' and datainicio='".$dataInicio."' and datafinal='".$dataFinal."' and gestor='".$gestorA["nome"]."' and status='1'";
	$consulta2 = mysql_query($comandosql3) or die(mysql_error());
	$contar2=mysql_num_rows($consulta2);
	if($contar2>='1') {
		?>
       <script type="text/javascript">
       alert("Existe uma solicita\u00e7\u00e3o semelhante pendente de aprova\u00e7\u00e3o no sistema, por favor aguarde resposta de seu gestor: <?php echo $gestorA["nome"] ?>.");
       history.back();
       </script>
       <?php 
	   }else{
	$inserir2=mysql_query($insertSol) or die(mysql_error());
	if ($inserir2) {
     	?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o cadastrada com sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: solferias.php');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("N\u00e3o foi poss\u00edvel inserir a solicita\u00e7\u00e3o. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: solferias.php');
	          }
	   }
	}
	
//Função para montar grade de Solicitações de 13 Pendentes

function montaGradePendente13($usuarioGradeP13){
	 $rs13 = mysql_query("SELECT * FROM sol13  WHERE funcionario='".utf8_decode($usuarioGradeP13)."' and status=1");
	  $contador13P = mysql_num_rows($rs13);
	 if($contador13P==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO PENDENTE<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data de Solicitação</strong></th><th width='320'><strong>Gestor</strong></th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj13 = mysql_fetch_object($rs13)){
			echo "<form action='excluirSol13.php' method='post' name='form".$obj13->id."' > <tr><td>".$obj13->dt_sol."</td><td><input name='id' id='id' value='".$obj13->id."' size='30' type='hidden'/>".$obj13->gestor."</td><td>Pendente de Aprovação</td><td><input class='button'  name='enviar5' type='submit' value='Excluir ?' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}
//Função para montar grade de Solicitações de 13 Aprovadas

function montaGradeAprovadas13($usuarioGradeAp13){
	 $rs113 = mysql_query("SELECT * FROM sol13  WHERE funcionario='".utf8_decode($usuarioGradeAp13)."' and status=2");
	  $contadorAp13 = mysql_num_rows($rs113);
	 if($contadorAp13==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO APROVADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data de Solicitação</strong></th><th width='320'><strong>Gestor</strong></th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj113 = mysql_fetch_object($rs113)){
			echo "<form action='imp13.php' method='post' name='form".$obj113->id."' > <tr><td>".$obj113->dt_sol."</td><td><input name='id' id='id' value='".$obj113->id."' size='30' type='hidden'/>".$obj113->gestor."</td><td>Aprovado</td><td><input class='button'  name='enviar6' type='submit' value='Imprimir Solicitacao' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}

//Função para montar grade de Solicitações de 13 Aprovadas para RH

function montaGradeAprovadasRh13(){
	 $rs113 = mysql_query("SELECT * FROM sol13  WHERE status=2 ORDER BY id DESC");
	  $contadorAp13 = mysql_num_rows($rs113);
	 if($contadorAp13==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO APROVADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Funcion&aacute;rio</strong></th><th width='60'><strong>Data de Solicitação</strong></th><th width='320'><strong>Gestor</strong></th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj113 = mysql_fetch_object($rs113)){
			echo "<form action='imp13.php' method='post' name='form".$obj113->id."' > <tr><td>".$obj113->funcionario."</td><td>".$obj113->dt_sol."</td><td><input name='id' id='id' value='".$obj113->id."' size='30' type='hidden'/>".$obj113->gestor."</td><td>Aprovado</td><td><input class='button'  name='enviar6' type='submit' value='Imprimir Solicitacao' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}

//Função para montar grade de Solicitações de 13º Recusadas

function montaGradeRecusadas13($usuarioGradeRe13){
	 $rs213 = mysql_query("SELECT * FROM sol13  WHERE funcionario='".utf8_decode($usuarioGradeRe13)."' and status=3");
	  $contadorRec13 = mysql_num_rows($rs213);
	 if($contadorRec13==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO RECUSADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='70'><strong>Data de Solicitação</strong></th><th width='340'><strong>Gestor</strong></th><th><strong>Status do Pedido</strong></th></tr>";
		while($obj213 = mysql_fetch_object($rs213)){
			echo "<form action='excluirSol.php' method='post' name='form".$obj213->id."' > <tr><td>".$obj213->dt_sol."</td><td>".$obj213->gestor."</td><td>Recusada</td></tr> </form>";
			}
			echo "</table></div>";}
	}



//Função para montar grade de Solicitações de Ferias Pendentes

function montaGradePendente($usuarioGradeP){
	 $rs = mysql_query("SELECT * FROM solferias  WHERE funcionario='".utf8_decode($usuarioGradeP)."' and status=1");
	  $contadorPen = mysql_num_rows($rs);
	 if($contadorPen==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO PENDENTE<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj = mysql_fetch_object($rs)){
			if($obj->abono=="abono"){
				$abonopd="SIM";}
				else{
					$abonopd="NAO";}
			echo "<form action='excluirSol.php' method='post' name='form".$obj->id."' > <tr><td>".$obj->datainicio."</td><td>".$obj->datafinal."</td><td><input name='id' id='id' value='".$obj->id."' size='30' type='hidden'/>".$obj->gestor."</td><td>".$abonopd."</td><td>".$obj->ad13."</td><td>Pendente de Aprovação</td><td><input class='button'  name='enviar5' type='submit' value='Excluir ?' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}
	
//Função para montar grade de Solicitações de Ferias Aprovadas

function montaGradeAprovadas($usuarioGradeAp){
	 $rs1 = mysql_query("SELECT * FROM solferias  WHERE funcionario='".utf8_decode($usuarioGradeAp)."' and status=2");
		 $contadorAp = mysql_num_rows($rs1);
	 if($contadorAp==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO APROVADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj1 = mysql_fetch_object($rs1)){
			if($obj1->abono=="abono"){
				$abonoap="SIM";}
				else{
					$abonoap="NAO";}
			echo "<form action='impFerias.php' method='post' name='form".$obj1->id."' > <tr><td>".$obj1->datainicio."</td><td>".$obj1->datafinal."</td><td><input name='id' id='id' value='".$obj1->id."' size='30' type='hidden'/>".$obj1->gestor."</td><td>".$abonoap."</td><td>".$obj1->ad13."</td><td>Aprovado</td><td><input class='button'  name='enviar6' type='submit' value='Imprimir Solicitacao' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}
//Função para montar grade de Solicitações de Ferias Aprovadas

function montaGradeAprovadasRh(){
	 $rs1 = mysql_query("SELECT * FROM solferias  WHERE status=2 ORDER BY id DESC");
		 $contadorAp = mysql_num_rows($rs1);
	 if($contadorAp==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO APROVADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Funcion&aacute;rio</strong></th><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj1 = mysql_fetch_object($rs1)){
			if($obj1->abono=="abono"){
				$abonoap="SIM";}
				else{
					$abonoap="NAO";}
			echo "<form action='impFerias.php' method='post' name='form".$obj1->id."' > <tr><td>".$obj1->funcionario."</td><td>".$obj1->datainicio."</td><td>".$obj1->datafinal."</td><td><input name='id' id='id' value='".$obj1->id."' size='30' type='hidden'/>".$obj1->gestor."</td><td>".$abonoap."</td><td>".$obj1->ad13."</td><td>Aprovado</td><td><input class='button'  name='enviar6' type='submit' value='Imprimir Solicitacao' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}


//Função para montar grade de Solicitações de Ferias Recusadas

function montaGradeRecusadas($usuarioGradeRe){
	 $rs2 = mysql_query("SELECT * FROM solferias  WHERE funcionario='".utf8_decode($usuarioGradeRe)."' and status=3");
	  $contadorRec = mysql_num_rows($rs2);
	 if($contadorRec==0){
		 echo "<BR>NÃO EXISTE SOLICITAÇÃO RECUSADA<BR>";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='70'><strong>Data Inicial</strong></th><th width='70'><strong>Qtd. Dias</strong></th><th width='340'><strong>Gestor</strong></th><th><strong>Status do Pedido</strong></th></tr>";
		while($obj2 = mysql_fetch_object($rs2)){
			echo "<form action='excluirSol.php' method='post' name='form".$obj2->id."' > <tr><td>".$obj2->datainicio."</td><td>".$obj2->datafinal."</td><td><input name='id' id='id' value='".$obj2->id."' size='30' type='hidden'/>".$obj2->gestor."</td><td>Recusadas</td></tr> </form>";
			}
			echo "</table></div>";}
	}
//Função para excluir um usuario
function excluirUserIntranet($idUserIntranet){
	require('conexaomysql.php');
	echo $idUserIntranet;
	$excluirUserIntranet="DELETE FROM usuarios WHERE (id='".$idUserIntranet."')";
    $deleteSqlUserIntranet=mysql_query($excluirUserIntranet);
	if ($deleteSqlUserIntranet) {
     	?>
       <script type="text/javascript">
       alert("Usuario exclu\u00eddo com sucesso!");
       window.location.href = 'listaUsuarios.php';
       </script>
       <?php
       header('Localização: listaUsuarios.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Usu\u00e1rio n\u00e3o exclu\u00eddo. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: listaUsuarios.php');
	      }
	mysql_close($conexao);
	}
//Função para excluir uma solicitação de 13
function excluirSol13($id13){
	require('conexaomysql.php');
	$excluirSql13="DELETE FROM sol13 WHERE (id='".$id13."')";
    $deleteSql13=mysql_query($excluirSql13);
	if ($deleteSql13) {
     	?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o deletada com sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: sol13.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o n\u00e3o deletada. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: sol13.php');
	      }
	mysql_close($conexao);
	}
//Função para excluir uma solicitação de férias
function excluirSol($id){
	require('conexaomysql.php');
	$excluirSql="DELETE FROM solferias WHERE (id='".$id."')";
    $deleteSql=mysql_query($excluirSql);
	if ($deleteSql) {
     	?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o deletada com Sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: solferias.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Solicita\u00e7ão n\u00e3o deletada. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: solferias.php');
	      }
	mysql_close($conexao);
	}

//Função para imprimir uma solicitação de 13
function imprimirFerias13($idFerias13){
	require('conexaomysql.php');
	   $imprimirSQL13 = mysql_query("SELECT * FROM sol13  WHERE id='".$idFerias13."'");
		while($objImprimir13 = mysql_fetch_object($imprimirSQL13)){
			echo "<table width='704' border='0'>
  <tr>
    <td><p align='center'><img src='imagens/logoDocumento.png' alt='' width='95' height='120' /> <br />
      ______________________________________________________________________________</p>
      <p align='center'><strong>SOLICITAÇÃO DE 13º SALÁRIO</strong></p>
      <p align='center'>&nbsp;</p>
        <strong>Data:</strong>  ".date("d")." / ".date("m")." / ".date("Y")."<br />
        <br />
        <strong>De</strong>: ".utf8_encode($objImprimir13->funcionario)."</p>
      <strong>Para</strong>: Recursos Humanos - DRH
      <p><strong>Referência: </strong> Solicitação de Adiantamento da 1ª Parcela de 13º Salário</p>
    <p></p></td>
  </tr>
  <tr>
    <td><p><br>Tendo em vista dificuldades financeiras no momento, venho solicitar que me seja adiantado a 1ª parecela do 13º salário do corrente ano.</p>
      <p align='center'>Solicitação aprovada por:<strong> ".utf8_encode($objImprimir13->gestor)."</strong> . </p>
	  <p align='center'>Identificador para autenticação: <strong>".$objImprimir13->id."</strong> . </p>
	  
	  
	  <ul>
      <p></p>
      <p></p>
      <p align='center'>&nbsp;</p>
	  <p align='center'>&nbsp;</p>
      <p>Atenciosamente,</p>
      <p align='center'>&nbsp;</p>
      <p align='center'>         ____________________________________________<br />
  <strong>".utf8_encode($objImprimir13->funcionario)."</strong></p>
     <br>
	 <br>
	 <p align='center'> APROVADO POR: <strong>".utf8_encode($objImprimir13->gestor)."</strong></p>
  </td>
  </tr>
  <tr>
    <td><img src='imagens/rodapeDocumento.png' width='703' height='77' /></td>
  </tr>
</table>";
			}
			
	}

//Função para imprimir uma solicitação de férias
function imprimirFerias($idFerias){
	require('conexaomysql.php');
	require('conectsqlserver.php');
	
	   $imprimirSQL = mysql_query("SELECT * FROM solferias  WHERE solferias.id='".$idFerias."'");
		$objImprimir = mysql_fetch_object($imprimirSQL);
		
		$consultaEmail=mysql_fetch_array(mysql_query("SELECT email FROM usuarios WHERE nome='".$objImprimir->funcionario."'"));
		$dataFerias=odbc_exec($conCab,"Select TOP 1
  RHPESSOAS.NOMECOMPLETO,
  RHCONTRATOS.DATAINICIOFERIAS,
  RHCONTRATOS.DATATERMINOFERIAS,
  RHCONTRATOS.DATAVENCTOFERIAS,
  RHCONTRATOS.DATAADMISSAO
From
  RHPESSOAS With(NoLock) Inner Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.EMPRESA = RHPESSOAS.EMPRESA And
    RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA
Where
  RHPESSOAS.EMAILCORPORATIVO = '".$consultaEmail['email']."'
  ORDER BY RHCONTRATOS.DATAADMISSAO DESC");
$datasFeriasArray=odbc_fetch_array($dataFerias);
$dtFeriasCompleto=explode("/",date('d/m/Y',strtotime($datasFeriasArray['DATAVENCTOFERIAS'])));
$diaFim=$dtFeriasCompleto[0]+1;
$mesFim=$dtFeriasCompleto[1];
$anoFim=$dtFeriasCompleto[2]-1;
if($dtFeriasCompleto[1]==2){
	if($dtFeriasCompleto[0]==28){
		$diaFim=1;
		$mesFim=3;
		}
	}elseif($dtFeriasCompleto[1]==1 || $dtFeriasCompleto[1]==3 || $dtFeriasCompleto[1]==5 || $dtFeriasCompleto[1]==7 || $dtFeriasCompleto[1]==8 || $dtFeriasCompleto[1]==10 || $dtFeriasCompleto[1]==12){
		if($dtFeriasCompleto[0]==31){
		$diaFim=1;
		$mesFim=$dtFeriasCompleto[1]+1;
		if($mesFim==13){
			$mesFim=1;
			$anoFim=$anoFim+1;
			}
		}
	}elseif($dtFeriasCompleto[1]==4 || $dtFeriasCompleto[1]==6 || $dtFeriasCompleto[1]==9 || $dtFeriasCompleto[1]==11){
		if($dtFeriasCompleto[0]==30){
		   $diaFim=1;
		   $mesFim=$dtFeriasCompleto[1]+1;
		  }
		}
$dtInicioFerias=$diaFim." / ".$mesFim." / ".$anoFim;
$dtFimFerias=($dtFeriasCompleto[0])." / ".$dtFeriasCompleto[1]." / ".($dtFeriasCompleto[2]);
			if($objImprimir->abono=="abono"){
				$abonoIp="SIM";}
				else{
					$abonoIp="NAO";}
			echo "<table width='704' border='0'>
  <tr>
    <td><p align='center'><img src='imagens/logoDocumento.png' alt='' width='95' height='120' /> <br />
      ______________________________________________________________________________</p>
      <p align='center'><strong>SOLICITAÇÃO DE FÉRIAS</strong></p>
      <p align='center'>&nbsp;</p>
        <strong>Data:</strong>  ".date("d")." / ".date("m")." / ".date("Y")."<br />
        <br />
        <strong>De</strong>: ".utf8_encode($objImprimir->funcionario)."</p>
      <strong>Para</strong>: Recursos Humanos - DRH
      <p><strong>Referência: </strong> Solicitação de férias</p>
    <p></p></td>
  </tr>
  <tr>
    <td><p>Considerando adquirir direito às férias do período aquisitivo de <u>".$dtInicioFerias."</u>  a <u>".$dtFimFerias."</u>, venho solicitar que me sejam concedidos férias no período abaixo:</p> 

	  <p align='center'><strong>".$objImprimir->datafinal."</strong> DIAS A PARTIR DE: <strong>".$objImprimir->datainicio."</strong>. </p>
	  <ul>
      <p><li>10 Dias Convertidos em Abono Pecuniário, Conforme Legislação  Vigente.(<strong>".$abonoIp."</strong>)</li></p>
      <p><li>Solicitação do Adiantamento da Primeira Parcela do 13º Salário: (<strong>".strtoupper($objImprimir->ad13)."</strong>)</li></p>
      <p align='center'>&nbsp;</p>
	  <p align='center'>&nbsp;</p>
      <p>Atenciosamente,</p>
	  <p align='center'>&nbsp;</p>
      <p align='center'>         _____________________________________________<br />
  <strong>".utf8_encode($objImprimir->funcionario)."</strong></p>
     <br>
	 <br>
	  <p align='center'> APROVADO POR:  <strong>".utf8_encode($objImprimir->gestor)."</strong></p>
  </td>
  </tr>
  <tr>
    <td><img src='imagens/rodapeDocumento.png' width='703' height='77' /></td>
  </tr>
</table>";			
	}
////Função para atualizar uma solicitação de férias
function atualizaSol13($id13,$status613,$funcFerias13){
	require('conexaomysql.php');
	include "mb.php";
	$updateSol13="UPDATE sol13 SET status = '".$status613."' WHERE id = '".$id13."'";
    $atualizarSol13=mysql_query($updateSol13) or die(mysql_error());
	$consultaGestor13="SELECT * FROM sol13 WHERE id='".$id13."'";
	$consultaGestorEx13=mysql_query($consultaGestor13) or die(mysql_error());
	$resultadoGestor13 = mysql_fetch_array($consultaGestorEx13);
	
	if ($atualizarSol13) {
	   	?>
       <script type="text/javascript">
	     alert("Solicita\u00e7\u00e3o Alterada com Sucesso <?php $funcFerias13 ?>!");
         window.location.href = 'home.php';
       </script>
       <?php
      // header('Localização: principal.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o n\u00e3oo alterada. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: gestFerias.php');
	      }
	mysql_close($conexao);
	}


////Função para atualizar uma solicitação de férias
function atualizaSol($id,$status6,$funcFerias){
	require('conexaomysql.php');
	include "mb.php";
	include "functionEmailRh.php";
	$updateSol="UPDATE solferias SET status = '".$status6."' WHERE id = '".$id."'";
    $atualizarSol=mysql_query($updateSol) or die(mysql_error());
	$consultaGestor="SELECT * FROM solferias WHERE id='".$id."'";
	$consultaGestorEx=mysql_query($consultaGestor) or die(mysql_error());
	$resultadoGestor = mysql_fetch_array($consultaGestorEx);
	
	if ($atualizarSol) {
		if($resultadoGestor['status']=='2'){
		$abono="NÃO";
		if($resultadoGestor['abono']=='abono'){
			$abono="NÃO";
			}
		$mensagemHtml="Prezados representantes do RH,\n\n<br><br>
		Informamos que as f&eacute;rias do funcion&aacute;rio ".$resultadoGestor['funcionario']." foi aprovada por ".$resultadoGestor['gestor']." em ".date("d/m/Y H:i:s").".\n<br>
		Data de in&iacute;cio: ".$resultadoGestor['datainicio'].".\n<br>
		Dias: ".$resultadoGestor['datafinal']."\n<br>
		Abono: ".$abono."\n<br>
		Adiantamento 13&ordm;: ".$resultadoGestor['ad13']."\n\n<br><br>
		Atenciosamente,\n\n<br><br>
		
		INTRANET/CPB";
	
	   	enviaEmailRh("FÉRIAS Aprovadas - ".$resultadoGestor['funcionario'],$mensagemHtml,"","","","");
		}else{
			?>
       <script type="text/javascript">
       alert("Recusada com sucesso.");
       window.location.href='home.php';
       </script>
       <?php
			}
		} else {
	          ?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o n\u00e3o alterada. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: gestFerias.php');
	      }
	mysql_close($conexao);
	}
	

//Função Alerta
function alertaOutros($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}
//Função para montar grade de Solicitações de Ferias Pendentes

function listaSolicitac13($userGestor13){
	 $rsGest13 = mysql_query("SELECT * FROM sol13  WHERE status=1 and gestor='".utf8_decode($userGestor13)."' ");
		 $contadorFeriasG13 = mysql_num_rows($rsGest13);
	 if($contadorFeriasG13==0){
		 echo "<BR><BR>NÃO EXISTE SOLICITAÇÃO PENDENTE";
		 }else{
		echo "<div id='tabela'><table border='1'> <tr><th width='120'><strong>Funcionario</strong></th><th width='70'><strong>Data de Solicitação</strong></th><th width='280'><strong>Gestor</strong></th><th width='150'><strong>Status do Pedido</strong></th><th width='60'>Aprovar/Recusar</th></tr>";
		while($objGest13 = mysql_fetch_object($rsGest13)){
			echo "<form action='atualizaSol13.php' method='post' name='form2".$objGest13->id."' > <tr><td><input name='nfunc2' id='nfunc2' value='".$objGest13->funcionario."' size='40' type='hidden' />".$objGest13->funcionario."</td><td>".$objGest13->dt_sol."</td><td><input name='id' id='id' value='".$objGest13->id."' size='30' type='hidden'/>".$objGest13->gestor."</td><td>Pendente de Aprovação</td>
	<td><div id='select'><select name='stat' id='stat'>
      <option selected='selected'></option>
      <option value='2'>Aprovada</option>
      <option value='3'>Recusada</option>
	  </select></div></td><td><input name='enviar5' class='button' type='submit' value='Alterar' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}

//Função para mostrar dados ao gestor
//Função para montar grade de Solicitações de Ferias Pendentes

function listaSolicitac($userGestor){
	echo $userGestor;
	 $rsGest = mysql_query("SELECT * FROM solferias  WHERE status=1 and gestor='".utf8_decode($userGestor)."' ");
	 $contadorFeriasG = mysql_num_rows($rsGest);
	 if($contadorFeriasG==0){
		 echo "<BR><BR>NÃO EXISTE SOLICITAÇÃO PENDENTE";
		 }else{
		 echo "<div id='tabela'><table border='1'> <tr><th width='120'><strong>Funcionario</strong></th><th width='70'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='280'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='150'><strong>Status do Pedido</strong></th><th width='60'>Aprovar/Recusar</th></tr>";
		
		while($objGest = mysql_fetch_object($rsGest)){
			if($objGest->abono=="abono"){
				$abonoGest="SIM";}
				else{
					$abonoGest="NAO";}
			echo "<form action='atualizaSol.php' method='post' name='form2".$objGest->id."' > <tr><td><input name='nfunc2' id='nfunc2' value='".$objGest->funcionario."' size='40' type='hidden' />".$objGest->funcionario."</td><td>".$objGest->datainicio."</td><td>".$objGest->datafinal."</td><td><input name='id' id='id' value='".$objGest->id."' size='30' type='hidden'/>".$objGest->gestor."</td><td>".$abonoGest."</td><td>".$objGest->ad13."</td><td>Pendente de Aprovação</td>
	<td><div id='select'><select name='stat' id='stat'>
      <option selected='selected'></option>
      <option value='2'>Aprovada</option>
      <option value='3'>Recusada</option>
	  </select></div></td><td><input name='enviar5' class='button' type='submit' value='Alterar' /></td></tr> </form>";
			}
			echo "</table></div>";}
	}

//Função de inserção de dados CI
function updateCi ($ciUpdate,$UserCiUpdate,$descricaoCiUpdate,$controleNovoCiUpdate,$pgRetornoUp,$idTipoUp){
	echo "<div id='outro' style='display: none;'>";
	require('conexaomysql.php');
	include "enviaEmail.php";
	$listaEmail='';
    $SQLIdIntranet =  mysql_query("SELECT * FROM usuarios WHERE usuario = '".$UserCiUpdate."'") or die(mysql_error());
    $resIdIntranet = mysql_fetch_array($SQLIdIntranet);
	$SQLIdIntranetEmail =  mysql_query("SELECT * FROM usuarios WHERE controle = '".$controleNovoCiUpdate."' Order By nome DESC") or die(mysql_error());
    $resIdIntranetEmail = mysql_fetch_array($SQLIdIntranetEmail);
	//Gambiarra para Comunicação (Alerar urgente)
	if($resIdIntranetEmail['controle']=='19'){
		$SQLIdIntranetEmail =  mysql_query("SELECT * FROM usuarios WHERE id = '192'") or die(mysql_error());
    $resIdIntranetEmail = mysql_fetch_array($SQLIdIntranetEmail);
		}
	$idUserIntranet=$resIdIntranet['cigam'];
	if($idTipoUp=='AT'){
	require "conectsqlserverci.php";
		}else{
	//require "conectsqlserverci.php";
	require "conectsqlserverciprod.php";
	 }
	$SQLConsContrCI = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol,
							  COCSO.controle
					   FROM COCSO WITH(nolock)
					   WHERE controle = '".$controleNovoCiUpdate."'";
			$resConsContrCI = odbc_exec($conCab, $SQLConsContrCI);
			$arrayConsContrCI = odbc_fetch_array($resConsContrCI);
			$SQLConsStatusCi = "SELECT 
								COSOLICI.campo27
					   FROM COSOLICI (nolock)
					   WHERE Solicitacao = '".$ciUpdate."'";
			$resConsStatusCi = odbc_exec($conCab, $SQLConsStatusCi);
			$arrayConsStatusCi = odbc_fetch_array($resConsStatusCi);
			$SQLConsContrCIAnt = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol,
							  COCSO.controle
					   FROM COCSO WITH(nolock)
					   WHERE controle = '".$arrayConsStatusCi['campo27']."'";
			$resConsContrCIAnt = odbc_exec($conCab, $SQLConsContrCIAnt);
			$arrayConsContrCIAnt = odbc_fetch_array($resConsContrCIAnt);
	        $dataCi=date("d.m.y");
			$horaCi=date("H:i:s");
			$horaSessaoCi=date("His");
			$SQLConsItemCI = "SELECT campo65,
									 situacao,
									 Sequencia
							  FROM COISOLIC with(nolock)
							  WHERE cd_especie_esto='E'
							  AND cd_solicitacao='".$ciUpdate."'";
			$resConsItemCI = odbc_exec($conCab, $SQLConsItemCI);
			//Fim das Consultas, inicia a atualização
			//Se o controle for diferente de AP, ele faz apenas a atualização
			if($controleNovoCiUpdate!='AP'){
			$updCoisolic=TRUE;
			$descContCIItemNovo='';
			while($objConsItemCI = odbc_fetch_object($resConsItemCI)){
				$descContCIItem=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
				$descContCIItemNovo=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
				$historicoCiItens="O controle do item da solicitação foi alterado de ".$objConsItemCI->campo65." - ".rtrim($descContCIItem)." para ".$controleNovoCiUpdate." - ".rtrim($descContCIItemNovo)." . Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCiItens=mb_convert_encoding($historicoCiItens,"ISO-8859-1","UTF-8");
			$SQLupdCoisolic="UPDATE COISOLIC
							 SET campo65='".$controleNovoCiUpdate."',
							 situacao='".$arrayConsContrCI['situac_item_sol']."',
							 usuario_modific='".$idUserIntranet."',
							 dt_modificacao=dbo.CGFC_DATAATUAL()
							 WHERE cd_especie_esto='E'
							 AND cd_solicitacao='".$ciUpdate."'
							 AND Sequencia='".$objConsItemCI -> Sequencia."'";
		    $updCoisolic=odbc_exec($conCab,$SQLupdCoisolic) or die("<p>".odbc_errormsg());
			$ciUpdateItensSol=str_pad($ciUpdate, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeq=str_pad($objConsItemCI -> Sequencia, 3, "0", STR_PAD_LEFT);
			$ciUpdateItens=$ciUpdateItensSol."/".$ciUpdateItensSeq;
			$SQLInsAcompItens="INSERT INTO GEACOMP VALUES('','".$ciUpdateItens."',".$ciUpdate.",".$objConsItemCI -> Sequencia.",'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCiItens."')";
			$InsAcompItens=odbc_exec($conCab,$SQLInsAcompItens) or die("<p>".odbc_errormsg());
			}
			$descContCI=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
			$descContCINovo=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
			$historicoCi="O controle da solicitação foi alterado de ".$arrayConsStatusCi['campo27']." - ".rtrim($descContCI)." para ".$controleNovoCiUpdate." - ".rtrim($descContCINovo).". Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCi=mb_convert_encoding($historicoCi,"ISO-8859-1","UTF-8");
			$SQLupdCosolici="UPDATE COSOLICI
							 SET campo27='".$controleNovoCiUpdate."',
							 situacao='".$arrayConsContrCI['sit_solicitacao']."'
							 WHERE solicitacao='".$ciUpdate."'";
		    $updCosolici=odbc_exec($conCab,$SQLupdCosolici) or die("<p>".odbc_errormsg());
			$ciUpdateCapa=str_pad($ciUpdate, 8, " ", STR_PAD_LEFT);
			$SQLInsAcompSol="INSERT INTO GEACOMP VALUES('','".$ciUpdateCapa."',0,0,'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCi."')";
			$InsAcompSol=odbc_exec($conCab,$SQLInsAcompSol) or die("<p>".odbc_errormsg());
			if($InsAcompSol){
			if ($updCoisolic) {
			                  
			if ($updCosolici) {	
$descContCIEmail=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
$controleCIEmail=$arrayConsContrCIAnt['controle'];
//$descContCIItemEmailNovo=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
	$emailSent[0]=$resIdIntranetEmail['email'];
	//$emailSent[0]='edy@cpb.org.br';
	ciAprovadaEmail($resIdIntranet['nome'],$resIdIntranetEmail['nome'],$emailSent,$ciUpdate,$descricaoCiUpdate,$controleCIEmail,rtrim(	$descContCIEmail),$controleNovoCiUpdate,$descContCINovo,$pgRetornoUp,0);
			}
			}
			}
			}
			//Se for para AP, iniciar esse processo de atualização que inclui lançamentos financeiros
			else{
				$SQLItemCILancAp = "select its.cd_solicitacao,
       							   its.sequencia,
								   its.quantidade,
								   its.pr_unitario,
								   its.cd_unidade_de_n,
								   its.cd_conta_gerenc,
								   its.campo41 as redContabil,
								   its.cd_material,
								   its.campo65,
								   sol.campo32 contaFinanc,
								   sol.cod_cliente empresaSol,
								   por.cd_portador,
								   isnull((select top 1 'Sim'
										   from TEITEMSOLDIARIAVIAGEM dia (nolock)
               				where dia.solicitacao = its.cd_solicitacao
               				and dia.sequencia = its.sequencia),'Não') possuiDiaria
							from COISOLIC its (nolock)
							inner join COSOLICI sol (nolock) on sol.solicitacao = its.cd_solicitacao
							left join TEPORTADORSOL por (nolock) on por.solicitacao = its.cd_solicitacao
							where its.cd_especie_esto = 'E'
							and its.campo65 <> 'AP'
							and its.cd_solicitacao = '".$ciUpdate."'
					--desconsiderando itens que possam estar diferente de 'AP' mas que possuem lançamentos financeiros já gerados...
					and not exists(select 1
								   from GFLANCAM lan (nolock) 
								   where lan.tipo_documento = '8'
								   and rtrim(ltrim(lan.documento)) = its.cd_solicitacao
								   and rtrim(ltrim(lan.usrlanc1)) = cast(its.sequencia as varchar(5)))";
				$resItemCILancAp = odbc_exec($conCab, $SQLItemCILancAp);
				//Buscando parametros de verbas de solicitação
				$SQLVerbasAp = "select dias_vcto,
									   historico,
									   historico_rpa,
									   historico_diaria
								from TEPARAMVERBA (nolock)";
				$resVerbasAp = odbc_exec($conCab, $SQLVerbasAp);
				$arrayVerbasAp = odbc_fetch_array($resVerbasAp);
				$lancFinanceiroAP=0;
				while($objItemCILancAp = odbc_fetch_object($resItemCILancAp)){
					if($objItemCILancAp->possuiDiaria=='Sim'){
						$SQLDiariasCiAp="select sequencia,
								   empresa,
								   valor
							from TEITEMSOLDIARIAVIAGEM (nolock)
							where solicitacao = '".$ciUpdate."' ";
						$resDiariasCiAp = odbc_exec($conCab, $SQLDiariasCiAp);
						//10868
					while($objDiariasCiAp = odbc_fetch_object($resDiariasCiAp)){
						$lancFinanceiroItemAP=0;
						$SQLUpUlLanAP = "UPDATE GFNUMLAN                                                     
									   SET Cd_ultimo_lanca = Cd_ultimo_lanca+1
									   WHERE Unico = ' '";
						$resUpUlLanAP = odbc_exec($conCab, $SQLUpUlLanAP) or die("<p>".odbc_errormsg());
						$SQLUlLanAP = "SELECT Cd_ultimo_lanca 
									   FROM GFNUMLAN (nolock)
									   WHERE Unico = ' '";
						$resUlLanAP = odbc_exec($conCab, $SQLUlLanAP);
						$arrayUlLanAp = odbc_fetch_array($resUlLanAP);
						if($resUpUlLanAP){
							//Pegando o número de lançamento financeiro
							$lancFinanceiroAP=$arrayUlLanAp['Cd_ultimo_lanca'];
							}
						//Lançamento da tabela GFLANCAM
						$cigflancamAP=str_pad($ciUpdate, 12, " ", STR_PAD_LEFT);
						$SQLgflancamAP="insert into GFLANCAM
   									(cd_lancamento,data,dt_vencimento,nf,fatura,complemento,cd_historico,historico,cd_conta,cd_tipo,valor,cd_empresa,cd_cobranca,  									cheque,cd_portador,dt_emissao,cd_c_partida,vl_saldo,conferido,desconto,situacao,conciliado,serie,contabilizado,usuario_modific,cd_tipo_de_paga,numero_no_banco,vl_juros_total,vl_juros_dia,dt_ultima_liqui,cd_unidade_de_n,documento,tipo_documento,vl_indexado,vl_saldo_indexa,tolerancia_venc,pe_multa,vl_multa,tolerancia_mult,tolerancia_juro,pe_juros,   									tipo_juros,vl_desconto,cd_lancamento_v,dt_inclusao,cd_sacador_aval,modalidade_venc,modalidade_paga,especie_documen,dt_provavel_pag,projeto, cd_contrato,cd_indice,bloqueto_impres,duplicata_impre,remessa_enviada,autorizado_por,dt_autorizado_e,dt_modificacao,usuario_criacao,sessao,campo60,campo61,campo62,campo63,campo64,campo65,campo66,campo67,campo68,campo69,campo70,campo71,campo72,campo73,campo74,campo75,campo76,campo77,campo78,campo79,campo80,campo81,campo82,campo83,campo84,campo85,campo86,campo87,campo88,usrlanc1,usrlanc2,usrlanc3
)
values
   (".$lancFinanceiroAP.",       									 --  Cd_lancamento  int 
   dbo.CGFC_DATAATUAL(),    									 --  Data  datetime 
   dbo.CGFC_DATAATUAL()+".$arrayVerbasAp['dias_vcto'].",           --  Dt_vencimento  datetime 
   0,                            									 --  Nf  float 
   0,                            									 --  Fatura  float 
   ' ',                          									 --  Complemento  char(5)
   '".$arrayVerbasAp['historico_diaria']."',                         --  Cd_historico  char(3)
   ' ',                          									 --  Historico  char(201)
   '".$objItemCILancAp->contaFinanc."',               				 --  Cd_conta  char(6)
   'P',                          									 --  Cd_tipo  char(1)
   -".abs($objDiariasCiAp->valor).",                  					 --  Valor  float 
   '".$objDiariasCiAp->empresa."',                                   --  Cd_empresa  char(6)
   '".$objDiariasCiAp->empresa."',                                   --  Cd_cobranca  char(6)
   0,                            									 --  Cheque  int 
   '".$objItemCILancAp->cd_portador."',		                         --  Cd_portador  char(3)
   dbo.CGFC_DATAATUAL(),    										 --  Dt_emissao  datetime 
   0,                            									 --  Cd_c_partida  int 
   -".abs($objDiariasCiAp->valor).",                                       --  Vl_saldo  float 
   ' ',                          									 --  Conferido  char(1)
   0,                            									 --  Desconto  real 
   'A',                          									 --  Situacao  char(1)
   ' ',                          									 --  Conciliado  char(1)
   ' ',                          									 --  Serie  char(5)
   'N',                          									 --  Contabilizado  char(1)
   '".$idUserIntranet."',                          					 --  Usuario_modific  char(3)
   ' ',                          									 --  Cd_tipo_de_paga  char(2)
   ' ',                          									 --  Numero_no_banco  char(15)
   0,                            									 --  Vl_juros_total  float 
   0,                            									 --  Vl_juros_dia  float 
   null,                         									 --  Dt_ultima_liqui  datetime 
   '".$objItemCILancAp->cd_unidade_de_n."', 						 --  Cd_unidade_de_n  char(3)
   '".$cigflancamAP."',               								 --  Documento  char(12)
   '8',                         									 --  Tipo_documento  char(1)
   0,                            									 --  Vl_indexado  float 
   0,                            									 --  Vl_saldo_indexa  float 
   0,                            									 --  Tolerancia_venc  smallint 
   0,                            									 --  Pe_multa  real 
   0,                            									 --  Vl_multa  float 
   0,                            									 --  Tolerancia_mult  smallint 
   0,                            									 --  Tolerancia_juro  smallint 
   0,                            									 --  Pe_juros  real 
   'S',                          									 --  Tipo_juros  char(1)
   0,                            									 --  Vl_desconto  float 
   0,                            									 --  Cd_lancamento_v  int 
   dbo.CGFC_DATAATUAL(),       									 --  Dt_inclusao  datetime 
   ' ',                          									 --  Cd_sacador_aval  char(6)
   ' ',                          									 --  Modalidade_venc  char(1)
   'P',                          									 --  Modalidade_paga  char(1)
   ' ',                          									 --  Especie_documen  char(2)
   dbo.CGFC_DATAATUAL(),                     						 --  Dt_provavel_pag  datetime 
   ' ',                          									 --  Projeto  char(12)
   ' ',                          									 --  Cd_contrato  char(8)
   ' ',                          									 --  Cd_indice  char(5)
   0,                            									 --  Bloqueto_impres  bit 
   0,                            									 --  Duplicata_impre  bit 
   0,                            									 --  Remessa_enviada  bit 
   ' ',                          									 --  Autorizado_por  char(3)
   null,                          									 --  Dt_autorizado_e  datetime 
   null,                          									 --  Dt_modificacao  datetime 
   '".$idUserIntranet."',                    						 --  Usuario_criacao  char(3)
   0,                          									     --  Sessao  int 
   null,                          									 --  campo60  datetime 
   null,                          									 --  campo61  datetime 
   null,                          									 --  campo62  datetime 
   null,                          									 --  campo63  datetime 
   ' ',                          									 --  campo64  char(6)
   ' ',                          									 --  campo65  char(6)
   ' ',                                                    			 --  campo66  char(6)
   ' ',                          									 --  campo67  char(6)
   ' ',                          									 --  campo68  char(1)
   ' ',                          									 --  campo69  char(1)
   ' ',                          									 --  campo70  char(1)
   'N',                          									 --  campo71  char(2)
   ' ',                          									 --  campo72  char(2)
   ' ',                          									 --  campo73  char(2)
   ' ',                          									 --  campo74  char(3)
   ' ',                          									 --  campo75  char(3)
   ' ',                          									 --  campo76  char(3)
   1,                          									     --  campo77  bit 
   0,                          									     --  campo78  bit 
   0,                          									     --  campo79  bit 
   0,                            									 --  campo80  float 
   0,                            									 --  campo81  float 
   0,                            									 --  campo82  float 
   0,                            									 --  campo83  float 
   0,                            									 --  campo84  float 
   0,                            									 --  campo85  float 
   ' ',                          									 --  campo86  char(20)
   ' ',                          									 --  campo87  char(20)
   '".$horaSessaoCi."',            									 --  campo88  char(6)
   '".$objItemCILancAp->sequencia."',                          		 --  usrlanc1  char(20)
   null,                          									 --  usrlanc2  datetime 
   0                             									 --  usrlanc3  float  
   )";
   $resgflancamAP = odbc_exec($conCab, $SQLgflancamAP) or die("<p>".odbc_errormsg());
   $SQLgfrcntbAP="insert into GFRCNTB(cd_lancamento,cd_reduzido_con,percentual_rate,valor,debito_credito,cd_historico,sessao,usuario_modific,usuario_criacao,dt_modificacao,campo9,campo11,campo12,campo13,campo14,campo15,campo16,cd_unidade_de_n,campo18,campo19,campo20,campo21,campo23)
					values
					   (".$lancFinanceiroAP.",       							 --  Cd_lancamento  int 
					   ".$objItemCILancAp->redContabil.",                        --  Cd_reduzido_con  int 
					   100,                          							 --  Percentual_rate  float 
					   ".$objDiariasCiAp->valor.",                         		 --  Valor  float 
					   ' ',                          							 --  Debito_credito  char(1)
					   ' ',                          							 --  Cd_historico  char(3)
					   0,                            							 --  Sessao  int 
					   ' ',                          							 --  Usuario_modific  char(3)
					   '".$idUserIntranet."',                   				 --  Usuario_criacao  char(3)
					   null,                         							 --  Dt_modificacao  datetime 
					   dbo.CGFC_DATAATUAL(),   	 							 --  campo9  datetime 
					   ' ',                          							 --  campo11  char(6)
					   ' ',                          							 --  campo12  char(6)
					   ' ',                          							 --  campo13  char(1)
					   ' ',                          							 --  campo14  char(1)
					   ' ',                          							 --  campo15  char(2)
					   ' ',                          							 --  campo16  char(2)
					   '".$objItemCILancAp->cd_unidade_de_n."',                        							 --  Cd_unidade_de_n  char(3)
					   ' ',                          							 --  campo18  char(3)
					   0,                            							 --  campo19  bit 
					   0,                            							 --  campo20  bit 
					   0,                            							 --  campo21  float 
					   0                             							 --  campo23  float 
					   )";
   $resgfrcntbAP = odbc_exec($conCab, $SQLgfrcntbAP) or die("<p>".odbc_errormsg());
   $SQLgfrgerenAP="insert into GFRGEREN (cd_lancamento,cd_reduzido_con,cd_conta_gerenc,percentual_rate,valor,sessao,usuario_modific,usuario_criacao,dt_modificacao,campo10,campo11,campo12,campo13,campo14,
campo15,cd_unidade_de_n,campo17,campo18,campo19,campo20,campo21)
				   values
				   (".$lancFinanceiroAP.",       							 --  Cd_lancamento  int 
				   ".$objItemCILancAp->redContabil.",            			 --  Cd_reduzido_con  int 
				   '".$objItemCILancAp->cd_conta_gerenc."',  				 --  Cd_conta_gerenc  char(25)
				   100,				                 						 -- Percentual_rate  float 
				   ".$objDiariasCiAp->valor.",				                 --  Valor  float 
				   0,                										 --  Sessao  int 
				   ' ',              										 --  Usuario_modific  char(3)
				   '".$idUserIntranet."',            						 --  Usuario_criacao  char(3)
				   null,             										 --  Dt_modificacao  datetime 
				   null,             										 --  campo10  datetime 
				   ' ',              										 --  campo11  char(6)
				   ' ',              										 --  campo12  char(1)
				   ' ',              										 --  campo13  char(1)
				   ' ',              										 --  campo14  char(2)
				   ' ',              										 --  campo15  char(2)
				   '".$objItemCILancAp->cd_unidade_de_n."',       			 --  Cd_unidade_de_n  char(3)
				   ' ',              										 --  campo17  char(3)
				   0,                										 --  campo18  bit 
				   0,                										 --  campo19  bit 
				   0,                										 --  campo20  float 
				   0                 										 --  campo21  float
				   )";
   $resgfrgerenAP = odbc_exec($conCab, $SQLgfrgerenAP) or die("<p>".odbc_errormsg());
   $SQLUpdItemDiariaAP="update TEITEMSOLDIARIAVIAGEM 
						set lancamento = ".$lancFinanceiroAP."
						where solicitacao = ".$ciUpdate."
						and sequencia = ".$objDiariasCiAp->sequencia."
						and empresa = ".$objDiariasCiAp->empresa." ";
   $resUpdItemDiariaAP = odbc_exec($conCab, $SQLUpdItemDiariaAP) or die("<p>".odbc_errormsg());
	}
						}else{
						$lancFinanceiroItemAP=0;
							//Se não tiver diária
						$SQLUpUlLanItemAP = "UPDATE GFNUMLAN                                                     
									   SET Cd_ultimo_lanca = Cd_ultimo_lanca+1
									   WHERE Unico = ' '";
						$resUpUlLanItemAP = odbc_exec($conCab, $SQLUpUlLanItemAP) or die("<p>".odbc_errormsg());
						$SQLUlLanItemAP = "SELECT Cd_ultimo_lanca 
									   FROM GFNUMLAN 
									   WHERE Unico = ' '";
						$resUlLanItemAP = odbc_exec($conCab, $SQLUlLanItemAP);
						$arrayUlLanItemAp = odbc_fetch_array($resUlLanItemAP);
						if($resUpUlLanItemAP){
							//Pegando o número de lançamento financeiro
							$lancFinanceiroItemAP=$arrayUlLanItemAp['Cd_ultimo_lanca'];
							}	
						$cigflancamItemAP=str_pad($ciUpdate, 12, " ", STR_PAD_LEFT);
						$valorlancItemAp=$objItemCILancAp->pr_unitario*$objItemCILancAp->quantidade;
						$SQLgflancamItemAP="insert into GFLANCAM
   									(cd_lancamento,data,dt_vencimento,nf,fatura,complemento,cd_historico,historico,cd_conta,cd_tipo,valor,cd_empresa,cd_cobranca,  									cheque,cd_portador,dt_emissao,cd_c_partida,vl_saldo,conferido,desconto,situacao,conciliado,serie,contabilizado,usuario_modific,cd_tipo_de_paga,numero_no_banco,vl_juros_total,vl_juros_dia,dt_ultima_liqui,cd_unidade_de_n,documento,tipo_documento,vl_indexado,vl_saldo_indexa,tolerancia_venc,pe_multa,vl_multa,tolerancia_mult,tolerancia_juro,pe_juros,   									tipo_juros,vl_desconto,cd_lancamento_v,dt_inclusao,cd_sacador_aval,modalidade_venc,modalidade_paga,especie_documen,dt_provavel_pag,projeto, cd_contrato,cd_indice,bloqueto_impres,duplicata_impre,remessa_enviada,autorizado_por,dt_autorizado_e,dt_modificacao,usuario_criacao,sessao,campo60,campo61,campo62,campo63,campo64,campo65,campo66,campo67,campo68,campo69,campo70,campo71,campo72,campo73,campo74,campo75,campo76,campo77,campo78,campo79,campo80,campo81,campo82,campo83,campo84,campo85,campo86,campo87,campo88,usrlanc1,usrlanc2,usrlanc3
)
values
   (".$lancFinanceiroItemAP.",      								 --  Cd_lancamento  int 
   dbo.CGFC_DATAATUAL(),	    									 --  Data  datetime 
   dbo.CGFC_DATAATUAL()+".$arrayVerbasAp['dias_vcto'].",	         --  Dt_vencimento  datetime 
   0,                            									 --  Nf  float 
   0,                            									 --  Fatura  float 
   ' ',                          									 --  Complemento  char(5)
   '".$arrayVerbasAp['historico']."',	                             --  Cd_historico  char(3)
   ' ',                          									 --  Historico  char(201)
   '".$objItemCILancAp->contaFinanc."',               				 --  Cd_conta  char(6)
   'P',                          									 --  Cd_tipo  char(1)
   -".abs($valorlancItemAp).",		                  					 --  Valor  float 
   '".$objItemCILancAp->empresaSol."',                               --  Cd_empresa  char(6)
   '".$objItemCILancAp->empresaSol."',                               --  Cd_cobranca  char(6)
   0,                            									 --  Cheque  int 
   '".$objItemCILancAp->cd_portador."',		                         --  Cd_portador  char(3)
   dbo.CGFC_DATAATUAL(),    										 --  Dt_emissao  datetime 
   0,                            									 --  Cd_c_partida  int 
   -".abs($valorlancItemAp).",                                            --  Vl_saldo  float 
   ' ',                          									 --  Conferido  char(1)
   0,                            									 --  Desconto  real 
   'A',                          									 --  Situacao  char(1)
   ' ',                          									 --  Conciliado  char(1)
   ' ',                          									 --  Serie  char(5)
   'N',                          									 --  Contabilizado  char(1)
   '".$idUserIntranet."',                          					 --  Usuario_modific  char(3)
   ' ',                          									 --  Cd_tipo_de_paga  char(2)
   ' ',                          									 --  Numero_no_banco  char(15)
   0,                            									 --  Vl_juros_total  float 
   0,                            									 --  Vl_juros_dia  float 
   null,                         									 --  Dt_ultima_liqui  datetime 
   '".$objItemCILancAp->cd_unidade_de_n."', 						 --  Cd_unidade_de_n  char(3)
   '".$cigflancamItemAP."',            								 --  Documento  char(12)
   '8',                         									 --  Tipo_documento  char(1)
   0,                            									 --  Vl_indexado  float 
   0,                            									 --  Vl_saldo_indexa  float 
   0,                            									 --  Tolerancia_venc  smallint 
   0,                            									 --  Pe_multa  real 
   0,                            									 --  Vl_multa  float 
   0,                            									 --  Tolerancia_mult  smallint 
   0,                            									 --  Tolerancia_juro  smallint 
   0,                            									 --  Pe_juros  real 
   'S',                          									 --  Tipo_juros  char(1)
   0,                            									 --  Vl_desconto  float 
   0,                            									 --  Cd_lancamento_v  int 
   dbo.CGFC_DATAATUAL(),       					     				 --  Dt_inclusao  datetime 
   ' ',                          			  						 --  Cd_sacador_aval  char(6)
   ' ',                          									 --  Modalidade_venc  char(1)
   'P',                          									 --  Modalidade_paga  char(1)
   ' ',                          									 --  Especie_documen  char(2)
   dbo.CGFC_DATAATUAL(),                     						 --  Dt_provavel_pag  datetime 
   ' ',                          									 --  Projeto  char(12)
   ' ',                          									 --  Cd_contrato  char(8)
   ' ',                          									 --  Cd_indice  char(5)
   0,                            									 --  Bloqueto_impres  bit 
   0,                            									 --  Duplicata_impre  bit 
   0,                            									 --  Remessa_enviada  bit 
   ' ',                          									 --  Autorizado_por  char(3)
   null,                          									 --  Dt_autorizado_e  datetime 
   null,                          									 --  Dt_modificacao  datetime 
   '".$idUserIntranet."',                    						 --  Usuario_criacao  char(3)
   0,                          									     --  Sessao  int 
   null,                          									 --  campo60  datetime 
   null,                          									 --  campo61  datetime 
   null,                          									 --  campo62  datetime 
   null,                          									 --  campo63  datetime 
   ' ',                          									 --  campo64  char(6)
   ' ',                          									 --  campo65  char(6)
   ' ',                                                    			 --  campo66  char(6)
   ' ',                          									 --  campo67  char(6)
   ' ',                          									 --  campo68  char(1)
   ' ',                          									 --  campo69  char(1)
   'B',                          									 --  campo70  char(1)
   'N',                          									 --  campo71  char(2)
   ' ',                          									 --  campo72  char(2)
   ' ',                          									 --  campo73  char(2)
   ' ',                          									 --  campo74  char(3)
   ' ',                          									 --  campo75  char(3)
   ' ',                          									 --  campo76  char(3)
   1,                          									     --  campo77  bit 
   0,                          									     --  campo78  bit 
   0,                          									     --  campo79  bit 
   0,                            									 --  campo80  float 
   0,                            									 --  campo81  float 
   0,                            									 --  campo82  float 
   0,                            									 --  campo83  float 
   0,                            									 --  campo84  float 
   0,                            									 --  campo85  float 
   ' ',                          									 --  campo86  char(20)
   ' ',                          									 --  campo87  char(20)
   '".$horaSessaoCi."',            									 --  campo88  char(6)
   '".$objItemCILancAp->sequencia."',                          		 --  usrlanc1  char(20)
   null,                          									 --  usrlanc2  datetime 
   0                             									 --  usrlanc3  float  
   )";
   $resgflancamItemAP = odbc_exec($conCab, $SQLgflancamItemAP) or die("<p>".odbc_errormsg());
   
   $SQLgfrcntbItemAP="insert into GFRCNTB(cd_lancamento,cd_reduzido_con,percentual_rate,valor,debito_credito,cd_historico,sessao,usuario_modific,usuario_criacao,dt_modificacao,campo9,campo11,campo12,campo13,campo14,campo15,campo16,cd_unidade_de_n,campo18,campo19,campo20,campo21,campo23)
					values
					   (".$lancFinanceiroItemAP.",     							 --  Cd_lancamento  int 
					   ".$objItemCILancAp->redContabil.",                        --  Cd_reduzido_con  int 
					   100,                          							 --  Percentual_rate  float 
					   ".$valorlancItemAp.",	                         		 --  Valor  float 
					   ' ',                          							 --  Debito_credito  char(1)
					   ' ',                          							 --  Cd_historico  char(3)
					   0,                            							 --  Sessao  int 
					   ' ',                          							 --  Usuario_modific  char(3)
					   '".$idUserIntranet."',                   				 --  Usuario_criacao  char(3)
					   null,                         							 --  Dt_modificacao  datetime 
					   dbo.CGFC_DATAATUAL(),   	 								 --  campo9  datetime 
					   ' ',                          							 --  campo11  char(6)
					   ' ',                          							 --  campo12  char(6)
					   ' ',                          							 --  campo13  char(1)
					   ' ',                          							 --  campo14  char(1)
					   ' ',                          							 --  campo15  char(2)
					   ' ',                          							 --  campo16  char(2)
					   '".$objItemCILancAp->cd_unidade_de_n."',					 --  Cd_unidade_de_n  char(3)
					   ' ',                          							 --  campo18  char(3)
					   0,                            							 --  campo19  bit 
					   0,                            							 --  campo20  bit 
					   0,                            							 --  campo21  float 
					   0                             							 --  campo23  float 
					   )";
   $resgfrcntbItemAP = odbc_exec($conCab, $SQLgfrcntbItemAP) or die("<p>".odbc_errormsg());
   
   $SQLgfrgerenItemAP="insert into GFRGEREN (cd_lancamento,cd_reduzido_con,cd_conta_gerenc,percentual_rate,valor,sessao,usuario_modific,usuario_criacao,dt_modificacao,campo10,campo11,campo12,campo13,campo14,
campo15,cd_unidade_de_n,campo17,campo18,campo19,campo20,campo21)
				   values
				   (".$lancFinanceiroItemAP.",       							 --  Cd_lancamento  int 
				   ".$objItemCILancAp->redContabil.",            			 --  Cd_reduzido_con  int 
				   '".$objItemCILancAp->cd_conta_gerenc."',  				 --  Cd_conta_gerenc  char(25)
				   100,				                 						 -- Percentual_rate  float 
				   ".$valorlancItemAp.",					                 --  Valor  float 
				   0,                										 --  Sessao  int 
				   ' ',              										 --  Usuario_modific  char(3)
				   '".$idUserIntranet."',            						 --  Usuario_criacao  char(3)
				   null,             										 --  Dt_modificacao  datetime 
				   null,             										 --  campo10  datetime 
				   ' ',              										 --  campo11  char(6)
				   ' ',              										 --  campo12  char(1)
				   ' ',              										 --  campo13  char(1)
				   ' ',              										 --  campo14  char(2)
				   ' ',              										 --  campo15  char(2)
				   '".$objItemCILancAp->cd_unidade_de_n."',       			 --  Cd_unidade_de_n  char(3)
				   ' ',              										 --  campo17  char(3)
				   0,                										 --  campo18  bit 
				   0,                										 --  campo19  bit 
				   0,                										 --  campo20  float 
				   0                 										 --  campo21  float
				   )";
   $resgfrgerenItemAP = odbc_exec($conCab, $SQLgfrgerenItemAP) or die("<p>".odbc_errormsg());	
							}
				$descContCIItemAP=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
				$descContCIItemNovoAP=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
				$historicoCiItensAP="O controle do item da solicitação foi alterado de ".$objItemCILancAp->campo65." - ".rtrim($descContCIItemAP)." para ".$controleNovoCiUpdate." - ".rtrim($descContCIItemNovoAP)." . Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCiItensAP=mb_convert_encoding($historicoCiItensAP,"ISO-8859-1","UTF-8");
			$ciUpdateItensSolAP=str_pad($ciUpdate, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeqAP=str_pad($objItemCILancAp->sequencia, 3, "0", STR_PAD_LEFT);
			$ciUpdateItensAP=$ciUpdateItensSolAP."/".$ciUpdateItensSeqAP;
			$SQLInsAcompItensAP="INSERT INTO GEACOMP VALUES('','".$ciUpdateItensAP."',".$ciUpdate.",".$objItemCILancAp->sequencia.",'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCiItensAP."')";
			$InsAcompItensAP=odbc_exec($conCab,$SQLInsAcompItensAP) or die("<p>".odbc_errormsg());
					}
			$SQLupdCOISOLICAP="UPDATE COISOLIC
							 SET campo65='".$controleNovoCiUpdate."',
							 situacao='".$arrayConsContrCI['situac_item_sol']."',
							 usuario_modific='".$idUserIntranet."',
							 dt_modificacao=dbo.CGFC_DATAATUAL()
							 WHERE cd_especie_esto='E'
							 AND cd_solicitacao='".$ciUpdate."'";
		    $updCOISOLICAP=odbc_exec($conCab,$SQLupdCOISOLICAP) or die("<p>".odbc_errormsg());
			$SQLUpdCOSOLICAP="update COSOLICI
								set campo27 = '".$controleNovoCiUpdate."',
									situacao = '".$arrayConsContrCI['situac_item_sol']."',
									usuario_modific = '".$idUserIntranet."',
									dt_modificacao = dbo.CGFC_DATAATUAL()
								where solicitacao =".$ciUpdate."";
			$updCOSOLICAP=odbc_exec($conCab,$SQLUpdCOSOLICAP) or die("<p>".odbc_errormsg());
			$ciUpdateCapaAP=str_pad($ciUpdate, 8, " ", STR_PAD_LEFT);
			$descContCIAP=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
			$descContCINovoAP=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
			$historicoCiAP="O controle da solicitação foi alterado de ".$arrayConsStatusCi['campo27']." - ".rtrim($descContCIAP)." para ".$controleNovoCiUpdate." - ".rtrim($descContCINovoAP).". Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCiAP=mb_convert_encoding($historicoCiAP,"ISO-8859-1","UTF-8");
			$SQLInsAcompSolAP="INSERT INTO GEACOMP VALUES('','".$ciUpdateCapaAP."',0,0,'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCiAP."')";
			$InsAcompSolAP=odbc_exec($conCab,$SQLInsAcompSolAP) or die("<p>".odbc_errormsg());
			if($updCOSOLICAP){
			if($updCOISOLICAP){
$descContCIEmailAPNovo=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
$controleCIEmailAPNovo=$arrayConsContrCI['controle'];
$descContCIEmailAP=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
$controleCIEmailAP=$arrayConsContrCIAnt['controle'];

$sqlConsultaGrupo="Select
  ESMATERI.Cd_grupo,
  ESMATERI.Cd_sub_grupo
From
  COSOLICI with(nolock) Inner Join
  COISOLIC with(nolock) On COSOLICI.Solicitacao = COISOLIC.Cd_solicitacao Inner Join
  ESMATERI with(nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material
WHERE COSOLICI.Solicitacao='".$ciUpdate."'";
$resSubGrupo = odbc_exec($conCab, $sqlConsultaGrupo);
$emailSentAp='';
$contApEmail=0;
while($objSubGrupo = odbc_fetch_object($resSubGrupo)){
	$consultaEmails="SELECT 
  	TE.cd_grupo,
  	TE.cd_sub_grupo,
  TE.email,
  TE.controle
FROM
  TEEMAILSOLICITACAO TE (nolock)
WHERE
TE.cd_grupo = '".$objSubGrupo->Cd_grupo."' AND
TE.cd_sub_grupo='".$objSubGrupo->Cd_sub_grupo."'
AND TE.controle='".$controleCIEmailAPNovo."'";
	$resConsultaEmails = odbc_exec($conCab, $consultaEmails);
while($objresConsultaEmails = odbc_fetch_object($resConsultaEmails)){
        //$emailSentAp[0]='edywill@hotmail.com';
	//$emailSentAp[1]='edywill@gmail.com';
	//$emailSentAp[2]='edy@cpb.org.br';
	//$emailSentAp[3]='edy@cpb.org.br';
	$emailSentAp[$contApEmail]=$objresConsultaEmails->email;
	$contApEmail++;
	}
    
}

echo "</div>";
ciAprovadaEmail($resIdIntranet['nome'],'Usuario',$emailSentAp,$ciUpdate,$descricaoCiUpdate,$controleCIEmailAP,rtrim($descContCIEmailAP),$controleCIEmailAPNovo,rtrim($descContCIEmailAPNovo),$pgRetornoUp,($contApEmail-1));
}
				  }
			}
	}
//Função para montar grade de CI Pendentes
function listaCi($userCiGestor,$controleCiGestor,$userCdCigamGestor){
	    include "mb.php";
		require "conectsqlserverciprod.php";
		$SQLCiV = "Select 
  COSOLICI.Solicitacao,
  COSOLICI.Data,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Desc_cond_pag
From
  COSOLICI 
  where
  COSOLICI.campo27='".$controleCiGestor."'
  ORDER BY COSOLICI.Solicitacao DESC";
          $resCiV = odbc_exec($conCab, $SQLCiV);
			if($controleCiGestor=='05'){
			echo "<br/><div id='tabela3'><table width='100%' border='1'>";
		while($objCiV = odbc_fetch_object($resCiV)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI pendente!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$SQLConsItemCIV = "SELECT 
										COISOLIC.*,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objCiV->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
				$valorCItemV=0;
				if($objConsItemCIV->Pr_unitario<>0){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
				}
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
		echo"	<form action='atualizaCi.php' method='post' name='form4.id_CI' onsubmit=\"this.elements['enviar5''].disabled=true;\">
		<tr><td bgcolor='#658BF3' colspan='7'><center><strong> Solicita&ccedil;&atilde;o N&ordm; 
		<input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' />
		<input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
		<input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />".$objCiV->Solicitacao."</strong></center></td></tr>
		
		<tr><th><strong>Processo/Evento</strong></th><td colspan='3'>".$objCiV->Desc_cond_pag."</td>
		
		<th colspan='2'><strong>Data Solicita&ccedil;&atilde;o</strong></th>
		
		<td>".date('d/m/Y',strtotime($objCiV->Data))."</td></tr>
		
		<tr><th>Total(R$)</th><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td>
		
		<th colspan='2'><strong>Solicitante</strong></th><td colspan='3'>".$nomeCompleto."</td></tr>
		
		<tr><th >Controle</th><td><select name='controle'><option selected='selected'>Escolha</option><option value='16'> 16 </option><option value='EP'> EP </option></select><input name='enviar5' id='enviar5' class='buttonVerde' type='submit' value='Alterar' /></form>
		
		</td><th colspan='2'>Op&ccedil;&otilde;es</th><td colspan='2'>
		
		<form action='ciWAlteraItAp.php' method='post' name='form4.id_CIItens' ><input name='userCi' id='user_ciItens' value='".$userCdCigamGestor."' size='40' type='hidden' /><input name='solicitacao' id='id_ciItens' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objCiV->Data))."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$nomeCompleto."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='150' type='hidden' /><input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItens, 2, ',', '.')."' size='40' type='hidden' /><input name='controle_ci' id='controle_ci' value='".$controleCiGestor."' size='40' type='hidden' /><input name='enviar6' class='buttonVerde' type='submit' value='Dados Or&ccedil;amento' /></form></td>
		
		<td colspan='2'><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target='_blank' ><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='buttonVerde' type='submit' value='Visualizar CI' /></form></td></tr><tr><td colspan='8' height='25'></td></tr>";}
			
			
			
			}
			echo "</table></div>";  
			  }elseif($controleCiGestor=='EP'){
				  echo "<br/><div id='tabela3'><table width='100%' border='1'>";
		while($objCiV = odbc_fetch_object($resCiV)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI pendente!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$SQLConsItemCIV = "SELECT 
										COISOLIC.*,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objCiV->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
				$valorCItemV=0;
				if($objConsItemCIV->Pr_unitario<>0){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
				}
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' onsubmit=\"this.elements['enviar5''].disabled=true;\">
			<tr><td bgcolor='#658BF3' colspan='7'><center><strong> Solicita&ccedil;&atilde;o N&ordm; 
		<input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' />
		<input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
		<input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />".$objCiV->Solicitacao."</strong></center></td></tr>
		
		<tr><th><strong>Processo/Evento</strong></th><td colspan='3'>".$objCiV->Desc_cond_pag."</td>
		
		<th colspan='2'><strong>Data Solicita&ccedil;&atilde;o</strong></th>
		
		<td>".date('d/m/Y',strtotime($objCiV->Data))."</td></tr>
		
		<tr><th>Total(R$)</th><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td>
		
		<th colspan='2'><strong>Solicitante</strong></th><td colspan='3'>".$nomeCompleto."</td></tr>
		
		<tr><th width='40'>Aprova/Reprova</th><td>
		 <select name='controle'>
			<option selected='selected'>Escolha</option>
			<option value='AP'> Aprovar </option>
			<option value='RP'> Reprovar </option>
		 </select>
			<input id='enviar5' name='enviar5' class='buttonVerde' type='submit' value='Alterar' /></form>
		
		</td><th colspan='2'>Op&ccedil;&otilde;es</th><td colspan='2'>
		
		<form action='listaItensCi.php'  method='post' name='form4.id_CIItens' >
		<input name='user_ciItens' id='user_ciItens' value='".$userCiGestor."' size='40' type='hidden' /><input name='controle' id='controle' value='AP' size='40' type='hidden' /><input name='id_ciItens' id='id_ciItens' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objCiV->Data))."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$nomeCompleto."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='150' type='hidden' /><input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItens, 2, ',', '.')."' size='40' type='hidden' /><input name='controle_ci' id='controle_ci' value='".$controleCiGestor."' size='40' type='hidden' />
		<input name='enviar6' class='buttonVerde' type='submit' value='Detalhar Itens' /></form></td>
		
		<td colspan='2'><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target='_blank'><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
		
		<input name='enviar7' class='buttonVerde' type='submit' value='Visualizar CI' /></form></td></tr><tr><td colspan='8' height='25'></td></tr>";}
			
			}
			echo "</table></div>";
					}
				else{
				  if($controleCiGestor=='14'||$controleCiGestor=='15'||$controleCiGestor=='17'||$controleCiGestor=='18'||$controleCiGestor=='19'){
			$controleNovo='05';
			}elseif($controleCiGestor=='16'){
				$controleNovo='EP';
				}else{
						$controleNovo='FI';
						}		
		//  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th><th width='50'>Detalhar Itens</th><th width='50'>Visualizar CI</th></tr>";
		  echo "<br/><div id='tabela3'><table width='100%' border='1'>";
		while($objCiV = odbc_fetch_object($resCiV)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI pendente!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$SQLConsItemCIV = "SELECT 
										COISOLIC.*,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objCiV->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
			$valorCItemV=0;
				if($objConsItemCIV->Pr_unitario<>0){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
				}
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' onsubmit=\"this.elements['enviar5'].disabled=true;\"> 
					<tr><td bgcolor='#658BF3' colspan='7'><center><strong> Solicita&ccedil;&atilde;o N&ordm; 
							<input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' />
							<input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
							<input name='controle' id='controle' value='".$controleNovo."' size='40' type='hidden' />
							<input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />".$objCiV->Solicitacao."</td>
							
							<tr><th><strong>Processo/Evento</strong></th><td colspan='3'>".$objCiV->Desc_cond_pag."</td>
							
							<th colspan='2'><strong>Data Solicita&ccedil;&atilde;o</strong></th><td>".date('d/m/Y',strtotime($objCiV->Data))."</td></tr>
							
							<tr><th>Total(R$)</th><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td>
							
							<th colspan='2'><strong>Solicitante</strong></th><td colspan='3'>".$nomeCompleto."</td></tr>
							
							<tr><th width='40'>Aprova/Reprova</th><td><table border='0' width='100%'><tr align='center'><td><input id='enviar5' name='enviar5' class='buttonVerde' type='submit' value='Aprovar CI' /></form></td><td>
				<form action='recusaCi.php' method='post' name='form6.id_CI' onsubmit=\"this.elements['enviar6'].disabled=true;\">			
							<input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' />
							<input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
							<input name='controle' id='controle' value='".$controleNovo."' size='40' type='hidden' />
							<input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />
							<input id='enviar5' name='enviar5' class='buttonVerde' type='submit' value='Recusar CI' /></form>
							</td></tr></table>
							</td>
						
						<form action='listaItensCi.php' method='post' name='form4.id_CIItens' >
							<input name='user_ciItens' id='user_ciItens' value='".$userCiGestor."' size='40' type='hidden' />
							<input name='id_ciItens' id='id_ciItens' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
							<input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objCiV->Data))."' size='40' type='hidden' />
							<input name='solic_ci' id='solic_ci' value='".$nomeCompleto."' size='40' type='hidden' />
							<input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='150' type='hidden' />
							<input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItens, 2, ',', '.')."' size='40' type='hidden' />
							<input name='controle_ci' id='controle_ci' value='".$controleCiGestor."' size='40' type='hidden' />
							<input name='controle' id='controle' value='".$controleNovo."' size='40' type='hidden' />
						
						<th colspan='2'>Op&ccedil;&otilde;es</th><td colspan='2'>						
							<input name='enviar6' class='buttonVerde' type='submit' value='Detalhar Itens' /></td><td> </form>
						<form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target='_blank' >
							<input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' />
							<input name='enviar7' class='buttonVerde' type='submit' value='Visualizar CI' /></form></td></tr>
							<tr><td colspan='8' height='25'></td></tr>";}
			
			}
			echo "</table></div>";}
	}
//Função para montar grade de CI Pendentes

function impressaoCi($numeroCiImpressao){
	    echo "<div id='outro' style='display: none;'>";
		include "mb.php";
		require "conectsqlserverciprod.php";
		$SQLImpCI = " select 
   sol.Solicitacao,
   item.Sequencia,
   sol.Data,
   item.Pr_unitario,
   item.Quantidade,
   rtrim(mat.descricao) descricao,
   (select top 1 rtrim(T801.Historico) 
      from GEACOMP T801 with (nolock) 
      where T801.Codigo_titulo = '801' and T801.Tipo_acompanham = 'R' and
            ltrim(rtrim(T801.Embarque_pedido)) = cast(sol.solicitacao as varchar(12))) Descricao_T801,
   (select top 1 rtrim(T802.Historico)
      from GEACOMP T802 with (nolock) 
      where T802.Codigo_titulo = '802' and T802.Tipo_acompanham = 'R' and
            ltrim(rtrim(T802.contato_os_lanc)) = cast(sol.solicitacao as varchar(12)) and T802.Sequencia_item = item.Sequencia) Descricao_T802,
   (select top 1 rtrim(T803.Historico) 
      from GEACOMP T803 with (nolock) 
      where T803.Codigo_titulo = '803' and T803.Tipo_acompanham = 'R' and
            ltrim(rtrim(T803.contato_os_lanc)) = cast(sol.solicitacao as varchar(12)) and T803.Sequencia_item = item.Sequencia) Descricao_T803,  
   sol.Cod_cliente,
   cli.Nome_completo cliente,
   pes.Cargo,
   ISNULL((select distinct 1
               from TEITEMSOLPASSAGEM pas (nolock)
               where pas.cd_solicitacao = item.cd_solicitacao),0) Passagem,
   ISNULL((select distinct 1
               from TEITEMSOLHOTEL hot (nolock)
               where hot.cd_solicitacao = item.cd_solicitacao),0) Hotel,
   isnull((select distinct 1
           from TEITEMSOLRPA rpa (nolock)
           where rpa.cd_solicitacao = item.cd_solicitacao),0) RPA,
   isnull((select distinct 1
           from TEITEMSOLDIARIAVIAGEM dia (nolock)
           where dia.solicitacao = item.cd_solicitacao),0) Diaria
from COSOLICI sol with (nolock)
inner join GEEMPRES cli with (nolock) on
   cli.Cd_empresa = sol.Cod_cliente
left join COISOLIC item with (nolock) on
   item.Cd_solicitacao = sol.Solicitacao and
  item.cd_especie_esto = 'E'
left join ESMATERI mat with (nolock) on 
   mat.Cd_material = item.Cd_material
left join GEPFISIC pes with (nolock) on
   pes.Cd_empresa = sol.Cod_cliente
where sol.Solicitacao = '".$numeroCiImpressao."'
Order By item.Sequencia";
          $resImpCI = odbc_exec($conCab, $SQLImpCI);
		  $SQLImp2CI = "select 
   sol.Solicitacao,
   item.Sequencia,
   sol.Data,
   sol.Campo27 AS controle,
   item.Pr_unitario,
   item.Quantidade,
   sol.Desc_cond_pag,
   rtrim(mat.descricao) descricao,
   (select top 1 rtrim(T801.Historico) 
      from GEACOMP T801 with (nolock) 
      where T801.Codigo_titulo = '801' and T801.Tipo_acompanham = 'R' and
            ltrim(rtrim(T801.Embarque_pedido)) = cast(sol.solicitacao as varchar(12))) Descricao_T801,
   (select top 1 rtrim(T802.Historico)
      from GEACOMP T802 with (nolock) 
      where T802.Codigo_titulo = '802' and T802.Tipo_acompanham = 'R' and
            ltrim(rtrim(T802.contato_os_lanc)) = cast(sol.solicitacao as varchar(12)) and T802.Sequencia_item = item.Sequencia) Descricao_T802,
   (select top 1 rtrim(T803.Historico) 
      from GEACOMP T803 with (nolock) 
      where T803.Codigo_titulo = '803' and T803.Tipo_acompanham = 'R' and
            ltrim(rtrim(T803.contato_os_lanc)) = cast(sol.solicitacao as varchar(12)) and T803.Sequencia_item = item.Sequencia) Descricao_T803,  
   sol.Cod_cliente,
   cli.Nome_completo cliente,
   pes.Cargo,
   ISNULL((select distinct 1
               from TEITEMSOLPASSAGEM pas (nolock)
               where pas.cd_solicitacao = item.cd_solicitacao),0) Passagem,
   ISNULL((select distinct 1
               from TEITEMSOLHOTEL hot (nolock)
               where hot.cd_solicitacao = item.cd_solicitacao),0) Hotel,
   isnull((select distinct 1
           from TEITEMSOLRPA rpa (nolock)
           where rpa.cd_solicitacao = item.cd_solicitacao),0) RPA,
   isnull((select distinct 1
           from TEITEMSOLDIARIAVIAGEM dia (nolock)
           where dia.solicitacao = item.cd_solicitacao),0) Diaria
from COSOLICI sol with (nolock)
inner join GEEMPRES cli with (nolock) on
   cli.Cd_empresa = sol.Cod_cliente
left join COISOLIC item with (nolock) on
   item.Cd_solicitacao = sol.Solicitacao and
  item.cd_especie_esto = 'E'
left join ESMATERI mat with (nolock) on 
   mat.Cd_material = item.Cd_material
left join GEPFISIC pes with (nolock) on
   pes.Cd_empresa = sol.Cod_cliente
where sol.Solicitacao = '".$numeroCiImpressao."'";
          $resImp2CI = odbc_exec($conCab, $SQLImp2CI);
		  $arrayImpCi = odbc_fetch_array($resImp2CI);
		     	$SQLItemEmbarqueImp = "select Embarque_pedido, DATA, Historico
										from geacomp with (nolock)
										where ltrim(rtrim(Embarque_pedido)) = '".$numeroCiImpressao."'
										and Campo39 = 1
										and Campo40 = 1";
					$resItemEmbarqueImp = odbc_exec($conCab, $SQLItemEmbarqueImp);
					//$arrayItemEmbarqueImp = odbc_fetch_array($resItemEmbarqueImp);
					$SQLItemSoliciImp = "Select
										  SOL.Solicitacao,
										  IT.Cd_material,
										  IT.Cd_centro_armaz,
										  IT.Quantidade,
										  IT.Pr_unitario,
										  MAT.Descricao,
										  IT.Sequencia_ordem
										From
										  COSOLICI SOL with (nolock) left Join
										  COISOLIC IT with (nolock) On IT.Cd_solicitacao = SOL.Solicitacao Inner Join
										  ESMATERI MAT with (nolock) On MAT.Cd_material = IT.Cd_material Inner Join
										  GEEMPRES EMP with (nolock) On EMP.Cd_empresa = IT.Cd_solicitante Inner Join
										  COCSO CO with (nolock) On CO.Controle = SOL.Campo27 
										where IT.sequencia_ordem = '0'
												 and sol.Solicitacao = '".$numeroCiImpressao."'";
					$resItemSoliciImp = odbc_exec($conCab, $SQLItemSoliciImp);
					$arrayItemEmbarqueImp = odbc_fetch_array($resItemSoliciImp);
					echo "</div>";
					echo "<table width='100%'><tr><td></td><td align='center'><img src='imagens/logoDocumento.png'></td><td></td></tr></table>";
					$dataImpCI=date('d/m/Y',strtotime($arrayImpCi['Data']));
				    echo "<H2>COMUNICA&Ccedil;&Atilde;O INTERNA</H2>";
					echo "Data: ".$dataImpCI."<br>";
					echo "CI N&ordm;: ".$arrayImpCi['Solicitacao']."<br>";
					echo "REF: ".$arrayImpCi['Desc_cond_pag']."<br>";
					$descT801=$arrayImpCi['Descricao_T801'];
					$descT801=str_replace("<<","<< ",$descT801);
					echo "<p align='justify'>".nl2br($descT801)."</p>";
					$passagem=$arrayImpCi['Passagem'];
					$hotelImp=$arrayImpCi['Hotel'];
					$rpaImp=$arrayImpCi['RPA'];
					$diariaImp=$arrayImpCi['Diaria'];
					$valorTotalImpCi=0;
					while($objImpCi = odbc_fetch_object($resImpCI)){
						$valorTotalItemImpCi=$objImpCi->Quantidade*$objImpCi->Pr_unitario;
						$valorTotalImpCi=$valorTotalImpCi+$valorTotalItemImpCi;
						
						echo "<br>";
						echo "<table width='100%' border='1' style='border:2px #000000; border-collapse:collapse'>
<tr bgcolor='#CBCACA' height='23px' valign='top'><td width='3%' rowspan='2' valign='top'><strong>".$objImpCi->Sequencia."</strong></td><td width='8%' align='center'><strong>QTD</strong></td><td width='53%'><strong>DESCRI&Ccedil;&Atilde;O</strong></td><td width='18%' align='center'><strong>UNIT&Aacute;RIO</strong></td><td width='18%' align='center'><strong>TOTAL</strong></td></tr>
<tr height='23px' valign='top'><td align='center'><strong>".(int)$objImpCi->Quantidade."</strong></td><td><strong>".strtoupper ( $objImpCi->descricao )."</strong></td><td align='right'><strong>R$ ".number_format($objImpCi->Pr_unitario,2,',','.')."</strong></td><td align='right'><strong>R$ ".number_format($valorTotalItemImpCi,2,',','.')."</strong></td></tr>
</table>";
					
						if($passagem=1){
							$SQLItemPassImp = "select 
							   ROW_NUMBER() over (partition by psg.cd_solicitacao,psg.sequencia order by psg.sequencia) num, 
							   psg.cd_solicitacao,
							   psg.sequencia,
							   psg.cargo,
							   psg.cd_empresa,
							   (case when psg.cadeirante = 1 then '* ' + nom.Nome_completo else nom.Nome_completo end) nome_completo,
							   psg.trecho,
							   (psg.dt_partida) ,
							   psg.dt_chegada,
							   psg.hr_partida,
							   psg.hr_chegada,
							   psg.observacao,
							   case when psg.cadeirante = 1 then 'X' end cadeirante 
							from TEITEMSOLPASSAGEM psg with (nolock)
							   inner join GEEMPRES nom with (nolock) on
								  nom.Cd_empresa = psg.cd_empresa
							where
							   psg.cd_solicitacao = '".$numeroCiImpressao."'
							   AND psg.sequencia='".$objImpCi->Sequencia."'";
							$resItemPassImp = odbc_exec($conCab, $SQLItemPassImp);
							if(odbc_num_rows($resItemPassImp)>0){
								echo "<br><table width='100%' border='1' style='border:1px #000000; border-collapse:collapse;font-size:9px'><tr align='center' height='30px'><td width='3%'><strong>N&ordm;</strong></td><td width='23%'><strong>NOME</strong></td><td width='23%'><strong>TRECHO</strong></td><td width='12%'><strong>DATA IDA</strong></td><td width='12%'><strong>DATA VOLTA</strong></td><td width='5%'><strong>CADEIR<br>ANTE</strong></td></tr>";
								while($objItemPassImp = odbc_fetch_object($resItemPassImp)){
									if(!empty($objItemPassImp->dt_chegada)){
									$chegadaImpPas=date('d/m/Y',strtotime($objItemPassImp->dt_chegada))." ".date('H:i',strtotime($objItemPassImp->hr_chegada));
									}else{
										$chegadaImpPas='';
										}
									echo "<tr height='20px'><td align='center'>".$objItemPassImp->num."</td><td>".$objItemPassImp->nome_completo."</td><td>".$objItemPassImp->trecho."</td><td>".date('d/m/Y',strtotime($objItemPassImp->dt_partida))." ".date('H:i',strtotime($objItemPassImp->hr_partida))."</td><td>".$chegadaImpPas."</td><td align='center'>".$objItemPassImp->cadeirante."</td></tr>";
									}
								echo "</table>";
								}
							}
							if($hotelImp=1){
							$SQLItemHotelImp = "select
		   htl.cd_solicitacao,
		   htl.sequencia, 
		   ROW_NUMBER() over (partition by htl.cd_solicitacao,htl.sequencia order by htl.sequencia) num, 
		   htl.reserva,
		   htl.cargo,
		   htl.cd_empresa,
		   nom.Nome_completo,
		   pes.Cargo funcao,
		   htl.dt_entrada,
		   htl.dt_saida
		
		from TEITEMSOLHOTEL htl with (nolock)
		inner join GEEMPRES nom with (nolock) on
			  nom.Cd_empresa = htl.cd_empresa
		left join
     (SELECT Cd_empresa, max(Cargo) AS Cargo
      FROM GEPFISIC (nolock)
		  GROUP BY Cd_empresa) pes ON
       pes.Cd_empresa = nom.Cd_empresa
		where
		   htl.cd_solicitacao = '".$numeroCiImpressao."'
		   AND htl.sequencia='".$objImpCi->Sequencia."'
		   ORDER BY htl.reserva";
			$resItemHotelImp = odbc_exec($conCab, $SQLItemHotelImp);
			if(odbc_num_rows($resItemHotelImp)>0){
								echo "<br><table width='100%' border='1' style='border:1px #000000; border-collapse:collapse;font-size:9px'><tr align='center' height='30px'>
<td align='center' width='3%'><strong>N&ordm;</strong></td><td align='center' width='5%'><strong>RL</strong></td><td align='center' width='35%'><strong>NOME</strong></td><td align='center' width='25%'><strong>FUN&Ccedil;&Atilde;O/CARGO</strong></td><td align='center' width='16%'><strong>DATA IDA</strong></td><td align='center' width='16%'><strong>DATA VOLTA</strong></td></tr>";
								while($objItemHotelImp = odbc_fetch_object($resItemHotelImp)){
									if(empty($objItemHotelImp->cargo)){
										$cargoImpCiHotel=$objItemHotelImp->funcao;
										}else{
											$cargoImpCiHotel=$objItemHotelImp->cargo;
											}
									echo "<tr height='20px'><td align='center'>".$objItemHotelImp->num."</td><td align='center'>".(int)$objItemHotelImp->reserva."</td><td>".$objItemHotelImp->Nome_completo."</td><td align='center'>".$cargoImpCiHotel."</td><td align='center'>".date('d/m/Y',strtotime($objItemHotelImp->dt_entrada))."</td><td align='center'>".date('d/m/Y',strtotime($objItemHotelImp->dt_saida))."</td></tr>";
									}
								echo "</table>";
								}
							}
						if($rpaImp=1){
							$SQLItemRPAImp = " select
							   rpa.cd_solicitacao,
							   rpa.sequencia,
							   rpa.cd_empresa,
							   nom.Nome_completo Profissional,
							   pes.Cargo,
							   rpa.dt_inicio,
							   rpa.dt_fim,
							   rpa.valor,
							   rpa.cargo As cargo1
							
							from TEITEMSOLRPA rpa with (nolock) 
							   inner join GEEMPRES nom with (nolock) on
								  nom.Cd_empresa = rpa.cd_empresa
							   left join
     (SELECT Cd_empresa, max(Cargo) AS Cargo
      FROM GEPFISIC (nolock)
		  GROUP BY Cd_empresa) pes ON
       pes.Cd_empresa = nom.Cd_empresa
							where
							   rpa.cd_solicitacao = '".$numeroCiImpressao."'
							   AND rpa.sequencia='".$objImpCi->Sequencia."'";
					$resItemRPAImp = odbc_exec($conCab, $SQLItemRPAImp);
							if(odbc_num_rows($resItemRPAImp)>0){
								echo "<br><table width='100%' border='1' style='border:1px #000000; border-collapse:collapse;font-size:9px'><tr align='center' height='30px'><td align='center' width='33%'><strong>PROFISSIONAL</strong></td><td align='center' width='27%'><strong>CARGO</strong></td><td align='center' width='13%'><strong>INICIO</strong></td><td align='center' width='13%'><strong>T&Eacute;RMINO</strong></td><td align='center' width='14%'><strong>VALOR</strong></td></tr>";
								while($objItemRPAImp = odbc_fetch_object($resItemRPAImp)){
									if(empty($objItemRPAImp->cargo1)){
										$cargoImpCiRpa=$objItemRPAImp->Cargo;
										}else{
											$cargoImpCiRpa=$objItemRPAImp->cargo1;
											}
									echo "<tr height='20px'><td>".$objItemRPAImp->Profissional."</td><td align='center'>".$cargoImpCiRpa."</td><td align='center'>".date('d/m/Y',strtotime($objItemRPAImp->dt_inicio))."</td><td align='center'>".date('d/m/Y',strtotime($objItemRPAImp->dt_fim))."</td><td align='right'>".number_format($objItemRPAImp->valor, 2, ',', '.')."</td></tr>";
									}
								echo "</table>";
								}
							}
						if($diariaImp=1){
								$SQLItemDiariaImp = "select
									   dia.solicitacao,
									   dia.sequencia,
									   dia.empresa,
									   nom.Nome_completo Profissional,
									   pes.Cargo,
									   dia.dt_inicio,
									   dia.dt_termino,
									   dia.valor,
									   dia.cargo cargo1
									
									from TEITEMSOLDIARIAVIAGEM dia with (nolock) 
									   inner join GEEMPRES nom with (nolock) on
										  nom.Cd_empresa = dia.empresa
									   left join 
     (SELECT Cd_empresa, max(Cargo) AS Cargo
      FROM GEPFISIC (nolock)
		  GROUP BY Cd_empresa) pes ON
       pes.Cd_empresa = nom.Cd_empresa
									where
									   dia.solicitacao = '".$numeroCiImpressao."'
									   AND dia.sequencia='".$objImpCi->Sequencia."'";
					$resItemDiariaImp = odbc_exec($conCab, $SQLItemDiariaImp);
							if(odbc_num_rows($resItemDiariaImp)>0){
								echo "<br><table width='100%' border='1' style='border:1px #000000; border-collapse:collapse;font-size:9px'><tr align='center' height='30px'><td align='center' width='33%'><strong>PROFISSIONAL</strong></td><td align='center' width='27%'><strong>CARGO</strong></td><td align='center' width='13%'><strong>INICIO</strong></td><td align='center' width='13%'><strong>T&Eacute;RMINO</strong></td><td align='center' width='14%'><strong>VALOR</strong></td></tr>";
								while($objItemDiariaImp = odbc_fetch_object($resItemDiariaImp)){
									if(empty($objItemDiariaImp->cargo1)){
										$cargoImpCiDiaria=$objItemDiariaImp->Cargo;
										}else{
											$cargoImpCiDiaria=$objItemDiariaImp->cargo1;
											}
									echo "<tr height='20px'><td>".$objItemDiariaImp->Profissional."</td><td align='center'>".$cargoImpCiDiaria."</td><td align='center'>".date('d/m/Y',strtotime($objItemDiariaImp->dt_inicio))."</td><td align='center'>".date('d/m/Y',strtotime($objItemDiariaImp->dt_termino))."</td><td align='right'>".number_format($objItemDiariaImp->valor, 2, ',', '.')."</td></tr>";
									}
								echo "</table>";
								}
							} 
																		$descT802=$objImpCi->Descricao_T802;
						$descT802=str_replace("<<","<< ",$descT802);
					    $descT803=$objImpCi->Descricao_T803;
						$descT803=str_replace("<<","<< ",$descT803);
						echo "<br>";
						echo nl2br($descT802);
						echo nl2br($descT803);
						echo "<br>";
		
						}
		echo "<table width='100%' border='1' style='border:2px #000000; border-collapse:collapse; font-size:13px'>
<tr bgcolor='#CBCACA' height='23px' valign='top'><td width='75%' align='center'><strong>TOTAL DA CI</strong></td><td width='25%' align='center'><strong>R$ ".number_format($valorTotalImpCi,2,',','.')."</strong></td></tr></table>";

		echo "<br><p align='center'>";
		echo "Atenciosamente,</p>";
		echo "<p></p>";
		$statusAssinatura="<font color='#9C9B9B' style=\"font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; font-size='9px'\"><i>Assinado Eletronicamente</i></font>";
		if($arrayImpCi['controle']=='03'){
			$statusAssinatura='Documento em Elabora&ccedil;&atilde;o';
			}
		echo "<p align='center'>".$statusAssinatura."<BR>";
		echo "<strong>".strtoupper($arrayImpCi['cliente'])."</strong><br/>";
		echo "".strtoupper($arrayImpCi['Cargo'])."</p>";
		
		$sqlAcompImpressao=odbc_exec($conCab,"Select
  aprovado = Case When GEACOMP.Historico Like '%de 03%' Then 'ELABORAÇÃO DA CI'
    When GEACOMP.Historico Like '%de 17%para 05%' Or
    GEACOMP.Historico Like '%de 17%para 16%' Then 'APROVAÇÃO SUAFC'
    When GEACOMP.Historico Like '%de 13%para 05%' Or
    GEACOMP.Historico Like '%de 13%para 16%' Then 'APROVAÇÃO VICE PRESIDÊNCIA'
    When GEACOMP.Historico Like '%de 14%para 05%' Or
    GEACOMP.Historico Like '%de 14%para 16%' Then 'APROVAÇÃO DIR. EXECUTIVA'
    When GEACOMP.Historico Like '%de 15%para 05%' Or
    GEACOMP.Historico Like '%de 15%para 16%' Then 'APROVAÇÃO DIR. TÉCNICA'
    When GEACOMP.Historico Like '%de 18%para 05%' Or
    GEACOMP.Historico Like '%de 18%para 16%' Then
    'APROVAÇÃO DIR. DE COMUNICAÇÃO'
    When GEACOMP.Historico Like '%de 19%para 05%' Or
    GEACOMP.Historico Like '%de 19%para 16%' Then
    'APROVAÇÃO DIR. DE MARKETING'
    When GEACOMP.Historico Like '%de 16%para 05%' Or
    GEACOMP.Historico Like '%de 16%para EP%' Then 'APROVAÇÃO CONVÊNIO'
    When GEACOMP.Historico Like '%de 05%para EP%' Or
    GEACOMP.Historico Like '%de 05%para 16%' Then 'APROVAÇÃO ORÇAMENTO'
    When GEACOMP.Historico Like '%para AP%' Then 'APROVAÇÃO PRESIDÊNCIA' Else '0'
  End,
  GEACOMP.Data As Data1,
  GEACOMP.Hora As Hora1,
  GEUSUARI.Nome
From
  GEACOMP With(NoLock) Left Join
  GEUSUARI On GEUSUARI.Cd_usuario = GEACOMP.Usuario
Where
  GEACOMP.Campo39 = 1 And
  GEACOMP.Campo40 = 1 And
  GEACOMP.Sequencia_item = 0 And
  LTrim(RTrim(GEACOMP.Embarque_pedido)) = '".$numeroCiImpressao."'
Order By
  Data1,
  Hora1");
		echo "</table><br>";
		    $counCompImp=odbc_num_rows($sqlAcompImpressao);
			if($counCompImp>0){
			echo"<div align='center'><table width='70%' border='1' style='border:1px #000000; border-collapse:collapse;font-size:9px'>
		     <tr bgcolor='#CBCACA' height='23px' valign='top'><td colspan='3'><strong>ASSINADO ELETRONICAMENTE POR:</strong></td></tr>
			 ";
			 $countImpressao=0;
			 $statusAcomp[]='';
			 $usuarioAcomp[]='';
			 $dataAcomp[]='';
			 $horaAcomp[]='';
		while($objImpAcomp=odbc_fetch_object($sqlAcompImpressao)){		  
		$statusAcomp[$countImpressao]=utf8_decode($objImpAcomp->aprovado);
	    $dataAcomp[$countImpressao]=$objImpAcomp->Data1;
		$horaAcomp[$countImpressao]=$objImpAcomp->Hora1;
		$usuarioAcomp[$countImpressao]=utf8_decode($objImpAcomp->Nome);
		for($i=0;$i<$countImpressao;$i++){
			if($statusAcomp[$countImpressao]==$statusAcomp[$i]){
				$statusAcomp[$i]='R';
				unset($horaAcomp[$i]);
				unset($dataAcomp[$i]);
				unset($usuarioAcomp[$i]);
				}
			}
		$countImpressao++;
		}
		for($j=0;$j<$countImpressao;$j++){
			if($statusAcomp[$j]<>'R' && $statusAcomp[$j]<>"0"){
				$arrayHoraP=str_split(str_pad($horaAcomp[$j], 6, "0", STR_PAD_LEFT),2);
		  $horaDataP=$arrayHoraP[0].':'.$arrayHoraP[1].":".$arrayHoraP[2];

echo "<tr><td><strong>".$statusAcomp[$j]."</strong></td><td>".$usuarioAcomp[$j]."</td><td>".date("d/m/Y", strtotime($dataAcomp[$i]))." &aacute;s ".$horaDataP."</td></tr>";
				}
			}
		echo "</table></div>";
			}
	echo "<div id='outro' style='display: none;'>";
	require_once('conect.php');
	$sqlDocumentoOnline=mysql_fetch_array(mysql_query("SELECT docdigital.id,docdigital.hash AS hash2,cidoc.numci,cidoc.data FROM docdigital LEFT JOIN cidoc ON docdigital.id=cidoc.iddoc WHERE cidoc.numci='".$numeroCiImpressao."'"));
	if(empty($sqlDocumentoOnline)){
		$hash=geraSenha(15);
		 $sqlMaxId=mysql_fetch_array(mysql_query("SELECT max(id) as maxid FROM docdigital"));
		 $idDoc=$sqlMaxId['maxid']+1;
		 $sqlCriaDoc=mysql_query("INSERT INTO docdigital VALUES ('".$idDoc."','".date("d/m/Y")."','".$hash."','2')") or die(mysql_error());
		 if(!$sqlCriaDoc){
			$hash=geraSenha(15);
			$sqlCriaDoc=mysql_query("INSERT INTO docdigital VALUES ('".$idDoc."','".date("d/m/Y")."','".$hash."','2')"); 
			 }
		$sqlDocCi=mysql_query("INSERT INTO cidoc VALUES ('".$idDoc."','".$numeroCiImpressao."','".date("d/m/Y - H:i:s")."')");
		 $codigoHash=$hash;
		}else{
			$codigoHash=$sqlDocumentoOnline['hash2'];
			}
			echo "</div>";
	echo "<br><table width='100%' border='0' style='border:0px #000000; border-collapse:collapse;font-size:9px'><tr height='23px'><td align='center'>Para verificar a autenticidade, acesse: <a href='http://www.cpb.org.br/intranetcpb/verifica' target='_blank'>http://intranetcpb.cpb.org.br/intranetcpb/verifica</a><br> e informe o c&oacute;digo: <strong><u>".$codigoHash."</u></strong></td></tr></table>";
	echo '';
	}
//Função para montar grade de Itens da CI Pendentes

function detalhaItensCi($UserCiItens,$controleCiItens,$idCiItens,$dataCiItens,$solicCiItens,$descCiItens,$valorCiItens,$controleCiItensProx){
	    include "mb.php";
		require "conectsqlserverciprod.php";
		$SQLCiItensV="Select
  COISOLIC.*,
  GEEMPRES.Nome_completo,
  ESMATERI.Descricao As Descricao1
From
  COISOLIC Inner Join
  GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante Inner Join
  ESMATERI On ESMATERI.Cd_material = COISOLIC.Cd_material
Where
  COISOLIC.Cd_solicitacao = '".$idCiItens."'";
          	
		$resCiItensV = odbc_exec($conCab, $SQLCiItensV);
		echo "<br/><div id='tabela3'><table width='100%' border='1'> <tr bgcolor='#658BF3'><td><strong>N&ordm; CI</strong></td><td width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></td><td width='180'><strong>Solicitante</strong></td><td width='250'><strong>Processo/Evento</strong></td><td width='60'><strong>Total(R$)</strong></td><td width='50'><strong>Aprovar</strong></td></tr>";
		  echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserCiItens."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descCiItens."' size='40' type='hidden' /><input name='controle' id='controle' value='".$controleCiItensProx."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idCiItens."' size='40' type='hidden' />".$idCiItens."</strong></td><td width='50'><strong>".$dataCiItens."</strong></td><td width='80'><strong>".$solicCiItens."</strong></td><td width='150'><strong>".$descCiItens."</strong></td><td width='60'><strong>".$valorCiItens."</strong></td><td width='50'><input name='enviar9' class='buttonVerde' type='submit' value='Aprovar CI' /></td></tr></form></table></div>";
		  echo "<br><strong>Itens da CI N&ordm; ".$idCiItens."</strong><br>";
		  echo "<div id='tabela3'><table width='100%' border='1'> <tr bgcolor='#658BF3'><td width='30'><strong>N&ordm; CI</strong></td><td width='10%'><strong>Sequencia</strong></td><td width='295'><strong>Item</strong></td><td width='60'><strong>Total(R$)</strong></td><td width='15%'>--</td></tr>";
		while($objCiItensV = odbc_fetch_object($resCiItensV)){
			if(empty($objCiItensV)){?>
       <script type="text/javascript">
	     alert("CI Aprovada com Sucesso!");
         window.location.href = 'ciWeb.php';
       </script>
       <?php	   
				}else{
			$valorCItemVIten=$objCiItensV->Quantidade*$objCiItensV->Pr_unitario;
			echo "<form action='detalhaItensCi.php' method='post' name='form4.id_CI' > <tr><td><input name='controleCi' id='controleCi' value='".$controleCiItensProx."' size='40' type='hidden' /><input name='user_ci' id='user_ci' value='".$idCiItens."' size='40' type='hidden' /><input name='userci' id='userci' value='".$UserCiItens."' size='40' type='hidden' /><input name='idci' id='idci' value='".$idCiItens."' size='40' type='hidden' /><input name='dataci' id='dataci' value='".$dataCiItens."' size='40' type='hidden' /><input name='solici' id='solici' value='".$solicCiItens."' size='40' type='hidden' /><input name='descci' id='descci' value='".$descCiItens."' size='40' type='hidden' /><input name='valorci' id='valorci' value='".$valorCiItens."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiItensV->Cd_solicitacao."' size='40' type='hidden' /><input name='seq_ci' id='seq_ci' value='".$objCiItensV->Sequencia."' size='40' type='hidden' />".$objCiItensV->Cd_solicitacao."</td><td><center>".$objCiItensV->Sequencia."</center></td><td>".$objCiItensV->Descricao1."</td><td>R$ ".number_format($valorCItemVIten, 2, ',', '.')."</td><td ><input name='enviar5' class='buttonVerde' type='submit' value='Detalhar Item' /></td></tr> </form>";
			}
			}
			echo "</table></div><br><br><a href=\"javascript:history.back()\"><input name='cont' class='button' type='button' value='Voltar' /></a>";
	}

//Função para montar grade de Itens da CI Pendentes

function detalhamentoItensCi($idItensDetalhado,$seqIdItensDetal,$UserCiItensDetail, $idCiItensDetail,$dataCiItensDetail,$solicCiItensDetail,$descCiItensDetail,$valorCiItensDetail,$controleCiItensDetail){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLItDiaViag="Select
  TEITEMSOLDIARIAVIAGEM.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLDIARIAVIAGEM Inner Join
  GEEMPRES On TEITEMSOLDIARIAVIAGEM.empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLDIARIAVIAGEM.solicitacao='".$idItensDetalhado."'
  AND TEITEMSOLDIARIAVIAGEM.sequencia='".$seqIdItensDetal."'";
		$resItDiaViag = odbc_exec($conCab, $SQLItDiaViag);
		$SQLItRPA="Select
  TEITEMSOLRPA.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLRPA Inner Join
  GEEMPRES On TEITEMSOLRPA.cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLRPA.cd_solicitacao='".$idItensDetalhado."'
  AND TEITEMSOLRPA.sequencia='".$seqIdItensDetal."'";
		$resItRPA = odbc_exec($conCab, $SQLItRPA);
		$SQLItHopedagem="Select
  TEITEMSOLHOTEL.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLHOTEL Inner Join
  GEEMPRES On TEITEMSOLHOTEL.Cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLHOTEL.cd_solicitacao='".$idItensDetalhado."'
  AND TEITEMSOLHOTEL.sequencia='".$seqIdItensDetal."'";
		$resItHopedagem = odbc_exec($conCab, $SQLItHopedagem);
		$SQLItPassagem="Select
  TEITEMSOLPASSAGEM.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLPASSAGEM Inner Join
  GEEMPRES On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLPASSAGEM.cd_solicitacao='".$idItensDetalhado."'
  AND TEITEMSOLPASSAGEM.sequencia='".$seqIdItensDetal."'";
		$resItPassagem = odbc_exec($conCab, $SQLItPassagem);
		echo "<br/><div id='tabela3'><table width='100%' border='1'> <tr bgcolor='#658BF3'><td width='30'><strong>N&ordm; CI</strong></td><td width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></td><td width='180'><strong>Solicitante</strong></td><td width='250'><strong>Processo/Evento</strong></td><td width='60'><strong>Total(R$)</strong></td><td width='50'><strong>Aprovar</strong></td></tr>";
		  echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserCiItensDetail."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descCiItensDetail."' size='40' type='hidden' /><input name='controle' id='controle' value='".$controleCiItensDetail."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idCiItensDetail."' size='40' type='hidden' />".$idCiItensDetail."</strong></td><td width='50'><strong>".$dataCiItensDetail."</strong></td><td width='80'><strong>".$solicCiItensDetail."</strong></td><td width='150'><strong>".$descCiItensDetail."</strong></td><td width='60'><strong>".$valorCiItensDetail."</strong></td><td width='50'><input name='enviar9' class='buttonVerde' type='submit' value='Aprovar CI' /></td></tr></form></table></div><br><br>";
		  echo "<br><strong>Detalhamento: CI N&ordm; ".$idItensDetalhado." Item ".$seqIdItensDetal."</strong><br>";
		  if(odbc_num_rows($resItDiaViag)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Di&aacute;rias de Viagem</h2>";
		  echo "<div id='tabela3'><table width='80%'  border='1'> <tr bgcolor='#658BF3'><td width='30'><strong>Nome</strong></td><td width='50'><strong>Dt. In&iacute;cio</strong></td><td width='80'><strong>Dt. T&eacute;rmino</strong></td><td width='80'><strong>Valor(R$)</strong></td></tr>";
		while($objItDiaViag = odbc_fetch_object($resItDiaViag)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItDiaViag->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItDiaViag->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItDiaViag->dt_termino))."</td><td>R$ ".number_format($objItDiaViag->valor, 2, ',', '.')."</td></tr> </form>";
			   }
			   echo "</table>";
			  }
					  if(odbc_num_rows($resItRPA)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Pagamento RPA</h2>";
		  echo "<div id='tabela3'><table width='80%' border='1'> <tr bgcolor='#658BF3'><td><strong>Nome</strong></td><td width='50'><strong>Dt. In&iacute;cio</strong></td><td width='80'><strong>Dt. T&eacute;rmino</strong></td><td width='80'><strong>Valor(R$)</strong></td></tr>";
		while($objItRPA = odbc_fetch_object($resItRPA)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItRPA->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItRPA->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItRPA->dt_fim))."</td><td>R$ ".number_format($objItRPA->valor, 2, ',', '.')."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItHopedagem)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Hopedagem</h2>";
		  echo "<div id='tabela3'><table width='80%'  border='1'> <tr bgcolor='#658BF3'><td width='30'><strong>Nome</strong></td><td width='50'><strong>Dt. Entrada</strong></td><td width='80'><strong>Dt. Sa&iacute;da</strong></td></tr>";
		while($objItHopedagem = odbc_fetch_object($resItHopedagem)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItHopedagem->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItHopedagem->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItHopedagem->dt_saida))."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItPassagem)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Passagem A&eacuterea</h2>";
		  echo "<div id='tabela3'><table width='100%'  border='1'> <tr bgcolor='#658BF3'><td width='30'><strong>Nome</strong></td><td width='50'><strong>Dt. Partida</strong></td><td width='30'><strong>Hr. Partida</strong></td><td width='80'><strong>Dt. Chegada</strong></td><td width='30'><strong>Hr. Chegada</strong></td><td width='70'><strong>Trecho</strong></td><td width='70'><strong>Observacao</strong></td></tr>";
		while($objItPassagem = odbc_fetch_object($resItPassagem)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItPassagem->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItPassagem->dt_partida))."</td><td>".date('H:i:s',$objItPassagem->hr_partida)."</td><td>".date('d/m/Y',strtotime($objItPassagem->dt_chegada))."</td><td>".date('H:i:s',$objItPassagem->hr_chegada)."</td><td>".$objItPassagem->trecho."</td><td>".$objItPassagem->observacao."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			echo "</div><br><br><a href=\"javascript:history.back()\"><input name='cont' class='button' type='button' value='Voltar' /></a>";
	}

//Função para montar grade de Itens da OC Pendentes

function detalhaItensOc($UserOcItens,$controleOcItens,$idOcItens,$dataOcItens,$solicOcItens,$descOcItens,$valorOcItens){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLOCItensV="Select
  ESMATERI.Descricao As Descricao1,
  COIORDEM.*,
  GEUSUARI.Nome
From
  ESMATERI Inner Join
  COIORDEM On COIORDEM.Cd_material = ESMATERI.Cd_material Inner Join
  GEUSUARI On COIORDEM.Usuario_criacao = GEUSUARI.Cd_usuario
Where
  COIORDEM.Cd_ordem = '".$idOcItens."'";
          	
		$resOCItensV = odbc_exec($conCab, $SQLOCItensV);
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; OC</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Produto/Servi&ccedil;o</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th></tr>";
		  echo "<form action='atualizaOc.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserOcItens."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idOcItens."' size='40' type='hidden' />".$idOcItens."</strong></td><td width='50'><strong>".$dataOcItens."</strong></td><td width='80'><strong>".$solicOcItens."</strong></td><td width='150'><strong>".$descOcItens."</strong></td><td width='60'>".$valorOcItens."</td><td width='50'><input name='enviar9' class='button' type='submit' value='Aprovar OC' /></td></tr></form></table></div>";
		  echo "<br><strong>Itens da OC N&ordm; ".$idOcItens."</strong><br>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; OC</strong></th><th width='50'><strong>Sequencia</strong></th><th width='80'><strong>Item</strong></th><th width='60'>Total(R$)</th><th width='50'>--</th></tr>";
		while($objOCItensV = odbc_fetch_object($resOCItensV)){
			if(empty($objOCItensV)){?>
       <script type="text/javascript">
	     alert("OC Aprovada com Sucesso!");
         window.location.href = 'ocWeb.php';
       </script>
       <?php	   
				}else{
			$valorOCItemVIten=$objOCItensV->Quantidade*$objOCItensV->Pr_unitario;
			echo "<form action='detalhaItensOc.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$idOcItens."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objOCItensV->Cd_ordem."' size='40' type='hidden' /><input name='seq_ci' id='seq_ci' value='".$objOCItensV->Sequencia."' size='40' type='hidden' /><input name='userci' id='userci' value='".$UserOcItens."' size='40' type='hidden' /><input name='idci' id='idci' value='".$idOcItens."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".$dataOcItens."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$solicOcItens."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descOcItens."' size='40' type='hidden' /><input name='valor_ci' id='valor_ci' value='".$valorOcItens."' size='40' type='hidden' />".$objOCItensV->Cd_ordem."</td><td>".$objOCItensV->Sequencia."</td><td>".$objOCItensV->Descricao1."</td><td>R$ ".number_format($valorOCItemVIten, 2, ',', '.')."</td><td><input name='enviar5' class='button' type='submit' value='Detalhar Item' /></td></tr> </form>";
			}
			}
			echo "</table></div><br><br><A HREF=\"javascript:history.back()\">Voltar</A>";
	}

//Função para montar grade de Itens da CI Pendentes

function detalhamentoItensOc($idItensDetalhadoOc,$seqIdItensDetalOc,$UserOcItensDetail, $idOcItensDetail,$dataOcItensDetail,$solicOcItensDetail,$descOcItensDetail,$valorOcItensDetail){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLItDiaViagOC="Select
  TEITEMSOLDIARIAVIAGEM.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLDIARIAVIAGEM Inner Join
  GEEMPRES On TEITEMSOLDIARIAVIAGEM.empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLDIARIAVIAGEM.solicitacao='".$idItensDetalhadoOc."'
  AND TEITEMSOLDIARIAVIAGEM.sequencia='".$seqIdItensDetalOc."'";
		$resItDiaViagOC = odbc_exec($conCab, $SQLItDiaViagOC);
		$SQLItRPAOC="Select
  TEITEMSOLRPA.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLRPA Inner Join
  GEEMPRES On TEITEMSOLRPA.cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLRPA.cd_solicitacao='".$idItensDetalhadoOc."'
  AND TEITEMSOLRPA.sequencia='".$seqIdItensDetalOc."'";
		$resItRPAOC = odbc_exec($conCab, $SQLItRPAOC);
		$SQLItHopedagemOC="Select
  TEITEMSOLHOTEL.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLHOTEL Inner Join
  GEEMPRES On TEITEMSOLHOTEL.Cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLHOTEL.cd_solicitacao='".$idItensDetalhadoOc."'
  AND TEITEMSOLHOTEL.sequencia='".$seqIdItensDetalOc."'";
		$resItHopedagemOC = odbc_exec($conCab, $SQLItHopedagemOC);
		$SQLItPassagemOC="Select
  TEITEMSOLPASSAGEM.*,
  GEEMPRES.Nome_completo
From
  TEITEMSOLPASSAGEM Inner Join
  GEEMPRES On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa
  WHERE TEITEMSOLPASSAGEM.cd_solicitacao='".$idItensDetalhadoOc."'
  AND TEITEMSOLPASSAGEM.sequencia='".$seqIdItensDetalOc."'";
		$resItPassagemOC = odbc_exec($conCab, $SQLItPassagemOC);
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; OC</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Produto/Servi&ccedil;o</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th></tr>";
		  echo "<form action='atualizaOc.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserOcItensDetail."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idOcItensDetail."' size='40' type='hidden' />".$idOcItensDetail."</strong></td><td width='50'><strong>".$dataOcItensDetail."</strong></td><td width='80'><strong>".$solicOcItensDetail."</strong></td><td width='150'><strong>".$descOcItensDetail."</strong></td><td width='60'>".$valorOcItensDetail."</td><td width='50'><input name='enviar9' class='button' type='submit' value='Aprovar OC' /></td></tr></form></table></div>";
		  echo "<br><strong>Detalhamento: OC N&ordm; ".$idItensDetalhadoOc." Item ".$seqIdItensDetalOc."</strong><br>";
		  if(odbc_num_rows($resItDiaViagOC)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Di&aacute;rias de Viagem</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. In&iacute;cio</strong></th><th width='80'><strong>Dt. T&eacute;rmino</strong></th><th width='60'>Valor(R$)</th></tr>";
		while($objItDiaViagOC = odbc_fetch_object($resItDiaViagOC)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItDiaViagOC->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItDiaViagOC->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItDiaViagOC->dt_termino))."</td><td>R$ ".number_format($objItDiaViagOC->valor, 2, ',', '.')."</td></tr> </form>";
			   }
			   echo "</table>";
			  }
					  if(odbc_num_rows($resItRPAOC)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Pagamento RPA</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. In&iacute;cio</strong></th><th width='80'><strong>Dt. T&eacute;rmino</strong></th><th width='60'>Valor(R$)</th></tr>";
		while($objItRPAOC = odbc_fetch_object($resItRPAOC)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItRPAOC->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItRPAOC->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItRPAOC->dt_fim))."</td><td>R$ ".number_format($objItRPAOC->valor, 2, ',', '.')."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItHopedagemOC)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Hopedagem</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. Entrada</strong></th><th width='80'><strong>Dt. Sa&iacute;da</strong></th></tr>";
		while($objItHopedagemOC = odbc_fetch_object($resItHopedagemOC)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItHopedagemOC->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItHopedagemOC->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItHopedagemOC->dt_saida))."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItPassagemOC)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Passagem Aerea</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. Partida</strong></th><th width='30'><strong>Hr. Partida</strong></th><th width='80'><strong>Dt. Chegada</strong></th><th width='30'><strong>Hr. Chegada</strong></th><th width='70'><strong>Trecho</strong></th><th width='70'>Observacao</th></tr>";
		while($objItPassagemOC = odbc_fetch_object($resItPassagemOC)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItPassagemOC->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItPassagemOC->dt_partida))."</td><td>".date('H:i:s',$objItPassagemOC->hr_partida)."</td><td>".date('d/m/Y',strtotime($objItPassagemOC->dt_chegada))."</td><td>".date('H:i:s',$objItPassagemOC->hr_chegada)."</td><td>".$objItPassagemOC->trecho."</td><td>".$objItPassagemOC->observacao."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			echo "</div><br><br><A HREF=\"javascript:history.back()\">Voltar</A>";
	}

//Função para alertar Gestor que existe pendência de aprovação de férias

function verifPendentes($userGestCont){
	    $resultadoGres1 =  mysql_query("SELECT * FROM usuarios WHERE usuario = '".$userGestCont."'") or die(mysql_error());
        $resultadoGres = mysql_fetch_array($resultadoGres1);
	    $nomeGres=$resultadoGres['nome'];
	    $rsGestCont = mysql_query("SELECT * FROM solferias  WHERE status=1 and gestor='".$nomeGres."' ");
		$contGest=mysql_num_rows($rsGestCont);
	if($contGest>='1') {
		?>
       <script type="text/javascript">
       alert("ATEN\u00c7\u00c3O!! Existe <?php echo $contGest ?> solicita\u00e7\u00e3es de f\u00e9rias pendentes de aprova\u00e7\u00e3o. Clique em APROVAR/RECUSAR F\u00c9RIAS!");
	   <?php header('Localização: gestFerias.php'); ?>
       </script>
       <?php 
	   }
	 }
//Funcão para apresentar dados ao RH de 13
function consultaRH13($codigo13){
	    require('conexaomysql.php');
	    $rsRh13 = mysql_query("SELECT * FROM sol13  WHERE status=2 AND id='".$codigo13."'");
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Funcionário</strong></th><th width='60'><strong>Data de Solicitação</strong></th><th width='320'><strong>Gestor</strong></th><th width='200'><strong>Status do Pedido</strong></th></tr>";
		while($objRh13 = mysql_fetch_object($rsRh13)){
			echo "<form action='impFerias.php' method='post' name='form".$objRh13->id."' > <tr><td>".$objRh13->funcionario."</td><td>".$objRh13->dt_sol."</td><td><input name='id' id='id' value='".$objRh13->id."' size='30' type='hidden'/>".$objRh13->gestor."</td><td>Aprovado</td></tr> </form>";
			}
			echo "</table>";
	}
	


//Funcão para apresentar dados ao RH
function consultaRHferias($dataInicio){
	    require('conexaomysql.php');
	    $rsRh = mysql_query("SELECT * FROM solferias  WHERE status=2 AND datainicio='".$dataInicio."'");
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Funcionário</strong></th><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th></tr>";
		while($objRh = mysql_fetch_object($rsRh)){
			if($objRh->abono=="abono"){
				$abonoRh="SIM";}
				else{
					$abonoRh="NAO";}
			echo "<form action='impFerias.php' method='post' name='form".$objRh->id."' > <tr><td>".$objRh->funcionario."</td><td>".$objRh->datainicio."</td><td>".$objRh->datafinal."</td><td><input name='id' id='id' value='".$objRh->id."' size='30' type='hidden'/>".$objRh->gestor."</td><td>".$abonoRh."</td><td>".$objRh->ad13."</td><td>Aprovado</td></tr> </form>";
			}
			echo "</table>";
	}
	
//Atualiza Perfil Usuário
function atualizaUsuario($funcionario,$perfil,$controleAtualiza,$cigamAtualiza,$moduloAtualiza,$contAtualiza){
	require('conexaomysql.php');
	if($perfil==1){
		$rsGe = mysql_query("SELECT * FROM usuarios  WHERE id='".$funcionario."'");
		$objGe = mysql_fetch_object($rsGe);
		if(empty($controleAtualiza)){
			$controleAtualiza=$objGe->controle;
			}
			if(empty($cigamAtualiza)){
			   if(empty($objGe->cigam)){
				   $cigamAtualiza="A02";
				   }else{
					   $cigamAtualiza=$objGe->cigam;
					   }
			}
		$rsConGe= mysql_query("SELECT * FROM gestores WHERE nome='".$objGe->nome."'");
		$contarConGe=mysql_num_rows($rsConGe);
	    if($contarConGe<'1') {
			$incluiGestor="INSERT INTO gestores VALUES ('','".$objGe->nome."')";
			$insertSql=mysql_query($incluiGestor) or die(mysql_error());
		}
	}else{
			$rsGe1 = mysql_query("SELECT * FROM usuarios  WHERE id=".$funcionario) or die(mysql_error());
			if($rsGe1){
				$objGe1 = mysql_fetch_object($rsGe1);
				if(empty($controleAtualiza)){
			$controleAtualiza=$objGe->controle;
			}
			if(empty($cigamAtualiza)){
			   if(empty($objGe->cigam)){
				   $cigamAtualiza="A02";
				   }else{
					   $cigamAtualiza=$objGe->cigam;
					   }
			}
				$deletarGestor="DELETE FROM cpb.gestores WHERE gestores.nome='".$objGe1->nome."'";
				$deleteSql2=mysql_query($deletarGestor) or die(mysql_error());
			 	}
			}
	$updateSql="UPDATE usuarios SET controle='".$controleAtualiza."',cigam='".$cigamAtualiza."' WHERE id = '".$funcionario."'";
    $atualizarSql=mysql_query($updateSql) or die(mysql_error());
	if ($atualizarSql) {
		$sqlModAt=mysql_query("DELETE FROM modulo WHERE user='".$funcionario."'");
		while($contAtualiza>0){
			$insertAtualidaModulo=mysql_query("INSERT INTO modulo VALUES ('','".$funcionario."','".$moduloAtualiza[$contAtualiza]."')");
			$contAtualiza--;
			}
     	?>
       <script type="text/javascript">
       alert("Usu\u00e1rio Atualizado com Sucesso.");
       history.back();
       </script>
       <?php
       header('Localização: alterUsuario.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Usu\u00e1rio não atualizado. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: alterUsuario.php');
	      }
	mysql_close($conexao);
	}
	
function listaUsuarios(){
	    require('conexaomysql.php');
		//include 'mb.php';
	    $rsUs = mysql_query("SELECT * FROM usuarios ORDER BY nome");
		echo "<div id='tabela'><table border='1'> <tr><th><strong>NOME</strong></th><th><strong>LOGIN</strong></th><th><strong>E-MAIL</strong></th><th><strong>EXCLUIR</strong></th></tr>";
		while($objUs = mysql_fetch_object($rsUs) or die(mysql_error())){
			$nomeUsuarioListar=mb_convert_encoding($objUs->nome,"UTF-8","ISO-8859-1");
			echo "<tr><td>".$nomeUsuarioListar."</td><td>".$objUs->usuario."</td><td>".$objUs->email."</td><td><form action='excluirUserIntra.php' method='post' name='form".$objUs->id."'><input name='id' id='id' value='".$objUs->id."' size='30' type='hidden'/><input class='button'  name='enviar5' type='submit' value='Excluir ?' /></form></td></tr>";
			}
			echo "</table></div>";
	}
?>