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
	
	if(isset($_GET['see'])){
		$cdUsuario = $_SESSION['cdUsuario'];
		$idNivel = $_SESSION['idNivel'];
		$url = $_GET['see'];

		$sql_verifica = "SELECT * FROM tb_projeto WHERE ds_url_projeto = '$url'";
		$query_verifica = mysqli_query($mysqli, $sql_verifica);
		$num_verifica = mysqli_num_rows($query_verifica);
		if($num_verifica > 0){
			$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
			$query = mysqli_query($mysqli, $sql);
			$dados = mysqli_fetch_object($query);

			$img_caminho = $dados->path_foto_usuario;

			$row_dados = mysqli_fetch_assoc($query_verifica);
			?>
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="UTF-8">
				<!--
					adiciona foto no site 
					<link rel="icon" href="dados/img/ft_usuarios/user.jpg"> 
				-->
				<title>Denuncias - <?php echo $row_dados['nm_projeto']; ?></title>
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
						$("#modal-deletar-projeto-adm").fadeOut();
						$("#modal-visualizar-motivo-adm").fadeOut();
						$("#modal-deletar-denuncia-adm").fadeOut();

						$(".btn-deletar-projeto").click(function(){
							$id_projeto = $(this).attr('id');

							$.ajax({
								url: "config/modal-deletar-projeto-adm.php",
								type: "POST",
								data: "idProjeto="+$id_projeto,
								dataType: "html"
							}).done(function(resposta){
								$("#modal-deletar-projeto-adm").html(resposta);
								$("#modal-deletar-projeto-adm").fadeIn();
							}).fail(function(jqXHR, textStatus ){
								console.log("Request failed: " + textStatus);
								$("#modal-deletar-projeto-adm").fadeOut();
							}).always(function(){
								console.log("completou");
							});
						})

						$(".btn-visualizar-motivo").click(function(){
							$id_denuncia = $(this).attr('id');

							$.ajax({
								url: "config/modal-visualizar-denuncia-adm.php",
								type: "POST",
								data: "idDenuncia="+$id_denuncia + "&nivelMotivo="+"2",
								dataType: "html"
							}).done(function(resposta){
								$("#modal-visualizar-motivo-adm").html(resposta);
								$("#modal-visualizar-motivo-adm").fadeIn();
							}).fail(function(jqXHR, textStatus ){
								console.log("Request failed: " + textStatus);
								$("#modal-visualizar-motivo-adm").fadeOut();
							}).always(function(){
								console.log("completou");
							});
						})

						$(".btn-deletar-denuncia").click(function(){
							$id_denuncia = $(this).attr('id');

							$.ajax({
								url: "config/modal-deletar-denuncia-adm.php",
								type: "POST",
								data: "idDenuncia="+$id_denuncia + "&nivelMotivo="+"2",
								dataType: "html"
							}).done(function(resposta){
								$("#modal-deletar-denuncia-adm").html(resposta);
								$("#modal-deletar-denuncia-adm").fadeIn();
							}).fail(function(jqXHR, textStatus ){
								console.log("Request failed: " + textStatus);
								$("#modal-deletar-denuncia-adm").fadeOut();
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
					<label class="h5" id="titulo-label">DENUNCIAS PROJETO</label>
					<button id="titulo-btn"><i class="fa-solid fa-triangle-exclamation" style="font-size: 22px;"></i></button>
				</div>

				<div id="tabela-denuncias" style="width: 80%; margin-top: 3%; margin-left: 10%; margin-right: 10%; background-color: white; border-radius: 8px; padding: 1%;">
					<div style="width: 100%; display: flex; margin-bottom: 0.9%;">
						<div style="width: 100%; text-align: center; display: flex;">
							<div title="ID denunciado" style="width: 6%; padding-top: 1.3%; padding-bottom: 1.3%; border: 1px solid;">
								<?php echo $row_dados['cd_projeto']; ?>
							</div>
							<div title="Nome do projeto" style="width: 82%; padding-top: 1.3%; padding-bottom: 1.3%; border: 1px solid; border-left: 0;">
								<?php echo $row_dados['nm_projeto']; ?>
							</div>
							<div class="btn-deletar-projeto btn btn-light" id="<?php echo $row_dados['ds_url_projeto']; ?>" title="Deletar" style="border-radius: 0; width: 12%; padding-top: 1.3%; padding-bottom: 1.3%; border: 1px solid; border-left: 0;">
								Deletar
							</div>
						</div>
					</div>
					<?php
						$sql_denuncias = "SELECT * FROM tb_denuncia_projeto WHERE id_denuncia_projeto = '".$row_dados['cd_projeto']."'";
						$query_denuncias = mysqli_query($mysqli, $sql_denuncias);
						$num_denuncias = mysqli_num_rows($query_denuncias);

						if($num_denuncias > 0){
							?>
								<div style="border: 1px solid; border-bottom: 0;">
							<?php
							while($row_denuncias = mysqli_fetch_assoc($query_denuncias)){
								$sql_autor_da_denuncia = "SELECT * FROM tb_usuario WHERE cd_usuario = '".$row_denuncias['id_autor_denuncia_projeto']."'";
								$query_autor_da_denuncia = mysqli_query($mysqli, $sql_autor_da_denuncia);
								$row_autor_da_denuncia = mysqli_fetch_assoc($query_autor_da_denuncia);
								?>
									<div style="width: 100%; display: flex;">
										<div style="width: 68%; text-align: center; display: flex;">
											<div title="ID autor" style="width: 8.8%; padding-top: 2%; border-right: 1px solid; padding-bottom: 2%; border-bottom: 1px solid;">
												<?php echo $row_autor_da_denuncia['cd_usuario']; ?>
											</div>
											<div title="Autor da denúncia" style="width: 91.2%; padding-top: 2%; padding-bottom: 2%; border-bottom: 1px solid; border-right: 1px solid;">
												<a style="text-decoration: none; color: black;" href="perfil.php?see=<?php echo $row_autor_da_denuncia['ds_url_usuario']; ?>"><?php echo $row_autor_da_denuncia['nm_usuario']; ?></a>
											</div>
										</div>
										<div style="width: 32%; text-align: center; display: flex;">
											<div class="btn-visualizar-motivo btn btn-light" id="<?php echo $row_denuncias['cd_denuncia_projeto']; ?>" title="Visualizar" style="border-radius: 0; width: 62.5%; padding-top: 4%; border-right: 1px solid; border-bottom: 1px solid;">
												Visualizar
											</div>
											<div class="btn-deletar-denuncia btn btn-light" id="<?php echo $row_denuncias['cd_denuncia_projeto']; ?>" title="Deletar" style="border-radius: 0; width: 37.5%; padding-top: 4%; border-bottom: 1px solid;">
												Deletar
											</div>
										</div>
									</div>
								<?php
							}
							?>
								</div>
							<?php
						}else{
							?>
								<div id="div-projeto" style="width: 100%; margin: 0; border-radius: 0; background-color: white; color: black; border: 1px solid;">
									<label class='h6'>Esse projeto não possui nenhuma denúncia!</label>
								</div>
							<?php
						}
					?>
				</div>

				<div class="modal" tabindex="-1" id="modal-deletar-projeto-adm"></div>
				<div class="modal" tabindex="-1" id="modal-visualizar-motivo-adm"></div>
				<div class="modal" tabindex="-1" id="modal-deletar-denuncia-adm"></div>
			</body>
			</html>
			<?php
		}else{
			header('Location: home_adm.php');
		}
	}else{
		header('Location: home_adm.php');
	}
?>