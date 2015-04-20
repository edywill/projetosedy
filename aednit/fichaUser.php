<?php 
$id=$_GET['id'];
require "conect.php";
$sqlFicha=mysql_query("SELECT * FROM usuarios WHERE id=".$id."") or die(mysql_error());
$arrayFicha=mysql_fetch_array($sqlFicha);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table cellspacing="0" cellpadding="0" border="1">
  <col width="64" />
  <col width="76" />
  <col width="64" span="8" />
  <tr>
    <td colspan="10" align="center"><h2><strong>AEDNIT </strong></h2></td>
  </tr>
  <tr>
    <td colspan="10" align="center">ASSOCIAÇÃO DE ENGENHEIROS</td>
  </tr>
  <tr>
    <td width="148"></td>
    <td width="77"></td>
    <td width="54"></td>
    <td width="114"></td>
    <td width="44"></td>
    <td width="123"></td>
    <td width="61"></td>
    <td width="57"></td>
    <td width="101"></td>
    <td width="3"></td>
  </tr>
  <tr>
    <td colspan="10" align="center"><strong>FICHA DE    INSCRIÇÃO DE SÓCIO ATIVO</strong></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><strong>MATRICULA SIAPE:</strong></td><td colspan="5" align="center"><strong><font color="#FF0000"><?php echo mb_convert_encoding($arrayFicha['matsiape'],"UTF-8","ISO-8859-1"); ?></font></strong></td>
  </tr>
  <tr>
    <td colspan="2"><strong>NOME:</strong></td>
    <td colspan="8"><?php echo mb_convert_encoding($arrayFicha['name'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>NACIONALIDADE:</strong></td>
    <td colspan="3"><?php echo mb_convert_encoding($arrayFicha['nacio'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>NATURALIDADE:</strong></td>
    <td colspan="4"><?php echo mb_convert_encoding($arrayFicha['natu'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>DATA DE NASC.:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['dtnasc'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>SEXO:</strong></td>
    <td><?php echo mb_convert_encoding($arrayFicha['sexo'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="2"><strong>PROFISSÃO:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['profi'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="3"><strong>CURSO DE FORMAÇÃO:</strong></td>
    <td colspan="3"><?php echo mb_convert_encoding($arrayFicha['curso'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="10"><strong>ESTABELECIMENTO DE    ENSINO DE FORMAÇÃO E ANO:</strong></td>
  </tr>
  <tr>
    <td colspan="10"><?php echo mb_convert_encoding($arrayFicha['univer'],"UTF-8","ISO-8859-1")." - ".mb_convert_encoding($arrayFicha['ano'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>CARGO NO DNIT:</strong></td>
    <td colspan="4"><?php echo mb_convert_encoding($arrayFicha['cargo'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="2"><strong>MAT. DNIT:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['matdnit'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>DATA DE ADMISSÃO:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['dtadm'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="2"><strong>LOTAÇÃO:</strong></td>
    <td colspan="4"><?php echo mb_convert_encoding($arrayFicha['lotacao'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>ENDEREÇO PARA    CORRESPONDÊNCIA:</strong></td>
    <td colspan="6"><?php echo mb_convert_encoding($arrayFicha['endereco'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>NUMERO:</strong></td>
    <td><?php echo mb_convert_encoding($arrayFicha['num'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="2"><strong>COMPLEMENTO:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['comp'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>BAIRRO:</strong></td>
    <td colspan="3"><?php echo mb_convert_encoding($arrayFicha['bairro'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td><strong>CIDADE:</strong></td>
    <td colspan="3"><?php echo mb_convert_encoding($arrayFicha['cidade'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>UF:</strong></td>
    <td><?php echo mb_convert_encoding($arrayFicha['estado'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>CEP:</strong></td>
    <td colspan="3"><?php echo mb_convert_encoding($arrayFicha['cep'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td><strong>TEL. RES.:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['resid'],"UTF-8","ISO-8859-1"); ?></td>
    <td><strong>TEL. CEL.:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['celular'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="2"><strong>TEL. TRAB./FAX:</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['trabalho'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
  <tr>
    <td><strong>E-MAIL:</strong></td>
    <td colspan="4"><?php echo mb_convert_encoding($arrayFicha['email'],"UTF-8","ISO-8859-1"); ?></td>
    <td colspan="3"><strong>AUTORIZADO DESCONTO?</strong></td>
    <td colspan="2"><?php echo mb_convert_encoding($arrayFicha['autorizo'],"UTF-8","ISO-8859-1"); ?></td>
  </tr>
</table>
</body>
</html>