<?php 
require("valida.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" type="text/css" href="datatables/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="datatables/dataTables.jqueryui.css">
<link rel="stylesheet" href="colorbox.css" />
<script type="text/javascript" language="javascript" src="datatables/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/dataTables.jqueryui.js"></script>
<script src="jscolorb.js"></script>
<script>
			$(document).ready(function(){
				$(".iframe").colorbox({iframe:true, width:700, height:550});
				
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 3, "desc" ]],
		"pagingType": "full_numbers"
    } );
} );

	</script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td></td>
<td colspan="2" width="1024px" align="center"></td><td></td>
</tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><img src="imagens/topo_brasil.png" center top/></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center"><a href="principal.php" style="border:hidden"><img src="imagens/topo_dnit.png" center top/></a></td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" valign="middle" align="center" style="background:url(imagens/topoceu.png) no-repeat center top">
<table border="0" cellpadding="0" cellspacing="0" width="1105px"><tr><td width="3%"></td>
<td height='130' colspan="2" align="left">
<h3><font color="#000066" style="padding-left:5em">Bem vindo 
<?php 
echo strtoupper($_SESSION['usuario']);
?></font></h3>
</td><td width="30%"></td></tr>
</table>
</td><td></td></tr>
<tr><td></td><td colspan="2" width="1024px" align="center" style="">

<table border="0" cellpadding="0" cellspacing="0" width="1104px" height="500">
<tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">

<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top">
    <td height="34" valign="bottom">
    <a href="principal.php" style="border:hidden"> <img src="imagens/butpainel.png" /></a></td>
    <td valign="bottom"><a href="usuarios.php" style="border:hidden"> <img src="imagens/butusuarios.png" /></a></td>
    <td valign="bottom"><a href="ouvidoria.php" style="border:hidden"> <img src="imagens/butouv.png" /></a></td>
    <td valign="bottom"><a href="relatorios.php" style="border:hidden"> <img src="imagens/butrel.png" /></a></td>
    <td valign="bottom"><a href="logout.php" style="border:hidden"> <img src="imagens/butsair.png" /></a></td>
  </tr>
</table>

</td></tr>
<td colspan="3" align="center" style="background:url(imagens/linhaceu.png) repeat-y">
<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top" align="center">
    <td height="34" valign="top" align="center">
<table id="example" width="100%" cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
  <thead>
  <tr>
    <td colspan="9" align="right"><font size="+3" color="#000066"><strong>OUVIDORIA</strong></font></tr>
			<tr bgcolor="#FFFFFF">
					<th width='8%' height="21">Rodovia/UF/KM</th>
					<th width='20%'>Tipo Ocorrência</th>
					<th width='15%'>Usuário</th>
					<th width='13%'>Data</th>
                    <th width='5%'>Foto</th>
                    <th width='5%'>Mapa</th>
                    <th width='12%'>Cód. Celular</th>
                    <th width='20%'>Mens. Ouvidoria</th>
				</tr>				
			</thead>
            <?php 
			require ("conexaobd/conectbd.php");
			$sql = "SELECT nome,
			        tipo_aviso2.tipo AS tipo_aviso2_resumo, 
					tipo_aviso1.tipo AS tipo_aviso1_resumo, 
					info.*,
					info.id AS idinfo,
					tipo_aviso3.tipo AS tipo_aviso3_resumo,
        			tipo_aviso4.tipo AS tipo_aviso4_resumo, 
					tipo_aviso5.tipo AS tipo_aviso5_resumo
        FROM (((((info LEFT JOIN email ON
        info.cod = email.cod) LEFT JOIN tipo_aviso1 ON
        info.a1 = tipo_aviso1.id_tipo1) LEFT JOIN tipo_aviso2 ON
        info.a2 = tipo_aviso2.id_tipo2) LEFT JOIN tipo_aviso3 ON
        info.a3 = tipo_aviso3.id_tipo3) LEFT JOIN tipo_aviso4 ON
        info.a5 = tipo_aviso4.id_tipo4) LEFT JOIN tipo_aviso5 ON
        info.a6 = tipo_aviso5.id_tipo5";
   			$query = odbc_exec($conCab,$sql);
			echo "<tbody>";
			while ($resultado = odbc_fetch_object($query)){
				$tipoOc='';
				$foto='';
			    if(!empty($resultado->tipo_aviso1_resumo)){
					$tipoOc.=$resultado->tipo_aviso1_resumo."<br>";
					}
				 if(!empty($resultado->tipo_aviso2_resumo)){
					$tipoOc.=$resultado->tipo_aviso2_resumo."<br>";
					}
				 if(!empty($resultado->tipo_aviso3_resumo)){
					$tipoOc.=$resultado->tipo_aviso3_resumo."<br>";
					}
				 if(!empty($resultado->tipo_aviso4_resumo)){
					$tipoOc.=$resultado->tipo_aviso4_resumo."<br>";
					}
				 if(!empty($resultado->tipo_aviso5_resumo)){
					$tipoOc.=$resultado->tipo_aviso5_resumo;
					}
					if(!empty($tipoOc)){
						if(!empty($resultado->foto)){
							$foto="<a class='iframe' href='foto.php?id=".$resultado->idinfo."'><img src='imagens/cam.png' width='25px' height='25px'/></a>";
							}
						$nome=$resultado->nome;
	$lat = trim($resultado->lat);
	$long = trim($resultado->long);
	$local = 'https://www.google.com.br/maps/place/'.$lat.','.$long;			
            	echo "<tr><td><font size='-1'>".strtoupper($resultado->rod)."/".strtoupper($resultado->uf)." - ".number_format($resultado->km,2,",",".")."</font></td><td><font size='-1'>".trim($tipoOc)."</font></td><td><font size='-1'>".mb_strtoupper($nome, 'UTF-8')."</font></td><td><font size='-1'>".date("d/m/y - H:i",strtotime($resultado->dt))."</font></td><td align='center'>".$foto."</td><td><a href='".$local."' target='_blank'>Local</a></td><td><font size='-2'>".strtoupper($resultado->cod)."</font></td><td><font size='-2'>".strtoupper($resultado->av)."</font></td></tr>";
				}
			}
			?>
            </table>
            </td></tr></table>
</td></tr>
<tr>
<td colspan="3" align="left" height="150px" style="background:url(imagens/rodapecentro.png) no-repeat">
</td></tr>
</table>
</td><td></td></tr>

</table>
<?php 
?>
</body>
</html>