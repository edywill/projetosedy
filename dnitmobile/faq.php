<?php 
require("valida.php");
$idProt=$_GET['id'];
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

<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 0, "desc" ]],
		"pagingType": "full_numbers"
    } );
} );

	</script>
    <script>
	
	<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type="text/javascript">

var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarMensagem(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consultaMensagem.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

window.opener.document.atocorrencia.mensagem.value = resposta;
window.opener.document.atocorrencia.mensagem.focus();
window.self.close();
}
}
req.send(null);
}
</script>
</head>
<body>
<table id="example" width="100%" cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
  <thead>
  <tr>
    <td colspan="
    <?php
	if($idProt<>0){
		echo "6";
		}else{
			
			echo "5";
		}
	 ?>
    " align="right"><font size="+3" color="#000066"><strong>RESPOSTAS ENVIADAS</strong></font></tr>
			<tr bgcolor="#FFFFFF">
					<th width='5%' height="21">Protocolo</th>
                    <th width='10%'>Usuário</th>
					<th width='20%'>Rod./ KM (UF)</th>
					<th width='15%'>Analista</th>
					<th width='40%'>Mensagem</th>
                    <?php 
					if($idProt<>0){
					?>
					<th width='10%'>COPIAR RESPOSTA</th>
                    <?php 
					}
					?>
           
				</tr>				
			</thead>
            <?php 
			require ("conexaobd/conectbd.php");
			$sql = "SELECT protocolo.id,
						   login.nome,
						   device.name,
						   acompanhamento.id AS idacomp,
						   acompanhamento.mensagem,
						   acompanhamento.dt_criacao 
			        FROM protocolo 
				    LEFT JOIN device ON
					          protocolo.device_id=device.id
					LEFT JOIN acompanhamento ON
					          acompanhamento.protocolo_id=protocolo.id
					LEFT JOIN login ON 
					           acompanhamento.analista_id=login.id_login
							   ORDER BY protocolo.id DESC";
			$query = odbc_exec($conCab,$sql);
			echo "<tbody>";
			while ($resultado = odbc_fetch_object($query)){
				if($idProt==0){
			$copiar='';
			}else{
			$copiar="<td align='center'><a href=javascript:buscarMensagem('".$resultado->idacomp."');><input type='submit' name='edit' value='COPIAR' style='background-color:#9F9'/></a></td>";
				}
					if(!empty($resultado->mensagem)){
						$rodUfKm='';
					$sqlDadosUfBr=odbc_exec($conCab,"SELECT report.estrada_br,report.br_km,estado.sigla FROM report LEFT JOIN estado ON report.estado_id=estado.id WHERE protocolo='".$resultado->id."'");	
					while($objDadosUfBr=odbc_fetch_object($sqlDadosUfBr)){
						if(!empty($objDadosUfBr->sigla) || !empty($objDadosUfBr->br_km) || !empty($objDadosUfBr->estrada_br)){
						$rodUfKm.=$objDadosUfBr->estrada_br."/".$objDadosUfBr->br_km."(".$objDadosUfBr->sigla.")<br>";
						   }
						}
						if(empty($rodUfKm)){
							$rodUfKm='N/D';
							}	
            	echo "<tr><td><font size='-2'>".strtoupper($resultado->id)."</font></td><td><font size='-1'>".utf8_encode($resultado->name)."</font></td><td><font size='-1'>".$rodUfKm."</font></td><td><font size='-1'>".utf8_encode($resultado->nome)."</font></td><td><font size='-1'><strong>".$resultado->dt_criacao."</strong><br>".utf8_encode($resultado->mensagem)."</font></td>".$copiar."</tr>";
				}
			}
			?>
            </table>
</body>
</html>