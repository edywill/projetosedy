<?php
require 'conect.php';
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$id=$_POST['id'];
$matsiape=$_POST['matsiape'];
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
$pass=trim($_POST['senha']);//20
require 'PasswordHash.php';
$t_hasher = new PasswordHash(8, FALSE);
$hash = $t_hasher->HashPassword($pass);
$valida=0;	
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
       alert("Cargo é um campo obrigatório!");
       history.back();
       </script>
       <?php	
				}
				
				if(empty($matdnit)){
					$valida=1;
					?>
       <script type="text/javascript">
       alert("A matrícula no DNIT ou SIAPE é campo obrigatório!");
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
							
							if(empty($_POST['senha'])){
										    $sqlPass=mysql_query("SELECT pass FROM usuarios WHERE id=".$id."") or die (mysql_error());
											$arrayPass=mysql_fetch_array($sqlPass);
											$pass=$arrayPass['pass'];
							}
											
											$sqlEmail=mysql_query("SELECT email FROM usuarios WHERE email='".$email."'") or die (mysql_error());
											$countEmail=mysql_num_rows($sqlEmail);
											$sqlEmailAnt=mysql_fetch_array(mysql_query("select email from usuarios where id='".$id."'"));
					if($countEmail>1){
						$valida=1;
												?>
												   <script type="text/javascript">
                                                   alert("Email já cadastrados no site. Utilize a opção \"Esqueci minha senha\" !");
                                                   history.back();
                                                   </script>
                                                   <?php									
												}
												
												if($valida==0){
												$sqlUpdateUser=mysql_query("UPDATE usuarios SET  name='".$name."',matsiape='".$matsiape."',nacio='".$nacio."',natu='".$natu."',ufnatu='".$ufnatu."',dtnasc='".$dtnasc."',sexo='".$sexo."',profi='".$profi."',curso='".$curso."',univer='".$univer."',ano='".$ano."',cargo='".$cargo."',matdnit='".$matdnit."',dtadm='".$dtadm."',lotacao='".$lotacao."',uflot='".$uflot."',endereco='".$endereco."',num='".$num."',comp='".$comp."',bairro='".$bairro."',cidade='".$cidade."',estado='".strtoupper($estado)."',cep='".$cep."',resid='".$resid."',celular='".$celular."',trabalho='".$trabalho."',email='".$email."',user='".$user."',pass='".$pass."',dtalt='".date("d/m/Y")."' WHERE id=".$id."") or die(mysql_error());
													
													$sqlUpdateForum=mysql_query("UPDATE phpbb_users SET user_password='".$hash."',
																											user_email='".$email."',
																											username='".$email."',
																											username_clean='".$email."' 
																											WHERE username=".$sqlEmailAnt['email']."") or die(mysql_error());
												}else{
													?>
												   <script type="text/javascript">
                                                   alert("Ocorreu um erro! Tente novamente!");
                                                   history.back();
                                                   </script>
                                                   <?php
													}
													if($sqlUpdateForum || $sqlUpdateUser){
														?>
												   <script type="text/javascript">
                                                   alert("Usuario Atualizado com sucesso!");
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