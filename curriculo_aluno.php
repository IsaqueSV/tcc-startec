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

	$sql_curriculo = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_estado_civil ON tb_curriculo.id_estado_civil = tb_estado_civil.cd_estado_civil INNER JOIN tb_municipio ON tb_curriculo.id_municipio = tb_municipio.cd_municipio INNER JOIN tb_etec ON tb_curriculo.id_etec_curriculo = tb_etec.cd_etec INNER JOIN tb_genero ON tb_curriculo.id_genero_curriculo = tb_genero.cd_genero WHERE id_autor_curriculo = '$cdUsuario'";
	$query_curriculo = mysqli_query($mysqli, $sql_curriculo);
	$row_curriculo = mysqli_fetch_assoc($query_curriculo);
	$contagem = mysqli_num_rows($query_curriculo);

	$img_caminho = $row_usuario['path_foto_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Meu currículo</title>
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
		button.titulo-btn-editar{
			width: 5%;
			border-top-right-radius: 8px;
			border-bottom-right-radius: 8px;
			border: 0;
			border-left: 1px solid black;
			transition: 0.5s ease;
		}
		button.titulo-btn-editar:hover{
			background-color: #DCDCDC;
			transition: 0.5s ease;
		}
		textarea{
			resize: none;
		}
	</style>
	<script>
		$(document).ready(function(){
			$("#modal-edita-comentario-curriculo").fadeOut();
			$("#modal-comentario-curriculo").fadeOut();
			$("#denuncia-curriculo").fadeOut();
			$("#pchave-curriculo").fadeOut();
			$("#resultado").hide();

			$(".titulo-btn-criar").click(function(){
				window.location.href = "criar_curriculo.php";
			});

			$(".titulo-btn-editar").click(function(){
				$id_curriculo = $(this).attr('id');

				window.location.href = "editar_curriculo.php?see="+$id_curriculo;
			});

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

			$(".pchave-curriculo").click(function(){
				$id_pchave_projeto = $(this).attr('id');
				$.ajax({
					url: "config/modal-pchave-curriculo.php",
					type: "POST",
					data: "idPchaveCurriculo="+$id_pchave_projeto,
					dataType: "html"
				}).done(function(resposta){
					$("#pchave-curriculo").html(resposta);
					$("#pchave-curriculo").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
					$("#pchave-curriculo").fadeOut();
				}).always(function(){
					console.log("completou");
				});
			});

			$(".btn-comentar").click(function(){
				$id_curriculo_comentario = $(this).attr('id');
				$.ajax({
					url: "config/modal-comentario-curriculo.php",
					type: "POST",
					data: "curriculoComentado="+$id_curriculo_comentario,
					dataType: "html"
				}).done(function(resposta){
					$("#modal-comentario-curriculo").html(resposta);
					$("#modal-comentario-curriculo").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
				}).always(function(){
					console.log("completou");
				});
			});

			$(".btn-editar-comentario").click(function(){
				$id_edita_comentario = $(this).attr('id');

				$.ajax({
					url: "config/modal-edita-comentario-curriculo.php",
					type: "POST",
					data: "comentarioEdita="+$id_edita_comentario,
					dataType: "html"
				}).done(function(resposta){
					$("#modal-edita-comentario-curriculo").html(resposta);
					$("#modal-edita-comentario-curriculo").fadeIn();
				}).fail(function(jqXHR, textStatus ){
					console.log("Request failed: " + textStatus);
				}).always(function(){
					console.log("completou");
				});
			});
		});
	</script>
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/geral.css">
	<link rel="stylesheet" href="css/footer.css">
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
	<?php
		if($contagem > 0){
			$sql_pega_comentario = "SELECT * FROM tb_comentario_curriculo INNER JOIN tb_usuario ON tb_comentario_curriculo.id_autor_comentario_curriculo = tb_usuario.cd_usuario WHERE id_comentario_curriculo = '".$row_curriculo['cd_curriculo']."' ORDER BY cd_comentario_curriculo DESC";
			$query_pega_comentario = mysqli_query($mysqli, $sql_pega_comentario);
			$num_pega_comentario = mysqli_num_rows($query_pega_comentario);

			$sql_pega_curtida = "SELECT * FROM tb_curtida_curriculo INNER JOIN tb_usuario ON tb_curtida_curriculo.id_autor_curtida_curriculo = tb_usuario.cd_usuario WHERE id_curtida_curriculo = '".$row_curriculo['cd_curriculo']."'";
			$query_pega_curtida = mysqli_query($mysqli, $sql_pega_curtida);
			$num_pega_curtida = mysqli_num_rows($query_pega_curtida);
			?>
			<div id="titulo">
				<label class="h5" id="titulo-label">MEU CURRÍCULO</label>
				<button class="titulo-btn-editar" id="<?php echo $row_curriculo['ds_url_curriculo']; ?>"><i class="fa-solid fa-ellipsis"></i></button>
			</div>
			<?php
		}else{
			?>
			<div id="titulo">
				<label class="h5" id="titulo-label">MEU CURRÍCULO</label>
				<button class="titulo-btn-criar" id="titulo-btn"><i class="fa-solid fa-plus"></i></button>
			</div>
			<?php
		}
	?>

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
	<div class="modal" tabindex="-1" id="denuncia"></div>

	<?php
		if($contagem > 0){
			?>
			<div class="container-fluid" id="div-curriculo-conteudo" style="margin-top: 5%; margin-bottom: 5%; border-top-left-radius: 15px; border-top-right-radius: 15px;">
				<div class="row" style="border-radius: 8px;">
					<div class="col" id="div-conteudo-titulo" style="padding: 0; border-top-left-radius: 8px; border-top-right-radius: 8px;">
						<label style="width: 100%; border-top-left-radius: 8px;" class="h5" id="label-projeto-titulo"></label>
					</div>
				</div>
				<div class="row" style="margin: 3%;">
					<div class="col-md-3" style="padding: 0;">
						<img src="<?php echo $row_curriculo['path_foto_curriculo']; ?>" style="width: 300px; height: 300px; padding: 0; border-color: black;" class="img-thumbnail" id="uploadPreview">
					</div>
					<div class="col-md-9" style="padding: 0; padding-top: 3%; padding-left: 2%;">
						<label for="nome" style="margin-bottom: 1%;">Nome completo:</label>
						<input type="text" style="margin-bottom: 1.5%;" class="form-control" name="nome" id="nome" value="<?php echo $row_curriculo['nm_completo_curriculo']; ?>" readonly>
						<label for="email" style="margin-bottom: 1%;">Email:</label>
						<input type="email" style="margin-bottom: 1.5%;" class="form-control" name="email" id="email" value="<?php echo $row_curriculo['ds_contato_email']; ?>" readonly>
						<label for="cargo" style="margin-bottom: 1%;">Cargo desejado</label>
						<input type="text" class="form-control" name="cargo" id="cargo" value="<?php echo $row_curriculo['ds_cargo']; ?>" readonly>
					</div>
				</div>
				
				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 3%;">
					<button class="pchave-curriculo" id="<?php echo $row_curriculo['cd_pchave_curriculo']; ?>">
							<?php echo $row_curriculo['nm_pchave_curriculo']; ?>
					</button>
				</div>
				
				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
					<div class="col" style="padding: 0;">
						<label for="nascimento" style="margin-bottom: 1%;">Data de nascimento:</label>
						<input type="text" class="form-control" name="nascimento" id="nascimento" value="<?php echo $row_curriculo['ds_nascimento']; ?>" readonly>
					</div>
					<div class="col" style="padding: 0; margin-left: 2%;">
						<label for="estado-civil" style="margin-bottom: 1%;">Estado civil:</label>
						<input type="text" class="form-control" name="estado-civil" id="estado-civil" value="<?php echo $row_curriculo['nm_estado_civil']; ?>">
					</div>
				</div>
				
				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
					<label for="telefone" style="margin-bottom: 1%; padding: 0;">Número de telefone:</label>
					<input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $row_curriculo['ds_contato_telefone']; ?>">
				</div>

				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
					<div class="col" style="padding: 0;">
						<label for="cidade" style="margin-bottom: 1%;">Cidade:</label>
						<input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo $row_curriculo['nm_municipio']; ?>" readonly>
					</div>
					<div class="col" style="padding: 0; margin-left: 2%;">
						<label for="cep" style="margin-bottom: 1%;">CEP:</label>
						<input type="text" class="form-control" name="cep" id="cep" value="<?php echo $row_curriculo['ds_cep']; ?>">
					</div>
				</div>

				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 3%;">
					<div class="col" style="padding: 0;">
						<label for="etec" style="margin-bottom: 1%;">ETEC frequentada:</label>
						<input type="text" class="form-control" name="etec" id="etec" value="<?php echo $row_curriculo['nm_etec']; ?>" readonly>
					</div>
					<div class="col" style="padding: 0; margin-left: 2%;">
						<label for="genero" style="margin-bottom: 1%;">Gênero:</label>
						<input type="text" class="form-control" name="genero" id="genero" value="<?php echo $row_curriculo['nm_genero']; ?>">
					</div>
				</div>

				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 2%;">
					<label for="idiomas" style="margin-bottom: 1%; padding: 0;">Idiomas:</label>
					<textarea class="form-control" name="idiomas" id="idiomas" placeholder="<?php echo $row_curriculo['ds_idioma']; ?>" readonly></textarea>
				</div>

				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 2%;">
					<label for="qualidades" style="margin-bottom: 1%; padding: 0;">Qualidades:</label>
					<textarea class="form-control" name="qualidades" id="qualidades" placeholder="<?php echo $row_curriculo['ds_qualidade']; ?>" readonly></textarea>
				</div>

				<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 3%;">
					<label for="cursos" style="margin-bottom: 1%; padding: 0;">Cursos:</label>
					<textarea class="form-control" name="cursos" id="cursos" placeholder="<?php echo $row_curriculo['ds_curso']; ?>" readonly></textarea>
				</div>
				<div class="row" style="border-top: 1px solid;">
					<div id="div-comentario" style="padding: 4%;">
						<label class="h6" id="titulo-comentario"><?php if($num_pega_comentario == 0){ echo $num_pega_comentario." comentários - "; } if($num_pega_comentario == 1){ echo $num_pega_comentario." comentário - "; } if($num_pega_comentario > 1){ echo $num_pega_comentario." comentários - "; }?></label>
					 		<label class="h6" id="titulo-curtida"><?php if($num_pega_curtida == 0){ echo $num_pega_curtida." curtidas"; } if($num_pega_curtida == 1){ echo $num_pega_curtida." curtida"; } if($num_pega_curtida > 1){ echo $num_pega_curtida. " curtidas"; }?></label>
					 	<hr size="1" width="100%"><br>
					 		<div style="display: flex;">
					 			<button id="<?php echo $row_curriculo['cd_curriculo']; ?>" class="btn-comentar">Criar comentário</button>
					 		</div>
					 		<hr size="1" style="margin-top: 4%;" width="100%"><br>
					 		<?php
					 		if($num_pega_comentario > 0){
					 			while($row_pega_comentario = mysqli_fetch_assoc($query_pega_comentario)){
					 				
					 				if($row_pega_comentario['cd_usuario'] == "$cdUsuario"){
					 					?>
					 					<div style="width:100%; margin-top: 1%; display: flex; margin-bottom: 2%;">
								 			<div id="left-comentarios" style="width: 4%;">
								 				<img id="foto-comentario" class="rounded-circle" src="<?php echo $row_pega_comentario['path_foto_usuario']; ?>">
								 			</div>
								 			<div id="right-comentarios" style="margin-left: 1.5%; width: 94.5%;">
												<label>Você</label>
												<label style="float: right; margin-right: 1%; color: gray;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_pega_comentario['created_comentario_curriculo'])); ?></label>
												<label style="display: flex;">
									 				<textarea name="comentario" style="width: 96%;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_pega_comentario['ds_comentario_curriculo']; ?></textarea>
									 				<button class="btn-editar-comentario" id="<?php echo $row_pega_comentario['cd_comentario_curriculo']; ?>" style="width: 5%; border: 1px solid; border-color: #DCDCDC; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"><i class="fa-solid fa-ellipsis"></i></button>
									 			</label>
								 			</div>
										</div>
					 					<?php
					 				}else{
					 					?>
					 					<div style="width:100%; margin-top: 1%; display: flex;">
								 			<div id="left-comentarios" style="width: 4%;">
								 				<img id="foto-comentario" class="rounded-circle" src="<?php echo $row_pega_comentario['path_foto_usuario']; ?>">
								 			</div>
								 			<div id="right-comentarios" style="margin-left: 1.5%; width: 94.5%;">
												<label ><?php echo $row_pega_comentario['nm_usuario']; ?></label>
												<label style="float: right; margin-right: 1%; color: gray;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_pega_comentario['created_comentario_curriculo'])); ?></label>
									 			<textarea name="comentario" style="width: 100%;" rows="2" class="form-control" id="comentario-projeto" readonly><?php echo $row_pega_comentario['ds_comentario_curriculo']; ?></textarea>
								 			</div>
										</div>
					 					<?php
					 				}
					 			}
							}else{
								?>
								<div id="div-sem-comentario" style="margin-bottom: 2%;">
									<label>Este currículo não tem nenhum comentário</label>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}else{
			?>
			<div id="div-projeto" style="margin-top: 5%; margin-bottom: 5%;">
				<label class='h6'>Você ainda não criou um currículo!</label>
			</div>
			<?php
		}
	?>
	<div class="modal" tabindex="-1" id="modal-pesquisa-curriculo"></div>
	<div class="modal" tabindex="-1" id="modal-comentario-curriculo"></div>
	<div class="modal" tabindex="-1" id="denuncia-curriculo"></div>
	<div class="modal" tabindex="-1" id="pchave-curriculo"></div>
	<div class="modal" tabindex="-1" id="modal-edita-comentario-curriculo"></div>
</html>