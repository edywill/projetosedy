<?php
$sqlMat=mysql_query("SELECT * FROM convmat WHERE convmat.modal='".$_SESSION['modalRef']."'") or die(mysql_error());
$countMat=mysql_num_rows($sqlMat);
if($countMat>0){

echo "<tr bgcolor='#999999'><td colspan='12'><h3 align='center'><font color='white'>MATERIAL</font></h3></td></tr>
<tr>
    <th width='48%' nowrap='nowrap' colspan='6' valign='bottom'><p align='center'>PROJETADO</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='5' valign='bottom'><p align='center'>REALIZADO</p></th>
  </tr>
  <tr>
    <th width='30%' colspan='2' nowrap='nowrap'><p align='center'><strong>DESCRI&Ccedil;&Atilde;O</strong></p></th>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>TIPO</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>VALOR UN.(R$)</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>QTD</strong></p></th>
    <th width='14%' nowrap='nowrap'><p align='center' ><strong>VALOR TOTAL (R$)</strong></p></th>
	    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>DESCRI&Ccedil;&Atilde;O</strong></p></th>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>TIPO</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>VALOR UN.(R$)</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>QTD</strong></p></th>
    <th width='14%' nowrap='nowrap'><p align='center' ><strong>VALOR TOTAL (R$)</strong></p></th>
  </tr>
  ";
  $nacionalMat="";
  $qtdMat=0;
  $vltotMat=0;
  while($objMat=mysql_fetch_object($sqlMat)){
   $nacionalMat.="<tr>
    <td nowrap='nowrap' colspan='2'><p align='center'><font size='-2'>".utf8_encode($objMat->descricao)."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".strtoupper($objMat->tipo)."</p></td>
    <td nowrap='nowrap'><p align='center'>R$ ".$objMat->vlunitreal."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objMat->qtd."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objMat->totalreal."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'></p></td>
	<td nowrap='nowrap'><p align='center'></p></td>
  </tr>";
  $qtdMat=$qtdMat+$objMat->qtd;
  $vltotMat=$vltotMat+(float)$objMat->totalreal;
  }
  
  $totalQtdGeralMat=$qtdMat;
  $totalGeralValorMat=$vltotMat;
  if($totalQtdGeralMat>0){
	   echo $nacionalMat;
  echo "
  <tr><td colspan='12' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p><strong>TOTAL GERAL MATERIAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralMat."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorMat,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p align='center'><strong>TOTAL GERAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='6' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p align='center'><strong>DIFEREN&Ccedil;A</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
}
?>