<?php 
session_start();
//Recebe a conexão com o banco
require "../../conectsqlserverci.php";
//recebe a variável mandada por POST da tela anterior e utiliza o trim para excluir espaços em branco que podem ser digitados.
$solicitacao=trim($_POST['ci']);
$autorizacao=$_POST['id'];
$txprojeto=$_POST['txprojeto'];
$datainicial=$_POST['datainicial'];
$datafinal=$_POST['datafinal'];
$evento=$_POST['evento'];

//Faço a consulta no banco para identificar os dados que preciso da passagem
//Escolhi alguns campos que julguei necessário. Mas pode-se escolher outros ou retirar.
$consultaPassageiro="Select
GEEMPRES.Nome_completo,
  TEITEMSOLHOTEL.cd_empresa,
  TEITEMSOLHOTEL.dt_entrada,
  TEITEMSOLHOTEL.dt_saida,
  TEITEMSOLHOTEL.cargo,
  TEITEMSOLHOTEL.reserva,
  GEPFISIC.cargo AS cargo2
From
  COSOLICI With(NoLock) Inner Join
 TEITEMSOLHOTEL With(NoLock) On COSOLICI.Solicitacao =
    TEITEMSOLHOTEL.cd_solicitacao Inner Join
  GEEMPRES On TEITEMSOLHOTEL.cd_empresa = GEEMPRES.Cd_empresa
  left join GEPFISIC with (nolock) on
	GEPFISIC.Cd_empresa = TEITEMSOLHOTEL.cd_empresa
Where COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaPas=odbc_exec($conCab, $consultaPassageiro) or die("<p>".odbc_errormsg()); 
//Conto para identificar se existe passagem nessa CI
$countConsultaPas=odbc_num_rows($resconsultaPas);

//Caso não exista eu finalizo e volto para a página anterior
 if($countConsultaPas==0){
?>
       <script type="text/javascript">
       alert("Nao foi encontrado nenhuma hospedagem nessa Solicitacao.");
       window.location="../index.php";
       </script>
<?php

}
//Senão eu continuo o script
else{

//Nesse Select pode-se declarar mais informações da CI caso julgue necessário.
//Quando precisar chamar, chame-os no campo array declaro abaixo. Serve para escrever o título da tabela por exemplo.

$consultaCi="Select
  COSOLICI.Desc_cond_pag
From
  COSOLICI (nolock) 
  WHERE COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaCi=odbc_exec($conCab, $consultaCi) or die("<p>".odbc_errormsg()); 
$arrayConsultaCi=odbc_fetch_array($resconsultaCi);

//Faço a conexão com o banco MySQL, para pegar as companhias aéras e descontos
require "../../conexaomysql.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#txprojeto").autocomplete("../suggest_projeto.php", {
		  width: 360,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<style>
    .sel { width: 70px; }
    
</style>

</head>
    
<body>
<div id='box3' style="height:auto">
    
    <?php
       $selectAutorizacao=mysql_query("select * from registroshos where solicitacao='$solicitacao'");
       $arrayAut=mysql_fetch_array($selectAutorizacao);
       $arrayAut['autorizacao'];
       
       if(!empty($arrayAut['autorizacao'])){
            $autorizacaoId=$arrayAut['autorizacao']; 
			$autorizacaoId="Nº: <font color='blue'>".$autorizacaoId."</font>";
        } else {
            $autorizacaoId='';
        }
		echo  "
    <div id='content' style=\"width:100%\"><h3>AUTORIZAÇÃO DE FATURAMENTO DE HOSPEDAGEM ".$autorizacaoId."</h3>";
		echo "<form action='salvaHospedagem.php?id=$autorizacaoId' method='post' target='_blank'>";
    ?>    
        
      
    
    <?php
    
    
     $selectProj=mysql_query("select solicitacao, projeto from registroshos where solicitacao= '".$solicitacao."'") or die(mysql_error());
     $arrayProj=mysql_fetch_array($selectProj);
    
    echo "   
       <hr/>
            
            <br/>
			<div id='notable' style='width:96%'><table>
            <tr><td>
			<strong>Processo: </strong></td>";
          echo "<td><input type='hidden' class='input' size='90' name='txprojeto' id='txprojeto' value='".trim($txprojeto)."'/>".trim($txprojeto)."</td> ";	  
	      
    ?></tr><br/>
    
            <tr>
            
                <td><strong>Período: </strong></td><td><?php 
			echo $datainicial; ?><input class="input" type="hidden" name="datainicial" id="datainicial"  readonly="readonly" value="<?php 
			echo $datainicial; ?>" maxlength='10' size='10'  /> 
                            a 
                                    <?php echo $datafinal; ?><input class="input" type="hidden" name="datafinal" id="datafinal"  value="<?php echo $datafinal; ?>"  maxlength='10' size='10' readonly='readonly'/></td>
            </tr><tr>
                <td><strong>Complemento: </strong></td><td><?php 
			echo $evento; ?><input class="input" type="hidden" size="90" maxlength="145" name="evento" value="<?php echo $arrayPeriodo['evento']; ?>"/></td>
            </tr>
    </table></div>
    <br><hr/>
    <br>
  
<div id="tabela" style="width:96%">

    <table width="100%">
    <tr><th colspan="8" align="center"><h2>LISTAGEM DE HOSPEDAGENS</h2></th></tr>

    <tr>
        <th align="left"><strong><u>CI Nº</u>: <?php echo $solicitacao; ?></strong></th><th colspan="7" align="right"><strong><u>DESCRI&Ccedil;&Atilde;O DA CI</u>: </strong><?php echo mb_convert_encoding($arrayConsultaCi['Desc_cond_pag'],"UTF-8","ISO-8859-1"); ?></th>
    </tr>
    <tr>
        <th width="25%">Nome</th><th width="20%">Cargo</th><th width="7%">Apto.</th><th width="11%">Entrada</th><th width="11%">Saída</th><th width="5%">Qtd. Diárias</th><th width="7%">VLR/Dia</th><th width="7%">Total</th></tr>
  <?php 
  $cont=0;
 	  $VrJs=0;
	  echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlDia".$i."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type=\"text/javascript\">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = \"0\";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = \"0\" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(\".\",\"\");

   moeda = moeda.replace(\",\",\".\");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos".$i."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
a=(moeda2float(document.getElementById('vlDia".$i."').value)*document.getElementById('qtdDias".$i."').value);
document.getElementById('totalLinha".$i."').innerHTML=float2moeda(a);
document.getElementById('vlTotH".$i."').value=float2moeda(a);
	}
}
req.send(null);
}
</script>";
$vlTotal=0;
while($objPassagens=odbc_fetch_object($resconsultaPas)){
$cont++;
$cargoTemp='';
if(!empty($objPassagens->cargo)){
	$cargoTemp=mb_convert_encoding($objPassagens->cargo,"UTF-8","ISO-8859-1");
	}else{
		$cargoTemp=mb_convert_encoding($objPassagens->cargo2,"UTF-8","ISO-8859-1");
		}
		$qtdDias="qtdDias".$cont;
		$vlDia="vlDia".$cont;
		$vlTotH="vlTotH".$cont;
		echo $vlTotH;
		$vlTotal+=$_POST[$vlTotH];
echo "<tr><td>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</td><td>".$cargoTemp."</td><td>".mb_convert_encoding($objPassagens->reserva,"UTF-8","ISO-8859-1")."</td><td>".date('d/m/y', strtotime($objPassagens->dt_entrada))."</td><td>".date('d/m/y', strtotime($objPassagens->dt_saida))."</td><td><input type='hidden' name='qtdDias".$cont."' id='qtdDias".$cont."' class='input' size='1' value='".$_POST[$qtdDias]."'/>".$_POST[$qtdDias]."</td><td>R$ <input type='hidden' name='vlDia".$cont."' id='vlDia".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" value='".$_POST[$vlDia]."'/></td><td>R$ <input type='hidden' name='vlTotH".$cont."' id='vlTotH".$cont."' size='5' value='".$_POST[$vlTotH]."'/>".$_POST[$vlTotH]."</td></tr>";
}

echo "<tr><td colspan='3' rowspan='9'></td><td colspan='2'><strong>Total diárias</strong></td><td>-</td><td colspan='2'>R$ ".$vlTotal."</div></td><tr>
      <tr><td colspan='2'><strong>Total taxa de serviço</strong></td><td><input type='text' name='totTxServ' id='totTxServ' class='input' size='1' value=''/></td><td colspan='2'>R$</td><tr>
	  <tr><td colspan='2'><strong>Total taxa de ISS</strong></td><td><input type='text' name='totTxIss' id='totTxIss' class='input' size='1' value=''/></td><td colspan='2'>R$</td><tr>
	  <tr><td colspan='2'><strong>Total contratual</strong></td><td><input type='text' name='totTxCont' id='totTxCont' class='input' size='1' value=''/></td><td colspan='2'>R$</td><tr>
	  <tr><th colspan='2'><strong>Total com taxas</strong></th><th></th><th colspan='2'>R$</th><tr>";
     ?>
	 </table>
     <a href='../index.php'><input type='button' class='button' value='<<VOLTAR'></a><div align='right'><input type='hidden' name='contador' id='contador' class='input' size='8' value='".$cont."'/><input type='hidden' name='ci' id='ci' class='input' size='8' value='".$solicitacao."'/><input type='submit' align= 'center' class='buttonVerde' value='SALVAR'></div>
</form>
<br/><br/>
</div></div></div>

</body>
</html>
<?php 
}
?>