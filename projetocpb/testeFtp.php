<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
if( $_SERVER['REQUEST_METHOD']=='POST' )
{
	if(!empty($_POST['arquivo'])){
	require("conectftp.php");  
	    if(is_dir($cheqftp.'CIWEB')){
			 echo "existe";
			 }else{
				 ftp_mkdir($con_id,'CIWEB');
				 echo "criado";
				 }
		  
        $caminho_absoluto = "CIWEB\\";
        $arquivo = $_FILES['arquivo'];
		if(ftp_put( $con_id, $caminho_absoluto.$arquivo['name'], $arquivo['tmp_name'], FTP_BINARY )){
																		  echo "Ok";
																		  }else{
																			  echo "Erro!";
																			  }
																			  ftp_close($con_id);
	}else{
		echo "informe arquivo";
		}
}
?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="arquivo" />
                <input type="submit" name="enviar" value="Enviar" />
        </form>
</body>
</html>