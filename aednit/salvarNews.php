<?php
require 'conect.php';
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
  $titulo=trim($_POST['titulo']);
  $descricao=$_POST['descricao'];
  $foto = $_FILES["imagem"];
  $error=array();
  $destaque=0;

if(!empty($_POST['destaque'])){
	  $destaque=1;
	  }
	// Se a foto estiver sido selecionada
	if (!empty($foto["name"])) {
 
		// Largura máxima em pixels
		$largura = 1000;
		// Altura máxima em pixels
		$altura = 1000;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 2097152;
 
    	// Verifica se o arquivo é uma imagem
 if(empty($foto["name"])){
     	   $error[1] = "Informe o arquivo.";
   	 	}    	
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
 
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[1] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}
 
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[2] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
 
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
   		 	$error[3] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}
 
		// Se não houver nenhum erro
		if (count($error) == 0) {
 
			// Pega extensão da imagem
			preg_match("/.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos/" . $nome_imagem;
 
			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);
		}
		}else{
			$caminho_imagem='fotos/imagempadrao.png';
			}
			
			if($destaque==1 && $caminho_imagem<>'fotos/imagempadrao.png'){
		       // Verifica se a largura da imagem é maior que a largura permitida
				if($dimensoes[0] > 906 || $dimensoes[1] > 390 || $dimensoes[0] < 906 || $dimensoes[1] < 390) {
				echo "<script>alert('Atencao a imagem encontra-se com as dimensoes incorretas (906 x 390)')</script>\n<script>window.history.back()</script>";	
				}
     		}
			// Insere os dados no banco
			$sql = mysql_query("INSERT INTO news VALUES ('', '".$titulo."', '".$descricao."', '".$caminho_imagem."',".$destaque.",'".date("d/m/Y")."')");
 
			// Se os dados forem inseridos com sucesso
			if ($sql){
				echo "<script>alert('Inserido com sucesso!')</script>\n<script>window.location=('admin.php')</script>";
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