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
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$funcionario."')";
          $resCab = odbc_exec($conCab, $SQLCab);
	      $array_resultado = odbc_fetch_array($resCab);
		 if(empty($array_resultado)){
             ?>
			   <script type="text/javascript">
               alert("Você não possui cadastro para esse mês.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
		else{
	echo "<table width='631' border='1' cellspacing='0' cellpadding='0'>";
    echo "<tr>";
    echo "<td colspan='2' align='center' class='negrito'><img src='imagens/logo_cpb1.png' width='204' height='46' />Ficha de Frequência</td>";
    echo "<td width='203' align='center' class='grande'><strong>Período:</strong><br /> <span class='menor'>26/".$mes."/".$ano." a 25/".($mes+1)."/".$ano."</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width='83'><span class='small'><strong>Empresa:</strong></span></td>";
    echo "<td width='337'><span class='small'>COMITÊ PARAOLÍMPICO BRASILEIRO</span></td>";
    echo "<td><span class='small'><strong>C.N.P.J</strong>: 00.700.114 / 0001-44</span></td>";
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
    echo "<td><span class='small'><strong>Cargo:</strong>".$array_resultado["DESCRICAO202"]."</span></td>";
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
           $diaStatus=consultaStatus($dia,($mes+1),$ano);
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
       alert("Ja existe evento cadastrado nesse dia. Exclua para alterar.");
       history.back();
       </script>
       <?php 
	   }else{
	$inserir=mysql_query($comandosql1);
	if ($inserir) {
     	?>
       <script type="text/javascript">
       alert("Cadastro efetuado com Sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: cadastroDias.html');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("Não foi possível deletar o evento. Tente novamente!");
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
       alert("Evento deletado com Sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: cadastroDias.html');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Evento não deletado ou não existe. Tente novamente!");
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
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome."')";
          $resRod = odbc_exec($conCab, $SQLRod);
	      $array_resultadoRod = odbc_fetch_array($resRod);
 echo "<table width='631' border='1' cellspacing='0' cellpadding='0'>";
 echo " <tr>";
 echo "   <td width='302'><strong>Total de Horas: </strong></td>";
 echo "    <td><strong>Total de Horas Extras: </strong></td>";
 echo "  </tr>";
 echo " <tr>";
 echo "   <td><p><span class='pequeno'>Concordo com os registros das horas trabalhadas.</span><br />";
 echo "     ____________________________________<br />";
 echo "     <strong>".$array_resultadoRod["NOME"]."</strong></p></td>";
 echo "   <td valign='top'><span class='pequeno'>Observações:</span><br />";
 //echo "     ____________________________________<br>";
 echo "     ________________________________</p></td>";
 echo " </tr>";
 echo "</table></div>";
 }

 //Inicia funções relacionadas ao ContraCheque
 
 //Função para montagem do cabeçalho do documento
 function montaCabecalhoContCheq($mesCh,$anoCh,$nome_funcCh){
	 include "mb.php";
	 require('conectsqlserver.php');
     $SQLCht = "Select
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
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')";
          $resCht = odbc_exec($conCab, $SQLCht);
	      $array_resultadoCht = odbc_fetch_array($resCht);
		  if(empty($array_resultadoCht)){
             ?>
			   <script type="text/javascript">
               alert("Voce nao possui documento cadastrado para esse mes.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
  else{
			echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
			echo "  <col width='64' span='10' />";
			echo "  <tr>";
			echo "    <td colspan='7'><strong class='titulo'>DEMONSTRATIVO DE PAGAMENTO</strong></td>";
			echo "    <td colspan='3' width='267'><strong>Folha Mensal de ".$mesCh."/".$anoCh."</strong></td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'>COMITE PARAOLIMPICO BRASILEIRO</td>";
			echo "    <td colspan='2'>CPB</td>";
			echo "    <td colspan='3'>CNPJ: 00700114/0001-44</td>";
			echo "  </tr>";
			echo "  <tr>";
			echo "    <td colspan='5'><strong>".$array_resultadoCht["NOME"]." </strong></td>";
			echo "    <td colspan='2'><strong>001/".$array_resultadoCht["PESSOA"]."</strong></td>";
			echo "    <td colspan='3'><strong>".$array_resultadoCht["DESCRICAO202"]."</strong></td>";
			echo "  </tr>";
			echo "</table>";
		odbc_close($conCab);	
	 }}
//Montar estrutura do centro do contracheque com os lançementos	 
function montaCentroContCheq($mesCh,$anoCh,$nome_funcCh){
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
					  dbo.RHPESSOAS.EMAILCORPORATIVO
					From
					  dbo.RHVDBFOLHA Left Join
					  dbo.RHCONTRATOS On dbo.RHVDBFOLHA.CONTRATO = dbo.RHCONTRATOS.CONTRATO Inner Join
					  dbo.RHPESSOAS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
					  dbo.RHVDB On dbo.RHVDBFOLHA.VDB = dbo.RHVDB.VDB
					  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')";
          $resChC = odbc_exec($conCab, $SQLChC);
echo "<table width='845' cellpadding='0' cellspacing='0' border='1'>";
echo "  <tr>";
echo "    <td width='80' align='center'><u>Cod.</u></td>";
echo "    <td width='407' align='center'><u>Descricao</u></td>";
echo "    <td width='108' align='center'><u>Hrs/Qtde</u></td>";
echo "    <td width='108' align='center'><u>Vencimentos</u></td>";
echo "    <td width='108' align='center'><u>Descontos</u></td>";
echo "  </tr>";
while($array_resultadoChC = odbc_fetch_array($resChC)){
	if($array_resultadoChC["DATAADMISSAO"]>$data){
             ?>
			   <script type="text/javascript">
               alert("Voce possui recibo para esse mes. Verifique com o RH.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	    }
		//Verificar data futura de selecao ??????? AJUSTE
		/*elseif($data > $dataatual){
			?>
			   <script type="text/javascript">
               alert("Proibido solicitacoes para data futura.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
			}*/
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
				  RHVDB On RHVDBFOLHA.VDB = RHVDB.VDB Inner Join
				  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
				  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$nome_funcCh."')";
	$resChR = odbc_exec($conCab, $SQLChR);
    echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr align='right'>";
	echo "    <td width='134'>Salario p/ Mes</td>";
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
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agencia: ".$agencia."-".$digitoAg."</td>";
	echo "    <td width='170' align='right'><strong>L i q u i d o<br />".$liquido."</strong></td>";
	echo "  </tr>";
	echo "</table>";
	echo "<table width='845' border='1' cellpadding='0' cellspacing='0'>";
	echo "  <tr>";
	echo "    <td width='845'>Recebi o valor liquido deste recibo,<br />";
	echo "      correspondente a discriminacao acima<br />";
	echo "      do qual dou plena e total "; 
	echo "quitacao.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/_____/______ ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ass._________________________________</td>";
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
function inserirFuncionario($nome3,$login2,$email){
	//Comparação com os dados do SIGAM
$loginInsert=strstr($login2,"@",true);
	      require('conectsqlserver.php');
		  $SQLCab9 = "Select
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
						  WHERE UPPER(dbo.RHPESSOAS.EMAILCORPORATIVO)=UPPER('".$email."')";
          $resCab9 = odbc_exec($conCab, $SQLCab9);
	      $array_resultado9 = odbc_fetch_array($resCab9);
		  
		  if(empty($array_resultado9)){
             ?>
			   <script type="text/javascript">
               alert("Usuário não cadastrado no CIGAM com os dados informados.");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	}else {
	require('conexaomysql.php');
	$insertFunc="INSERT INTO usuarios VALUES ('','".$nome3."','".$email."' ,'".$loginInsert."','12345','3','')";
	$consultaDuplo = "SELECT * FROM usuarios WHERE usuario='".$loginInsert."'";
	$consultaDexec = mysql_query($consultaDuplo) or die(mysql_error());
	$contarDuplo=mysql_num_rows($consultaDexec);
	if($contarDuplo>='1') {
		?>
       <script type="text/javascript">
       alert("Ja existe um usuário com o mesmo login no sistema. Por favor verificar.");
       history.back();
       </script>
       <?php 
	   }else{
		$inserirFunc=mysql_query($insertFunc);
	     if ($inserirFunc) {
     	  ?>
          <script type="text/javascript">
          alert("Funcionário Cadastrado com Sucesso!");
          window.location.href = 'home.php';
          </script>
       <?php
       header('Localização: principal.php');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("Não foi possível inserir o usuário. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: principal.php');
	          }
	   }
	}
}

//Função para cadastrar solicitação de férias
function inserirSolic($funcionario8,$dataInicio,$dataFinal,$gestor,$abono,$radio){
	require('conexaomysql.php');
	$gestorQ = mysql_query("SELECT * FROM gestores WHERE id = ".$gestor) or die(mysql_error());
	$gestorA = mysql_fetch_array($gestorQ);	
	$insertSol="INSERT INTO solferias VALUES ('','".$funcionario8."','".$dataInicio."' ,'".$dataFinal."','".$gestorA["nome"]."','1','".$abono."','1','".$radio."')";
	$comandosql3="SELECT * FROM solferias  WHERE funcionario='".$funcionario8."' and datainicio='".$dataInicio."' and datafinal='".$dataFinal."' and gestor='".$gestorA["nome"]."' and status='1'";
	$consulta2 = mysql_query($comandosql3) or die(mysql_error());
	$contar2=mysql_num_rows($consulta2);
	if($contar2>='1') {
		?>
       <script type="text/javascript">
       alert("Ja existe uma solicitação com os mesmos parâmetros pendente de aprovação no sistema, por favor aguarde a aprovação de seu gestor: <?php echo $gestorA["nome"] ?>.");
       history.back();
       </script>
       <?php 
	   }else{
	$inserir2=mysql_query($insertSol) or die(mysql_error());
	if ($inserir2) {
     	?>
       <script type="text/javascript">
       alert("Solicitação Cadastrada com Sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: solferias.php');
	    } else {
	          ?>
			   <script type="text/javascript">
               alert("Não foi possível inserir a solicitação. Tente novamente!");
               history.back();
               </script>
               <?php
               header('Localização: solferias.php');
	          }
	   }
	}
	
//Função para montar grade de Solicitações de Ferias Pendentes

function montaGradePendente($usuarioGradeP){
	 $rs = mysql_query("SELECT * FROM solferias  WHERE funcionario='".$usuarioGradeP."' and status=1");
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj = mysql_fetch_object($rs)){
			if($obj->abono=="abono"){
				$abonopd="SIM";}
				else{
					$abonopd="NAO";}
			echo "<form action='excluirSol.php' method='post' name='form".$obj->id."' > <tr><td>".$obj->datainicio."</td><td>".$obj->datafinal."</td><td><input name='id' id='id' value='".$obj->id."' size='30' type='hidden'/>".$obj->gestor."</td><td>".$abonopd."</td><td>".$obj->ad13."</td><td>Pendente de Aprovação</td><td><input class='button'  name='enviar5' type='submit' value='Excluir ?' /></td></tr> </form>";
			}
			echo "</table></div>";
	}
	
//Função para montar grade de Solicitações de Ferias Aprovadas

function montaGradeAprovadas($usuarioGradeAp){
	 $rs1 = mysql_query("SELECT * FROM solferias  WHERE funcionario='".$usuarioGradeAp."' and status=2");
		echo "<div id='tabela'><table border='1'> <tr><th width='60'><strong>Data Inicial</strong></th><th width='60'><strong>Qtd. Dias</strong></th><th width='320'><strong>Gestor</strong></th><th width='60'>Abono</th><th width='90'>Parcela 13º Salario</th><th width='200'><strong>Status do Pedido</strong></th><th width='60'></th></tr>";
		while($obj1 = mysql_fetch_object($rs1)){
			if($obj1->abono=="abono"){
				$abonoap="SIM";}
				else{
					$abonoap="NAO";}
			echo "<form action='impFerias.php' method='post' name='form".$obj1->id."' > <tr><td>".$obj1->datainicio."</td><td>".$obj1->datafinal."</td><td><input name='id' id='id' value='".$obj1->id."' size='30' type='hidden'/>".$obj1->gestor."</td><td>".$abonoap."</td><td>".$obj1->ad13."</td><td>Aprovado</td><td><input class='button'  name='enviar6' type='submit' value='Imprimir Solicitacao' /></td></tr> </form>";
			}
			echo "</table></div>";
	}

//Função para montar grade de Solicitações de Ferias Recusadas

function montaGradeRecusadas($usuarioGradeRe){
	 $rs2 = mysql_query("SELECT * FROM solferias  WHERE funcionario='".$usuarioGradeRe."' and status=3");
		echo "<div id='tabela'><table border='1'> <tr><th width='70'><strong>Data Inicial</strong></th><th width='70'><strong>Qtd. Dias</strong></th><th width='340'><strong>Gestor</strong></th><th><strong>Status do Pedido</strong></th></tr>";
		while($obj2 = mysql_fetch_object($rs2)){
			echo "<form action='excluirSol.php' method='post' name='form".$obj2->id."' > <tr><td>".$obj2->datainicio."</td><td>".$obj2->datafinal."</td><td><input name='id' id='id' value='".$obj2->id."' size='30' type='hidden'/>".$obj2->gestor."</td><td>Recusadas</td></tr> </form>";
			}
			echo "</table></div>";
	}

//Função para excluir uma solicitação de férias
function excluirSol($id){
	require('conexaomysql.php');
	$excluirSql="DELETE FROM solferias WHERE (id='".$id."')";
    $deleteSql=mysql_query($excluirSql);
	if ($deleteSql) {
     	?>
       <script type="text/javascript">
       alert("Solicitação deletada com Sucesso!");
       window.location.href = 'home.php';
       </script>
       <?php
       header('Localização: solferias.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Solicitação não deletada. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: solferias.php');
	      }
	mysql_close($conexao);
	}

//Função para imprimir uma solicitação de férias
function imprimirFerias($idFerias){
	require('conexaomysql.php');
	   $imprimirSQL = mysql_query("SELECT * FROM solferias  WHERE id='".$idFerias."'");
		while($objImprimir = mysql_fetch_object($imprimirSQL)){
			if($objImprimir->abono=="abono"){
				$abonoIp="SIM";}
				else{
					$abonoIp="NAO";}
			echo "<table width='704' border='0'>
  <tr>
    <td><p align='center'><img src='imagens/logoDocumento.png' alt='' width='95' height='120' /> <br />
      ______________________________________________________________________________</p>
      <p align='center'><strong>COMUNICAÇÃO INTERNA</strong></p>
      <p align='center'>&nbsp;</p>
      <p><strong>Nº:   </strong><br />
        <strong>Data:</strong>  ____/_____/______<br />
        <br />
        <strong>De</strong>: ".$objImprimir->funcionario."</p>
      <strong>Para</strong>: Recursos Humanos - DRH
      <p><strong>Referência: </strong> Solicitação de férias</p>
    <p></p></td>
  </tr>
  <tr>
    <td><p>Considerando adquirir direito às férias do período aquisitivo de ___/___/___  a ___/___/___, venho solicitar que me sejam concedidos férias no período abaixo:</p>
      <p align='center'><strong>".$objImprimir->datafinal."</strong> DIAS A PARTIR DE: <strong>".$objImprimir->datainicio."</strong>. </p>
	  <ul>
      <p><li>10 Dias Convertidos em Abono Pecuniário, Conforme Legislação  Vigente.(<strong>".$abonoIp."</strong>)</li></p>
      <p><li>Solicitação do Adiantamento da Primeira Parcela do 13º Salário: (<strong>".strtoupper($objImprimir->ad13)."</strong>)</li></p>
      <p align='center'>&nbsp;</p>
	  <p align='center'>&nbsp;</p>
	  <p align='center'>&nbsp;</p>
      <p>Atenciosamente,</p>
      <p align='center'>&nbsp;</p>
	  <p align='center'>&nbsp;</p>
      <p align='center'>         ______________________________________<br />
  <strong>".$objImprimir->funcionario."</strong></p>
     <br>
	 <br>
  </td>
  </tr>
  <tr>
    <td><img src='imagens/rodapeDocumento.png' width='703' height='77' /></td>
  </tr>
</table>";
			}
			
	}

////Função para atualizar uma solicitação de férias
function atualizaSol($id,$status6,$funcFerias){
	require('conexaomysql.php');
	$updateSol="UPDATE solferias SET status = '".$status6."' WHERE id = '".$id."'";
    $atualizarSol=mysql_query($updateSol) or die(mysql_error());
	$consultaGestor="SELECT * FROM solferias WHERE id='".$id."'";
	$consultaGestorEx=mysql_query($consultaGestor) or die(mysql_error());
	$resultadoGestor = mysql_fetch_array($consultaGestorEx);
	
	if ($atualizarSol) {
	   	?>
       <script type="text/javascript">
	     alert("Solicitação Alterada com Sucesso <?php $funcFerias ?>!");
         window.location.href = 'home.php';
       </script>
       <?php
      // header('Localização: principal.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Solicitação nao alterada. Tente novamente!");
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
//Função para mostrar dados ao gestor
//Função para montar grade de Solicitações de Ferias Pendentes

function listaSolicitac($userGestor){
	 $rsGest = mysql_query("SELECT * FROM solferias  WHERE status=1 and gestor='".$userGestor."' ");
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
			echo "</table></div>";
	}
	
//Função para montar grade de Oc Pendentes

function listagemOC($userOcGestor,$controleOcGestor){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLOcV = "Select
  COORDEM.Cd_ordem_compra,
  COORDEM.Dt_compra,
  COORDEM.Descricao_cond_
From
  COORDEM 
Where
  COORDEM.campo89='10'";
          $resOcV = odbc_exec($conCab, $SQLOcV);
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; OC</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/CI</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th><th width='50'>Detalhar Itens</th></tr>";
		while($objOcV = odbc_fetch_object($resOcV)){
			if(empty($objOcV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI Pendente!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$SQLConsItemOcV = "SELECT 
										COIORDEM.*,
  										GEUSUARI.Nome
							  FROM
							  COIORDEM Inner Join
  							  GEUSUARI On COIORDEM.Usuario_modific = GEUSUARI.Cd_usuario
							  WHERE COIORDEM.cd_especie_esto='E'
							  AND COIORDEM.cd_ordem='".$objOcV->Cd_ordem_compra."'";
			$resConsItemOcV = odbc_exec($conCab, $SQLConsItemOcV);
			$valorTotalItensOc=0;
			$countCISol=0;
			$nomeUsuarioOc='Indefinido';
			$arrayCIvOC='Sem cadastro Definido no CIGAM';
			while($objConsItemOcV = odbc_fetch_object($resConsItemOcV)){
				$SQLCountCIOC = "SELECT *
							  FROM
							  COIORDEM
							  WHERE COIORDEM.cd_ordem='".$objOcV->Cd_ordem_compra."'
							  AND COIORDEM.Cd_solicitacao <> '".$objConsItemOcV->Cd_solicitacao."'";
			$resCountCIOC = odbc_exec($conCab, $SQLCountCIOC);
			$SQLOCItensValor="Select
  ESMATERI.Descricao As Descricao1,
  COIORDEM.*,
  GEUSUARI.Nome
From
  ESMATERI Inner Join
  COIORDEM On COIORDEM.Cd_material = ESMATERI.Cd_material Inner Join
  GEUSUARI On COIORDEM.Usuario_criacao = GEUSUARI.Cd_usuario
Where
  COIORDEM.Cd_ordem = '".$objOcV->Cd_ordem_compra."'";
          	
		$resOCItensValor = odbc_exec($conCab, $SQLOCItensValor);
			$countCISol=$countCISol+1;
			while($objOCItensValor= odbc_fetch_object($resOCItensValor)){
			$valorOcItemV=$objOCItensValor->Quantidade*$objOCItensValor->Pr_unitario;
			$valorTotalItensOc=$valorTotalItensOc+$valorOcItemV;
			}
			$nomeUsuarioOc=$objConsItemOcV->Nome;
			$SQLCIvOC = "SELECT *
							  FROM
							  COSOLICI
							  WHERE COSOLICI.Solicitacao='".$objConsItemOcV->Cd_solicitacao."'";
			$resCIvOC = odbc_exec($conCab, $SQLCIvOC);
			$arrayCIvOC = odbc_fetch_array($resCIvOC);
			}
			if($countCISol>1){
				$descOcCi='Multiplas CIs';
				}else{
					if($arrayCIvOC=='Sem cadastro Definido no CIGAM'){
				      $descOcCi='Ordem de Compra sem Itens';//Informação apenas interna!
						}else{
			    $descOcCi=$arrayCIvOC['Solicitacao']." - ".$arrayCIvOC['Desc_cond_pag'];
			echo "<form action='atualizaOc.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$userOcGestor."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objOcV->Cd_ordem_compra."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descOcCi."' size='40' type='hidden' />".$objOcV->Cd_ordem_compra."</td><td>".date('d/m/Y',strtotime($objOcV->Dt_compra))."</td><td>".$nomeUsuarioOc."</td><td>".$descOcCi."</td><td>R$ ".number_format($valorTotalItensOc, 2, ',', '.')."</td><td><input name='enviar5' class='button' type='submit' value='Aprovar CI' /></form></td><form action='listaItensOc.php' method='post' name='form4.id_CIItens' ><td><input name='user_ciItens' id='user_ciItens' value='".$userOcGestor."' size='40' type='hidden' /><input name='id_ciItens' id='id_ciItens' value='".$objOcV->Cd_ordem_compra."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objOcV->Dt_compra))."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$nomeUsuarioOc."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descOcCi."' size='150' type='hidden' /><input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItensOc, 2, ',', '.')."' size='40' type='hidden' /><input name='controle_ci' id='controle_ci' value='".$controleOcGestor."' size='40' type='hidden' /><input name='enviar6' class='button' type='submit' value='Detalhar Itens' /></td></tr> </form>";
			}}
			}
			}
			echo "</table></div>";
	}

//Função de inserção de dados CI
function updateCi($ciUpdate,$UserCiUpdate,$descricaoCiUpdate){
	require "conectsqlserverci.php";
	$SQLConsContrCI = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol
					   FROM COCSO WITH(nolock)
					   WHERE controle = 'W'";
			$resConsContrCI = odbc_exec($conCab, $SQLConsContrCI);
			$arrayConsContrCI = odbc_fetch_array($resConsContrCI);
			$SQLConsStatusCi = "SELECT 
								campo27
					   FROM COSOLICI WITH(nolock)
					   WHERE Solicitacao = '".$ciUpdate."'";
			$resConsStatusCi = odbc_exec($conCab, $SQLConsStatusCi);
			$arrayConsStatusCi = odbc_fetch_array($resConsStatusCi);
			$SQLConsContrCIAnt = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol
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
			while($objConsItemCI = odbc_fetch_object($resConsItemCI)){
				$descContCIItem=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
				$historicoCiItens="O controle do item da solicitação foi alterado de ".$objConsItemCI->campo65." - ".rtrim($descContCIItem)." para W - Alteração de Controle Através da WEB . Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCiItens=mb_convert_encoding($historicoCiItens,"ISO-8859-1","UTF-8");
			$SQLupdCoisolic="UPDATE COISOLIC
							 SET campo65='W',
							 situacao='".$arrayConsContrCI['situac_item_sol']."',
							 usuario_modific='WEB',
							 dt_modificacao=dbo.CGFC_DATAATUAL()
							 WHERE cd_especie_esto='E'
							 AND cd_solicitacao='".$ciUpdate."'
							 AND Sequencia='".$objConsItemCI -> Sequencia."'";
		    $updCoisolic=odbc_exec($conCab,$SQLupdCoisolic) or die("<p>".odbc_errormsg());
			$ciUpdateItensSol=str_pad($ciUpdate, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeq=str_pad($objConsItemCI -> Sequencia, 3, "0", STR_PAD_LEFT);
			$ciUpdateItens=$ciUpdateItensSol."/".$ciUpdateItensSeq;
			$SQLInsAcompItens="INSERT INTO GEACOMP VALUES('','".$ciUpdateItens."',".$ciUpdate.",".$objConsItemCI -> Sequencia.",'R','',null,null,null,null,'WEB',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','WEB','','','','','','',0,0,0,0,'',dbo.CGFC_DATAATUAL(),".$horaSessaoCi.",null,null,'','".$converterHistoricoCiItens."')";
			$InsAcompItens=odbc_exec($conCab,$SQLInsAcompItens) or die("<p>".odbc_errormsg());
			}
			$descContCI=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
			$historicoCi="O controle da solicitação foi alterado de ".$arrayConsStatusCi['campo27']." - ".rtrim($descContCI)." para W - Alteração de Controle Através da WEB . Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCi=mb_convert_encoding($historicoCi,"ISO-8859-1","UTF-8");
			$SQLupdCosolici="UPDATE COSOLICI
							 SET campo27='W',
							 situacao='".$arrayConsContrCI['sit_solicitacao']."'
							 WHERE solicitacao='".$ciUpdate."'";
		    $updCosolici=odbc_exec($conCab,$SQLupdCosolici) or die("<p>".odbc_errormsg());
			$ciUpdateCapa=str_pad($ciUpdate, 8, " ", STR_PAD_LEFT);
			$SQLInsAcompSol="INSERT INTO GEACOMP VALUES('','".$ciUpdateCapa."',0,0,'R','',null,null,null,null,'WEB',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','WEB','','','','','','',0,0,0,0,'',dbo.CGFC_DATAATUAL(),".$horaSessaoCi.",null,null,'','".$converterHistoricoCi."')";
			$InsAcompSol=odbc_exec($conCab,$SQLInsAcompSol) or die("<p>".odbc_errormsg());
			if($InsAcompSol){
			if ($updCoisolic) {
			                  
			if ($updCosolici) {
				/*$nomeEmailCI=strtoupper($UserCiUpdate);
				$emailCIEnvio="edywill@hotmail.com";
				$controleCIEnvio=$arrayConsStatusCi['campo27'];
				
				
				$codCIEnvio=;
				$descCIEnvio=;
				$qtdCIEnvio=;
				$przCIEnvio=;
				echo "<form action='http://www.cpb.org.br/intranetcpb/enviaEmail.php' method='post'>
<input name='email' type='hidden' value='".$emailCIEnvio."' /><br /><input name='nome' type='hidden' value='".$nomeEmailCI."'/><br /><input name='controle' type='hidden' value='".$controleCIEnvio."'/><br /><input name='cod' type='hidden' value='".$codCIEnvio."'/><br /><input name='desc' type='hidden' value='".$descCIEnvio."'/><br /><input name='qtd' type='hidden' value='".$qtdCIEnvio."'/><br /><input name='prz' type='hidden' value='".$przCIEnvio."'/>
<h2>CI Aprovada com Sucesso</h2>
<strong>Clique em OK para continuar!</strong><br>
<input name='ok' type='submit' value='ok' />
</form>
";*/
echo "<form action='http://www.cpb.org.br/intranetcpb/enviaEmail.php' method='post' name='form5.id_CI' > <table width='100%' align='center'><tr><td><input name='user_ci' id='user_ci' value='".$UserCiUpdate."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$ciUpdate."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descricaoCiUpdate."' size='40' type='hidden' /><h2>SOLICITA&Ccedil;&Atilde;O ATUALIZADA COM SUCESSO.<br> PARA CONTINUAR CLIQUE NO BOT&Atilde;O ABAIXO.</h2></td></tr><tr><td><input name='enviar7' class='button' type='submit' value='CONTINUAR' /></td></tr></table>";
            }
			}
			}
			
	}
//Função para atualizar a OC

function updateOc($cdOcUpdate,$UserOCUpdate,$descOcUpdate){
			require "conectsqlserverci.php";
			$SQLVerbaOc = "SELECT 'S'
						   FROM GELIBERA lib(nolock)
						   WHERE lib.tipo_documento='OC'
						   AND lib.liberado <= 'N'
						   AND lib.doc_alpha='".$cdOcUpdate."'";
			$resVerbaOc = odbc_exec($conCab, $SQLVerbaOc);
			$arrayVerbaOc = odbc_fetch_array($resVerbaOc);
			if(empty($arrayVerbaOc)){
			$SQLControleOc = "SELECT con.descricao,
								  con.situacao_pedido,
								  con.situac_item_ped
						   FROM COCONTRO con(nolock)
						   WHERE con.controle='25'
						   AND con.controle<>dbo.CGFC_BUSCA_CONFIGURACAO(1073,null)";
			$resControleOc = odbc_exec($conCab, $SQLControleOc);
			$arrayCotroleOc = odbc_fetch_array($resControleOc);
			$SQLConsItemOC="SELECT *
							 FROM COIORDEM (nolock)
							 WHERE cd_especie_esto='E'
							 AND cd_ordem='".$cdOcUpdate."'";
		    $resConsItemOC=odbc_exec($conCab,$SQLConsItemOC) or die("<p>".odbc_errormsg());
			$SQLConsStatusOC = "SELECT 
								campo89,
								Cd_fornecedor
					   FROM COORDEM WITH(nolock)
					   WHERE cd_ordem_compra='".$cdOcUpdate."'";
			$resConsStatusOC = odbc_exec($conCab, $SQLConsStatusOC);
			$arrayConsStatusOC = odbc_fetch_array($resConsStatusOC);
			$dataOc=date("d.m.y");
			$horaOc=date("H:i:s");
			$horaSessaoOc=date("His");
			$SQLControleOcGeral = "SELECT con.descricao,
								  con.situacao_pedido,
								  con.situac_item_ped,
								  con.controle
						   FROM COCONTRO con(nolock)
						   WHERE con.controle='".$arrayConsStatusOC['campo89']."'
						   AND con.controle<>dbo.CGFC_BUSCA_CONFIGURACAO(1073,null)";
			$resControleOcGeral = odbc_exec($conCab, $SQLControleOcGeral);
			$arrayControleOcGeral = odbc_fetch_array($resControleOcGeral);
			while($objConsItemOC = odbc_fetch_object($resConsItemOC)){
			$descContOcItem=mb_convert_encoding($arrayControleOcGeral['descricao'],"UTF-8","ISO-8859-1");
			$historicoOcItens="O controle do item da ordem de compra foi alterado de ".$arrayConsStatusOC['campo89']."-".rtrim($descContOcItem)." para 25 - Aprovação de OC - WEB . Alteração realizada pelo usuário ".strtoupper($UserOCUpdate)." em ".$dataOc." às ".$horaOc.".";
			$converterHistoricoOCItens=mb_convert_encoding($historicoOcItens,"ISO-8859-1","UTF-8");
			$SQLupdCOIORDEM="UPDATE COIORDEM
							 SET campo91='25',
							 situacao='".$arrayCotroleOc['situac_item_ped']."',
							 usuario_modific='WEB',
							 dt_modificacao=dbo.CGFC_DATAATUAL(),
							 dt_item=dbo.CGFC_DATAATUAL()
							 WHERE cd_especie_esto='E'
							 AND cd_ordem='".$cdOcUpdate."'";
		    $updCOIORDEM=odbc_exec($conCab,$SQLupdCOIORDEM) or die("<p>".odbc_errormsg());
			//$ciUpdateItensSol=str_pad($ciUpdate, 8, "0", STR_PAD_LEFT);
			//$ciUpdateItensSeq=str_pad($objConsItemCI -> Sequencia, 3, "0", STR_PAD_LEFT);
			//$ciUpdateItens=$ciUpdateItensSol."/".$ciUpdateItensSeq;
			$SQLInsAcompItensOc="INSERT INTO GEACOMP VALUES('','".$cdOcUpdate."',0,".$objConsItemOC -> Sequencia.",'9','',null,null,null,null,'WEB',".$horaSessaoOc.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','WEB','','','','','','',0,0,0,0,'',dbo.CGFC_DATAATUAL(),".$horaSessaoOc.",null,null,'','".$converterHistoricoOCItens."')";
		$InsAcompItemOC=odbc_exec($conCab,$SQLInsAcompItensOc) or die("<p>".odbc_errormsg());

			}
			$descContOc=mb_convert_encoding($arrayControleOcGeral['descricao'],"UTF-8","ISO-8859-1");
			$historicoOc="O controle da ordem de compra foi alterado de ".$arrayConsStatusOC['campo89']."-".rtrim($descContOc)." para 25 - Aprovação de OC - WEB . Alteração realizada pelo usuário ".strtoupper($UserOCUpdate)." em ".$dataOc." às ".$horaOc.".";
			$converterHistoricoOC=mb_convert_encoding($historicoOc,"ISO-8859-1","UTF-8");
			$SQLupdCOORDEM="UPDATE COORDEM
							 SET campo89='25',
							 situacao='".$arrayCotroleOc['situac_item_ped']."'
							 WHERE cd_ordem_compra='".$cdOcUpdate."'";
		    $updCOORDEM=odbc_exec($conCab,$SQLupdCOORDEM) or die("<p>".odbc_errormsg());
				$SQLInsAcompOc="INSERT INTO GEACOMP VALUES('".$arrayConsStatusOC['Cd_fornecedor']."','".$cdOcUpdate."',0,0,'O','',null,null,null,null,'WEB',".$horaSessaoOc.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','WEB','','','','','','',0,0,0,0,'',dbo.CGFC_DATAATUAL(),".$horaSessaoOc.",null,null,'','".$converterHistoricoOC."')";
		$InsAcompOC=odbc_exec($conCab,$SQLInsAcompOc) or die("<p>".odbc_errormsg());
				if($InsAcompOC){
					if($updCOORDEM){
						echo "<form action='http://www.cpb.org.br/intranetcpb/enviaEmailOc.php' method='post' name='form5.id_Oc' > <table width='100%' align='center'><tr><td><input name='user_ci' id='user_ci' value='".$UserOCUpdate."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$cdOcUpdate."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descOcUpdate."' size='40' type='hidden' /><h2>SOLICITA&Ccedil;&Atilde;O ATUALIZADA COM SUCESSO.<br> PARA CONTINUAR CLIQUE NO BOT&Atilde;O ABAIXO.</h2></td></tr><tr><td><input name='enviar7' class='button' type='submit' value='CONTINUAR' /></td></tr></table>";

			}}
				
				}else{
					?>
       <script type="text/javascript">
	     alert("Houve Verba Excedida para esta ordem de compra, solicite liberacao de verbas.");
         window.location.href = 'home.php';
       </script>
       <?php

					}
	
	}
//Função para montar grade de CI Pendentes

function listaCi($userCiGestor,$controleCiGestor){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLCiV = "Select
  COSOLICI.Solicitacao,
  COSOLICI.Data,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Desc_cond_pag
From
  COSOLICI 
  where
  COSOLICI.campo27='".$controleCiGestor."'";
          $resCiV = odbc_exec($conCab, $SQLCiV);
		  if($controleCiGestor=='05'){
			echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='40'>Controle</th><th width='50'>Aprovar</th><th width='50'>Detalhar Itens</th><th width='50'>Visualizar CI</th></tr>";
		while($objCiV = odbc_fetch_object($resCiV)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI Pendente!");
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
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />".$objCiV->Solicitacao."</td><td>".date('d/m/Y',strtotime($objCiV->Data))."</td><td>".$nomeCompleto."</td><td>".$objCiV->Desc_cond_pag."</td><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td><td><select name='controle'><option selected='selected'>Escolha</option><option value='16'> 16 </option><option value='EP'> EP </option></select></td><td><input name='enviar5' class='button' type='submit' value='Aprovar CI' /></form></td><form action='listaItensCi.php' method='post' name='form4.id_CIItens' ><td><input name='user_ciItens' id='user_ciItens' value='".$userCiGestor."' size='40' type='hidden' /><input name='id_ciItens' id='id_ciItens' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objCiV->Data))."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$nomeCompleto."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='150' type='hidden' /><input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItens, 2, ',', '.')."' size='40' type='hidden' /><input name='controle_ci' id='controle_ci' value='".$controleCiGestor."' size='40' type='hidden' /><input name='enviar6' class='button' type='submit' value='Detalhar Itens' /></td><td> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' ><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='button' type='submit' value='Visualizar CI' /></form></td></tr>";}
			}
			echo "</table></div>";  
			  }else{
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th><th width='50'>Detalhar Itens</th><th width='50'>Visualizar CI</th></tr>";
		while($objCiV = odbc_fetch_object($resCiV)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI Pendente!");
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
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$userCiGestor."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' />".$objCiV->Solicitacao."</td><td>".date('d/m/Y',strtotime($objCiV->Data))."</td><td>".$nomeCompleto."</td><td>".$objCiV->Desc_cond_pag."</td><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td><td><input name='enviar5' class='button' type='submit' value='Aprovar CI' /></form></td><form action='listaItensCi.php' method='post' name='form4.id_CIItens' ><td><input name='user_ciItens' id='user_ciItens' value='".$userCiGestor."' size='40' type='hidden' /><input name='id_ciItens' id='id_ciItens' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='data_ci' id='data_ci' value='".date('d/m/Y',strtotime($objCiV->Data))."' size='40' type='hidden' /><input name='solic_ci' id='solic_ci' value='".$nomeCompleto."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='150' type='hidden' /><input name='valor_ci' id='valor_ci' value='".number_format($valorTotalItens, 2, ',', '.')."' size='40' type='hidden' /><input name='controle_ci' id='controle_ci' value='".$controleCiGestor."' size='40' type='hidden' /><input name='enviar6' class='button' type='submit' value='Detalhar Itens' /></td><td> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' ><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='button' type='submit' value='Visualizar CI' /></form></td></tr>";}
			}
			echo "</table></div>";}
	}
//Função para montar grade de CI Pendentes

function impressaoCi($numeroCiImpressao){
	    include "mb.php";
		require "conectsqlserverci.php";
		$SQLImpCI = "select 
   sol.Solicitacao,
   item.Sequencia,
   sol.Data,
   item.Pr_unitario,
   item.Quantidade,
   mat.descricao,
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
inner join COISOLIC item with (nolock) on
   item.Cd_solicitacao = sol.Solicitacao and
  item.cd_especie_esto = 'E'
inner join ESMATERI mat with (nolock) on 
   mat.Cd_material = item.Cd_material
left join GEPFISIC pes with (nolock) on
   pes.Cd_empresa = sol.Cod_cliente
where sol.Solicitacao = '".$numeroCiImpressao."'";
          $resImpCI = odbc_exec($conCab, $SQLImpCI);
		  $SQLImp2CI = "select 
   sol.Solicitacao,
   item.Sequencia,
   sol.Data,
   item.Pr_unitario,
   item.Quantidade,
   mat.descricao,
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
inner join COISOLIC item with (nolock) on
   item.Cd_solicitacao = sol.Solicitacao and
  item.cd_especie_esto = 'E'
inner join ESMATERI mat with (nolock) on 
   mat.Cd_material = item.Cd_material
left join GEPFISIC pes with (nolock) on
   pes.Cd_empresa = sol.Cod_cliente
where sol.Solicitacao = '".$numeroCiImpressao."'";
          $resImp2CI = odbc_exec($conCab, $SQLImp2CI);
		  $arrayImpCi = odbc_fetch_array($resImp2CI);
		  //while($objCiV = odbc_fetch_object($resCiV)){
			//$arrayItemPassImp = odbc_fetch_array($resItemPassImp);
			//$arrayItemHotelImp = odbc_fetch_array($resItemHotelImp);
   			//$arrayItemRPAImp = odbc_fetch_array($resItemRPAImp);
			//$arrayItemDiariaImp = odbc_fetch_array($resItemDiariaImp);
					$SQLItemEmbarqueImp = "select Embarque_pedido, DATA, Historico
										from geacomp
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
										  COSOLICI SOL Inner Join
										  COISOLIC IT On IT.Cd_solicitacao = SOL.Solicitacao Inner Join
										  ESMATERI MAT On MAT.Cd_material = IT.Cd_material Inner Join
										  GEEMPRES EMP On EMP.Cd_empresa = IT.Cd_solicitante Inner Join
										  COCSO CO On CO.Controle = SOL.Campo27 
										where sequencia_ordem = '0'
												 and sol.Solicitacao = '".$numeroCiImpressao."'";
					$resItemSoliciImp = odbc_exec($conCab, $SQLItemSoliciImp);
					$arrayItemEmbarqueImp = odbc_fetch_array($resItemSoliciImp);
					echo "<table width='100%'><tr><td></td><td align='center'><img src='imagens/logoDocumento.png'></td><td></td></tr></table>";
					$dataImpCI=date('d/m/Y',strtotime($arrayImpCi['Data']));
				    echo "<H2>COMUNICA&Ccedil;&Atilde;O INTERNA</H2>";
					echo "Data: ".$dataImpCI."<br>";
					$descT801=$arrayImpCi['Descricao_T801'];
					echo nl2br($descT801);
					$passagem=$arrayImpCi['Passagem'];
					$hotelImp=$arrayImpCi['Hotel'];
					$rpaImp=$arrayImpCi['RPA'];
					$diariaImp=$arrayImpCi['Diaria'];
					while($objImpCi = odbc_fetch_object($resImpCI)){
						echo "<br>";
						echo "<strong>".$objImpCi->Sequencia." . ".strtoupper ( $objImpCi->descricao )."</strong><br>";
						$descT802=$objImpCi->Descricao_T802;
					    $descT803=$objImpCi->Descricao_T803;
						echo nl2br($descT802);
						echo nl2br($descT803);
						if($passagem=1){
							$SQLItemPassImp = "select 
							   ROW_NUMBER() over (partition by psg.cd_solicitacao,psg.sequencia order by psg.sequencia) num, 
							   psg.cd_solicitacao,
							   psg.sequencia,
							   psg.cd_empresa,
							   (case when psg.cadeirante = 1 then '* ' + nom.Nome_completo else nom.Nome_completo end) nome_completo,
							   psg.trecho,
							   (psg.dt_partida) ,
							   psg.dt_chegada,
							   psg.observacao,
							   case when psg.cadeirante = 1 then 'X' end cadeirante 
							from TEITEMSOLPASSAGEM psg with (nolock)
							   inner join GEEMPRES nom with (nolock) on
								  nom.Cd_empresa = psg.cd_empresa
							where
							   psg.cd_solicitacao = '".$numeroCiImpressao."'
							   AND psg.sequencia='".$objImpCi->Sequencia."'";
							$resItemPassImp = odbc_exec($conCab, $SQLItemPassImp);
							/*$sqlPassagemImpr="SELECT *
											  FROM TEITEMSOLPASSAGEM pas
											  WHERE pas.cd_solicitacao=".$numeroCiImpressao."
											  AND pas.sequencia=".$objImpCi->Sequencia."";
							$passagemImpre=odbc_exec($conCab, $sqlPassagemImpr);*/
							if(odbc_num_rows($resItemPassImp)>0){
								echo "<div id='tabela'><table border='1'><tr><td><strong>N&ordm;</strong></td><td><strong>NOME</strong></td><td><strong>TRECHO</strong></td><td><strong>IDA</strong></td><td><strong>VOLTA</strong></td><td><strong><font size='-2'>CADEIRANTE</font></strong></td></tr>";
								while($objItemPassImp = odbc_fetch_object($resItemPassImp)){
									echo "<tr><td>".$objItemPassImp->num."</td><td>".$objItemPassImp->nome_completo."</td><td>".$objItemPassImp->trecho."</td><td>".date('d/m/Y',strtotime($objItemPassImp->dt_partida))."</td><td>".date('d/m/Y',strtotime($objItemPassImp->dt_chegada))."</td><td>".$objItemPassImp->cadeirante."</td></tr>";
									}
								echo "</div></table>";
								}
							}
							if($hotelImp=1){
							$SQLItemHotelImp = "select
		   htl.cd_solicitacao,
		   htl.sequencia, 
		   ROW_NUMBER() over (partition by htl.cd_solicitacao,htl.sequencia order by htl.sequencia) num, 
		   htl.reserva,
		   htl.cd_empresa,
		   nom.Nome_completo,
		   pes.Cargo funcao,
		   htl.dt_entrada,
		   htl.dt_saida
		
		from TEITEMSOLHOTEL htl with (nolock)
		inner join GEEMPRES nom with (nolock) on
			  nom.Cd_empresa = htl.cd_empresa
		left join GEPFISIC pes with (nolock) on
		   pes.Cd_empresa = nom.Cd_empresa
		where
		   htl.cd_solicitacao = '".$numeroCiImpressao."'
		   AND htl.sequencia='".$objImpCi->Sequencia."'";
			$resItemHotelImp = odbc_exec($conCab, $SQLItemHotelImp);
			if(odbc_num_rows($resItemHotelImp)>0){
								echo "<div id='tabela'><table border='1'><tr><td><strong>N&ordm;</strong></td><td><strong>RL</strong></td><td><strong>NOME</strong></td><td><strong>FUN&Ccedil;&Atilde;O/CARGO</strong></td><td><strong>IDA</strong></td><td><strong>VOLTA</strong></td></tr>";
								while($objItemHotelImp = odbc_fetch_object($resItemHotelImp)){
									echo "<tr><td>".$objItemHotelImp->num."</td><td>".$objItemHotelImp->reserva."</td><td>".$objItemHotelImp->Nome_completo."</td><td>".$objItemHotelImp->funcao."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_saida))."</td></tr>";
									}
								echo "</div></table>";
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
							   rpa.valor
							
							from TEITEMSOLRPA rpa with (nolock) 
							   inner join GEEMPRES nom with (nolock) on
								  nom.Cd_empresa = rpa.cd_empresa
							   left join GEPFISIC pes with (nolock) on
								  pes.Cd_empresa = nom.Cd_empresa
							where
							   rpa.cd_solicitacao = '".$numeroCiImpressao."'
							   AND rpa.sequencia='".$objImpCi->Sequencia."'";
					$resItemRPAImp = odbc_exec($conCab, $SQLItemRPAImp);
							if(odbc_num_rows($resItemRPAImp)>0){
								echo "<div id='tabela'><table border='1'><tr><td><strong>PROFISSIONAL</strong></td><td><strong>CARGO</strong></td><td><strong>INICIO</strong></td><td><strong>T&eacute;RMINO</strong></td><td><strong>VALOR</strong></td></tr>";
								while($objItemRPAImp = odbc_fetch_object($resItemRPAImp)){
									echo "<tr><td>".$objItemRPAImp->Profissional."</td><td>".$objItemRPAImp->Cargo."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_fim))."</td><td>R$ ".number_format($objItemRPAImp->valor, 2, ',', '.')."</td></tr>";
									}
								echo "</div></table>";
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
									   dia.valor
									
									from TEITEMSOLDIARIAVIAGEM dia with (nolock) 
									   inner join GEEMPRES nom with (nolock) on
										  nom.Cd_empresa = dia.empresa
									   left join GEPFISIC pes with (nolock) on
										  pes.Cd_empresa = nom.Cd_empresa
									where
									   dia.solicitacao = '".$numeroCiImpressao."'
									   AND dia.sequencia='".$objImpCi->Sequencia."'";
					$resItemDiariaImp = odbc_exec($conCab, $SQLItemDiariaImp);
							if(odbc_num_rows($resItemDiariaImp)>0){
								echo "<div id='tabela'><table border='1'><tr><td><strong>PROFISSIONAL</strong></td><td><strong>CARGO</strong></td><td><strong>INICIO</strong></td><td><strong>T&eacute;RMINO</strong></td><td><strong>VALOR</strong></td></tr>";
								while($objItemDiariaImp = odbc_fetch_object($resItemDiariaImp)){
									echo "<tr><td>".$objItemDiariaImp->Profissional."</td><td>".$objItemDiariaImp->Cargo."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_termino))."</td><td>R$ ".number_format($objItemDiariaImp->valor, 2, ',', '.')."</td></tr>";
									}
								echo "</div></table>";
								}
							} 
						}
		echo "<br><br><table width='100%' border='0'><tr><td align='center'>Atenciosamente,<br><br><br>_______________________________________<br><strong>".strtoupper ($arrayImpCi['cliente'])."</strong><br>".$arrayImpCi['Cargo']."</td></tr></table><br><br>";
		echo "<div id='tabela'><table width='100%' border='1'><tr><td><strong>Acompanhamentos</strong></td></tr>";
		while ($objItemEmbarqueImp = odbc_fetch_object($resItemEmbarqueImp)){
			echo "<tr><td><srong>".date('d/m/Y',strtotime($objItemEmbarqueImp->DATA))." - ".$objItemEmbarqueImp->Historico."</strong></td></tr>";
			}
			echo "</div></table>";
	}
//Função para montar grade de Itens da CI Pendentes

function detalhaItensCi($UserCiItens,$controleCiItens,$idCiItens,$dataCiItens,$solicCiItens,$descCiItens,$valorCiItens){
	    include "mb.php";
		require "conectsqlserverci.php";
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
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th></tr>";
		  echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserCiItens."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descCiItens."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idCiItens."' size='40' type='hidden' />".$idCiItens."</strong></td><td width='50'><strong>".$dataCiItens."</strong></td><td width='80'><strong>".$solicCiItens."</strong></td><td width='150'><strong>".$descCiItens."</strong></td><td width='60'>".$valorCiItens."</td><td width='50'><input name='enviar9' class='button' type='submit' value='Aprovar CI' /></td></tr></form></table></div>";
		  echo "<br><strong>Itens da CI N&ordm; ".$idCiItens."</strong><br>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Sequencia</strong></th><th width='80'><strong>Item</strong></th><th width='60'>Total(R$)</th><th width='50'>--</th></tr>";
		while($objCiItensV = odbc_fetch_object($resCiItensV)){
			if(empty($objCiItensV)){?>
       <script type="text/javascript">
	     alert("Todos os itens foram aprovados! CI Aprovada com Sucesso!");
         window.location.href = 'ciWeb.php';
       </script>
       <?php	   
				}else{
			$valorCItemVIten=$objCiItensV->Quantidade*$objCiItensV->Pr_unitario;
			echo "<form action='detalhaItensCi.php' method='post' name='form4.id_CI' > <tr><td><input name='user_ci' id='user_ci' value='".$idCiItens."' size='40' type='hidden' /><input name='userci' id='userci' value='".$UserCiItens."' size='40' type='hidden' /><input name='idci' id='idci' value='".$idCiItens."' size='40' type='hidden' /><input name='dataci' id='dataci' value='".$dataCiItens."' size='40' type='hidden' /><input name='solici' id='solici' value='".$solicCiItens."' size='40' type='hidden' /><input name='descci' id='descci' value='".$descCiItens."' size='40' type='hidden' /><input name='valorci' id='valorci' value='".$valorCiItens."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiItensV->Cd_solicitacao."' size='40' type='hidden' /><input name='seq_ci' id='seq_ci' value='".$objCiItensV->Sequencia."' size='40' type='hidden' />".$objCiItensV->Cd_solicitacao."</td><td>".$objCiItensV->Sequencia."</td><td>".$objCiItensV->Descricao1."</td><td>R$ ".number_format($valorCItemVIten, 2, ',', '.')."</td><td><input name='enviar5' class='button' type='submit' value='Detalhar Item' /></td></tr> </form>";
			}
			}
			echo "</table></div><br><br><A HREF=\"javascript:history.back()\">Voltar</A>";
	}

//Função para montar grade de Itens da CI Pendentes

function detalhamentoItensCi($idItensDetalhado,$seqIdItensDetal,$UserCiItensDetail, $idCiItensDetail,$dataCiItensDetail,$solicCiItensDetail,$descCiItensDetail,$valorCiItensDetail){
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
		echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>N&ordm; CI</strong></th><th width='50'><strong>Data Solicita&ccedil;&atilde;o</strong></th><th width='80'><strong>Solicitante</strong></th><th width='150'><strong>Processo/Evento</strong></th><th width='60'>Total(R$)</th><th width='50'>Aprovar</th></tr>";
		  echo "<form action='atualizaCi.php' method='post' name='form4.id_CI' ><tr><td width='30'><strong><input name='user_ci' id='user_ci' value='".$UserCiItensDetail."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$descCiItensDetail."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$idCiItensDetail."' size='40' type='hidden' />".$idCiItensDetail."</strong></td><td width='50'><strong>".$dataCiItensDetail."</strong></td><td width='80'><strong>".$solicCiItensDetail."</strong></td><td width='150'><strong>".$descCiItensDetail."</strong></td><td width='60'>".$valorCiItensDetail."</td><td width='50'><input name='enviar9' class='button' type='submit' value='Aprovar CI' /></td></tr></form></table></div><br><br>";
		  echo "<br><strong>Detalhamento: CI N&ordm; ".$idItensDetalhado." Item ".$seqIdItensDetal."</strong><br>";
		  if(odbc_num_rows($resItDiaViag)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Di&aacute;rias de Viagem</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. In&iacute;cio</strong></th><th width='80'><strong>Dt. T&eacute;rmino</strong></th><th width='60'>Valor(R$)</th></tr>";
		while($objItDiaViag = odbc_fetch_object($resItDiaViag)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItDiaViag->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItDiaViag->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItDiaViag->dt_termino))."</td><td>R$ ".number_format($objItDiaViag->valor, 2, ',', '.')."</td></tr> </form>";
			   }
			   echo "</table>";
			  }
					  if(odbc_num_rows($resItRPA)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Pagamento RPA</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. In&iacute;cio</strong></th><th width='80'><strong>Dt. T&eacute;rmino</strong></th><th width='60'>Valor(R$)</th></tr>";
		while($objItRPA = odbc_fetch_object($resItRPA)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItRPA->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItRPA->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItRPA->dt_fim))."</td><td>R$ ".number_format($objItRPA->valor, 2, ',', '.')."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItHopedagem)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Hopedagem</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. Entrada</strong></th><th width='80'><strong>Dt. Sa&iacute;da</strong></th></tr>";
		while($objItHopedagem = odbc_fetch_object($resItHopedagem)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItHopedagem->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItHopedagem->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItHopedagem->dt_saida))."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			  if(odbc_num_rows($resItPassagem)>0){
		  echo "<h2>Solicita&ccedil;&atilde;o de Passagem Aerea</h2>";
		  echo "<div id='tabela'><table border='1'> <tr><th width='30'><strong>Nome</strong></th><th width='50'><strong>Dt. Partida</strong></th><th width='30'><strong>Hr. Partida</strong></th><th width='80'><strong>Dt. Chegada</strong></th><th width='30'><strong>Hr. Chegada</strong></th><th width='70'><strong>Trecho</strong></th><th width='70'>Observacao</th></tr>";
		while($objItPassagem = odbc_fetch_object($resItPassagem)){
			echo "<form action='' method='post' name='form6.id_CI' > <tr><td>".$objItPassagem->Nome_completo."</td><td>".date('d/m/Y',strtotime($objItPassagem->dt_partida))."</td><td>".date('H:i:s',$objItPassagem->hr_partida)."</td><td>".date('d/m/Y',strtotime($objItPassagem->dt_chegada))."</td><td>".date('H:i:s',$objItPassagem->hr_chegada)."</td><td>".$objItPassagem->trecho."</td><td>".$objItPassagem->observacao."</td></tr></form>";
			   }
			   echo "</table>";
			  }
			echo "</div><br><br><A HREF=\"javascript:history.back()\">Voltar</A>";
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
	     alert("Todos os itens foram aprovados! OC Aprovada com Sucesso!");
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
       alert("ATENCAO!! Existe <?php echo $contGest ?> solicitacoes de ferias pendentes de aprovacao. Clique em APROVAR/RECUSAR FERIAS!");
	   <?php header('Localização: gestFerias.php'); ?>
       </script>
       <?php 
	   }
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
function atualizaUsuario($funcionario,$perfil,$controleAtualiza){
	require('conexaomysql.php');
	if($perfil==1){
		$rsGe = mysql_query("SELECT * FROM usuarios  WHERE id='".$funcionario."'");
		$objGe = mysql_fetch_object($rsGe);
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
				$deletarGestor="DELETE FROM cpb.gestores WHERE gestores.nome='".$objGe1->nome."'";
				$deleteSql2=mysql_query($deletarGestor) or die(mysql_error());
			 	}
			}
	$updateSql="UPDATE usuarios SET status = '".$perfil."',controle='".$controleAtualiza."' WHERE id = '".$funcionario."'";
    $atualizarSql=mysql_query($updateSql) or die(mysql_error());
	if ($atualizarSql) {
     	?>
       <script type="text/javascript">
       alert("Usuário Atualizado com Sucesso.");
       history.back();
       </script>
       <?php
       header('Localização: alterUsuario.php');
	    } else {
	          ?>
       <script type="text/javascript">
       alert("Usuário não atualizado. Tente novamente!");
       history.back();
       </script>
       <?php
       header('Localização: alterUsuario.php');
	      }
	mysql_close($conexao);
	}
	
function listaUsuarios(){
	    require('conexaomysql.php');
	    $rsUs = mysql_query("SELECT * FROM usuarios");
		echo "<div id='tabela'><table border='1'> <tr><th><strong>NOME</strong></th><th><strong>LOGIN</strong></th><th><strong>E-MAIL</strong></th></tr>";
		while($objUs = mysql_fetch_object($rsUs) or die(mysql_error())){
			echo "<tr><td>".$objUs->nome."</td><td>".$objUs->usuario."</td><td>".$objUs->email."</td></tr>";
			}
			echo "</table></div>";
	}
?>