<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
 <script type="text/javascript">
  $(document).ready(function(){
      $('#desconto').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
       	<script type="text/javascript">
	
		function confirma(){
		  return confirm("Deseja realmente excluir? ");
		}
	
	</script>

</head>
<body>
<div id='tabela'>    
    <?php
        require "../../conexaomysql.php";
         $nome='';
		 $desconto='';
		 $id='';
		 
		if(!empty($_GET['id'])){
        $id=$_GET['id'];
        
        $sql = "SELECT id, nome, desconto FROM cia where id='".$id."'";
        $qr = mysql_query($sql) or die(mysql_error());
        
        //while($ln = mysql_fetch_assoc($qr)){ 
         $ln=mysql_fetch_array($qr);
	     $nome=$ln['nome'];
		 $desconto=$ln['desconto'];
		 $id=$ln['id'];
	}
   ?>
    
    <br/>
<h2>CADASTRO DE COMPAINHA AÉREA</h2>   
<div align="center"><button><a href="../index.php">Início</a></button></div>
<br/>
<form method="post" action="atualiza.php">
    <div id="notable">
    <table><tr>
        <td><strong>Nome:</strong></td><td><input type="text" size='25' name="nome" value="<?php echo $nome; ?>"/></td>
        </tr>
        <td><strong>Desconto:</strong></td><td><input type="text" size='15' name="desconto" id='desconto' value="<?php echo number_format($desconto, 2, ',', '.'); ?>"/><strong>%</strong> Ex: 15<br/></td>
    </tr></table>
    <br/><br/>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    </div>
    <input class="button" type="submit" value="ATUALIZAR"/>
</form>
<br/>


<?php
        //} //fecha while

    $sql = "SELECT id, nome, desconto FROM cia where id > 1";
    $qr = mysql_query($sql) or die(mysql_error());
    
   echo "<table width='400px'><th width='50px'>COD</th><th width='150px'>NOME</th><th width='50px'>DESCONTO</th><th width='50px'>Editar</th><th width='50px'>Excluir</th>";
    
    
    while($ln = mysql_fetch_assoc($qr)){
       echo "<tr><td><center>".$ln['id']."</center></td><td>".$ln['nome']."</td><td>".$ln['desconto']."</td><td><a href='atualizacia.php?id=".$ln['id']."'><center><img width='25%' src='../css/editar.jpg'></center></a></td><td><a href='delete.php?id=".$ln['id']."' onClick='return confirma()'><center><img width='30%' src='../css/excluir.png'></img></center></a></center></td>";
 					
    }
    
     echo "</table>";
 ?>


</div>
</body>
</html>
