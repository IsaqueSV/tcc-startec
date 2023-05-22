<?php
	include('banco/conexao.php');
	session_start();
	if((!isset ($_SESSION['cdUsuario']) == true) and (!isset ($_SESSION['idNivel']) == true)){
		header('Location: index.php');
	}
	if($_SESSION['idNivel'] == 2){
		header('Location: home_empresa.php');
	}if($_SESSION['idNivel'] == 3){
		header('Location: home_adm.php');
	}

	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];
	
	$sql = "SELECT path_foto_usuario FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$row_usuario = mysqli_fetch_assoc($query);

	$filtro = "SELECT * FROM tb_pchave_projeto";
	$query_filtro = mysqli_query($mysqli, $filtro);

	$consulta = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto ORDER BY cd_projeto DESC";
	$query_consulta = mysqli_query($mysqli, $consulta);
	$contagem = mysqli_num_rows($query_consulta);

	$img_caminho = $row_usuario['path_foto_usuario'];
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
	<script>
		$(document).ready(function(){
			$("#pchave-projeto").fadeOut();
			$("#resultado").hide();

			$("#titulo-btn").click(function(){
				window.location.href = "criar_projeto.php";
			});

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
				$id_projeto_curtido = $(this).attr('id');

				$.ajax({
					url: "config/curtir-projeto.php",
					type: "POST",
					data: "projetoCurtido="+$id_projeto_curtido + "&autor="+ "<?php echo $cdUsuario; ?>",
					dataType: "html"
				}).done(function(resposta){
					console.log(resposta);
					setTimeout(function() {
					  window.location.reload(1);
					}, 500);
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
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
		});
	</script>
</head>
<body>
    <!-- Navbar (topo) -->
	<nav class="navbar" id="nav-topo">
		<div class="container-fluid" id="div-topo">
			<a class="navbar-brand" href="home_aluno.php" id="a-topo">
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
  		<a class="nav-link p-3" id="a-navega-a" href="sobre_aluno.php">Quem somos</a>
  		<a class="nav-link p-3" id="a-navega-b" href="projetos_aluno.php">Projetos</a>
  		<a class="nav-link p-3" id="a-navega-c" href="escolas_aluno.php">Escolas</a>
  		<a class="nav-link p-3" id="a-navega-d" href="vagas_aluno.php">Vagas</a>
  		<a class="nav-link p-3" id="a-navega-e" href="curriculo_aluno.php">Meu currículo</a>
  		<a class="nav-link p-3" id="a-navega-f" href="ajuda_aluno.php">Ajuda</a>
	</nav>

	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">PROJETOS</label>
		<button id="titulo-btn"><i class="fa-solid fa-plus"></i></button>
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
				$sql_pega_minha_curtida = "SELECT * FROM tb_curtida_projeto INNER JOIN tb_usuario ON tb_curtida_projeto.id_autor_curtida_projeto = tb_usuario.cd_usuario WHERE id_autor_curtida_projeto = '$cdUsuario' AND id_curtida_projeto = '".$row_geral['cd_projeto']."'";
				$query_pega_minha_curtida = mysqli_query($mysqli, $sql_pega_minha_curtida);
				$num_pega_minha_curtida = mysqli_num_rows($query_pega_minha_curtida);
				?>

				<style>
				</style>

				<div class="projeto">
					<div id="titulo-projeto" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid;">
						<div id="titulo-projeto-esquerda" style="width: 70%; padding: 1%;">
							<a href="projetos.php?see=<?php echo $row_geral['ds_url_projeto']; ?>" title="Nome do projeto" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_projeto']; ?></a> - 
							<a class="pchave-projeto" id="<?php echo $row_geral['cd_pchave_projeto']; ?>" title="Linguagem de programação" style="text-decoration: none; color: black; cursor: pointer;"><?php echo $row_geral['nm_pchave_projeto']; ?></a>
						</div>
						<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1%;">
							<?php
								if($row_geral['id_autor_projeto'] == $cdUsuario){
									?>
										<a href="editar_projeto.php?see=<?php echo $row_geral['ds_url_projeto']; ?>" style="text-decoration: none;"><i class="btn-editar-projeto fa-solid fa-gear" style="font-size: 30px; color: black; cursor: pointer;"></i></a>
										<!-- <a href="editar_projeto.php?see=<?php echo $row_geral['ds_url_projeto']; ?>" style="text-decoration: none;"><button class="btn btn-light" style="transition: 0.5s ease; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Editar</button></a> -->
									<?php
								}else{
									if($num_pega_minha_curtida > 0){
										?>
											<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: red; cursor: pointer;" id="<?php echo $row_geral['cd_projeto']; ?>"></i>
											<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row_geral['cd_projeto']; ?>" style="transition: 0.5s ease; background-color: #DCDCDC; width: 50%; border-radius: 0; border: 1px solid;">Curtido</button> -->
										<?php	
									}else{
										?>
											<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: black; cursor: pointer;" id="<?php echo $row_geral['cd_projeto']; ?>"></i>
											<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row_geral['cd_projeto']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
										<?php
									}
								}
							?>
						</div>
					</div>
					<div id="desc-projeto" style="padding: 1%;">
						<?php echo $row_geral['ds_projeto']; ?>
					</div>
					<div id="footer-projeto" style="border-top: 1px solid; display: flex;">
						<div id="autor-projeto-esquerda" style="width: 70%; padding: 1%;">
							<?php 
								if($row_geral['id_autor_projeto'] == $cdUsuario){
									?>
										<a href="meu_perfil.php" title="Autor" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_usuario']; ?></a>
									<?php
								}else{
									?>
										<a href="perfil.php?see=<?php echo $row_geral['ds_url_usuario']; ?>" title="Autor" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_usuario']; ?></a>
									<?php
								}
							?>
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
</body>
</html>