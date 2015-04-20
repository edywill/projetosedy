<?php
include "header.php";

?>
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
	
	<body class="home">
				
				<!-- Slider -->
			<div id="slider-block">
                <div id="slider-holder">
					<div id="slider">
                    <?php 
					require "conect.php";
					mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
					$sqlNotDes=mysql_query("SELECT id,titulo,imagem1,descricao FROM news WHERE destaque=1 ORDER BY id DESC LIMIT 5") or die(mysql_error());
					while($objNotDes=mysql_fetch_object($sqlNotDes)){
						echo "<a href='lerNews.php?id=".$objNotDes->id."'><img src='".$objNotDes->imagem1."' width='906' height='390' title='<strong>".$objNotDes->titulo."</strong>".substr($objNotDes->descricao,0,150)."... &nbsp;&nbsp;&nbsp;<a href=\"lerNews.php?id=".$objNotDes->id."\"><font color=\"white\">Leia mais</font></a>'/></a>";
						}
					?>                        
					</div>
				</div>
			</div>
			<!-- ENDS Slider -->
				
			</div>
			<!-- ENDS HEADER -->
			<!-- MAIN -->
			<div id="main">
				
				<!-- content -->
				<div id="content">
					
						<!-- TABS -->
						<!-- the tabs -->
						<ul class="tabs">
						<h2>Outras notícias:</h2>
                        </ul>
						<!-- tab "panes" -->
						<div class="panes">
						<?php 
						$sqlOutrasNoticias=mysql_query("SELECT id,titulo,imagem1,descricao FROM news WHERE destaque=0 ORDER BY id LIMIT 3") or die(mysql_error());
						?>
							<!-- Posts -->
							<div>
								<ul class="blocks-thumbs thumbs-rollover">
                                <?php 
								while ($objOutrasNews=mysql_fetch_object($sqlOutrasNoticias)){
									echo "
									<li>
										<a href='lerNews.php?id=".$objOutrasNews->id."' class='thumb' title='".$objOutrasNews->titulo."'><img src='".$objOutrasNews->imagem1."' alt='".$objOutrasNews->titulo."' width='282' height='150'/></a>
										<div>
											<a href='lerNews.php?id=".$objOutrasNews->id."' class='header'>".$objOutrasNews->titulo."</a>
											".substr($objOutrasNews->descricao,0,200)."
										</div>
										<a href='lerNews.php?id=".$objOutrasNews->id."'>Leia mais &#8594;</a>
									</li>
									";
									}
								?>
							  </ul>
                              <ul class="tabs">
                        <h2>Acesse:</h2>
                        </ul>
                                    <ul class="blocks-thumbs thumbs-rollover">
                                    <?php 
									if(!empty($_SESSION['usuarioID'])){
									
									?>
                                    <li>
										<a href="arqPrest.php" class="thumb" title="PrestContas"><img src="img/prest_contas.png" alt="Prestacao de Contas" /></a>
										<div>
											<a href="arqPrest.php" class="header">Prestação de Contas</a>
											Veja as prestações de contas da associação.
										</div>
										<a href="arqPrest.php">Confira &#8594;</a>
									</li>
									<li>
										<a href="aniversariantes.php" class="thumb" title="An image"><img src="img/aniversariantes.png" alt="Post" /></a>
										<div>
											<a href="aniversariantes.php" class="header">Aniversariantes do Dia</a>
											Veja os associados que fazem aniversário hoje.
										</div>
										<a href="aniversariantes.php">Confira &#8594;</a>
									</li>
                                    <?php 
									}
									?>
									<li>
										<a href="diretoria.php" class="thumb" title="An image"><img src="img/diretoria.png" alt="Post" /></a>
										<div>
											<a href="diretoria.php" class="header">Diretoria</a>
											Conheça os diretores da associação.
										</div>
										<a href="diretoria.php">Conheça &#8594;</a>
									</li>
								</ul>
							</div>
							<!-- ENDS posts -->
							
							<!-- Information  -->
							<div>
								<div class="plain-text">
									<h6>Pellentesque habitant morbi tristique senectus et netus et malesuada.</h6> 
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. <a href="#">This is a link</a></p>
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. </p>
								</div>
							</div>
							<!-- ENDS Information -->
							
							<!-- Information  -->
							<div>
								<div class="plain-text">
									<h6>Pellentesque habitant morbi tristique senectus et netus et malesuada.</h6> 
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. <a href="#">This is a link</a></p>
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. </p>
								</div>
							</div>
							<!-- ENDS Information -->
							
							<!-- Information  -->
							<div>
								<div class="plain-text">
									<h6>Pellentesque habitant morbi tristique senectus et netus et malesuada.</h6> 
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. <a href="#">This is a link</a></p>
									<p>Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.Fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. </p>
								</div>
							</div>
							<!-- ENDS Information -->
							
</div>
						<!-- ENDS TABS -->
	
	
	
				</div>
				<!-- ENDS content -->
	
	
			</div>
			<!-- ENDS MAIN -->
			
			<?php include "footer.php"; ?>
		</div>
		<!-- ENDS WRAPPER -->
	
	</body>
	
</html>