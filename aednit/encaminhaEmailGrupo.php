<?php
require 'conect.php';
include "function.php";
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
  $assunto=trim($_POST['titulo']);
  $mensagemHtml=$_POST['descricao'];
  $paginaRetorno="admin.php";
  $foto = $_FILES["imagem"];
  $error=array();
  $emailRetorno='';
  $contCaixa=0;
  $contCaixa2=1;
 
		// Tamanho máximo do arquivo em bytes
		$tamanho = 5242880;
 
    	// Verifica se o arquivo é uma imagem
 if(empty($foto["name"])){
     	   $error[1] = "Informe o arquivo.";
   	 	}    	
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
   		 	$error[2] = "O arquivo deve ter no máximo 5 Mbytes";
		}
 
		// Se não houver nenhum erro
		if (count($error) == 0) {
 
			// Pega extensão da imagem
			preg_match("/.(pdf|doc|docx|xls|xlsx|ppt|pptx|gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "arquivos/" . $nome_imagem;
 
			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);
		$msgArquivo='Arquivo Anexo <a href="http://www.aednit.org.br/'.$caminho_imagem.'">clique aqui</a>.';
		}else{
			$msgArquivo='';
			}	
		$validaEnvio=0;
		$sqlEmails=mysql_query("SELECT email FROM usuarios");
		$sqlCount=mysql_num_rows($sqlEmails);
		
		$mensagemHtml=$mensagemHtml."<br><br>".$msgArquivo;
		$contador=0;
		
		while($obj=mysql_fetch_object($sqlEmails)){
		   	if($contador==0){
			$contador++;
			$para=$obj->email;
			}elseif($contador<40){
				$contador++;
				$para=$para.";".$obj->email;
				}elseif($contador==40){
					if($contCaixa<2){
						$emailRetorno='contato@aednit.org.br';
						$valida=enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
						}elseif(($contCaixa%2)==0){
							$emailRetorno='contato'.$contCaixa2.'@aednit.org.br';
							$valida=enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
							$contCaixa2++;
							}
					$contCaixa++;
					$contador=0;
					if($valida==1){
						$validaEmail++;
						}
					}
			}
		   $sql = mysql_query("INSERT INTO files VALUES ('', '".$assunto."', '".$mensagemHTML."', '".$caminho_imagem."','D','".date("d/m/Y")."')") or die(mysql_error());
				
			// Se os dados forem inseridos com sucesso
			if ($validaEmail>0){
				echo "<script>alert('Enviado com sucesso!')</script>\n<script>window.location=('admin.php')</script>";
			}else{
				echo "<script>alert('Ocorreu um erro! Tente novamente')</script>\n<script>window.history.back()</script>";
				}
 
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo "<script>alert('".$erro."')</script>\n<script>window.history.back()</script>";
			}
		}
?>