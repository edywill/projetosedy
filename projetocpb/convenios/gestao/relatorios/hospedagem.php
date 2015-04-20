<?php
$sqlHosEvento=mysql_query("SELECT * FROM convhos WHERE convhos.idevento='".$idEvento."'") or die(mysql_error());
$countHosEvento=mysql_num_rows($sqlHosEvento);
if($countHosEvento>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>HOSPEDAGEM</font></h3></td></tr>
<tr>
    <th width='48%' nowrap='nowrap' colspan='7' valign='bottom'><p align='center'>PROJETADO</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6' valign='bottom'><p align='center'>REALIZADO</p></th>
  </tr>
  <tr>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>TIPO</strong></p></th>
    <th width='20%' colspan='2' nowrap='nowrap'><p align='center'><strong>LOCAL</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>QUANTIDADE</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>DI&Aacute;RIA</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='20%' colspan='2' nowrap='nowrap'><p align='center'><strong>LOCAL</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>QUANTIDADE</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>DI&Aacute;RIA</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
  </tr>
  ";
  $qtdHosNac=0;
  $vltotHosNac=0;
  $qtdHosInt=0;
  $vltotHosInt=0;
  $nacionalHosp="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>NACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>NACIONAL</strong></p></th>
  </tr>";
  $interNacionalHosp="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>INTERNACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>INTERNACIONAL</strong></p></th>
  </tr>";
  while($objHosEv=mysql_fetch_object($sqlHosEvento)){
  $sqlReferencia='';
  $qtdQuat=0;
  if($objHosEv->qtdsingle>0){
	  $sqlReferencia=mysql_fetch_array(mysql_query("select * from convhosreferencia where id='".$objHosEv->refs."'"));
	  $tipo='Single';
	  $qtdQuat=$objHosEv->qtdsingle;
	  }elseif($objHosEv->qtdduplo>0){
		  $sqlReferencia=mysql_fetch_array(mysql_query("select * from convhosreferencia where id='".$objHosEv->refs."'"));
		  $tipo='Duplo';
		  $qtdQuat=$objHosEv->qtdduplo;
		  }
		if($sqlReferencia['abrg']=='nac'){
  $nacionalHosp.="<tr><td nowrap='nowrap'><p align='center'><font size='-2'>".utf8_encode($tipo)."</font></p></td>
    <td nowrap='nowrap' colspan='2'><p align='center'><font size='-1'>".utf8_encode($sqlReferencia['local'])."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$qtdQuat."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objHosEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$sqlReferencia['valor']."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objHosEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdHosNac=$qtdHosNac+$qtdQuat;
  $vltotHosNac=$vltotHosNac+(float)$objHosEv->total;
		}elseif($sqlReferencia['abrg']=='int'){
			$interNacionalHosp.="<tr>
    <td nowrap='nowrap'><p align='center'><font size='-2'>".utf8_encode($tipo)."</font></p></td>
	<td nowrap='nowrap' colspan='2'><p align='center'><font size='-1'>".utf8_encode($sqlReferencia['local'])."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$qtdQuat."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objHosEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$sqlReferencia['valor']."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objHosEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdHosInt=$qtdHosInt+$qtdQuat;
  $vltotHosInt=$vltotHosInt+(float)$objHosEv->total;
			}
  }
	$nacionalHosp.="<tr>
    <th colspan='3' nowrap='nowrap' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdHosNac."</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'><p align='right'><strong>R$ ".number_format($vltotHosNac,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
    $interNacionalHosp.="<tr>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdHosInt."</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'><p align='right'><strong>R$ ".number_format($vltotHosInt,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  $totalQtdGeralHos=$qtdHosInt+$qtdHosNac;
  $totalGeralValorHos=$vltotHosInt+$vltotHosNac;
  if($totalQtdGeralHos>0){
	  if($qtdHosNac>0){
		  echo $nacionalHosp;
		  }
	   if($qtdHosInt>0){
		   echo $interNacionalHosp;
		   }
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>TOTAL GERAL HOSPEDAGEM</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralHos."</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorHos,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>TOTAL GERAL HOSPEDAGEM</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='7' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
     <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>DIFEREN&Ccedil;A</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
 }
?>