<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>AEDNIT - Associação dos Engenheiros do DNIT</title>
		
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

	</head>
	
	<body class="">
<?php include "header.php";
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
				  <div id="page-title"> <span class="title">Administração</span> <span class="subtitle">Painel de administração do site!</span> </div>
				  <!-- ENDS title -->
				  <!-- project column (left)-->
				  <div class="project-column">
				    <!-- shadow -->
				    <div class="project-shadow">
				      <div class="project-thumbnail"><img src="img/admin.png"  alt="Feature image" /></div>
				      <!-- meta -->
				      <!-- ENDS meta -->
			        </div>
				    <!-- ENDS shadow -->
			      </div>
				  <!-- ENDS project column (left)-->
				  <!--project column (right) -->
				  <div class="project-column">
				    <h1 class="project-title">GERENCIAMENTO</h1>
				    <div>
				      <table border="1">
				        <tr>
				          <td><a href="gerNews.php"><img src="img/news.png"></a></td>
				          <td><a href="gerUsers.php"><img src="img/user.png"></a></td>
				          <td><a href="gerFiles.php"><img src="img/files.png"></a></td>
			            </tr>
				        <tr>
                        <td colspan='3' align="center"><a href="http://webmail.aednit.org.br" target="_blank"><img src="img/mail.png"></a></td>
                        </tr>
			          </table>
			        </div>
				    <p>&nbsp;</p>
			      </div>
				  <div class="clear"></div>
				  <!-- ENDS project column (right) -->
			  </div>
				<!-- ENDS content -->
	
	
</div>
			<!-- ENDS MAIN -->
			
			<?php include "footer.php"; ?>
		</div>
		<!-- ENDS WRAPPER -->
	
	</body>
	
</html>