<?php
include "header.php";
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
  if(!empty($_GET['id'])){
	  $idUser=$_GET['id'];
	  $tituloPrincipal="Administração";
	  $tituloSec="Atualização de Cadastro de Sócio Ativo.";
	  }else{
		  $idUser=$_SESSION['usuarioID'];
		  $tituloPrincipal="Cadastro";
		  $tituloSec="Mantenha sempre seus dados atualizados";
		  }
$sqlUser=mysql_query("SELECT * FROM usuarios WHERE id=".$idUser."") or die(mysql_error());
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
					<span class="title"><?php echo $tituloPrincipal; ?></span>
					<span class="subtitle"><?php echo $tituloSec; ?></span>
				</div>
				<!-- ENDS title -->
					<!-- column (left)-->
				<div style="width:auto; margin-left:30px">
					<!-- form -->
					<h2>Dados de Sócio Ativo</h2>
					<script type="text/javascript" src="js/form-validation.js"></script>
					<?php
					if($tituloPrincipal=="Cadastro"){
					?>
                    <!-- content -->
					<p>Mantenha sempre seu cadastro atualizado junto a associação.<br>
					Em caso de dúvidas entre em contato conosco:<br/>
					(61) 3315-4229<br/>
					<a href="mailto:contato@aednit.org,br">contato@aednit.org,br</a></p>
                    <?php 
					}
					?>
					<form  action="atualizaCadastro.php" method="post">
                    <input type="hidden" value="<?php echo $_SESSION['usuarioID']; ?>" name="id"/>
						<fieldset>
                        <table border="1">
                        <tr><td><label>Nome</label></td><td colspan="3">
								<input name="name"  id="name" type="text" class="form-poshytip" size="60" title="Entre com seu nome completo" value="<?php echo $arrayUser['name']; ?>" /></td></tr>
                        <tr><td><label>Matricula SIAPE</label></td><td><input name="matsiape"  id="matsiape" type="text" class="form-poshytip" title="Informe sua matrícula no SIAPE" value="<?php echo $arrayUser['matsiape']; ?>" /></td><td><label>Matrícula (DNIT)</label></td><td>
								<input name="matdnit"  id="matdni" type="text" class="form-poshytip" title="Informe sua matrícula no DNIT" value="<?php echo $arrayUser['matdnit']; ?>"/></td></tr>
                                <tr><td><label>Data de Nascimento</label></td><td>
								<input name="dtnasc"  id="dtnasc" type="text" class="form-poshytip" title="Informe sua data de nascimento" maxlength="10" value="<?php echo $arrayUser['dtnasc']; ?>"/></td><td><label>Sexo</label></td><td>
								<select name="sexo" id="sexo">
                                <?php if(empty($arrayUser['sexo']) || $arrayUser['sexo']=='0'){
									?>
								<option value="0" selected>Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>	
									<?php 
									}elseif($arrayUser['sexo']=='Masculino'){
										echo " <option value='Masculino' selected>Masculino</option>
                                				<option value='Feminino'>Feminino</option>";
										}else{
											echo " <option value='Masculino'>Masculino</option>
                                				<option value='Feminino' selected>Feminino</option>";
											} ?>
                                
                                </select></td></tr>
                                <tr><td><label>Naturalidade/<br>UF</label></td><td>
								<input name="natu"  id="natu" type="text" class="form-poshytip" title="Informe sua naturalidade" value="<?php echo $arrayUser['natu']; ?>" />
								<select name="ufnatu"><?php 
								if(empty($arrayUser['ufnatu'])){
								echo "<option value='0' selected>Selecione</option>";
								}else{
									echo "<option value='".$arrayUser['ufnatu']."' selected>".strtoupper($arrayUser['ufnatu'])."</option>";
									}
								?>
                                
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
                                </select></td><td><label>Nacionalidade</label></td><td>
								<input name="nacio"  id="nacio" type="text" class="form-poshytip" value="<?php echo $arrayUser['nacio']; ?>" title="Informe sua Nacionalidade" /></td></tr>
                                <tr><td><label>Profissão</label></td><td>
					<input name="profi"  id="profi" type="text" class="form-poshytip" title="Informe sua profissão/Formação" value="<?php echo $arrayUser['profi']; ?>"/></td><td><label>Cargo (DNIT)</label></td><td>
								<input name="cargo"  id="cargo" type="text" class="form-poshytip" title="Informe seu cargo no DNIT" value="<?php echo $arrayUser['cargo']; ?>"/></td></tr>
                                <tr><td><label>Curso de Formação/Universitário</label></td><td>
								<input name="curso"  id="curso" type="text" class="form-poshytip" title="Informe seu curso de formação" value="<?php echo $arrayUser['curso']; ?>"/></td><td><label>Estabelecimento em que se formou/Ano</label></td><td>
								<input name="univer"  id="univer" type="text" class="form-poshytip" title="Informe a faculdade/universidade" value="<?php echo $arrayUser['univer']; ?>" />/<input name="ano"  id="ano" type="text" class="form-poshytip" title="Informe o ano de formação" maxlength="4" size="10" value="<?php echo $arrayUser['ano']; ?>"/></td></tr>
                                <tr><td><label>Data de Admissão (DNIT)</label></td><td>
								<input name="dtadm"  id="dtadm" type="text" class="form-poshytip" title="Informe sua data de admissão no DNIT" value="<?php echo $arrayUser['dtadm']; ?>" /></td><td><label>Lotação/<br>UF</label></td><td>
								<input name="lotacao"  id="lotacao" type="text" class="form-poshytip" title="Informe sua lotação atual" value="<?php echo $arrayUser['lotacao']; ?>"/><br><select name="uflot">
                                <?php 
								if(empty($arrayUser['uflot'])){
								echo "<option value='0' selected>Selecione</option>";
								}else{
									echo "<option value='".$arrayUser['uflot']."' selected>".strtoupper($arrayUser['uflot'])."</option>";
									}
								?>
								?>
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
                                  </select></td></tr><tr><td><label>Endereço para Correspondência</label></td><td colspan="2"><input name="endereco"  id="endereco" type="text" class="form-poshytip" title="Informe seu endereço" size="60" value="<?php echo $arrayUser['endereco']; ?>"/><br><label>Nº</label><input name="num"  id="num" type="text" class="form-poshytip" title="Informe o número do imóvel" value="<?php echo $arrayUser['num']; ?>"/></td><td><label>Comp.</label><input name="comp"  id="comp" type="text" class="form-poshytip" title="Informe o complemento" value="<?php echo $arrayUser['comp']; ?>"/></td></tr>
                                <tr><td><label>Bairro</label><input name="bairro"  id="bairro" type="text" class="form-poshytip" title="Informe o bairro" value="<?php echo $arrayUser['bairro']; ?>" /></td><td><label>Cidade</label><input name="cidade"  id="cidade" type="text" class="form-poshytip" value="<?php echo $arrayUser['cidade']; ?>" title="Informe a cidade" /></td><td><label>UF</label>
								<select name="estado"><?php 
                                if(empty($arrayUser['estado'])){
								echo "<option value='0' selected>Selecione</option>";
								}else{
									echo "<option value='".$arrayUser['estado']."' selected>".strtoupper($arrayUser['estado'])."</option>";
									}
								?>
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
</td><td><label>CEP</label>
								<input name="cep"  id="cep" type="text" class="form-poshytip" title="Informe o CEP" maxlength="10" value="<?php echo $arrayUser['cep']; ?>"/></td></tr>
                                <tr><td colspan="4">
								<label>Tel. Resid.</label>
								<input name="resid"  id="resid" type="text" class="form-poshytip" title="Informe o telefone residencial" value="<?php echo $arrayUser['resid']; ?>"/>  <label>Tel. Celular</label>
								<input name="celular"  id="celular" type="text" class="form-poshytip" title="Informe o telefone celular" value="<?php echo $arrayUser['celular']; ?>"/>  <label>Tel. Trabalho</label>
								<input name="trabalho"  id="trabalho" type="text" class="form-poshytip" title="Informe o telefone do trabalho" value="<?php echo $arrayUser['trabalho']; ?>"/></td></tr>
                                <tr><td colspan="2"><label>E-mail de acesso ao site</label>
								<input name="email"  id="email" type="text" class="form-poshytip" title="Informe o e-mail, de preferência um pessoal" value="<?php echo $arrayUser['email']; ?>"/>
                                </td><td colspan="2"><label>Digite nova SENHA, caso queira alterar:</label>
								<input name="pass"  id="pass" type="password" class="form-poshytip" title="Digite uma nova senha, caso queira alterar"/></td></tr><tr><td colspan="4"><input type="submit" value="Atualizar" name="submit" id="submit" /></td></tr>
                                
                                </table>
			                   </fieldset>
					</form>
					<!-- ENDS form -->
				</div>
				<!-- ENDS column -->
				
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