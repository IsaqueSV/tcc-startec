<?php
	include('banco/conexao.php');
	session_start();
	if((isset ($_SESSION['cdUsuario']) == true) and (isset ($_SESSION['idNivel']) == true)){
		if($_SESSION['idNivel'] == 1){
			header('Location: home_aluno.php');
		}if($_SESSION['idNivel'] == 2){
			header('Location: home_empresa.php');
		}if($_SESSION['idNivel'] == 3){
			header('Location: home_adm.php');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ajuda</title>
	<!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
	<!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
    <!-- Jquery Mask <script src="css/local/js/jquery.mask.min.js"></script> -->
	<!-- CSS --><link rel="stylesheet" href="css/navbar.css">
	<!-- CSS --><link rel="stylesheet" href="css/geral.css">
	<!-- CSS --><link rel="stylesheet" href="css/footer.css">
	<script>
		$(document).ready(function(){
			$("#resultado").hide();

			$("#btn-pesquisa").click(function(){
				$.ajax({
					url: "config/pesquisa-usuario.php",
				    type: "POST",
				    data: "text-pesquisa="+$("#text-pesquisa").val() + "&select-pesquisa="+$("#select-pesquisa").val(),
				    dataType: "html"
				}).done(function(resposta) {
				    $("#resultado-pesquisa").html(resposta);
				}).fail(function(jqXHR, textStatus ) {
				    console.log("Request failed: " + textStatus);
				}).always(function() {
				    console.log("completou");
				});
			});
		});

		function myFunction() {
 			document.getElementById("myDropdown").classList.toggle("show");
		}

		window.onclick = function(event) {
  			if(!event.target.matches('.dropbtn')) {
    			var dropdowns = document.getElementsByClassName("dropdown-content");
    			var i;
    			for (i = 0; i < dropdowns.length; i++) {
      				var openDropdown = dropdowns[i];
      				if (openDropdown.classList.contains('show')) {
        				openDropdown.classList.remove('show');
      				}
    			}
  			}
		}
	</script>
</head>
<body>
	<!-- Navbar (topo) -->
	<nav class="navbar" id="nav-topo">
		<div class="container-fluid" id="div-topo">
			<a class="navbar-brand" href="index.php" id="a-topo">
				STAR TEC
			</a>
			<div class="dropdown">
  				<button onclick="myFunction()" class="dropbtn">CADASTRAR-SE</button>
  				<div id="myDropdown" class="dropdown-content">
    				<a href="cadastrar_aluno.php">Aluno</a>
    				<a href="cadastrar_empresa.php">Empresa</a>
  				</div>
			</div>
		</div>
	</nav>

	<style>
		a.nav-link#li-a{
			color: white;
			transition: 0.5s ease;
		}
		a.nav-link#li-a:hover{
			transition: 0.5s ease;
			color: gray;
		}

		.dropbtn{
			background-color: rgba(10,23,55,0);
			transition: 0.5s ease;
		  	color: white;
		  	padding: 16px;
		  	font-size: 16px;
		  	border: none;
		  	cursor: pointer;
		}

		.dropbtn:hover, .dropbtn:focus{
		  	opacity: 70%;
			transition: 0.5s ease;
		}

		.dropdown{
		  	position: relative;
		  	display: inline-block;
		}

		.dropdown-content{
		  	display: none;
		  	position: absolute;
		  	background-color: #f1f1f1;
		  	min-width: 160px;
		  	overflow: auto;
		  	box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		  	z-index: 1;
		}

		.dropdown-content a{
		  	color: black;
		  	padding: 12px 16px;
		  	text-decoration: none;
		  	display: block;
		}

		.dropdown a:hover {background-color: #ddd;}

		.show {display: block;}
	</style>

	<!-- Navbar (navega) -->
	<nav class="nav nav-pills nav-justified" id="nav-navega">
  		<a class="nav-link p-3" id="a-navega-a" href="sobre_nao_logado.php">Quem somos</a>
  		<a class="nav-link p-3" id="a-navega-b" href="projetos_nao_logado.php">Projetos</a>
  		<a class="nav-link p-3" id="a-navega-c" href="escolas_nao_logado.php">Escolas</a>
  		<a class="nav-link p-3" id="a-navega-f" href="ajuda_nao_logado.php">Ajuda</a>
	</nav>

	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">AJUDA</label>
		<button id="titulo-btn"><i class="fa-solid fa-question"></i></button>
	</div>

	<!-- Barra de pesquisa (pesquisa) -->
	<div class="input-group mb-3" id="div-pesquisa">
		<select class="form-select form-select-sm p-3" id="select-pesquisa">
			<option value=" " selected title="Filtrar busca">Filtros</option>
			<option value="1">Aluno</option>
			<option value="2">Empresa</option>
		</select>
		<input type="text" class="form-control" placeholder="Pesquise algo..." id="text-pesquisa">
  		<button class="btn" type="button" id="btn-pesquisa"><i class="fa-solid fa-magnifying-glass" id="i-pesquisa"></i></button>
	</div>

	<!-- Resultado (resultado-pesquisa) -->
	<div class="alert" id="resultado" role="alert">
		<span id="resultado-pesquisa"></span>
	</div>

	<div style="width: 80%; margin-top: 5%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">TIPOS DE USUÁRIO</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Em nosso site você, nosso querido usuário, possui acesso a uma gama diversa de conteúdos que podem ser acessados por dois tipos de usuários, sendo eles: o ALUNO e a EMPRESA. Ambos possuem diferentes funcionalidades que possuem grande importância para a existência de nossa comunidade.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">O QUE UM ALUNO PODE FAZER?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Os nossos navegantes que se cadastraram/logaram como alunos podem desfrutar de algumas ferramentas, sendo elas: <br> - A confecção e gerenciamento de projetos que sejam voltados para o ramo de programação, o que por consequência acaba por desenvolver um portfólio para o aluno autor; <br> - A confecção de seu currículo, o qual o usuário pode usar do mesmo para encontrar e candidatar-se a vagas; <br> - A interação com nossos outros usuários através do campo de comentários, encontrados em projetos, currículos e vagas.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">O QUE UMA EMPRESA PODE FAZER?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;"> Já os navegantes que optarem por seguir como emrpesas podem desfrutar das seguintes funções: <br> - A confecção e gerenciamento de vagas de emprego voltadas ao ramo de programação; <br> - A visualização de todos os currículos já registrados em nosso site; <br> - A interação com os outros usuários de nosso site através de comentários, assim como já citado acima.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">COMO CRIAR UM CURRÍCULO?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Primeiramente, vale ressaltar que tal ação esta presente apenas para os usuários que efetuarem um cadastro/login como aluno. Sendo assim, o usuário deve acessar a página MEU CURRÍCULO e, no caso de ainda não possuir um, deve clicar no ícone de adição (+) encontrado logo após o título MEU CURRÍCULO. Após isso o usuário será direcionado para outra página, na qual todos os campos (obrigatórios) devem ser preenchidos e então salvos e publicados, através do botão PUBLICAR. <br> Com o currículo já publicado, seu autor pode edita-lo ou até mesmo deletar-lo.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">COMO CRIAR UMA VAGA?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Esta ação pode ser realizada apenas por usuários cadastrados/logados como empresa. Acessando a página MINHAS VAGAS o usuário deve clicar no ícone de adição (+) encontrado logo após o título MINHAS VAGAS. Sendo assim, o usuário será direcionado para uma página na qual todos os campos devem ser preenchidos e então salvos e publicados, através do botão PUBLICAR. <br> Com a vaga já publicada, seu autor pode edita-la ou até mesmo deleta-la.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">COMO CRIAR UM PROJETO?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Tal ação pode ser feita apenas por usuários cadastrados/logados como aluno. Acessando a páginas PROJETOS o usuário deve clicar no ícone de adição (+) encontrado logo após o título PROJETOS. Com isso, o usuário é direcionado para uma página na qual todos os campos devem ser preenchidos e então salvos e publicados, através do botão PUBLICAR. <br> Com o projeto já publicado, seu autor pode edita-lo ou até mesmo deletar-lo.</label>
	</div>

	<div style="width: 80%; margin-top: 2%; margin-bottom: 2%; margin-left: 10%; margin-right: 10%;">
		<label class="h4" id="titulo-label" style="padding: 1%; width: 100%; border-radius: 3px; text-align: center; margin-bottom: 1; background-color: #172f54; color: white; border-radius: 10px;">COMO DENUNCIAR PROJETOS, CURRÍCULOS, VAGAS OU USUÁRIOS INDEVIDOS?</label>

		<label style="padding: 2%; padding-left: 2%; padding-right: 2%; width: 100%; border-radius: 3px; text-align: justify-all; margin-bottom: 2%; background-color: white; color: black; border-radius: 10px;">Caso encontrem algo que vá contra as diretrizes de nosso site, todos os usuários (logados) podem denunciar projetos, currículos, vagas e até mesmo usuários. Após isso tais denuncias serão analisadas e devidamente tratadas por nossa equipe de gestão.</label>
	</div>

	
	<!-- Modal (resultado-pesquisa) -->
	<div class="modal" tabindex="-1" id="modal"></div>
	<div class="modal" tabindex="-1" id="cadastrar-login"></div>
	  
</body>
</html>