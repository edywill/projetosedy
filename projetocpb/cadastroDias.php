<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>

<body>

<div id='box'>
<form action="cadastroDia.php" method="post" name="cadastroDia">
<div id='tabela2'>
<br/>
<table border="0" cellspacing="0" cellpadding="0">
  <strong >Cadastro de Evento Folha de Ponto</strong>
<br/><br/>    
  <tr>
    <td><strong>Dias</strong></td>
    <td>
	<div id="select">
	<select style='width:55px'  name="dia" id="dia" >
      <option selected="selected"></option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
      <option>13</option>
      <option>14</option>
      <option>15</option>
      <option>16</option>
      <option>17</option>
      <option>18</option>
      <option>19</option>
      <option>20</option>
      <option>21</option>
      <option>22</option>
      <option>23</option>
      <option>24</option>
      <option>25</option>
      <option>26</option>
      <option>27</option>
      <option>28</option>
      <option>29</option>
      <option>30</option>
      <option>31</option>
    </select></div></td>
  </tr>
  <tr>
    <td><strong>Mês</strong></td>
    <td>
	<div id="select">
	<select style='width:55px' name="mes" id="mes" >
      <option selected="selected"></option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
    </select></div></td>
  </tr>
  <tr>
    <td><strong>Ano</strong></td>
    <td><input type="text"  class='input' name="ano" id="ano" size="2" maxlength="4"/></td>
  </tr>
  <tr>
    <td><strong>Tipo</strong></td>
    <td>
	<div id='select'>
	<select name="status" id="status" >
      <option selected="selected"></option>
      <option>Sabado</option>
      <option>Domingo</option>
      <option>Feriado</option>
      <option>Recesso</option>
    </select></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align='right'>
    <td border='0' colspan="2"><input type="submit"  class='button' name="cadastrar" id="submit" value="Cadastrar" /></td>
    </tr>
</table></div>

</form>
<br /><br /><br /><br />
<form action="excluirDia.php" method="post" name="excluiDia">

<div id='tabela2'>
<table width="251" border="0" cellspacing="0" cellpadding="0">
  <strong>Exclusão de Evento Folha de Ponto</strong>
<br/>  <br/>  
  <tr>
    <td width="45"><strong>Dia</strong></td>
    <td width="200">
	<div id="select">
	<select style='width:55px' name="diax" id="diax" >
      <option selected="selected"></option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
      <option>13</option>
      <option>14</option>
      <option>15</option>
      <option>16</option>
      <option>17</option>
      <option>18</option>
      <option>19</option>
      <option>20</option>
      <option>21</option>
      <option>22</option>
      <option>23</option>
      <option>24</option>
      <option>25</option>
      <option>26</option>
      <option>27</option>
      <option>28</option>
      <option>29</option>
      <option>30</option>
      <option>31</option>
    </select></div></td>
  </tr>
  <tr>
    <td><strong>Mês</strong></td>
    <td>
	<div id="select">
	<select style='width:55px' name="mesx" id="mesx" >
      <option selected="selected"></option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
    </select></div></td>
  </tr>
  <tr>
    <td><strong>Ano</strong></td>
    <td><input class="input" type="text" name="anox" id="anox" size="2" maxlength="4"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align='right'>
    <td colspan="2"><input type="submit" class="button" name="exclui" id="submit" value="Excluir" /></td>
    </tr>
</table>
</div>

</form>
</div>
</body>
</html>
