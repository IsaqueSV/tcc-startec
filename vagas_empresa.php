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

	$filtro = "SELECT * FROM tb_pchave_vaga";
	$query_filtro = mysqli_query($mysqli, $filtro);

	$consulta = "SELECT * FROM tb_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario  INNER JOIN tb_pchave_curriculo ON tb_vaga.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga WHERE id_autor_vaga = '$cdUsuario' ORDER BY cd_vaga DESC";
	$query_consulta = mysqli_query($mysqli, $consulta);
	$contagem = mysqli_num_rows($query_consulta);

	$img_caminho = $row_usuario['path_foto_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Minhas vagas</title>
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
			$("#pchave-vaga").fadeOut();
			$("#resultado").hide();

			$("#titulo-btn").click(function(){
				window.location.href = "criar_vaga.php";
			});

			$("#btn-pesquisa").click(function(){
				$.ajax({
					url: "config/pesquisa-vaga.php",
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

			$(".pchave-vaga").click(function(){
				$id_pchave_candidatos = $(this).attr('id');
				$.ajax({
					url: "config/modal-pchave-vaga.php",
					type: "POST",
					data: "idPchaveVaga="+$id_pchave_candidatos,
					dataType: "html"
				}).done(function(resposta){
					$("#pchave-vaga").html(resposta);
					$("#pchave-vaga").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#pchave-vaga").fadeOut();
				}).always(function(){
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
		<label class="h5" id="titulo-label">MINHAS VAGAS</label>
		<button id="titulo-btn"><i class="fa-solid fa-plus"></i></button>
	</div>

	<!-- Barra de pesquisa (pesquisa) -->
	<div class="input-group mb-3" id="div-pesquisa">
		<select class="form-select form-select-sm p-3" id="select-pesquisa">
			<option value="" selected title="Filtrar busca">Filtros</option>
			<?php 
				while($row_filtro = mysqli_fetch_assoc($query_filtro)){
					?>
					<option value="<?php echo $row_filtro['cd_pchave_vaga']; ?>"><?php echo $row_filtro['nm_pchave_vaga']; ?></option>
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

	<!-- Vagas (conteúdo) -->
	<div style="margin-top: 3%; margin-bottom: 5%;">
	<?php
		if($contagem <= 0){
			?>
			<div id="div-projeto">
				<label class='h6'>Nenhuma vaga foi criada ainda!</label>
			</div>
			<?php
		}else{
			while($row_geral = mysqli_fetch_assoc($query_consulta)){
				?>
				<div class="vaga">
					<div id="titulo-vaga" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid;">
						<div id="titulo-vaga-esquerda" style="width: 70%; padding: 1%;">
							<a href="vagas.php?see=<?php echo $row_geral['ds_url_vaga']; ?>" title="Nome da vaga" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_vaga']; ?></a> - 
							<a class="pchave-vaga" id="<?php echo $row_geral['cd_pchave_curriculo']; ?>" title="Requisito" style="text-decoration: none; color: black; cursor: pointer;"><?php echo $row_geral['nm_pchave_curriculo']; ?></a>
						</div>
						<div id="titulo-vaga-direita" style="width: 30%; text-align: right;">
							<a href="editar_vaga.php?see=<?php echo $row_geral['ds_url_vaga']; ?>" style="text-decoration: none;"><i class="btn fa-solid fa-gear" style="font-size: 30px; color: black; cursor: pointer;"></i></a>

							<!-- <a href="editar_vaga.php?see=<?php echo $row_geral['ds_url_vaga']; ?>" style="text-decoration: none;"><button class="btn btn-light" style="transition: 0.5s ease; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Editar</button></a> -->
						</div>
					</div>
					<div id="desc-vaga" style="padding: 1%;">
						<?php echo $row_geral['ds_vaga']; ?>
					</div>
					<div id="footer-vaga" style="border-top: 1px solid; display: flex;">
						<div id="autor-vaga-esquerda" style="width: 70%; padding: 1%;">
							<a href="perfil.php?see=<?php echo $row_geral['ds_url_usuario']; ?>" title="Autor" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_usuario']; ?></a>
						</div>

						<div id="data-vaga-direita" style="width: 30%; text-align: right; padding: 1%; margin-right: 1%;">
							<a title="Data de criação" style="text-decoration: none; color: black;"><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row_geral['created_vaga'])); ?></a>
						</div>
					</div>
				</div>
			<?php
			}
		}
	?>
	</div>

	<div class="modal" tabindex="-1" id="modal-pesquisa-vaga"></div>
	<div class="modal" tabindex="-1" id="pchave-vaga"></div>
</body>
</html>