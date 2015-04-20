<?php
require 'conect.php';
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
  $id=$_POST['id'];
  $titulo=trim($_POST['titulo']);
  $autor=trim($_POST['autor']);
  $descricao=$_POST['descricao'];
  $foto = $_FILES["imagem"];
  $error=array();
  $tipo=$_POST['tipo'];
$tamanho = 5242880;
	// Se a foto estiver sido selecionada
if (!empty($foto["name"])) {	    	
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
		}
}else{
			$caminho_imagem=$_POST['imagem1'];
			}
		// Insere os dados no banco
			$sql = mysql_query("UPDATE files SET titulo='".$titulo."',autor='".$autor."', descricao='".$descricao."',imagem1='".$caminho_imagem."',tipo='".$tipo."' WHERE id=".$id."") or die (mysql_error());;
 
			// Se os dados forem inseridos com sucesso
			if ($sql){
				echo "<script>alert('Atualizado com sucesso!')</script>\n<script>window.location=('admin.php')</script>";
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