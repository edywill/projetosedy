<?php
 $sqlSgvEvento=mysql_query("SELECT * FROM convsgv LEFT JOIN convsgvreferencia ON convsgv.idref=convsgvreferencia.id WHERE convsgv.idevento='".$idEvento."'") or die(mysql_error());
 $countSgvEvento=mysql_num_rows($sqlSgvEvento);
 if($countSgvEvento>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>SEGURO VIAGEM</font></h3></td></tr>
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
    <th width='14%'><p align='center'><strong>PER&Iacute;ODO</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='20%' colspan='2' nowrap='nowrap'><p align='center'><strong>LOCAL</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>QUANTIDADE</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>PER&Iacute;ODO</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
  </tr>
  ";
  $qtdSgvInt=0;
  $vltotSgvInt=0;
  $interNacionalSgv="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>INTERNACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>INTERNACIONAL</strong></p></th>
  </tr>";
  while($objSgvEv=mysql_fetch_object($sqlSgvEvento)){
  $tipo="Seguro Viagem";
  	$interNacionalTra.="<tr>
    <td nowrap='nowrap'><p align='center'>".$tipo."</p></td>
	<td nowrap='nowrap' colspan='2'><p align='center'>".utf8_encode($objSgvEv->local)."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objSgvEv->qtdseg."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objSgvEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>".$objSgvEv->qtddias."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objSgvEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap' colspan='2'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdSgvInt=$qtdSgvInt+$objSgvEv->qtdseg;
  $vltotSgvInt=$vltotSgvInt+(float)$objSgvEv->total;
  }
	$interNacionalSgv.="<tr>
    <th nowrap='nowrap'  colspan='3' valign='bottom'><p><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdSgvInt."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'  colspan='2'><p align='right'><strong>R$ ".number_format($vltotSgvInt,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  $totalQtdGeralSgv=$qtdSgvInt;
  $totalGeralValorSgv=$vltotSgvInt;
  if($totalQtdGeralSgv>0){
	     echo $interNacionalSgv;
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>TOTAL GERAL SEGURO VIAGEM</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralSgv."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' colspan='2' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorSgv,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL GERAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='7' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>DIFEREN&Ccedil;A</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
 }
?>