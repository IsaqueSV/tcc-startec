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
	<title>Quem somos</title>
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
		<label class="h5" id="titulo-label">QUEM SOMOS</label>
		<button id="titulo-btn"><i class="fa-solid fa-question"></i></button>
	</div>

	<div style="display: flex; width: 80%; height: 400px; margin-top: 5%; margin-bottom: 6%; margin-left: 10%; margin-right: 10%;">
		<div style="width: 45%; height: 400px; margin-right: 1%; border-radius: 3px;">
			<img src="dados/img/banners/imagem.png" style="width: 100%; height: 340px; border-radius: 3px; border: 1px solid white;">
			<label style="width: 100%; height: 60px; text-align: center; padding: 1%; margin-top: 2%; border-radius: 3px; background: rgb(69,210,251); background: linear-gradient(90deg, rgba(69,210,251,0.15449929971988796) 0%, rgba(170,57,238,0.1516981792717087) 80%, rgba(221,21,246,0.14609593837535018) 100%); color: white;">Felipe D.Z. - Isaque S.V. - Juan V.A. - Maria Eduarda P.S. - Lawany Gabriele L.S.</label>
		</div>
		<div style="width: 53%; height: 400px; margin-left: 1%;">
			<label style="width: 100%; height: 60px; border-radius: 3px; text-align: center; margin-bottom: 2%; padding-top: 2%; padding-bottom: 2%; background-color: #172f54; color: white; border-radius: 15px;">
				<h3>UM POUCO SOBRE NÓS...</h3>
			</label>
			<label style="width: 100%; height: 340px; border-radius: 20px; font-size: 20px; text-align: justify-all; padding: 2%; background-color: #2a3550; color: white;">
				A equipe LOTUS, vinculada à Etec de Itanhaém, é  a responsável por atuar na área de construção e desenvolvimento de sites para a internet.<br>
				Este manual contempla os aspectos relacionados ao uso do logotipo da equipe na internet. É importante seguir os procedimentos descritos a fim de alcançarmos os objetivos propostos.<br>
				Dentre eles fazer do logotipo da LOTUS uma ferramenta de uso comum, decorrente de uma padronização visual consistente, agregando valores de modernidade, confiança e qualidade.
			</label>
		</div>
	</div>
	
	<!-- Modal (resultado-pesquisa) -->
	<div class="modal" tabindex="-1" id="modal"></div>
	<div class="modal" tabindex="-1" id="cadastrar-login"></div>
	

	
	<!--<i class="fa-regular fa-circle-question"></i>-->
</body>
</html>