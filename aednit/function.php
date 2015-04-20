<?php
//Função genérica para envio de e-mail

function enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$paraQ){
// Este sempre deverá existir para garantir a exibição correta dos caracteres
$headers = "MIME-Version: 1.1\n";
 
// Para enviar o e-mail em formato texto com codificação de caracteres Europeu Ocidental (usado no Brasil)
$headers .= "Content-type: text/plain; charset=utf-8\n";
  
// Para enviar o e-mail em formato HTML com codificação de caracteres Unicode (Usado em todos os países)
$headers .= "Content-type: text/html; charset=utf-8\n";
 
// Para enviar o e-mail em formato HTML com codificação de caracteres Unicode (Usado em todos os países)
$headers .= "From: Site AEDNIT <".$emailRetorno.">\n";

// E-mail que receberá a resposta quando se clicar no 'Responder' de seu leitor de e-mails
$headers .= "Reply-To: ".$emailRetorno."\n";

$envio = mail($paraQ, $assunto, $mensagemHtml, $headers,"-r".$emailRetorno);

if($envio){
	   if($paginaRetorno=='admin.php'){
		   return 1;
		   }else{
	   ?>
       <script type="text/javascript">
       alert("Email enviado com sucesso!");
       window.location.href = '<?php echo $paginaRetorno; ?>';
       </script>
       <?php
		   }
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro! Tente Novamente!");
       history.back();
       </script>
       <?php
		}
}

?>