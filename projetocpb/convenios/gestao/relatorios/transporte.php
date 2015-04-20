<?php
 $sqlTraEvento=mysql_query("SELECT * FROM convtra LEFT JOIN convtrareferencia ON convtra.idref=convtrareferencia.id WHERE convtra.idevento='".$idEvento."'") or die(mysql_error());
$countTraEvento=mysql_num_rows($sqlTraEvento);
if($countTraEvento>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>TRANSPORTE</font></h3></td></tr>
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
  $qtdTraNac=0;
  $vltotTraNac=0;
  $qtdTraInt=0;
  $vltotTraInt=0;
  $nacionalTra="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>NACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>NACIONAL</strong></p></th>
  </tr>";
  $interNacionalTra="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>INTERNACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>INTERNACIONAL</strong></p></th>
  </tr>";
  while($objTraEv=mysql_fetch_object($sqlTraEvento)){
  $tipo=strtoupper($objTraEv->tipo);
  $vlDiaTra=0;
	  if($objTraEv->abrg=='nac'){
  $nacionalTra.="<tr>
    <td nowrap='nowrap'><p align='center'>".utf8_encode($tipo)."</p></td>
    <td nowrap='nowrap' colspan='2'><p align='center'><font size='-1'>".utf8_encode($objTraEv->local)."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$objTraEv->qtdveic."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objTraEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objTraEv->valor."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objTraEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap' colspan='2'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdTraNac=$qtdTraNac+$objTraEv->qtdveic;
  $vltotTraNac=$vltotTraNac+(float)$objTraEv->total;
		}elseif($objTraEv->abrg=='int'){
			$interNacionalTra.="<tr>
    <td nowrap='nowrap'><p align='center'>".$tipo."</p></td>
	<td nowrap='nowrap' colspan='2'><p align='center'>".utf8_encode($objTraEv->local)."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objTraEv->qtdveic."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objTraEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objTraEv->valor."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objTraEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap' colspan='2'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdTraInt=$qtdTraInt+$objTraEv->qtdveic;
  $vltotTraInt=$vltotTraInt+(float)$objTraEv->total;
			}
  }
	$nacionalTra.="<tr>
    <th colspan='3' nowrap='nowrap' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdTraNac."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' colspan='2'><p align='right'><strong>R$ ".number_format($vltotTraNac,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
    $interNacionalTra.="<tr>
    <th nowrap='nowrap'  colspan='3' valign='bottom'><p><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdTraInt."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'  colspan='2'><p align='right'><strong>R$ ".number_format($vltotTraInt,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  $totalQtdGeralTra=$qtdTraInt+$qtdTraNac;
  $totalGeralValorTra=$vltotTraInt+$vltotTraNac;
  if($totalQtdGeralTra>0){
	  if($qtdTraNac>0){
		  echo $nacionalTra;
		  }
	   if($qtdTraInt>0){
		   echo $interNacionalTra;
		   }
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>TOTAL GERAL TRANSPORTE</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralTra."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' colspan='2' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorTra,2,",",".")."</strong></p></td>
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