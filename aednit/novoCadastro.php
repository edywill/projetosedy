<?php
require 'conect.php';

  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$matsiape=$_POST['matsiape'];//100
$name=$_POST['name'];//100
$nacio=$_POST['nacio'];//50
$natu=$_POST['natu'];//80
$ufnatu=$_POST['ufnatu'];
$dtnasc=$_POST['dtnasc'];//30
$sexo=$_POST['sexo'];//15
$profi=$_POST['profi'];//40
$curso=$_POST['curso'];//40
$univer=$_POST['univer'];//80
$ano=$_POST['ano'];//int
$cargo=$_POST['cargo'];//60
$matdnit=$_POST['matdnit'];//15
$dtadm=$_POST['dtadm'];//20
$lotacao=$_POST['lotacao'];//30
$uflot=$_POST['uflot'];
$endereco=$_POST['endereco'];//100
$num=$_POST['num'];//inteiro
$comp=$_POST['comp'];//20
$bairro=$_POST['bairro'];//50
$cidade=$_POST['cidade'];//50
$estado=$_POST['estado'];//10
$cep=$_POST['cep'];//14
$resid=$_POST['resid'];//20
$celular=$_POST['celular'];//20
$trabalho=$_POST['trabalho'];//20
$email=$_POST['email'];//80
$user=$_POST['email'];//40
$pass=$_POST['pass'];//20
require 'PasswordHash.php';
$t_hasher = new PasswordHash(8, FALSE);
$hash = $t_hasher->HashPassword($pass);
if(!empty($_POST['autorizo'])){
$autorizo='SIM';
}else{
$autorizo='NAO';	
	}
$valida=0;

if($autorizo=='NAO'){
	$valida=1;
	?>
       <script type="text/javascript">
       alert("Para cadastrar é necessário informar SIM na autorização de desconto.");
       history.back();
       </script>
       <?php
	}
	
	if(empty($dtnasc)){
			$valida=1;
			?>
       <script type="text/javascript">
       alert("Data de nascimento é obrigatório!");
       history.back();
       </script>
       <?php
			}
			
			if(empty($cargo)){
			$valida=1;
			?>
       <script type="text/javascript">
       alert("Cargo é um campo obrigatório!Caso seja aposentado informa aposentado!");
       history.back();
       </script>
       <?php	
				}
				
				if(empty($matdnit)){
				$valida=1;
				?>
       <script type="text/javascript">
       alert("A matrícula no DNIT é campo obrigatório!");
       history.back();
       </script>
       <?php
				}
				
				if(empty($matsiape)){
					$valida=1;
					?>
       <script type="text/javascript">
       alert("A matrícula do SIAPE é campo obrigatório!");
       history.back();
       </script>
       <?php
					}
					
					if(empty($lotacao)){
					$valida=1;
					?>
       <script type="text/javascript">
       alert("Lotação é obrigatórioi. Caso aposentado, informar Aposentado!");
       history.back();
       </script>
       <?php
						}
						
						if(empty($trabalho)){
							if(empty($celular)){
								if(empty($resid)){
									$valida=1;
									?>
       <script type="text/javascript">
       alert("Necessário informar ao menos um telefone!");
       history.back();
       </script>
       <?php
									}
								}
						}
		if(empty($user)){
		$valida=1;
		?>
       <script type="text/javascript">
       alert("Informe um usuário de acesso ao site!");
       history.back();
       </script>
       <?php
									}
									
		if(empty($pass)){
			$valida=1;
										?>
       <script type="text/javascript">
       alert("A senha deve ser informada!");
       history.back();
       </script>
       <?php
										}
										
											$sqlEmail=mysql_query("SELECT email FROM usuarios WHERE email='".$email."'") or die (mysql_error());
											$countEmail=mysql_num_rows($sqlEmail);
											$sqlUser=mysql_query("SELECT user FROM usuarios WHERE user='".$user."'") or die (mysql_error());
											$countUser=mysql_num_rows($sqlUser);
						if($countEmail>1 || $countUser>1){
												$valida=1;
												?>
												   <script type="text/javascript">
                                                   alert("Usuário / Email já cadastrados no site. Utilize a opção \"Esqueci minha senha\" !");
                                                   history.back();
                                                   </script>
                                                   <?php									
												}
												
												if($valida==0){
													$sqlInsertUser=mysql_query("INSERT INTO usuarios VALUES ('',
														 '".$name."','".$matsiape."','".$nacio."','".$natu."','".$ufnatu."','".$dtnasc."','".$sexo."','".$profi."','".$curso."','".$univer."','".$ano."','".$cargo."','".$matdnit."','".$dtadm."','".$lotacao."','".$uflot."','".$endereco."','".$num."','".$comp."','".$bairro."','".$cidade."','".strtoupper($estado)."','".$cep."','".$resid."','".$celular."','".$trabalho."','".$email."','".$user."','".$pass."','".$autorizo."','N','U','','".date("d/m/Y")."')") or die(mysql_error());
													$sqlContador=mysql_fetch_array(mysql_query("SELECT TOP id FROM phpbb_users"));
													$cont=$sqlContador['id']+1;
													$sqlInsertForum=mysql_query("INSERT INTO  phpbb_users VALUES (".$cont.",0,2,'',0,'187.104.219.40','1411935756','".$objUser->user."','".$objUser->user."','".$hash."','1411935756','0','".$objUser->email."','','','0','','0','','','0','0','0','0','0','0','0','pt_br','-3.00','0','D M d, Y h:i','1','0','','0','0','0','0','-3','0','0','t','d','0','t','a','0','1','0','1','1','1','1','230271','','0','0','0','','','','','','','','','','','','','','','9056a079fca18bd2',1,0,0)")or die (mysql_error());
$sqlGroup1=mysql_query("INSERT INTO phpbb_user_group VALUES (7,".$cont.",0,0)") or die(mysql_error());
$sqlGroup2=mysql_query("INSERT INTO phpbb_user_group VALUES(2,".$cont.",0,0)")or die(mysql_error());
												}else{
													?>
												   <script type="text/javascript">
                                                   alert("Ocorreu um erro! Tente novamente!");
                                                   history.back();
                                                   </script>
                                                   <?php
													}
													if($sqlInsertForum || $sqlInsertUser){														
														?>
												   <script type="text/javascript">
                                                   alert("Usuario inserido com sucesso! Utilize seu usuario e senha para logar no site!");
                                                   window.location="index.php";
                                                   </script>
                                                   <?php
														}else{
														?>
												   <script type="text/javascript">
                                                   alert("Ocorreu um erro! Tente novamente!");
                                                   history.back();
                                                   </script>
                                                   <?php
														}
?>