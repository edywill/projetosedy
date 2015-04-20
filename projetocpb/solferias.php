<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>

<script language="javascript">

	function getValue(e){
		for(var i=0; i < document.getElementById('radio').childNodes.length; i++)					
			if(document.getElementById('radio').childNodes[i].nodeName == 'INPUT')
				if(document.getElementById('radio').childNodes[i].type == 'radio')
					if(document.getElementById('radio').childNodes[i].checked == true)
						alert(document.getElementById('radio').childNodes[i].value);
	}

	window.onload = function(){
		document.getElementById('enviar').onclick		= getValue;
	}

</script>

<!-- insira o seguinte código de javascript em sua página. -->

<script language='Javascript'>

// construindo o calendário
function popdate(obj,div,tam,ddd)
{
    if (ddd) 
    {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "/") 
            {
                c++; 
                s++; 
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }
        ddd = mmonth + "/" + day + "/" + ano
    }
  
    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}
  
    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)
  
    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)

    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}
    txt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>X</b></a></td></tr></table></td></tr>"
    txt += "<tr><td colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    txt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    txt += "<tr bgcolor='#330099'><td width='14%' class='dia' align=center><b>Dom</b></td><td width='14%' class='dia' align=center><b>Seg</b></td><td width='14%' class='dia' align=center><b>Ter</b></td><td width='14%' class='dia' align=center><b>Qua</b></td><td width='14%' class='dia' align=center><b>Qui</b></td><td width='14%' class='dia' align=center><b>Sex<b></td><td width='14%' class='dia' align=center><b>Sab</b></td></tr>"
    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;

    for (n=1;n<= 42;n++) 
    {
        if (week == 1)  txt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start) 
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" )
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  d + "/" + (mmonth+1).toString() + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            d ++ 
        } 
        else 
        { 
            txt += "<td class='data' align=center> </td>"
        }
        week ++
        if (week == 8) 
        { 
            week = 1; txt += "</tr>"} 
        }
        txt += "</table>"
        div2 = eval (div)
        div2.innerHTML = txt 
}
  
// função para exibir a janela com os meses
function pop_month(obj, div, tam, ano)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"')>" + umonth[n] +"</a></td></tr>" }
  txt += "</table>"
  popd.innerHTML = txt
}

// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) txt += "<tr>"
     txt += "<td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"')>" + n + "</a></td>"
     l++
     if (l == 4) 
        {txt += "</tr>"; l = 1 } 
  }
  txt += "</tr></table>"
  popd.innerHTML = txt 
}

// função para fechar o calendário
function force_close(div) 
    { div2 = eval (div); div2.innerHTML = ''}
    
// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div)
{ 
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data 
}

</script>

<!-- 
o css abaixo é apenas para dar uma aparência melhor para o calendário. vc pode mudá-lo a sua maneira 
insira o código abaixo entre as tags <HEAD> </HEAD> de sua página
-->
<style>
    .dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF}
    .data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
    .mes {font-family: helvetica, arial; font-size: 8pt}
    .Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
</style>

<style type="text/css">
.negrito {
	font-weight: bold;
}
</style>
<script type="text/javascript">
function validaCampo()
{
if(document.cadform.titulo.value=="")
{
alert("O Campo titulo é obrigatório!");
return false;
}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-1.4.2.min.js"></script>
</head>

<body>
<div id="box3">
<?php 
include "function.php";
$usuarioSolF=$_GET['usuario'];
 ?>
<br />
Selecione o período de férias desejado, o seu gestor direto e uma das opções (se for o caso) referente aos dias restantes:
<br /><br />
<form action="incluiSolicitacao.php" method="post" name="form3" onsubmit="return validaCampo();" >
<table width="484" border="0">
  <tr>
    <td width="92" class="negrito">Funcionário: </td>
    <td width="294"><?php echo $usuarioSolF ?><input name="func" id="func" value="<?php echo $usuarioSolF ?>" size="30" type="hidden"/>
   </td>
  </tr>
  <tr>
    <td class="negrito">Data Inicial:</td>
    <td><input class="input" NAME="data3" SIZE="5" MAXLENGTH="10" value="" readonly="readonly"> 
<input TYPE="button" class="input" NAME="btnData3" VALUE="..." Onclick="javascript:popdate('document.form3.data3','pop3','150',document.form3.data3.value)">
<!-- 
    na span abaixo aparece o primeiro calendario.
    vc pode colocar a span abaixo no lugar onde quiser em sua 
    pagina inclusive dentro de uma table para facilitar o 
    posicionamento. Mas lembre-se que quanto mais perto a span 
    estiver do campo de data a ela associada mais fácil será para
    o usuario associar. 
-->

<span id="pop3" style="position:absolute">	</span></td>
  </tr>
  <tr>
    <td class="negrito">Quantidade de Dias:</td>
    <td>
<input class="input" NAME="data4" SIZE="5" MAXLENGTH="2" value="">
<font size="-2"><strong>*Mínimo  10 dias</strong></font></td>
  </tr>
  <tr>
    <td><strong>Gestor</strong></td>
    <td><?php 
	require('conexaomysql.php');
	//consulta
    $rs = mysql_query("SELECT id, nome FROM gestores ORDER BY nome");
     //chama a função
    montaCombo('comboGestores', $rs, 'id', 'nome'); 
	?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="ab10" id="ab10" value="abono"/>Abono Pecuniário de 10 dias, conforme legislação vigente
    </td>
   <!-- <td>Abono Pecuniário de 10 dias, conforme legislação vigente</td>-->
  </tr><tr height="15"></tr>
  <tr>
    <td colspan="2">Deseja solicitar o adiantamento da 1ª parcela do 13º salário?</td>
    </tr>
  <tr>
   <td>
      <input type="radio" name="radio" value="SIM" checked="checked" />
      SIM </td><td>
        <input type="radio" name="radio" value="NAO" />
        NÃO</td>
  </tr>
  <tr><td></td>
    <td width="84" align="right"><input class="button" name="enviar" type="submit" value="enviar" /></td>
</tr>
</table>
<br />
<br />
<label for="ano"></label><br />
</form>
<strong>Solicitações Pendentes de Aprovação:</strong>
<?php
montaGradePendente($usuarioSolF);
?>
<br />
<strong>Solicitações Aprovadas:</strong>
<?php
montaGradeAprovadas($usuarioSolF);
?>
<br />
<strong>Solicitações Recusadas:</strong>
<?php
montaGradeRecusadas($usuarioSolF);
?>
</div>
</body>
</html>
