var navegador = navigator.userAgent.toLowerCase(); 

//Cria uma vari�vel global chamada 'xmlhttp'
var xmlhttp; 
//Fun��o que inicia o objeto XMLHttpRequest
function objetoXML() {
	if (navegador.indexOf('msie') != -1) { //Internet Explorer
		var controle = (navegador.indexOf('msie 5') != -1) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP';
		try {

			xmlhttp = new ActiveXObject(controle); //Inicia o objeto no IE
		} catch (e) { }
	} else { //Firefox, Safari, Mozilla
		xmlhttp = new XMLHttpRequest(); //Inicia o objeto no Firefox, Safari, Mozilla
	}
}
//Fun��o que envia o formul�rio
function enviarForm(url, campos, destino) {

	//Atribui � vari�vel 'elemento' o elemento que ir� receber a p�gina postada
	var elemento = document.getElementById(destino); 
	//Executa a fun��o objetoXML()
	objetoXML(); 
	//Se o objeto de 'xmlhttp' n�o estiver true
	if (!xmlhttp) {
		//Insere no 'elemento' o texto atribu�do
		elemento.innerHTML = 'Imposs�vel iniciar o objeto XMLHttpRequest.'; 
		return;
	} else { 
		//Insere no 'elemento' o texto atribu�do
		elemento.innerHTML = 'Salvando...'; 
	}
	xmlhttp.onreadystatechange = function () {
		//Se a requisi��o estiver completada
		if (xmlhttp.readyState == 4 || xmlhttp.readyState == 0) { 
			//Se o status da requisi��o estiver OK
			if (xmlhttp.status == 200) {
				//Insere no 'elemento' a p�gina postada
					if(xmlhttp.responseText!='1'){
						
						$("#divResultado").jui_alert({
    				containerClass: "jui-modal-alert",
    				message: xmlhttp.responseText,
    				timeout: 0,
    				messageIconClass: ""
 				 });
					}else{
						$("#divResultado").jui_alert({
    					containerClass: "jui-modal-sucess",
    					message: " <p align='center'>INSERIDO COM SUCESSO!</p>",
    					timeout: 6000,
    					messageIconClass: ""
 				 	});
						reescreveTabelas();
						}
				  
				 					
				//elemento.innerHTML = 
				//elemento.slideDown();
					
			} else { 
				//Insere no 'elemento' o texto atribu�do
				elemento.innerHMTL = 'P�gina n�o encontrada!'; 
			}
		}
	}

	//Abre a p�gina que receber� os campos do formul�rio
	xmlhttp.open('POST', url+'?'+campos, true);

	//Envia o formul�rio com dados da vari�vel 'campos' (passado por par�metro)
	xmlhttp.send(campos); 

}
