jQuery(document).ready(function($) {

	// hide messages 
	$("#error").hide();
	$("#success").hide();
	
	// on submit...
	$("#contactForm #submit").click(function() {
		$("#error").hide();
		
		//required:
		
		//name
		var name = $("input#name").val();
		if(name == ""){
			$("#error").fadeIn().text("Nome obrigat�rio");
			$("input#name").focus();
			return false;
		}
		
		//nacio
		var nacio = $("input#nacio").val();
		if(nacio == ""){
			$("#error").fadeIn().text("Necess�rio informar a nacionalidade");
			$("input#nacio").focus();
			return false;
		}
		//nacio
		var natu = $("input#natu").val();
		if(natu == ""){
			$("#error").fadeIn().text("Necess�rio informar a naturalidade");
			$("input#natu").focus();
			return false;
		}
		//dtnasc
		var dtnasc = $("input#dtnasc").val();
		if(dtnasc == ""){
			$("#error").fadeIn().text("Necess�rio informar a Data de nascimento");
			$("input#nacio").focus();
			return false;
		}
		// sexo
		var sexo = $("input#sexo").val();
		if(sexo == ""){
			$("#error").fadeIn().text("Necess�rio informar o sexo");
			$("input#sexo").focus();
			return false;
		}
		// estcivil
		var estcivil = $("input#estcivil").val();
		if(estcivil == ""){
			$("#error").fadeIn().text("Necess�rio informar o estado civil");
			$("input#estcivil").focus();
			return false;
		}
	// cargo
		var cargo = $("input#cargo").val();
		if(cargo == ""){
			$("#error").fadeIn().text("Necess�rio informar  o cargo");
			$("input#cargo").focus();
			return false;
		}
		// matdnit
		var matdnit = $("input#matdnit").val();
		if(matdnit == ""){
			$("#error").fadeIn().text("A matr�cula � obrigat�ria");
			$("input#matdnit").focus();
			return false;
		}
		// endere�o
		var endereco = $("input#endereco").val();
		if(endereco == ""){
			$("#error").fadeIn().text("Informe o endere�o");
			$("input#endereco").focus();
			return false;
		}
		// bairro
		var bairro = $("input#bairro").val();
		if(bairro == ""){
			$("#error").fadeIn().text("Informe o bairro");
			$("input#bairro").focus();
			return false;
		}
		// cidade
		var cidade = $("input#cidade").val();
		if(cidade == ""){
			$("#error").fadeIn().text("Informe o cidade");
			$("input#cidade").focus();
			return false;
		}
		// estado
		var estado = $("input#estado").val();
		if(estado == ""){
			$("#error").fadeIn().text("Informe o estado");
			$("input#estado").focus();
			return false;
		}
		// trabalho
		var trabalho = $("input#trabalho").val();
		if(trabalho == ""){
			$("#error").fadeIn().text("Informe o telefone do trabalho ou residencial");
			$("input#trabalho").focus();
			return false;
		}
	// email
		var email = $("input#email").val();
		if(email == ""){
			$("#error").fadeIn().text("Email obrigat�rio");
			$("input#email").focus();
			return false;
		}
		// user
		var user = $("input#user").val();
		if(user == ""){
			$("#error").fadeIn().text("Informe usuario de acesso.");
			$("input#user").focus();
			return false;
		}
		// pass
		var pass = $("input#pass").val();
		if(pass == ""){
			$("#error").fadeIn().text("Informe a senha.");
			$("input#pass").focus();
			return false;
		}
	});  
		
		
	// on success...
	 function success(){
	 	$("#success").fadeIn();
	 	$("#contactForm").fadeOut();
	 }
	
    return false;
});

