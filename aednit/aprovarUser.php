<?php 
include "header.php";
?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>AEDNIT - Associação dos Engenheiros do DNIT</title>
<link rel="stylesheet" href="datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela2').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 2, "asc" ]]
	});
	$checado=false;
});
</script>
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />
		<!--[if IE 8]>
			<link rel="stylesheet" type="text/css" media="screen" href="/css/ie8-hacks.css" />
		<![endif]-->
		<!-- ENDS CSS -->	
		
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		
		<!-- JS -->
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/quicksand.js"></script>
		<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<!--[if IE]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
			<script>
	      		/* EXAMPLE */
	      		//DD_belatedPNG.fix('*');
	    	</script>
		<![endif]-->
		<!-- ENDS JS -->
		
		
		<!-- Nivo slider -->
		<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
		<script src="js/nivo-slider/jquery.nivo.slider.js" type="text/javascript"></script>
		<!-- ENDS Nivo slider -->
		
		<!-- tabs -->
		<link rel="stylesheet" href="css/tabs.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/tabs.js"></script>
  		<!-- ENDS tabs -->
  		
  		<!-- prettyPhoto -->
		<script type="text/javascript" src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- superfish -->
		<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
		<link rel="stylesheet" media="screen" href="css/superfish-left.css" /> 
		<script type="text/javascript" src="js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/superfish.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- poshytip -->
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-twitter/tip-twitter.css" type="text/css" />
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
		<script type="text/javascript" src="js/poshytip-1.0/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- Tweet -->
		<link rel="stylesheet" href="css/jquery.tweet.css" media="all"  type="text/css"/> 
		<script src="js/tweet/jquery.tweet.js" type="text/javascript"></script> 
		<!-- ENDS Tweet -->
		
		<!-- Fancybox -->
		<link rel="stylesheet" href="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<!-- ENDS Fancybox -->
		
		<!-- SKIN -->
		<link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />

<link rel="stylesheet" href="datatables/estilo/table_jui.css" />
	</head>
	
	<body class="">
<?php
if(empty($_SESSION['usuarioID']) || ($_SESSION['usuarioPerfil']<>'A')){
	?>
												   <script type="text/javascript">
                                                   alert("Acesso restiro!");
                                                   window.location="logout.php";
                                                   </script>
                                                   <?php
	}?>
				
				
			</div>
			<!-- ENDS HEADER -->
			<!-- MAIN -->
			<div id="main">
				
				<!-- content -->
				<div id="content">
				  <!-- title -->
				  <div id="page-title"> <span class="title">Administração</span> <span class="subtitle">Gerenciamento de Usuários!</span></div>
				  <!-- ENDS title -->
				  <?php 
				  require "conect.php";
				  ?>
				  <table border="1" width="100%">
				    <thead>
                    <tr>
				      <th align="center" colspan="6">USUÁRIOS PENDENTES DE APROVAÇÃO</th>
			        </tr>
				    <tr>
				      <th width="40%"><strong>Nome</strong></th>
				      <th width="10%"><strong>Siape</strong></th>
				      <th width="20%"><strong>Email</strong></th>
				      <th width="10%"><strong>Celular</strong></th>
				      <th width="10%"><strong>Aprovar</strong></th>
				      <th width="10%"><strong>Recusar</strong></th>
			        </tr>
                    </thead>
                    <tbody>
                    <?php
					$sqlPendAp=mysql_query("SELECT * FROM usuarios WHERE status='N'");
					while($objPendAp=mysql_fetch_object($sqlPendAp)){
                    echo "<tr>
                    <td>$objPendAp->name</td>
                    <td>$objPendAp->matsiape</td>
                    <td>$objPendAp->email</td>
                    <td>$objPendAp->celular</td>
                    <td><a href='aprovUser.php?id=".$objPendAp->id."&status=".$objPendAp->status."'><input type='button' value='Aprovar'/></a></td>
                    <td><a href='delUser.php?id=".$objPendAp->id."'><input type='button' value='Aprovar'/></a></td>
                    </tr>";
					}
					?>
                    </tbody>
			      </table>
				  <table border="1" width="100%">
				    <thead>
                    <tr>
				      <th align="center" colspan="6">USUÁRIOS PENDENTES DE INCLUSÃO NA D8</th>
			        </tr>
                    <tr>
				      <th width="40%"><strong>Nome</strong></th>
				      <th width="10%"><strong>Siape</strong></th>
				      <th width="20%"><strong>Email</strong></th>
				      <th width="10%"><strong>Celular</strong></th>
				      <th width="10%"><strong>Aprovar</strong></th>
				      <th width="10%"><strong>Recusar</strong></th>
			        </tr>
                    </thead>
                    <tbody>
                    <?php
					$sqlPendD8=mysql_query("SELECT * FROM usuarios WHERE status='D'");
					while($objPendD8=mysql_fetch_object($sqlPendD8)){
                    echo "<tr>
                    <td>$objPendD8->name</td>
                    <td>$objPendD8->matsiape</td>
                    <td>$objPendD8->email</td>
                    <td>$objPendD8->celular</td>
                    <td><a href='aprovUser.php?id=".$objPendD8->id."&status=".$objPendD8->status."'><input type='button' value='Aprovar'/></a></td>
                    <td><a href='delUser.php?id=".$objPendD8->id."'><input type='button' value='Aprovar'/></a></td>
                    </tr>";
					}
					?>
                    </tbody>
			      </table>
				  <table border="1" width="100%">
				    <tr>
				      <th align="center">USUÁRIOS CADASTRADOS</th>
			        </tr>
			      </table>
				  <iframe src="gerListaUsers.php" width="100%" height="100%" vspace="0" align="top"></iframe>
			  </div>
				<!-- ENDS content -->
	
	
</div>
			<!-- ENDS MAIN -->
			
			<?php include "footer.php"; ?>
		</div>
		<!-- ENDS WRAPPER -->
	
	</body>
	
</html>