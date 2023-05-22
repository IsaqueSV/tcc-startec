function mostrarOcultarSenhaA(){
	var senha=document.getElementById("cad_senha");

	if(senha.type=="password"){
		senha.type="text";
	}else{
		senha.type="password";
	}
}	// cria uma função que permite visualizar/ocultar o campo senha

$(document).ready(function(){

  $("#versenhaA").click(function(){
    if($(this).attr("class") == "fa-solid fa-eye") 
      $(this).attr("class", "fa-solid fa-eye-slash");
    else
      $(this).attr("class","fa-solid fa-eye");

  });
});	// cria uma função que muda de um icone para outro