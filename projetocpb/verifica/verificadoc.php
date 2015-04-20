<?php 
 session_start();
 require "../conectsqlserver.php";
 require "../conect.php";
 $endereco="";
 $idDoc2=0;
 $valida=0;
 $hash=$_POST['codigo'];
 $tituloDoc='';
  if(empty($hash)){
	 $valida=1;
	 ?>
  <script type="text/javascript">
       alert("Erro: Informe o código!");
       history.back();
       </script>
       <?php
	 }else{
 $sqlDocumentoOnline=mysql_query("SELECT docdigital.tipo,docdigital.id FROM docdigital WHERE docdigital.hash='".$hash."'") or die(mysql_error());
 $arrayDocumentoOnline=mysql_fetch_array( $sqlDocumentoOnline);
 if(empty($arrayDocumentoOnline)){
	 $valida=1;
	 ?>
  <script type="text/javascript">
       alert("Documento não encontrado!");
       history.back();
       </script>
       <?php
	 }
 
	 }
if($valida==0){
	$tipo=$arrayDocumentoOnline['tipo'];
if($tipo==1){
	include "buscaDadosSav.php";
	}elseif($tipo==2){
		include "buscaDadosCi.php";
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Intranet - CPB</title>
</head>

<body >
	<div  style='position:relative; top:0px; left:0px;'>
		<img width="100%" src="../imagens/topo_new1.png" border=0>
	</div>
	<!--<div style='position:absolute; top:70px; left:50px;'>
		<img width="280px" src="imagens/logo_cpb1.png"/>
	</div>
	<img src="imagens/topo_new.png" width="100%"  border="0" />
	<img width="280px" style="margin-top: -140px; margin-left: 50px; " src='imagens/logo_cpb1.png'>-->
<div id="container">
<div id="content">
<table width="100%" border="0">
<tr><td></td></tr>
</table>
<br><br><br>
<form id="form1" name="form1" method="post" action="verificadoc.php">
<table  width="100%" height="20" border="0">
<tr><td>
  <p align="center"><strong>AUTENTICAÇÃO DE DOCUMENTOS CPB</strong></p><br/>
  <?php 
  if($_SESSION['pendAprov']<>0){
	  echo "<p align='left'>DOCUMENTO INDISPONÍVEL PARA CONSULTA.<BR> ESTARÁ DISPONÍVEL SOMENTE APÓS A APROVAÇÃO DE TODOS OS GESTORES RESPONSÁVEIS.</p>";
	  }else{
  echo "<p align='center'><strong>".$tituloDoc."</strong></p>";
  ?>
  
  <p align="left">Esse documento foi assinado eletronicamente por:</p>
  <?PHP 
  echo $tabelaDados;
  ?>
 
 <p align="right">Para visualizar o documento <strong><a href="<?php echo $endereco.$idDoc2; ?>" target="_blank">CLIQUE AQUI</a>.</strong></p>
 <?php 
	  }
 ?>
 <p align="left"><a href="index.php"><input type="button" name="voltar" value="<<Voltar" class='button'/></a></p></td></tr>
</table>

</div>
</div>

	<div  style='position:relative; bottom:0%; left:0px;'>
		<img width="100%" src="../imagens/rodape_new1.png" border=0>
	</div>




<!--<img src="imagens/rodape_new.jpg"  width="100%"  border="0" />
<img width="280px" style="margin-top: -140px; margin-left: 50px; " src=''>-->
</body>
</html>
<?php 
}
?>