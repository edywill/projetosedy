<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<style media="print">
.botao {
display: none;
}
</style>
<body>

<?php

// Determina que o arquivo é uma planilha do Excel
   header("Content-type: application/vnd.ms-excel");   

   // Força o download do arquivo
   header("Content-type: application/force-download");  

   // Seta o nome do arquivo
   header("Content-Disposition: attachment; filename=avaliacaoAtletas.xls");

   header("Pragma: no-cache");
 
echo "<table cellspacing='0' cellpadding='0' width='100%' border='1'>
  <tr  bgcolor='#0099FF' align='center' valign='middle'>
    <th colspan='10' rowspan='2'><h3><strong><font color='#FFFFFF'>Programa Atletas de Alto Nível</font></strong></h3></th>
    <th colspan='2' rowspan='2'><strong><font color='#FFFFFF'>Melhor marca da    vida</font></strong></th>
    <th colspan='30'><font color='#FFFFFF'>Melhor marca ano a ano</font></th>
    <th colspan='2' rowspan='2'><font color='#FFFFFF'>Outros projetos</font></th>
    <th colspan='2' rowspan='2'>&nbsp;</th>
  </tr>
  <tr bgcolor='#0099FF' align='center' valign='middle'>
    <th colspan='3'><font color='#FFFFFF'>2014</font></th>
    <th colspan='3'><font color='#FFFFFF'>2013</font></th>
    <th colspan='3'><font color='#FFFFFF'>2012</font></th>
    <th colspan='3'><font color='#FFFFFF'>2011</font></th>
    <th colspan='3'><font color='#FFFFFF'>2010</font></th>
    <th colspan='3'><font color='#FFFFFF'>2009</font></th>
    <th colspan='3'><font color='#FFFFFF'>2008</font></th>
    <th colspan='3'><font color='#FFFFFF'>2007</font></th>
    <th colspan='3'><font color='#FFFFFF'>2006</font></th>
    <th colspan='3'><font color='#FFFFFF'>2005</font></th>
  </tr>
  <tr bgcolor='#0099FF' align='center' valign='middle'>
    <th><font color='#FFFFFF'>Nº</font></th>
    <th><font color='#FFFFFF'>Patrocìnio</font></th>
	<th><font color='#FFFFFF'>Atletas</font></th>
    <th><font color='#FFFFFF'>Classe</font></th>
    <th><font color='#FFFFFF'>Modalidade</font></th>
    <th><font color='#FFFFFF'>Categoria</font></th>
    <th><font color='#FFFFFF'>Bolsa 2014</font></th>
    <th><font color='#FFFFFF'>Entrada no Programa</font></th>
    <th><font color='#FFFFFF'>Melhor marca no ano em que entrou</font></th>
    <th><font color='#FFFFFF'>Principal prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'>Prova</font></th>
    <th><font color='#FFFFFF'>Marca</font></th>
    <th><font color='#FFFFFF'>Data e evento</font></th>
    <th><font color='#FFFFFF'> Projeto</font> </th>
    <th><font color='#FFFFFF'> Valor</font> </th>
    <th><font color='#FFFFFF'>Avaliação</font></th>
    <th><font color='#FFFFFF'>Justificativa</font></th>
  </tr>";
	require "conectAtleta.php";
	$sqlReg=odbc_exec($conCab,"SELECT atleta.*,
					  				  modalidade.descricao,
									  avalia.justificativa,
									  avalia.parecer,
					  				 (SELECT nome FROM prova (nolock) WHERE id=atleta.pmelhormarcaprov) as pprova,
									 (SELECT nome FROM prova (nolock) WHERE id=atleta.princprova) as prinprova,
									 (SELECT nome FROM prova (nolock) WHERE id=atleta.memarcprova) as melhorprova,
									 (SELECT patrocinio FROM patrocinio (nolock) WHERE id=atleta.patrocinio_id) as nomepat
									 FROM atleta (nolock) LEFT JOIN modalidade (nolock) ON atleta.id_modal=modalidade.id
									 LEFT JOIN avalia (nolock) ON avalia.atleta_id=atleta.id");
	$countReg=odbc_num_rows($sqlReg);
	while($objReg=odbc_fetch_object($sqlReg)){
		
		echo "<tr valign='middle'><td align='center'>".$objReg->id."</td><td>".utf8_encode($objReg->nomepat)."</td><td>".utf8_encode($objReg->nome)."</td><td align='center'>".trim(utf8_encode($objReg->classe))."</td><td>".utf8_encode($objReg->descricao)."</td><td align='center'>".trim(utf8_encode($objReg->categoria))."</td><td>R$ ".$objReg->bolsaatual."</td><td>";
		if($objReg->dtatleta<>0){
		echo "Atleta: ".$objReg->dtatleta;
		}
		if($objReg->dtheroi<>0){
			echo "<br> Herói: ".$objReg->dtheroi;
			}
 echo "</td><td>";
 if(!empty($objReg->pprova)){
	echo utf8_encode($objReg->pprova)." - ";
	 }
 if(!empty($objReg->pmelhormarcapos)){
	 echo utf8_encode($objReg->pmelhormarcapos);
	 }
 echo "</td><td>";
 if(!empty($objReg->prinprova)){
	 echo utf8_encode($objReg->prinprova);
	 }
$melhorProva='';
if(!empty($objReg->melhorprova) || $objReg->melhorprova<>0){
	$melhorProva=utf8_encode($objReg->melhorprova)." - ";
	}
 echo "</td><td>".utf8_encode($melhorProva).utf8_encode($objReg->memarcapos)."</td><td>".utf8_encode($objReg->memarcaevento)."</td><td colspan='3'>";
 //2014
 $sqlMarca2014=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2014'");
 echo "<table border='1' width='100%'>";
 $marca2014='';
 while($objMarca2014=odbc_fetch_object($sqlMarca2014)){
	if(trim($objMarca2014->tipo)=='m'){
		$marca2014=number_format($objMarca2014->marca,2,".","");
		}else{
			$marca2014=number_format($objMarca2014->marca,0,"","");
			$marcaAtletaArr2014=str_split(str_pad($marca2014, 8, "0", STR_PAD_LEFT), 2);
			$marca2014=$marcaAtletaArr2014[0].":".$marcaAtletaArr2014[1].":".$marcaAtletaArr2014[2].".".$marcaAtletaArr2014[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2014->nome)."</td><td>".utf8_encode($marca2014)."</td><td>".utf8_encode($objMarca2014->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2013
 $sqlMarca2013=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2013'");
 echo "<table border='1' width='100%'>";
 $marca2013='';
 while($objMarca2013=odbc_fetch_object($sqlMarca2013)){
	if(trim($objMarca2013->tipo)=='m'){
		$marca2013=number_format($objMarca2013->marca,2,".","");
		}else{
			$marca2013=number_format($objMarca2013->marca,0,"","");
			$marcaAtletaArr2013=str_split(str_pad($marca2013, 8, "0", STR_PAD_LEFT), 2);
			$marca2013=$marcaAtletaArr2013[0].":".$marcaAtletaArr2013[1].":".$marcaAtletaArr2013[2].".".$marcaAtletaArr2013[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2013->nome)."</td><td>".utf8_encode($marca2013)."</td><td>".utf8_encode($objMarca2013->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2012
 $sqlMarca2012=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2012'");
 echo "<table border='1' width='100%'>";
 $marca2012='';
 while($objMarca2012=odbc_fetch_object($sqlMarca2012)){
	if(trim($objMarca2012->tipo)=='m'){
		$marca2012=number_format($objMarca2012->marca,2,".","");
		}else{
			$marca2012=number_format($objMarca2012->marca,0,"","");
			$marcaAtletaArr2012=str_split(str_pad($marca2012, 8, "0", STR_PAD_LEFT), 2);
			$marca2012=$marcaAtletaArr2012[0].":".$marcaAtletaArr2012[1].":".$marcaAtletaArr2012[2].".".$marcaAtletaArr2012[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2012->nome)."</td><td>".utf8_encode($marca2012)."</td><td>".utf8_encode($objMarca2012->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2011
 $sqlMarca2011=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2011'");
 echo "<table border='1' width='100%'>";
 $marca2011='';
 while($objMarca2011=odbc_fetch_object($sqlMarca2011)){
	if(trim($objMarca2011->tipo)=='m'){
		$marca2011=number_format($objMarca2011->marca,2,".","");
		}else{
			$marca2011=number_format($objMarca2011->marca,0,"","");
			$marcaAtletaArr2011=str_split(str_pad($marca2011, 8, "0", STR_PAD_LEFT), 2);
			$marca2011=$marcaAtletaArr2011[0].":".$marcaAtletaArr2011[1].":".$marcaAtletaArr2011[2].".".$marcaAtletaArr2011[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2011->nome)."</td><td>".utf8_encode($marca2011)."</td><td>".utf8_encode($objMarca2011->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2010
 $sqlMarca2010=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2010'");
 echo "<table border='1' width='100%'>";
 $marca2010='';
 while($objMarca2010=odbc_fetch_object($sqlMarca2010)){
	if(trim($objMarca2010->tipo)=='m'){
		$marca2010=number_format($objMarca2010->marca,2,".","");
		}else{
			$marca2010=number_format($objMarca2010->marca,0,"","");
			$marcaAtletaArr2010=str_split(str_pad($marca2010, 8, "0", STR_PAD_LEFT), 2);
			$marca2010=$marcaAtletaArr2010[0].":".$marcaAtletaArr2010[1].":".$marcaAtletaArr2010[2].".".$marcaAtletaArr2010[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2010->nome)."</td><td>".utf8_encode($marca2010)."</td><td>".utf8_encode($objMarca2010->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2009
 $sqlMarca2009=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2009'");
 echo "<table border='1' width='100%'>";
 $marca2009='';
 while($objMarca2009=odbc_fetch_object($sqlMarca2009)){
	if(trim($objMarca2009->tipo)=='m'){
		$marca2009=number_format($objMarca2009->marca,2,".","");
		}else{
			$marca2009=number_format($objMarca2009->marca,0,"","");
			$marcaAtletaArr2009=str_split(str_pad($marca2009, 8, "0", STR_PAD_LEFT), 2);
			$marca2009=$marcaAtletaArr2009[0].":".$marcaAtletaArr2009[1].":".$marcaAtletaArr2009[2].".".$marcaAtletaArr2009[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2009->nome)."</td><td>".utf8_encode($marca2009)."</td><td>".utf8_encode($objMarca2009->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2008
 $sqlMarca2008=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2008'");
 echo "<table border='1' width='100%'>";
 $marca2008='';
 while($objMarca2008=odbc_fetch_object($sqlMarca2008)){
	if(trim($objMarca2008->tipo)=='m'){
		$marca2008=number_format($objMarca2008->marca,2,".","");
		}else{
			$marca2008=number_format($objMarca2008->marca,0,"","");
			$marcaAtletaArr2008=str_split(str_pad($marca2008, 8, "0", STR_PAD_LEFT), 2);
			$marca2008=$marcaAtletaArr2008[0].":".$marcaAtletaArr2008[1].":".$marcaAtletaArr2008[2].".".$marcaAtletaArr2008[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2008->nome)."</td><td>".utf8_encode($marca2008)."</td><td>".utf8_encode($objMarca2008->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2007
 $sqlMarca2007=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2007'");
 echo "<table border='1' width='100%'>";
 $marca2007='';
 while($objMarca2007=odbc_fetch_object($sqlMarca2007)){
	if(trim($objMarca2007->tipo)=='m'){
		$marca2007=number_format($objMarca2007->marca,2,".","");
		}else{
			$marca2007=number_format($objMarca2007->marca,0,"","");
			$marcaAtletaArr2007=str_split(str_pad($marca2007, 8, "0", STR_PAD_LEFT), 2);
			$marca2007=$marcaAtletaArr2007[0].":".$marcaAtletaArr2007[1].":".$marcaAtletaArr2007[2].".".$marcaAtletaArr2007[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2007->nome)."</td><td>".utf8_encode($marca2007)."</td><td>".utf8_encode($objMarca2007->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2006
 $sqlMarca2006=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2006'");
 echo "<table border='1' width='100%'>";
 $marca2006='';
 while($objMarca2006=odbc_fetch_object($sqlMarca2006)){
	if(trim($objMarca2006->tipo)=='m'){
		$marca2006=number_format($objMarca2006->marca,2,".","");
		}else{
			$marca2006=number_format($objMarca2006->marca,0,"","");
			$marcaAtletaArr2006=str_split(str_pad($marca2006, 8, "0", STR_PAD_LEFT), 2);
			$marca2006=$marcaAtletaArr2006[0].":".$marcaAtletaArr2006[1].":".$marcaAtletaArr2006[2].".".$marcaAtletaArr2006[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2006->nome)."</td><td>".utf8_encode($marca2006)."</td><td>".utf8_encode($objMarca2006->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='3'>";
 //2005
 $sqlMarca2005=odbc_exec($conCab,"SELECT marcas.ano,marcas.posicao,marcas.marca,marcas.tipo,prova.nome FROM marcas (nolock) LEFT JOIN prova ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$objReg->id."' AND marcas.ano='2005'");
 echo "<table border='1' width='100%'>";
 $marca2005='';
 while($objMarca2005=odbc_fetch_object($sqlMarca2005)){
	if(trim($objMarca2005->tipo)=='m'){
		$marca2005=number_format($objMarca2005->marca,2,".","");
		}else{
			$marca2005=number_format($objMarca2005->marca,0,"","");
			$marcaAtletaArr2005=str_split(str_pad($marca2005, 8, "0", STR_PAD_LEFT), 2);
			$marca2005=$marcaAtletaArr2005[0].":".$marcaAtletaArr2005[1].":".$marcaAtletaArr2005[2].".".$marcaAtletaArr2005[3];
			}
	 echo "<tr><td>".utf8_encode($objMarca2005->nome)."</td><td>".utf8_encode($marca2005)."</td><td>".utf8_encode($objMarca2005->posicao)."</td></tr>";
	 }
echo "</table>";
 echo "</td><td colspan='2'>";
 $sqlProjetos=odbc_exec($conCab,"SELECT * FROM projetos WHERE atleta_id='".$objReg->id."'");
 echo "<table border='1' width='100%'>";
 while($objProjetos=odbc_fetch_object($sqlProjetos)){
	 echo "<tr><td>".utf8_encode($objProjetos->descproje)."</td><td>R$ ".utf8_encode($objProjetos->valor)."</td></tr>";
	 }
 echo "</table>";
 echo "</td><td>".utf8_encode($objReg->parecer)."</td><td>".nl2br(utf8_encode($objReg->justificativa))."</td></tr>";
			
		}
    echo "</table>";
?>
</body>
</html>