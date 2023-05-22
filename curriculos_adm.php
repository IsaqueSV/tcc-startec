<?php
	include('banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: index.php');
	}
	if($_SESSION['idNivel'] == 1){
		header('Location: home_aluno.php');
	}
	if($_SESSION['idNivel'] == 2){
		header('Location: home_empresa.php');
	}

	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$dados = mysqli_fetch_object($query);

	$img_caminho = $dados->path_foto_usuario;

	$filtro = "SELECT * FROM tb_pchave_curriculo";
	$query_filtro = mysqli_query($mysqli, $filtro);

	$sql_curriculos = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_estado_civil ON tb_curriculo.id_estado_civil = tb_estado_civil.cd_estado_civil INNER JOIN tb_municipio ON tb_curriculo.id_municipio = tb_municipio.cd_municipio INNER JOIN tb_etec ON tb_curriculo.id_etec_curriculo = tb_etec.cd_etec INNER JOIN tb_genero ON tb_curriculo.id_genero_curriculo = tb_genero.cd_genero ORDER BY cd_curriculo DESC";
	$query_curriculos = mysqli_query($mysqli, $sql_curriculos);
	$num_curriculos = mysqli_num_rows($query_curriculos);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!--
		adiciona foto no site 
		<link rel="icon" href="dados/img/ft_usuarios/user.jpg"> 
	-->
	<title>Currículos</title>
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
			$("#pchave-curriculo").fadeOut();
			$("#resultado").hide();

			$("#btn-pesquisa").click(function(){
				$.ajax({
					url: "config/pesquisa-curriculo.php",
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

			$(".btn-denuncias-curriculo").click(function(){
				$id_curriculo = $(this).attr('id');

				window.location.href = "denuncias_curriculo.php?see="+$id_curriculo;
			})

			$(".btn-visualizar-curriculo").click(function(){
				$id_curriculo = $(this).attr('id');

				window.location.href = "curriculos.php?see="+$id_curriculo;
			})

			$(".btn-autor-curriculo").click(function(){
				$id_autor = $(this).attr('id');

				window.location.href = "perfil.php?see="+$id_autor;
			})

			$(".btn-deletar-curriculo").click(function(){
				$id_curriculo = $(this).attr('id');

				$.ajax({
					url: "config/modal-deletar-curriculo-adm.php",
					type: "POST",
					data: "idCurriculo="+$id_curriculo,
					dataType: "html"
				}).done(function(resposta){
					$("#modal-deletar-curriculo-adm").html(resposta);
					$("#modal-deletar-curriculo-adm").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#modal-deletar-curriculo-adm").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			})
		});
	</script>
</head>
<body>
	<!-- Navbar (topo) -->
	<nav class="navbar" id="nav-topo">
		<div class="container-fluid" id="div-topo">
			<a class="navbar-brand" href="home_adm.php" id="a-topo">
				STAR TEC
			</a>
			<ul class="nav justify-content-end" id="ul-topo">
				<li class="nav-item" id="li-topo">
					<a class="nav-link" title="Meu perfil" id="li-a" style="padding-right: 0; padding-left: 0;">
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
  		<a class="nav-link p-3" id="a-navega-a" href="alunos_adm.php">Alunos</a>
  		<a class="nav-link p-3" id="a-navega-b" href="empresa_adm.php">Empresas</a>
  		<a class="nav-link p-3" id="a-navega-c" href="projetos_adm.php">Projetos</a>
  		<a class="nav-link p-3" id="a-navega-d" href="vagas_adm.php">Vagas</a>
  		<a class="nav-link p-3" id="a-navega-f" href="curriculos_adm.php">Currículos</a>
	</nav>

	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">CURRÍCULOS</label>
		<button id="titulo-btn"><i style="font-size: 22px;" class="fa-regular fa-clipboard"></i></button>
	</div>

	<!-- Barra de pesquisa (pesquisa) -->
	<div class="input-group mb-3" id="div-pesquisa">
		<select class="form-select form-select-sm p-3" id="select-pesquisa">
			<option value=" " selected title="Filtrar busca">Filtros</option>
			<?php 
				while($row_filtro = mysqli_fetch_assoc($query_filtro)){
					?>
					<option value="<?php echo $row_filtro['cd_pchave_curriculo']; ?>"><?php echo $row_filtro['nm_pchave_curriculo']; ?></option>
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

	<div id="lista-de-curriculos" style="width: 80%; margin-top: 3%; margin-left: 10%; margin-right: 10%;border-radius: 8px;">
		<?php
			if($num_curriculos > 0){
				while($row_curriculo = mysqli_fetch_assoc($query_curriculos)){
					?>
						<div style="width: 100%; display: flex; margin-bottom: 0.5%;">
							<div style="width: 60%; text-align: center; display: flex;">
								<div title="ID curriculo" style="width: 10%; padding-top: 2%; background-color: white; padding-bottom: 2%; border: 1px solid; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">
									<?php echo $row_curriculo['cd_curriculo']; ?>
								</div>
								<div title="Nome do currículo" style="width: 60%; padding-top: 2%; padding-bottom: 2%; background-color: white; border: 1px solid; border-left: 0;">
									<?php echo $row_curriculo['nm_completo_curriculo']; ?>
								</div>
								<div class="btn-autor-curriculo btn btn-light" id="<?php echo $row_curriculo['ds_url_usuario']; ?>" title="Nome do autor" style="width: 30%; padding-top: 2%; padding-bottom: 2%; border: 1px solid; border-left: 0; border-radius: 0;">
									<?php echo $row_curriculo['nm_usuario']; ?>
								</div>
							</div>
							<div style="width: 40%; text-align: center; display: flex;">
								<div class="btn-denuncias-curriculo btn btn-light" id="<?php echo $row_curriculo['ds_url_curriculo']; ?>" title="Denuncias" style="border-radius: 0; width: 30%; padding-top: 2.5%; padding-bottom: 2%; border: 1px solid; border-left: 0;">
									Denuncias
								</div>
								<div class="btn-visualizar-curriculo btn btn-light" id="<?php echo $row_curriculo['ds_url_curriculo']; ?>" title="Visualizar" style="border-radius: 0; width: 40%; padding-top: 2.5%; padding-bottom: 2%; border: 1px solid; border-left: 0;">
									Visualizar
								</div>
								<div class="btn-deletar-curriculo btn btn-light" id="<?php echo $row_curriculo['ds_url_curriculo']; ?>" title="Deletar" style="border-radius: 0; width: 30%; padding-top: 2.5%; padding-bottom: 2%; border: 1px solid; border-left: 0; border-top-right-radius: 4px; border-bottom-right-radius: 4px;">
									Deletar
								</div>
							</div>
						</div>
					<?php
				}
			}else{
				?>
					<div id="div-projeto" style="width: 100%; margin: 0;">
						<label class='h6'>Nenhum curriculo foi encontrado!</label>
					</div>
				<?php
			}
		?>
	</div>

	<div class="modal" tabindex="-1" id="modal-pesquisa-curriculo"></div>
	<div class="modal" tabindex="-1" id="modal-deletar-curriculo-adm"></div>
</body>
</html>