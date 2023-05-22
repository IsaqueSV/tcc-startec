<?php
	include('banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: index.php');
	}
	if($_SESSION['idNivel'] == 1){
		header('Location: home_aluno.php');
	}if($_SESSION['idNivel'] == 3){
		header('Location: home_adm.php');
	}

	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	$sql = "SELECT path_foto_usuario FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$row_usuario = mysqli_fetch_assoc($query);

	$img_caminho = $row_usuario['path_foto_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Escolas</title>
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
	</script>
	<style>
		.accordion {
			background-color: #eee;
		  	color: #444;
		  	cursor: pointer;
		  	padding: 18px;
		  	width: 100%;
		  	border: none;
		  	text-align: center;
		  	outline: none;
		  	font-size: 15px;
		  	transition: 0.4s;
		}
		.active, .accordion:hover {
  			background-color: #ccc; 
		}

		.a1{
			width: 83%; 
			margin-left: 8.5%; 
			margin-right: 8.5%; 
			display: flex;
		}

		.a{
			margin-left: 2%;
		}

		.b{
			margin-right: 2%;
		}

		.c{
			margin-left: 2%;
		}

		.d{
			margin-right: 2%;
		}



		.panel {
  			padding: 8px 18px;
  			display: none;
  			background-color: white;
  			width: 100%;
  			overflow: hidden;
		}
	</style>
</head>
<body>
	<!-- Navbar (topo) -->
	<nav class="navbar" id="nav-topo">
		<div class="container-fluid" id="div-topo">
			<a class="navbar-brand" href="home_empresa.php" id="a-topo">
				STAR TEC
			</a>
			<ul class="nav justify-content-end" id="ul-topo">
				<li class="nav-item" id="li-topo">
					<a class="nav-link" title="Meu perfil" id="li-a" href="meu_perfil.php" style="padding-right: 0; padding-left: 0;">
						<img src="<?php echo $img_caminho; ?>" id="li-img" class="rounded-circle" style="margin: 0; width: 40px; height: 40px;">
					</a>
				</li>
				<li class="nav-item" id="li-topo">
					<a class="nav-link" href="config/finaliza-sessao.php" id="a-sair" style="margin-left: 35px; margin-bottom: 0; margin-top: 15px;">Sair</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- Navbar (navega) -->
	<nav class="nav nav-pills nav-justified" id="nav-navega">
  		<a class="nav-link p-3" id="a-navega-a" href="sobre_empresa.php">Quem somos</a>
  		<a class="nav-link p-3" id="a-navega-b" href="projetos_empresa.php">Projetos</a>
  		<a class="nav-link p-3" id="a-navega-c" href="escolas_empresa.php">Escolas</a>
  		<a class="nav-link p-3" id="a-navega-d" href="vagas_empresa.php">Minhas vagas</a>
  		<a class="nav-link p-3" id="a-navega-e" href="curriculos_empresa.php">Currículos</a>
  		<a class="nav-link p-3" id="a-navega-f" href="ajuda_empresa.php">Ajuda</a>
	</nav>

	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">ESCOLAS</label>
		<button id="titulo-btn"><i class="fa-solid fa-bookmark"></i></button>
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
<br>
	<!-- Escolas (conteúdo) -->
	
<div class="a1" style="margin-top: 4%;">
  <div class="a" style="width: 150%; margin-right: 1%;">
    <button class="accordion">ETEC Adolpho Berezin</button>
    <div class="panel">
      <p>A Etec Adolpho Berezin está localizada no endereço Av. Monteiro Lobato, 8000 - Balneário Itaóca, Mongaguá - SP, 11730-000 e oferece os seguintes cursos: Administração, Edificações, Enfermagem, Informática, Turismo Receptivo e Desenvolvimento de Sistemas.</p>
    </div>
  </div>
  <div class="b" style="width: 150%; margin-left: 1%;">
    <button class="accordion">ETEC Alberto Santos Dumont</button>
    <div class="panel">
      <p>A Etec Etec Alberto Santos Dumont está localizada no endereço  Rua Dr. Carlos Nehring, 165 - Jardim Helena Maria, Guarujá - SP, 11431-090 e oferece os seguintes cursos: Gastronomia, Logística, Secretariado, Informática, Administração, Transações Imobiliárias, Guia de Turismo, Desenvolvimento de Sistemas, Comércio, Eventos e Gestão de Projetos.</p>
    </div>
  </div>
</div>
<br>

	<div class="a1">
	  <div class="c" style="width:150%; margin-right:1%">
	<button class="accordion">ETEC Aristóteles Ferreira</button>
	<div class="panel">
	  <p>A Etec Aristóteles Ferreira está localizada no endereço 
	Av. Dr. Epitácio Pessoa, 466 - Aparecida, Santos - SP, 11030-600
	 e oferece os seguintes cursos: Agenciamento de Viagem, Desenho de Construção Civil, Edificações, Eletrônica, Eventos, Mecânica, Metalurgia, Programação de Jogos Digitais, Eletrotécnica, Soldagem, Informática, Administração, Automação Industrial e Informática para Internet.
	</p>
	</div>
	</div>
	<div class="d" style="width: 150%; margin-left: 1%">
	<button class="accordion">ETEC de Itanhaém</button>
	<div class="panel">
	  <p>A Etec de Itanhaém está localizada no endereço Av. José Batista Campos, 1431 - Cidade Anchieta, Itanhaém - SP, 11740-000 e oferece os seguintes cursos: Administração, Desenvolvimento de Sistemas, Meio Ambiente e Farmácia.</p>
	</div>
	</div>
	</div>  
	<br>

<div class="a1">
  <div class="c" style="width:150%; margin-right:1%">
<button class="accordion">ETEC de Peruíbe</button>
<div class="panel">
  <p>A Etec de Peruíbe  está localizada no endereço R. Alan Kardec, 1695 - Balneario Tres Marias, Peruíbe - SP, 11750-000 e oferece os seguintes cursos: Administração, Contabilidade, Eventos, Turismo Receptivo, Edificações, Transações Imobiliárias, Desenvolvimento de Sistemas e Programação de Jogos Digitais.</p>
</div>
</div>
<div class="d" style="width: 150%; margin-left: 1%">
<button class="accordion">ETEC de Praia Grande</button>
<div class="panel">
  <p>A Etec de Praia Grande está localizada no endereço Rua Guadalajara, 943 - Guilhermina - CEP: 11702-210 - Praia Grande - SP e oferece os seguintes cursos: Administração, Comércio, Desenvolvimento de Sistemas, Transações Imobiliárias, Secretariado, Recursos Humanos, Logística, Informática, Guia de Turismo, Gestão de Projetos, Farmácia e Química.</p>
</div>
</div>
</div>  
<br>

<div class="a1">
  <div class="c" style="width:150%; margin-right:1%">
<button class="accordion">ETEC de Praia Grande - Extensão Balneário Maracanã</button>
<div class="panel">
  <p>A Etec de Praia Grande (Extensão Balneário Maracanã) está localizada no endereço Avenida Dr. Roberto de Almeida Vinhas, 10119 - Balneário Maracanã - CEP: 11705-740 - Praia Grande - SP e oferece os seguintes cursos: Administração, Informática para Internet, Técnico em Segurança do Trabalho.</p>
</div>
</div>
<div class="d" style="width: 150%; margin-left: 1%">
<button class="accordion">ETEC de Cubatão</button>
<div class="panel">
  <p>A Etec de cubatão está localizada no endereço R. Tamoyo, 230 – Vila Couto, Cubatão – SP, 11510-160 e oferece os seguintes cursos: ADMINISTRAÇÃO, LOGÍSTICA, MEIO-AMBIENTE, PROGRAMAÇÃO DE JOGOS e CONTABILIDADE.
</p>
</div>
</div> 
</div>  
	<br>

<div class="a1" style="margin-bottom: 3%;">
  <div class="c" style="width:150%; margin-right:1%">
<button class="accordion">ETEC Doutora Ruth Cardoso</button>
<div class="panel">
  <p>A Etec Dra. Ruth Cardoso está localizada no endereço Pr. Cel. Lopes, 387 - Centro, São Vicente - SP, 11310-020
 e oferece os seguintes cursos: Desenvolvimento de Sistemas, Edificações, Enfermagem, Transações Imobiliárias, Administração, Comércio, Guia de Turismo, Secretariado e Gestão de Projetos.</p>
</div>
</div>
<div class="d" style="width: 150%; margin-left: 1%">

</div> 
</div> 
	
	<script>
		var acc = document.getElementsByClassName("accordion");
		var i;

		for(i = 0; i < acc.length; i++){
			acc[i].addEventListener("click", function(){
		    	this.classList.toggle("active");
		    	var panel = this.nextElementSibling;
		    	if(panel.style.display === "block"){
		      		panel.style.display = "none";
		    	}else{
		      		panel.style.display = "block";
		    	}
		 	});
		}
	</script>

	<!-- Modal (resultado-pesquisa) -->
	<div class="modal" tabindex="-1" id="modal"></div>
	<div class="modal" tabindex="-1" id="denuncia"></div>
	  
</body>
</html>