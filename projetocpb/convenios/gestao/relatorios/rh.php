<?php
$sqlRhEvento=mysql_query("SELECT * FROM convrh LEFT JOIN convrhreferencia ON convrh.nome=convrhreferencia.id WHERE convrh.idevento='".$idEvento."'") or die(mysql_error());
$countRhEvento=mysql_num_rows($sqlRhEvento);
if($countRhEvento>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>RECURSOS HUMANOS</font></h3></td></tr>
<tr>
    <th width='48%' nowrap='nowrap' colspan='7' valign='bottom'><p align='center'>PROJETADO</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6' valign='bottom'><p align='center'>REALIZADO</p></th>
  </tr>
  <tr>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>FUN&Ccedil;&Atilde;O</strong></p></th>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>VALOR</strong></p></th>
    <td width='23%' nowrap='nowrap' bgcolor='yellow'><p align='center'><strong>BOLSA (S/PATRO)</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PATRONAL</strong></p></th>
    <td width='14%' nowrap='nowrap' bgcolor='yellow'><p align='center' ><strong>ENCARGOS</strong></p></th>
	<th width='14%'><p align='center'><strong>QTS</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>VALOR</strong></p></th>
    <td width='23%' nowrap='nowrap' bgcolor='yellow'><p align='center'><strong>BOLSA (S/PATRO)</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PATRONAL</strong></p></th>
    <td width='14%' nowrap='nowrap' bgcolor='yellow'><p align='center' ><strong>ENCARGOS</strong></p></th>
	<th width='14%'><p align='center'><strong>QTS</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
  </tr>
  ";
  $qtdRhNac=0;
  $vltotRhNac=0;
  $nacionalRh="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>NACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>NACIONAL</strong></p></th>
  </tr>";
  while($objRhEv=mysql_fetch_object($sqlRhEvento)){
	  $bolsaSt=(float)$objRhEv->salario*$objRhEv->qtdtem;
	  $totTributos=(float)$objRhEv->tributos*$objRhEv->qtdtem;
	  $totalLinhaRh=($bolsaSt+$totTributos)*$objRhEv->qtdpes;
   $nacionalRh.="<tr>
    <td nowrap='nowrap'><p align='center'><font size='-2'>".utf8_encode($objRhEv->funcao)."</font></p></td>
    <td nowrap='nowrap'><p align='center'><font size='-1'>R$ ".$objRhEv->salario."</font></p></td>
    <td nowrap='nowrap' bgcolor='yellow'><p align='center'>R$ ".number_format($bolsaSt,2,",",".")."</p></td>
    <td nowrap='nowrap'><p align='center'>R$ ".$objRhEv->tributos."</p></td>
    <td nowrap='nowrap' bgcolor='yellow'><p align='right'>R$ ".number_format($totTributos,2,",",".")."</p></td>
    <td nowrap='nowrap'><p align='right'>".$objRhEv->qtdpes."</p></td>
	<td nowrap='nowrap'><p align='right'>R$ ".number_format($totalLinhaRh,2,",",".")."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'  bgcolor='yellow'><p align='center'>&nbsp;</p></td>
	<td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'  bgcolor='yellow'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdRhNac=$qtdRhNac+$objRhEv->qtdpes;
  $vltotRhNac=$vltotRhNac+$totalLinhaRh;
  }
  
  $totalQtdGeralRh=$qtdRhNac;
  $totalGeralValorRh=$vltotRhNac;
  if($totalQtdGeralRh>0){
	   echo $nacionalRh;
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='5' valign='bottom'><p><strong>TOTAL GERAL RH</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralRh."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorRh,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p align='center'><strong>TOTAL GERAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='7' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p align='center'><strong>DIFEREN&Ccedil;A</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
  }
?>