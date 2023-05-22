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
	<!--
		adiciona foto no site 
		<link rel="icon" href="dados/img/ft_usuarios/user.jpg"> 
	-->
	<title>Home</title>
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
	
	<!-- Modal (resultado-pesquisa) -->
	<div class="modal" tabindex="-1" id="modal"></div>
	<div class="modal" tabindex="-1" id="cadastrar-login"></div>

	<div id="demo" class="carousel slide" data-ride="carousel" style="width: 80%; border-radius: 8px; margin-top: 4%; margin-bottom: 3%; margin-left: 10%; margin-right: 10%; border: 1px solid white;">
	  	<!-- Indicators -->
		<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
		    <li data-target="#demo" data-slide-to="1"></li>
		    <li data-target="#demo" data-slide-to="2"></li>
		</ul>
	  	
	  	<!-- The slideshow -->
	  	<div class="carousel-inner">
	    	<div class="carousel-item active">
	      		<img style="border-radius: 8px; width: 100%;" src="dados/img/banners/1.png" alt="Los Angeles" width="1100" height="500">
	    	</div>
	    	<div class="carousel-item">
	      		<img style="border-radius: 8px; width: 100%;" src="dados/img/banners/2.png" alt="Chicago" width="1100" height="500">
	    	</div>
	    	<div class="carousel-item">
	      		<img style="border-radius: 8px; width: 100%;" src="dados/img/banners/3.png" alt="New York" width="1100" height="500">
	    	</div>
	    	<div class="carousel-item">
	      		<img style="border-radius: 8px; width: 100%;" src="dados/img/banners/4.png" alt="New York" width="1100" height="500">
	    	</div>
	    	<div class="carousel-item">
	      		<img style="border-radius: 8px; width: 100%;" src="dados/img/banners/5.png" alt="New York" width="1100" height="500">
	    	</div>
	  	</div>
	  
	  	<!-- Left and right controls -->
	  	<a class="carousel-control-prev" href="#demo" data-slide="prev">
	    	<span class="carousel-control-prev-icon"></span>
	  	</a>
	  	<a class="carousel-control-next" href="#demo" data-slide="next">
	    	<span class="carousel-control-next-icon"></span>
	  	</a>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>