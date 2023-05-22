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
	</script>
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
		<label class="h5" id="titulo-label">QUEM SOMOS</label>
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
	<div class="modal" tabindex="-1" id="denuncia"></div>
	  
	</div>
</body>
</html>