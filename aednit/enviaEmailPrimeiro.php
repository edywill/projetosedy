<?php 
require 'conect.php';
include "function.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$assunto="[AEDNIT] Novo Site (dados de acesso)";
$mensagemHtml="";
  $paginaRetorno="admin.php";
  $emailRetorno='';
  $contCaixa=0;
  $contCaixa2=1;
//$array=mysql_fetch_array($sql);
		$validaEnvio=0;
		$sqlEmails=mysql_query("SELECT email,name,user,id FROM usuarios");
		$sqlCount=mysql_num_rows($sqlEmails);
		$contador=0;
		
		while($obj=mysql_fetch_object($sqlEmails)){
		   	$para=$obj->email;
			$senha=geraSenha();
			$sqlUpdSenha=mysql_query("UPDATE usuarios SET pass='".$senha."' WHERE id='".$obj->id."'");
			$sqlUpdForum=mysql_query("UPDATE forum_users SET password='".md5($senha)."' WHERE id='".$obj->id."'");
			$mensagemHtml="Prezado(a) ".$obj->name.",<br><br>
A Associa&ccedil;&atilde;o dos Engenheiros do DNIT (AEDNIT) est&aacute; com um novo site. &Eacute; um site mais moderno e din&acirc;mico. <br>
Todos os nossos associados foram cadastrados no site automaticamente e por esse motivo, estamos encaminhando seu usu&aacute;rio e senha de acesso:<br><br>
<strong>LOGIN</strong>: ".$obj->user."<br>
<strong>SENHA</strong>: ".$senha."<br><br>
Com esse usu&aacute;rio voc&ecirc; poder&aacute; acessar os conte&uacute;dos exclusivos do site, fazer solicita&ccedil;&otilde;es e acessar o f&oacute;rum. S&atilde;o novas ferramentas de intera&ccedil;&atilde;o, buscando aproximar cada vez mais o associado.<br>
Acesse: http://www.aednit.org.br <br>
N&atilde;o deixe de conferir e deixar seu elogio, cr&iacute;tica ou sugest&atilde;o.<br><br>
Atenciosamente,<br>

<strong>Associa&ccedil;&atilde;o dos Servidores do Departamento de Infraestrutura em Transportes / AEDNIT</strong>";
			if($contador<90){
			$contador++;
			if($contCaixa==0){
						$emailRetorno='contato@aednit.org.br';
						$valida=enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
						}else{
							$emailRetorno='contato'.$contCaixa2.'@aednit.org.br';
							$valida=enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
							}
					if($valida==1){
						$validaEmail++;
						}
			}else{
					$contador=0;
					$contCaixa++;
					$contCaixa2++;
					}
			}
				
			// Se os dados forem inseridos com sucesso
			if ($validaEmail>0){
				echo "<script>alert('Enviado com sucesso!')</script>\n<script>window.location=('admin.php')</script>";
			}else{
				echo "<script>alert('Ocorreu um erro! Tente novamente')</script>\n<script>window.history.back()</script>";
				}
 
//Gerar Senha aleatoria
function geraSenha(){
                
                //caracteres que serão usados na senha randomica
                $chars2 = 'abcdxyswzABCDZYWSZ0123456789';
                //ve o tamnha maximo que a senha pode ter
                $max2 = strlen($chars2) - 1;
                //declara $senha
                $senha2 = null;
                
                //loop que gerará a senha de 8 caracteres
                for($i2=0;$i2 < 8; $i2++){
                        
                        $senha2 .= $chars2{mt_rand(0,$max2)};
        
                }
                return $senha2;          
        }
?>