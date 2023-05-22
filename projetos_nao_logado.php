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
	
	$filtro = "SELECT * FROM tb_pchave_projeto";
	$query_filtro = mysqli_query($mysqli, $filtro);

	$consulta = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto ORDER BY cd_projeto DESC";
	$query_consulta = mysqli_query($mysqli, $consulta);
	$contagem = mysqli_num_rows($query_consulta);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Projetos</title>
	<!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
	<!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
	<!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
	<!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
	<!-- Jquery Mask <script src="css/local/js/jquery.mask.min.js"></script> -->
	<!-- CSS --><link rel="stylesheet" href="css/navbar.css">
	<!-- CSS --><link rel="stylesheet" href="css/geral.css">
	<!-- CSS --><link rel="stylesheet" href="css/footer.css">
	<style>
		div#descricao-projeto1{
			transition: 0.5s ease;
		}div#descricao-projeto1:hover{
			transition: 0.5s ease;
			background-color: #DCDCDC;
		}
		div#metade{
			transition: 0.5s ease;
		}div#metade:hover{
			transition: 0.5s ease;
			background-color: #DCDCDC;
		}button.candidatar{
			transition: 0.5s ease;
		}button.candidatar:hover{
			transition: 0.5s ease;
			background-color: #DCDCDC;
		}
	</style>
	<script>
		$(document).ready(function(){
			$("#pchave-projeto").fadeOut();
			$("#resultado").hide();

			$("#btn-pesquisa").click(function(){
				$.ajax({
					url: "config/pesquisa-projeto.php",
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

			$(".btn-projeto-curtida").click(function(){
				$.ajax({
					url: "config/modal-cadastro-login.php",
					type: "POST",
					dataType: "html"
				}).done(function(resposta){
					$("#cadastrar-login").html(resposta);
					$("#cadastrar-login").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#cadastrar-login").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			});

			$(".pchave-projeto").click(function(){
				$id_pchave_projeto = $(this).attr('id');
				$.ajax({
					url: "config/modal-pchave-projeto.php",
					type: "POST",
					data: "idPchaveProjeto="+$id_pchave_projeto,
					dataType: "html"
				}).done(function(resposta){
					$("#pchave-projeto").html(resposta);
					$("#pchave-projeto").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#pchave-projeto").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			});	

			$("#btn-alerta-cad").click(function(){
				$.ajax({
					url: "config/modal-cadastro-login.php",
					type: "POST",
					dataType: "html"
				}).done(function(resposta){
					$("#cadastrar-login").html(resposta);
					$("#cadastrar-login").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#cadastrar-login").fadeOut();
				}).always(function(){
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
		<label class="h5" id="titulo-label">PROJETOS</label>
		<button id="titulo-btn"><i style="font-size: 22px;" class="fa-solid fa-mug-hot"></i></button>
	</div>

	<!-- Barra de pesquisa (pesquisa) -->
	<div class="input-group mb-3" id="div-pesquisa">
		<select class="form-select form-select-sm p-3" id="select-pesquisa">
			<option value="" selected title="Filtrar busca">Filtros</option>
			<?php 
				while($row_filtro = mysqli_fetch_assoc($query_filtro)){
					?>
					<option value="<?php echo $row_filtro['cd_pchave_projeto']; ?>"><?php echo $row_filtro['nm_pchave_projeto']; ?></option>
					<?php
				}
			?>
		</select>
		<input type="text" class="form-control" placeholder="Pesquise algo..." id="text-pesquisa">
  		<button class="btn" type="button" id="btn-pesquisa"><i class="fa-solid fa-magnifying-glass" id="i-pesquisa"></i></button>
	</div><br>

	<!-- Resultado (resultado-pesquisa) -->
	<div class="alert" style="margin-top: 0; margin-top: 1%;" id="resultado" role="alert">
		<span id="resultado-pesquisa"></span>
	</div>

	<!-- Projetos (conteúdo) -->
	<div style="margin-top: 3%; margin-bottom: 5%;">
	<?php
		if($contagem <= 0){
			?>
			<div id="div-projeto">
				<label class='h6'>Nenhum projeto foi criado ainda!</label>
			</div>
			<?php
		}else{
			while($row_geral = mysqli_fetch_assoc($query_consulta)){
				?>
				<div class="projeto">
					<div id="titulo-projeto" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid;">
						<div id="titulo-projeto-esquerda" style="width: 70%; padding: 1%;">
							<a href="projetos.php?see=<?php echo $row_geral['ds_url_projeto']; ?>" title="Nome do projeto" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_projeto']; ?></a> - 
							<a class="pchave-projeto" id="<?php echo $row_geral['cd_pchave_projeto']; ?>" title="Linguagem de programação" style="text-decoration: none; color: black; cursor: pointer;"><?php echo $row_geral['nm_pchave_projeto']; ?></a>
						</div>
						<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1%;">
							<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: black; cursor: pointer;" id="<?php echo $row_geral['cd_projeto']; ?>"></i>
							<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row_geral['cd_projeto']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
						</div>
					</div>
					<div id="desc-projeto" style="padding: 1%;">
						<?php echo $row_geral['ds_projeto']; ?>
					</div>
					<div id="footer-projeto" style="border-top: 1px solid; display: flex;">
						<div id="autor-projeto-esquerda" style="width: 70%; padding: 1%;">
							<a id="btn-alerta-cad" title="Autor" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_usuario']; ?></a>
						</div>

						<div id="data-projeto-direita" style="width: 30%; text-align: right; padding: 1%; margin-right: 1%;">
							<a title="Data de criação" style="text-decoration: none; color: black;"><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row_geral['created_projeto'])); ?></a>
						</div>
					</div>
				</div>
			<?php
			}
		}
	?>
	</div>

	<div class="modal" tabindex="-1" id="modal-pesquisa-projeto"></div>
	<div class="modal" tabindex="-1" id="pchave-projeto"></div>
	<div class="modal" tabindex="-1" id="cadastrar-login"></div>
</body>
</html>