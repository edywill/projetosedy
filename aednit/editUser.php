<?php
include "header.php";
if(empty($_SESSION['usuarioID']) || ($_SESSION['usuarioPerfil']<>'A')){
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
$sqlUser=mysql_query("SELECT * FROM usuarios WHERE id=".$_GET['id']."") or die(mysql_error());
$arrayUser=mysql_fetch_array($sqlUser);

?>
<!DOCTYPE  html>
<html>
	<head>
		
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
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" /> 
		<script src="http://code.jquery.com/jquery-1.8.2.js"></script> 
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>
$(document).ready(function(){
				 	$("#dtnasc").datepicker({
						dateFormat: 'dd/mm/yy',
						changeMonth: true,
        				changeYear: true,
						yearRange: '-114:-14',
						dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
						dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
						dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
						monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
						nextText: 'Próximo',
						prevText: 'Anterior'
					});
			});
</script>
<script>
$(document).ready(function(){
				 	$("#dtadm").datepicker({
						dateFormat: 'dd/mm/yy',
						changeMonth: true,
        				changeYear: true,
						yearRange: '-64:+1',
						dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
						dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
						dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
						monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
						nextText: 'Próximo',
						prevText: 'Anterior'
					});
			});
</script>

		<!-- SKIN -->
		<link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/css_outro/estilo.css" type="text/css" media="screen" />

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
					<span class="title">Administração</span>
					<span class="subtitle">Atualização de Cadastro de Sócio Ativo.</span>
				</div>
				<!-- ENDS title -->
					
				<!-- column (left)-->
				<div class="one-column">
					<!-- form -->
					<h2>Dados de Sócio Ativo</h2>
					<script type="text/javascript" src="js/form-validation.js"></script>
					<form id="contactForm" action="atualizaCadastro.php" method="post">
                    <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id"/>
						<fieldset>
							<div>
								<label>Nome</label>
								<input name="name"  id="name" type="text" class="form-poshytip" title="Entre com seu nome completo" value="<?php echo $arrayUser['name']; ?>" />
							</div>
							<div>
								<label>Nacionalidade</label>
								<input name="nacio"  id="nacio" type="text" class="form-poshytip" value="Brasileira" title="Informe sua Nacionalidade"  value="<?php echo $arrayUser['nacio']; ?>" />
							</div>
                            <div>
								<label>Naturalidade</label>
								<input name="natu"  id="natu" type="text" class="form-poshytip" title="Informe sua naturalidade"  value="<?php echo $arrayUser['natu']; ?>" />
							</div>												
                            <div>
								<label>Data de Nascimento</label>
								<input name="dtnasc"  id="dtnasc" type="text" class="form-poshytip" title="Informe sua data de nascimento" maxlength="10"  value="<?php echo $arrayUser['dtnasc']; ?>"/>
							</div>	
                            <div>
								<label>Sexo</label>
								<select name="sexo" id="sexo">
                                <option  value="<?php echo $arrayUser['sexo']; ?>" selected><?php echo $arrayUser['sexo']; ?></option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                </select>
							</div>							
                            <div>
								<label>Estado Civil</label>
								<select name="estcivil" id="estcivil">
                                <option value="<?php echo $arrayUser['estcivil']; ?>" selected><?php echo $arrayUser['estcivil']; ?></option>
                                <option value="Solteiro">Solteiro</option>
                                <option value="Casado">Casado</option>
                                <option value="Viúvo">Viúvo</option>
                                <option value="Outros">Outros</option>
                                </select>
							</div>	
                            <div>
								<label>Profissão</label>
								<input name="profi"  id="profi" type="text" class="form-poshytip" title="Informe sua profissão" value="<?php echo $arrayUser['profi']; ?>"/>
                                </div>												
                                <div>
								<label>Curso de Formação</label>
								<input name="curso"  id="curso" type="text" class="form-poshytip" title="Informe seu curso de formação" value="<?php echo $arrayUser['curso']; ?>"/>
                                </div>																							
                                <div>
								<label>Estabelecimento em que se formou</label>
								<input name="univer"  id="univer" type="text" class="form-poshytip" title="Informe a faculdade/universidade"  value="<?php echo $arrayUser['univer']; ?>"/>
                                </div>												
                                <div>
								<label>Ano de Formação</label>
								<input name="ano"  id="ano" type="text" class="form-poshytip" title="Informe o ano de formação" maxlength="4" value="<?php echo $arrayUser['ano']; ?>"/>
                                </div>												
                                <div>
								<label>Cargo (DNIT)</label>
								<input name="cargo"  id="cargo" type="text" class="form-poshytip" title="Informe seu cargo" value="<?php echo $arrayUser['cargo']; ?>" />
                                </div>												
                                <div>
								<label>Matrícula (DNIT)</label>
								<input name="matdnit"  id="matdni" type="text" class="form-poshytip" title="Informe sua matrícula no DNIT" value="<?php echo $arrayUser['matdnit']; ?>"/>
                                </div>												
                                <div>
								<label>Data de Admissão (DNIT)</label>
								<input name="dtadm"  id="dtadm" type="text" class="form-poshytip" title="Informe sua data de admissão no DNIT" value="<?php echo $arrayUser['dtadm']; ?>"/>
                                </div>												
                                <div>
								<label>Lotação</label>
								<input name="lotacao"  id="lotacao" type="text" class="form-poshytip" title="Informe sua lotação" value="<?php echo $arrayUser['lotacao']; ?>"/>
                                </div>												
                                <div>
								<label>Endereço para Correspondência</label>
								<input name="endereco"  id="endereco" type="text" class="form-poshytip" title="Informe seu endereço" value="<?php echo $arrayUser['endereco']; ?>"/>
                                </div>												
                                <div>
								<label>Nº</label>
								<input name="num"  id="num" type="text" class="form-poshytip" title="Informe o número do imóvel" value="<?php echo $arrayUser['num']; ?>"/>
                                </div>												
                                <div>
								<label>Complemento</label>
								<input name="comp"  id="comp" type="text" class="form-poshytip" title="Informe o complemento" value="<?php echo $arrayUser['comp']; ?>" />
                                </div>												
                                <div>
								<label>Bairro</label>
								<input name="bairro"  id="bairro" type="text" class="form-poshytip" title="Informe o bairro" value="<?php echo $arrayUser['bairro']; ?>" />
                                </div>												
                                <div>
								<label>Cidade</label>
								<input name="cidade"  id="cidade" type="text" class="form-poshytip" title="Informe a cidade" value="<?php echo $arrayUser['cidade']; ?>" />
                                </div>												
                                <div>
								<label>UF</label>
								<select name="estado">
                                <option value="<?php echo $arrayUser['estado']; ?>"><?php echo strtoupper($arrayUser['estado']); ?></option>
                                <option value="ac">AC</option>
                                <option value="al">AL</option>
                                <option value="ap">AP</option>
                                <option value="am">AM</option>
                                <option value="ba">BA</option>
                                <option value="ce">CE</option>
                                <option value="df">DF</option>
                                <option value="es">ES</option>
                                <option value="go">GO</option>
                                <option value="ma">MA</option>
                                <option value="ms">MS</option>
                                <option value="mt">MT</option>
                                <option value="mg">MG</option>
                                <option value="pa">PA</option>
                                <option value="pb">PB</option>
                                <option value="pr">PR</option>
                                <option value="pe">PE</option>
                                <option value="pi">PI</option>
                                <option value="rj">RJ</option>
                                <option value="rn">RN</option>
                                <option value="rs">RS</option>
                                <option value="ro">RO</option>
                                <option value="rr">RR</option>
                                <option value="sc">SC</option>
                                <option value="sp">SP</option>
                                <option value="se">SE</option>
                                <option value="to">TO</option>
                                </select>
                                </div>												
                                                                <div>
								<label>CEP</label>
								<input name="cep"  id="cep" type="text" class="form-poshytip" title="Informe o CEP" maxlength="10" value="<?php echo $arrayUser['cep']; ?>"/>
                                </div>												
                                <div>
								<label>Telefone Residencial</label>
								<input name="resid"  id="resid" type="text" class="form-poshytip" title="Informe o telefone residencial" value="<?php echo $arrayUser['resid']; ?>"/>
                                </div>
                                <div>
								<label>Telefone Celular</label>
								<input name="celular"  id="celular" type="text" class="form-poshytip" title="Informe o telefone celular" value="<?php echo $arrayUser['celular']; ?>"/>
                                </div>												
                                <div>
								<label>Telefone Trabalho</label>
								<input name="trabalho"  id="trabalho" type="text" class="form-poshytip" title="Informe o telefone do trabalho" value="<?php echo $arrayUser['trabalho']; ?>"/>
                                </div>
                                <div>
								<label>E-mail</label>
								<input name="email"  id="email" type="text" class="form-poshytip" title="Informe o e-mail" value="<?php echo $arrayUser['email']; ?>"/>
                                </div>
                                <input name="user"  id="user" type="hidden" class="form-poshytip" title="Informe o nome de usuário que gostaria de utilizar para acessar o site" value="<?php echo $arrayUser['user']; ?>"/>
                                <input name="senha"  id="senha" type="hidden" class="form-poshytip" title="Informe uma senha de no mínimo 4 e no máximo 10 caracteres para acessar o site" value="<?php echo $arrayUser['pass']; ?>"/>
                                 <div>
                                </div>
                                                               <div>

							<p><input type="submit" value="Atualizar" name="submit" id="submit" /></p>
						</fieldset>
					</form>
					<!-- ENDS form -->
				</div>
				<!-- ENDS column -->
				
				<!-- column (right)-->
				<div class="one-column">
					<!-- content -->
					<p></p>
					<p>Mantenha sempre seu cadastro atualizado junto a AEDNIT.</p>					
					<p><br/>
					Em caso de dúvidas entre em contato conosco:<br/>
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