<?php 
include "valida.php";
if(empty($_SESSION['usuarioPerfil'])){
	unset($_SESSION['usuarioID']);
	}
echo "<meta charset='utf-8'>";
$login="<a href='login.php'><input type='button' value='Login'/></a>";
echo "<!-- WRAPPER -->
		<div id='wrapper'>
					<!-- HEADER -->
			<div id='header'>
				<a href='index.php'><p align='center'><br>
				  <img src='images/cabecalhoAEDNIT_0.png' width='902' height='55'></p>
				</a>				
				<!-- Navigation -->
		  <ul id='nav' class='sf-menu'>
					<li><a href='index.php'>INÍCIO</a></li>
					<li><a href='#'>INSTITUCIONAL</a>
						<ul>
							<li><a href='diretoria.php'><span> DIRETORIA</span></a></li>
							<li><a href='objetivos.php'><span> OBJETIVOS</span></a></li>
							<li><a href='aposentadoria.php'><span>APOSENTADORIA</span></a></li>
                            <li><a href='parcerias.php'><span>PARCERIAS</span></a></li>
                            <li><a href='contato.php'><span>FALE CONOSCO</span></a></li>
						</ul>
					</li>
					<li><a href='noticias.php'>NOTÍCIAS</a></li>";
if(!empty($_SESSION['usuarioID'])){
	$login="<a href='logout.php'><input type='button' value='Logout'/></a>";
	echo "<li><a href='#'>ASSOCIADOS</a>
                        <ul>
							<li><a href='aniversariantes.php'><span> ANIVERSARIANTES </span></a></li>
							<li><a href='cadastro.php'><span> CADASTRO </span></a></li>
							<li><a href='solicitacao.php'><span> SOLICITAÇÃO </span></a></li>
                        </ul>
					</li>
					<li><a href='#'>ARQUIVOS</a>
					   <ul>
							<li><a href='arqDocs.php'><span> DOC./FICHAS</span></a></li>
							<li><a href='arqLeis.php'><span>LEIS/TEXTOS</span></a></li>
							<li><a href='arqPrest.php'><span>PRESTACAO DE CONTAS</span></a></li>
							<li><a href='arqTrab.php'><span>TRABALHOS TECNICOS</span></a></li>
						</ul>
                    </li>";
					if($_SESSION['usuarioPerfil']=='A'){
						echo "<li><a href='admin.php'>ADMINISTRAR</a></li>";
						}
	}else{
		echo "<li><a href='filia.php'>INSCREVA-SE</a></li>";
		}
		
                    
                    
					
                   echo" <li><a href='#'>LINKS</a>
						<ul>
							<li><a href='http://www.dnit.gov.br'><span> DNIT </span></a></li>
							<li><a href='http://www.condsef.org.br'><span> CONDSEF </span></a></li>
							<li><a href='http://www.confea.org.br'><span> CONFEA </span></a></li>
							<li><a href='http://www.transportes.gov.br'><span> MT </span></a></li>
                            <li><a href='http://www.sengedf.com.br/'><span> SENGE-DF </span></a></li>
						</ul>
					</li>
					<li><a href='forum/index.php' target='_blank'><span>FÓRUM</span></a></li>
				</ul>
				<!-- Navigation -->	";
				
				
				echo "<!-- search -->
				<div class='top-search'>
					<form  method='get' id='searchform' action='#'>
						<div>
							".$login."
						</div>
					</form>
				</div>
				<!-- ENDS search -->";
				
				echo "<!-- headline -->
				<div id='headline'></div>
				<!-- ENDS headline -->";
				?>