<?php
require 'conexaoconv.php';
//include "mb.php";

$modalidade=$_GET['valor'];
if($modalidade<>"0"){
$sql = "SELECT modalidade.*,eventos.*,estados.estados,estados.uf AS ufEst FROM eventos,modalidade,estados WHERE eventos.idmodalidade=".$modalidade." AND eventos.idmodalidade=modalidade.id AND eventos.uf=estados.id";
$resultado = mysql_query($sql);
$resultado = mysql_fetch_array($resultado);
		if (!empty($resultado)){	
			echo "<p>";
			echo "<p>Eventos para a modalidade: ".utf8_encode ($resultado['modalidade'])."</p>";
			echo "<p><div id='tabela'>";
			echo "<table width='100%'>";
			echo "<tr>";
			echo "<th>Evento</th>";
			echo "<th>Cidade/UF</th>";
			echo "<th>Datas</th>";
			echo "<th colspan='2' align='center'>Editar</th>";
			echo "</tr>";
			$cadastro = mysql_query($sql);
				while ($linha = mysql_fetch_object($cadastro)) {
					echo "<tr>";
					echo "<td>";
					echo utf8_encode ($linha->nome);				
					echo "</td>";
					echo "<td>".utf8_encode ($linha->cidade)."/".$linha->ufEst."</td>";
					echo  "<td>".$linha->dtinicio." - ".$linha->dtfim."</td>";
					echo "<td><form action='atConv.php' method='POST' name='editar'><input name='idEvento' type='hidden' value='".$linha->id."'/><input type='submit' class='button' value='Dados do Evento' /></form></td>";
					echo "<td><form action='atValConv.php' method='POST' name='editarV'><input name='idEvento' type='hidden' value='".$linha->id."'/><input name='descEvento' type='hidden' value='".utf8_encode ($linha->nome)."'/><input type='submit' class='button' value='Projeções' /></form></td>";
					echo "</tr>";				
				}	
			echo "</table></div>";
		} else {
			
			 echo "<p>Não há eventos para essa modalidade cadastrado.</p>";
		}
		$sqlRh = "SELECT modalidade.*,rhpermanente.* FROM rhpermanente,modalidade WHERE rhpermanente.idmodalidade=".$modalidade." AND rhpermanente.idmodalidade=modalidade.id";
$resultadoRh = mysql_query($sqlRh);
$resultadoRh = mysql_fetch_array($resultadoRh);
		if (!empty($resultadoRh)){	
			echo "<p>";
			echo "<p>Recursos Humanos Permanentes</p>";
			echo "<p><div id='tabela'>";
			echo "<table width='100%'>";
			echo "<tr>";
			echo "<th>Função</th>";
			echo "<th>Quantidade/Unid. Med.</th>";
			echo "<th>Valor Unit. / Valor Total</th>";
			echo "<th colspan='1' align='center'>Editar</th>";
			echo "</tr>";
			$cadastroRh = mysql_query($sqlRh);
				while ($linhaRh = mysql_fetch_object($cadastroRh)) {
					echo "<tr>";
					echo "<td>";
					echo utf8_encode ($linhaRh->funcao);				
					echo "</td>";
					echo "<td>".$linhaRh->quantidade."/".utf8_encode ($linhaRh->um)."</td>";
					echo  "<td>R$".number_format($linhaRh->vlunit, 2, ',', '.')." - R$".number_format($linhaRh->vlunit, 2, ',', '.')."</td>";
					echo "<td><form action='atConvPerm.php' method='POST' name='editarP'><input name='idEvento' type='hidden' value='".$linhaRh->id."'/><input type='submit' class='button' value='Dados RH' /></form></td>";
					echo "</tr>";				
				}	
			echo "</table></div>";
		} else {
			
			 echo "<p>Não há recursos humanos permanentes para essa modalidade cadastrado.</p>";
		}
		
		}
?>