<?php
	include('banco/conexao.php');

	if(isset($_GET['see'])){
		session_start();
		if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
			$cdUsuario = $_SESSION['cdUsuario'];
			$idNivel = $_SESSION['idNivel'];

		}else{
			header('Location: index.php');
		}

		$url = $_GET['see'];
		if($idNivel == 1){
			$sql_confere = "SELECT * FROM tb_curriculo WHERE ds_url_curriculo = '$url'";
			$query_confere = mysqli_query($mysqli, $sql_confere);
			$row_confere = mysqli_fetch_assoc($query_confere);

			if($row_confere['id_autor_curriculo'] != $cdUsuario){
				header('Location: index.php');
			}
		}

		$sql = "SELECT * FROM tb_curriculo INNER JOIN tb_etec ON tb_curriculo.id_etec_curriculo = tb_etec.cd_etec INNER JOIN tb_estado_civil ON tb_curriculo.id_estado_civil = tb_estado_civil.cd_estado_civil INNER JOIN tb_municipio ON tb_curriculo.id_municipio = tb_municipio.cd_municipio INNER JOIN tb_genero ON tb_curriculo.id_genero_curriculo = tb_genero.cd_genero INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario WHERE ds_url_curriculo = '$url'";
		$query = mysqli_query($mysqli, $sql);
		$num = mysqli_num_rows($query);
		$row = mysqli_fetch_assoc($query);

		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<!--
				adiciona foto no site 
				<link rel="icon" href="dados/img/ft_usuarios/user.jpg"> 
			-->
			<title>Currículo - <?php echo $row['nm_completo_curriculo']; ?></title>
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
					$("#modal-edita-comentario-curriculo").fadeOut();
					$("#denuncia-curriculo").fadeOut();
					$("#pchave-curriculo").fadeOut();
					
					$(".btn-projeto-denuncia").click(function(){
						$id_curriculo_denuncia = $(this).attr('id');
						
						$.ajax({
							url: "config/modal-denuncia-curriculo.php",
							type: "POST",
							data: "curriculoDenunciado="+$id_curriculo_denuncia,
							dataType: "html"
						}).done(function(resposta){
							$("#denuncia-curriculo").html(resposta);
							$("#denuncia-curriculo").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
							$("#denuncia-curriculo").fadeOut();
						}).always(function(){
							console.log("completou");
						});
					});

					$(".btn-projeto-curtida").click(function(){
						$id_curriculo_curtido = $(this).attr('id');

						$.ajax({
							url: "config/curtir-curriculo.php",
							type: "POST",
							data: "curriculoCurtido="+$id_curriculo_curtido + "&autor="+ "<?php echo $cdUsuario; ?>",
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
						$id_pchave_curriculo = $(this).attr('id');

						$.ajax({
							url: "config/modal-pchave-curriculo.php",
							type: "POST",
							data: "idPchaveCurriculo="+$id_pchave_curriculo,
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

					$("#btn-publicar-comentario").click(function(){
						$texto_do_comentario = $("#textarea-criar-comentario").val();
						if($texto_do_comentario == "" || $texto_do_comentario == " "){

						}else{
							$.ajax({
								url: "config/comentar-curriculo.php",
								type: "POST",
								data: "autor=" + "<?php echo $cdUsuario; ?>" + "&curriculoComentado=" + "<?php echo $row['cd_curriculo']; ?>" + "&desc-comentario="+$("#textarea-criar-comentario").val(),
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
						}
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
					})
				});
				</script>
				<style>
					div#cabecalho-projeto, div#div-ver-projeto-a, div#div-ver-projeto-b{
						width: 96%;
						display: flex;
						margin-left: 2%;
						margin-right: 2%;
						margin-top: 3%;
					}
					div#cabecalho-projeto-esquerda{
						width: 85%;
						padding-top: 1%;
						padding-bottom: 1%;
						padding-left: 2%;
						border: 1px solid;
					}
					div#cabecalho-projeto-direita{
						width: 10%;
						margin-left: 5%;
						text-align: center;
						padding-top: 0.5%;
						padding-bottom: 0.5%;
						background-color: #2a3550;
					}
					img#foto-autor-projeto{
						width: 40px;
						height: 40px;
						border: 1px solid; 
						margin-left: 1%;
					}
					div#arquivo-do-projeto-direita{
						cursor: pointer;
						background-color: #F0F0F0;
						transition: 0.5s ease;
					}
					div#arquivo-do-projeto-direita:hover{
						background-color: #DCDCDC;
						transition: 0.5s ease;
					}
					div#info-metade{
						background-color: #F0F0F0;
						transition: 0.5s ease;
					}
					div#info-metade:hover{
						background-color: #DCDCDC;
						transition: 0.5s ease;
					}
				</style>
			</head>
			<body>
				<?php
					if($num > 0){
						$sql_contagem_curtida = "SELECT * FROM tb_curtida_curriculo WHERE id_curtida_curriculo = '".$row['cd_curriculo']."'";
						$query_contagem_curtida = mysqli_query($mysqli, $sql_contagem_curtida);
						$num_contagem_curtida = mysqli_num_rows($query_contagem_curtida);

						$sql_contagem_comentario = "SELECT * FROM tb_comentario_curriculo INNER JOIN tb_usuario ON tb_comentario_curriculo.id_autor_comentario_curriculo = tb_usuario.cd_usuario WHERE id_comentario_curriculo = '".$row['cd_curriculo']."'";
						$query_contagem_comentario = mysqli_query($mysqli, $sql_contagem_comentario);
						$num_contagem_comentario = mysqli_num_rows($query_contagem_comentario);

						$sql_eu = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
						$query_eu = mysqli_query($mysqli, $sql_eu);
						$dados_eu = mysqli_fetch_object($query_eu);

						$img_caminho = $dados_eu->path_foto_usuario;

						$sql_pega_curtida = "SELECT * FROM tb_curtida_curriculo WHERE id_autor_curtida_curriculo = '$cdUsuario' AND id_curtida_curriculo = '".$row['cd_curriculo']."'";
						$query_pega_curtida = mysqli_query($mysqli, $sql_pega_curtida);
						$num_pega_curtida = mysqli_num_rows($query_pega_curtida);

						$sql_pega_denuncia = "SELECT * FROM tb_denuncia_curriculo WHERE id_autor_denuncia_curriculo = '$cdUsuario' AND id_denuncia_curriculo = '".$row['cd_curriculo']."'";
						$query_pega_denuncia = mysqli_query($mysqli, $sql_pega_denuncia);
						$num_pega_denuncia = mysqli_num_rows($query_pega_denuncia);

						if($idNivel == 1){
							?>
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
							<?php
						}else if($idNivel == 2){
							?>
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
							<?php
						}else if($idNivel == 3){
							?>
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
							<?php
						}else{
							header('Location: index.php');
						}

						?>

							<!-- cabeçalho do curriculo --> 
							<div id="cabecalho-projeto" style="width: 80%; margin-left: 10%; margin-right: 10%;">
								<div id="cabecalho-projeto-esquerda" style="display: flex; width: 100%; background-color: #2a3550; color: white; border: none;">
									<div id="titulo-projeto-esquerda" style="display: flex; width: 70%;" title="Autor">
										<label><?php echo $row['nm_completo_curriculo']; ?></label>
									</div>
									<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;" title="Data de publicação">
										<label><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row['created_curriculo'])); ?></label>
									</div>
								</div>
								<div id="cabecalho-projeto-direita">
									<?php
										if($idNivel == 3){
											?>
												<button class="btn-deletar-curriculo btn btn-light" id="<?php echo $row['ds_url_curriculo']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 86%; height: 100%; border-radius: 0; border: 1px solid; text-align: center;">Excluir</button>

												<!-- <button class="btn-deletar-curriculo btn btn-light" id="<?php echo $row['ds_url_curriculo']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 100%; border-radius: 0; border: 1px solid;">Excluir</button> -->
											<?php
										}else{
											if($num_pega_curtida > 0){
												?>
													<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: red; cursor: pointer;" id="<?php echo $row['cd_curriculo']; ?>"></i>

													<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_curriculo']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #DCDCDC; width: 50%; border-radius: 0; border: 1px solid;">Curtido</button> -->
												<?php
											}else{
												?>
													<i class="btn-projeto-curtida fa-regular fa-heart" style="font-size: 30px; color: white; cursor: pointer;" id="<?php echo $row['cd_curriculo']; ?>"></i>
													<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_curriculo']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
												<?php
											}

											if($idNivel == 1){
												?>
													<a href="editar_curriculo.php?see=<?php echo $row['ds_url_curriculo']; ?>" id="<?php echo $row['cd_curriculo']; ?>" style="text-decoration: none; transition: 0.5s ease;padding-top: 14px; margin-left: 1%; width: 50%; border-radius: 0;"><i class="btn-projeto-editar fa-solid fa-gear" style="font-size: 30px; color: white; cursor: pointer;"></i></a>
												<?php
											}else{
												if($num_pega_denuncia > 0){
													?>
														<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_curriculo']; ?>" style="font-size: 30px;color: yellow; cursor: pointer;"></i>

														<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_curriculo']; ?>" style="transition: 0.5s ease; background-color: #DCDCDC; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
													<?php
												}else{
													?>
														<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_curriculo']; ?>" style="font-size: 30px; color: white; cursor: pointer;"></i>
														
														<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_curriculo']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
													<?php
												}
											}
										}			
									?>	
								</div>
							</div>

							<div class="projeto" style="margin-top: 4%;">
								<div id="titulo-projeto" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid; background-color: #2a3550; color: white;">
									<div id="titulo-projeto-esquerda" title="Autor" style="width: 70%; padding: 1%;">
									</div>
									<div id="titulo-projeto-direita" style="width: 30%; text-align: right; padding: 1.5%;">
										<label>
											<?php
												echo $num_contagem_curtida;
												if($num_contagem_curtida == 0 OR $num_contagem_curtida > 1){
													echo " curtidas - ";
												}else{
													echo " curtida - ";
												}

												echo $num_contagem_comentario;
												if($num_contagem_comentario == 0 OR $num_contagem_comentario > 1){
													echo " comentários ";
												}else{
													echo " comentário ";
												}
											?>
										</label>
									</div>
								</div>
								<div id="footer-projeto" style="background-color: #49587c; color: white; padding-top: 3%; padding-bottom: 3%;">
									<div id="tabela-de-arquivos-projeto">
										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 3%;">
											<div class="col-md-3" style="padding: 0;">
												<img src="<?php echo $row['path_foto_curriculo']; ?>" style="width: 300px; height: 300px; padding: 0; border-color: black;" class="img-thumbnail" id="uploadPreview">
											</div>
											<div class="col-md-9" style="padding: 0; padding-top: 3%; padding-left: 2%;">
												<label for="nome" style="margin-bottom: 1%;">Nome completo:</label>
												<input type="text" style="margin-bottom: 1.5%;" class="form-control" name="nome" id="nome" value="<?php echo $row['nm_completo_curriculo']; ?>" readonly>
												<label for="email" style="margin-bottom: 1%;">Email:</label>
												<input type="email" style="margin-bottom: 1.5%;" class="form-control" name="email" id="email" value="<?php echo $row['ds_contato_email']; ?>" readonly>
												<label for="cargo" style="margin-bottom: 1%;">Cargo desejado</label>
												<input type="text" class="form-control" name="cargo" id="cargo" value="<?php echo $row['ds_cargo']; ?>" readonly>
											</div>
										</div>
										
										<button class="pchave-projeto" id="<?php echo $row['cd_pchave_curriculo']; ?>">
											<?php echo $row['nm_pchave_curriculo']; ?>
										</button>
										
										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
											<div class="col" style="padding: 0;">
												<label for="nascimento" style="margin-bottom: 1%;">Data de nascimento:</label>
												<input type="text" class="form-control" name="nascimento" id="nascimento" value="<?php echo $row['ds_nascimento']; ?>" readonly>
											</div>
											<div class="col" style="padding: 0; margin-left: 2%;">
												<label for="estado-civil" style="margin-bottom: 1%;">Estado civil:</label>
												<input type="text" class="form-control" name="estado-civil" id="estado-civil" value="<?php echo $row['nm_estado_civil']; ?>">
											</div>
										</div>
										
										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
											<label for="telefone" style="margin-bottom: 1%; padding: 0;">Número de telefone:</label>
											<input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $row['ds_contato_telefone']; ?>">
										</div>

										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 1%;">
											<div class="col" style="padding: 0;">
												<label for="cidade" style="margin-bottom: 1%;">Cidade:</label>
												<input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo $row['nm_municipio']; ?>" readonly>
											</div>
											<div class="col" style="padding: 0; margin-left: 2%;">
												<label for="cep" style="margin-bottom: 1%;">CEP:</label>
												<input type="text" class="form-control" name="cep" id="cep" value="<?php echo $row['ds_cep']; ?>">
											</div>
										</div>

										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 3%;">
											<div class="col" style="padding: 0;">
												<label for="etec" style="margin-bottom: 1%;">ETEC frequentada:</label>
												<input type="text" class="form-control" name="etec" id="etec" value="<?php echo $row['nm_etec']; ?>" readonly>
											</div>
											<div class="col" style="padding: 0; margin-left: 2%;">
												<label for="genero" style="margin-bottom: 1%;">Gênero:</label>
												<input type="text" class="form-control" name="genero" id="genero" value="<?php echo $row['nm_genero']; ?>">
											</div>
										</div>

										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 2%;">
											<label for="idiomas" style="margin-bottom: 1%; padding: 0;">Idiomas:</label>
											<textarea class="form-control" name="idiomas" id="idiomas" placeholder="<?php echo $row['ds_idioma']; ?>" readonly></textarea>
										</div>

										<div class="row" style="margin-left: 3%; margin-right: 3%; margin-bottom: 2%;">
											<label for="qualidades" style="margin-bottom: 1%; padding: 0;">Qualidades:</label>
											<textarea class="form-control" name="qualidades" id="qualidades" placeholder="<?php echo $row['ds_qualidade']; ?>" readonly></textarea>
										</div>

										<div class="row" style="margin-left: 3%; margin-right: 3%;">
											<label for="cursos" style="margin-bottom: 1%; padding: 0;">Cursos:</label>
											<textarea class="form-control" name="cursos" id="cursos" placeholder="<?php echo $row['ds_curso']; ?>" readonly></textarea>
										</div>
									</div>	
								</div>
							</div>

							<div class="projeto">
									<div id="titulo-projeto" style="display: flex; border-bottom: 1px solid; background-color: #2a3550; color: white;">
										<label style="padding-top: 1.3%; padding-bottom: 1.3%; padding-left: 1.5%;">COMENTÁRIOS</label>
									</div>
									<div id="desc-projeto" style="padding: 1.5%; background-color: #49587c;">
										<div style="padding-top: 1%; padding-bottom: 1%; width: 100%; background-color: #49587c; color: white;">
										<?php
											if($num_contagem_comentario > 0){
												while($row_comentario = mysqli_fetch_assoc($query_contagem_comentario)){
													if($row_comentario['id_autor_comentario_curriculo'] == $cdUsuario){
														?>
														<div style="margin-top: 1%; margin-bottom: 1.5%; display: flex;">
												 			<div id="left-comentarios" style="width: 4%;">
												 				<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><img id="foto-comentario" class="rounded-circle" src="<?php echo $row_comentario['path_foto_usuario']; ?>"></a>
												 			</div>
												 			<div id="right-comentarios" style="width: 94%; margin-left: 2%;">
																<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><label>Você</label></a>
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_curriculo'])); ?></label>
													 			<label style="margin-top: 0.2%; display: flex;">
													 				<textarea name="comentario" style="width: 96%;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_curriculo']; ?></textarea>
													 				<button class="btn-editar-comentario" id="<?php echo $row_comentario['cd_comentario_curriculo']; ?>" style="width: 4%; border: 1px solid; border-color: #DCDCDC; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"><i class="fa-solid fa-ellipsis"></i></button>
													 			</label>
												 			</div>
														</div>	
														<?php
													}else{
														?>
														<style>
									 						@media only screen and (max-width: 1440px) {
															  
															  div#right-comentarios{
															  	margin-left: 1.5%;
															  	width: 94.5%;
															  }
															}
									 						@media only screen and (max-width: 1152px) {
															  
															  div#right-comentarios{
															  	margin-left: 2.5%;
															  	width: 93.5%;
															  }
															}
									 						@media only screen and (max-width: 1080px) {
															  
															  div#right-comentarios{
															  	margin-left: 5.5%;
															  	width: 90.5%;
															  }
															}	
									 					</style>
									 					<div style="margin-top: 1%; margin-bottom: 1.5%; display: flex;">
												 			<div id="left-comentarios" style="width: 4%;">
												 				<a href="perfil.php?see=<?php echo $row_comentario['ds_url_usuario']; ?>" style="color: white; text-decoration: none; cursor: pointer;"><img id="foto-comentario" class="rounded-circle" src="<?php echo $row_comentario['path_foto_usuario']; ?>"></a>
												 			</div>
												 			<div id="right-comentarios" style="width: 94%; margin-left: 2%;">
																<a href="perfil.php?see=<?php echo $row_comentario['ds_url_usuario']; ?>" style="color: white; text-decoration: none; cursor: pointer;"><label><?php echo $row_comentario['nm_usuario']; ?></label></a>
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_curriculo'])); ?></label>
													 			<label style="display: flex; margin-top: 0.2%;">
													 				<textarea name="comentario" style="width: 100%; border-radius: 6px;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_curriculo']; ?></textarea>
													 			</label>
												 			</div>
														</div>	
														<?php
													}
												}
											}else{
												?>
													<div>
														<div style="border: 1px solid #DCDCDC;  border-radius: 4px; padding-top: 1%; padding-bottom: 1%; text-align: center; background-color: white;">
															<i style="color: black;">Este currículo não possui nenhum comentário</i>
														</div>
													</div>	
												<?php
											}
										?>
									</div>
									</div>
									
									<?php
										if($idNivel == 3){
											?>

											<?php
										}else{
											?>
											<div id="footer-projeto" style="border-top: 1px solid; padding: 1.5%; padding-bottom: 0; background-color: #49587c;">
												<textarea id="textarea-criar-comentario" style="width: 100%; padding: 1%; background-color: white;" rows="2" maxlength="400" placeholder="Digite algo aqui"></textarea>
												<div style="text-align: right;">
													<button class="btn" id="btn-publicar-comentario" style="border-radius: 0; border: 1px solid black; width: 20%; margin-top: 0.5%; margin-bottom: 1%;">Postar comentário</button>
													<style>
														button#btn-publicar-comentario{
															background-color: #F0F0F0;
															transition: 0.5s ease;
														}
														button#btn-publicar-comentario:hover{
															background-color: #DCDCDC;
															transition: 0.5s ease;
														}
													</style>
												</div>
											</div>
											<?php
										}
									?>
								</div>
						<?php
					}else{
						header('Location: index.php');
					}
				?>
				<div class="modal" tabindex="-1" id="modal-comentario-curriculo"></div>
				<div class="modal" tabindex="-1" id="modal-edita-comentario-curriculo"></div>
				<div class="modal" tabindex="-1" id="denuncia-curriculo"></div>
				<div class="modal" tabindex="-1" id="pchave-curriculo"></div>
				<div class="modal" tabindex="-1" id="modal-deletar-curriculo-adm"></div>
			</body>
		</html>
		<?php
	}else{
		header('Location: index.php');
	}
?>