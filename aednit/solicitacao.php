<?php include "header.php";
if(empty($_SESSION['usuarioID'])){
	?>
												   <script type="text/javascript">
                                                   alert("Acesso restiro!");
                                                   window.location="logout.php";
                                                   </script>
                                                   <?php
	}
					mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$sqlUser=mysql_query("SELECT name,email,lotacao FROM usuarios WHERE id=".$_SESSION['usuarioID']."") or die(mysql_error());
$arrayUser=mysql_fetch_array($sqlUser);?>
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
				
				
			</div>
			<!-- ENDS HEADER -->
			<!-- MAIN -->
			<div id="main">
				<!-- content -->
			<div id="content">
				
				<!-- title -->
				<div id="page-title">
					<span class="title">Solicitação / Contato</span>
					<span class="subtitle">Utilize o formulário abaixo para fazer sua solicitação ou entre contato nos telefones informados.</span>
				</div>
				<!-- ENDS title -->
					
				<!-- column (left)-->
				<div class="one-column">
					<!-- form -->
					<h2>Formulário de Contato</h2>
					<script type="text/javascript" src="js/form-validation.js"></script>
					<form id="contactForm" action="enviaEmail.php" method="post">
						<fieldset>
							<div>
								<label>Nome</label>
								<input name="name"  id="name" type="text" class="form-poshytip" title="Entre com seu nome completo" readonly value="<?php echo $arrayUser['name'];?>" />
							</div>
							<div>
								<label>Email</label>
								<input name="email"  id="email" type="text" class="form-poshytip" title="Entre com seu e-mail" readonly value="<?php echo $arrayUser['email'];?>"/>
							</div>
							<div>
								<label>Lotação</label>
								<input name="uf"  id="uf" type="text" class="form-poshytip" title="Entre com a sua lotação." readonly value="<?php echo $arrayUser['lotacao'];?>"/>
							</div>
							<div>
								<label>Mensagem</label>
								<textarea  name="comments"  id="comments" rows="5" cols="20" class="form-poshytip" title="Informe sua mensagem"></textarea>
							</div>												
							<p><input type="submit" value="Enviar" name="submit" id="submit" /></p>
						</fieldset>
					</form>
					<!-- ENDS form -->
				</div>
				<!-- ENDS column -->
				
				<!-- column (right)-->
				<div class="one-column">
					<!-- content -->
					<p></p>
					<p>Além do endereço informado abaixo, a associação possui representação nas SRs e no Mezanino da SEDE.</p>					
					<p>Para entrar em contato, utilize um dos seguintes canais:<br/>
					(61) <br/>
					<a href="mailto:aednit@aednit.org,br">aednit@aednit.org,br</a></p>
					<!-- ENDS content -->
				</div>
				<!-- ENDS column -->							

			</div>
			<!-- ENDS content -->
	
	
			</div>
			<!-- ENDS MAIN -->
			
			<?php include "footer.php"; ?>
		</div>
		<!-- ENDS WRAPPER -->
	
	</body>
	
</html>