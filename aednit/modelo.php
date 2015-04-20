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
<?php include "header.php" ?>
				
				
			</div>
			<!-- ENDS HEADER -->
			<!-- MAIN -->
			<div id="main">
				<!-- content -->
			<div id="content">
				
				<!-- title -->
				<div id="page-title">
					<span class="title">Contact us</span>
					<span class="subtitle">Donec eu libero sit amet quam egestas semper.</span>
				</div>
				<!-- ENDS title -->
					
				<!-- column (left)-->
				<div class="one-column">
					<!-- form -->
					<h2>Contact Form</h2>
					<script type="text/javascript" src="js/form-validation.js"></script>
					<form id="contactForm" action="#" method="post">
						<fieldset>
							<div>
								<label>Name</label>
								<input name="name"  id="name" type="text" class="form-poshytip" title="Enter your full name" />
							</div>
							<div>
								<label>Email</label>
								<input name="email"  id="email" type="text" class="form-poshytip" title="Enter your email address" />
							</div>
							<div>
								<label>Website</label>
								<input name="web"  id="web" type="text" class="form-poshytip" title="Enter your website" />
							</div>
							<div>
								<label>Comments</label>
								<textarea  name="comments"  id="comments" rows="5" cols="20" class="form-poshytip" title="Enter your comments"></textarea>
							</div>
							
							<!-- send mail configuration -->
							<input type="hidden" value="your_email@your_server.com" name="to" id="to" />
							<input type="hidden" value="youremail@luiszuno.com" name="from" id="from" />
							<input type="hidden" value="From torn wordpress online" name="subject" id="subject" />
							<input type="hidden" value="send-mail.php" name="sendMailUrl" id="sendMailUrl" />
							<!-- ENDS send mail configuration -->
							
							<p><input type="button" value="SEND" name="submit" id="submit" /></p>
						</fieldset>
						<p id="error" class="warning">Message</p>
					</form>
					<p id="success" class="success">Thanks for your comments.</p>
					<!-- ENDS form -->
				</div>
				<!-- ENDS column -->
				
				<!-- column (right)-->
				<div class="one-column">
					<!-- content -->
					<p><img src="img/dummies/map.jpg" alt="map"></p>
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>					
					<p>Chambers St 1254 New York City<br/>
					USA ZIP 44511<br/>
					(33) 1234 5677, (33) 12459876<br/>
					<a href="mailto:email@server.com">email@server.com</a></p>
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