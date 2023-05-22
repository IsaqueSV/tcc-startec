<?php
	include('banco/conexao.php');
	
	if(isset($_GET['see'])){
		session_start();
		if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
			$cdUsuario = $_SESSION['cdUsuario'];
			$idNivel = $_SESSION['idNivel'];
		}
		$url = $_GET['see'];

		$sql = "SELECT * FROM tb_projeto INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario WHERE ds_url_projeto = '$url'";
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
			<title>Projeto - <?php echo $row['nm_projeto']; ?></title>
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
					$("#modal-edita-comentario-projeto").fadeOut();
					$("#modal-deletar-projeto-adm").fadeOut();
					$("#denuncia-projeto").fadeOut();
					$("#pchave-projeto").fadeOut();
					$("#cadastrar-login").fadeOut();
					
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

					$(".btn-projeto-denuncia").click(function(){
						$id_projeto_denuncia = $(this).attr('id');
						$.ajax({
							url: "config/modal-denuncia-projeto.php",
							type: "POST",
							data: "projetoDenunciado="+$id_projeto_denuncia,
							dataType: "html"
						}).done(function(resposta){
							$("#denuncia-projeto").html(resposta);
							$("#denuncia-projeto").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
							$("#denuncia-projeto").fadeOut();
						}).always(function(){
							console.log("completou");
						});
					});

					$("#btn-publicar-comentario").click(function(){
						$texto_do_comentario = $("#textarea-criar-comentario").val();
						if($texto_do_comentario == "" || $texto_do_comentario == " "){

						}else{
							$.ajax({
								url: "config/comentar-projeto.php",
								type: "POST",
								data: "autor=" + "<?php echo $cdUsuario; ?>" + "&projetoComentado=" + "<?php echo $row['cd_projeto']; ?>" + "&desc-comentario="+$("#textarea-criar-comentario").val(),
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

					$(".btn-editar-comentario").click(function(){
						$id_edita_comentario = $(this).attr('id');

						$.ajax({
							url: "config/modal-edita-comentario-projeto.php",
							type: "POST",
							data: "comentarioEdita="+$id_edita_comentario,
							dataType: "html"
						}).done(function(resposta){
							$("#modal-edita-comentario-projeto").html(resposta);
							$("#modal-edita-comentario-projeto").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
						}).always(function(){
							console.log("completou");
						});
					})

					$(".btn-editar-projeto").click(function(){
						window.location.href = "editar_projeto.php?see="+"<?php echo $url; ?>";
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
			</head>
			<body>
				<?php
					if($num > 0){
						$sql_contagem_curtida = "SELECT * FROM tb_curtida_projeto WHERE id_curtida_projeto = '".$row['cd_projeto']."'";
						$query_contagem_curtida = mysqli_query($mysqli, $sql_contagem_curtida);
						$num_contagem_curtida = mysqli_num_rows($query_contagem_curtida);

						$sql_contagem_comentario = "SELECT * FROM tb_comentario_projeto INNER JOIN tb_usuario ON tb_comentario_projeto.id_autor_comentario_projeto = tb_usuario.cd_usuario WHERE id_comentario_projeto = '".$row['cd_projeto']."'";
						$query_contagem_comentario = mysqli_query($mysqli, $sql_contagem_comentario);
						$num_contagem_comentario = mysqli_num_rows($query_contagem_comentario);

						if(isset($cdUsuario) AND isset($idNivel)){
							$sql_eu = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
							$query_eu = mysqli_query($mysqli, $sql_eu);
							$dados_eu = mysqli_fetch_object($query_eu);

							$img_caminho = $dados_eu->path_foto_usuario;

							$sql_pega_curtida = "SELECT * FROM tb_curtida_projeto WHERE id_autor_curtida_projeto = '$cdUsuario' AND id_curtida_projeto = '".$row['cd_projeto']."'";
							$query_pega_curtida = mysqli_query($mysqli, $sql_pega_curtida);
							$num_pega_curtida = mysqli_num_rows($query_pega_curtida);

							$sql_pega_denuncia = "SELECT * FROM tb_denuncia_projeto WHERE id_autor_denuncia_projeto = '$cdUsuario' AND id_denuncia_projeto = '".$row['cd_projeto']."'";
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
													<a class="nav-link" title="Meu perfil" id="li-a" href="meu_perfil.php">
														<img src="<?php echo $img_caminho; ?>" id="li-img" class="rounded-circle" style="width: 40px; height: 40px;">
													</a>
												</li>
												<li class="nav-item" id="li-topo">
													<a class="nav-link" href="config/finaliza-sessao.php" id="a-sair">Sair</a>
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
							}
							?>
								<!-- cabeçalho do projeto --> 
								<div id="cabecalho-projeto" style="width: 80%; margin-left: 10%; margin-right: 10%;">
									<div id="cabecalho-projeto-esquerda" style="display: flex; width: 100%; background-color: #2a3550; color: white; border: none;">
										<div id="titulo-projeto-esquerda" style="display: flex; width: 70%;" title="Nome do projeto">
											<label><?php echo $row['nm_projeto']; ?></label>
										</div>
										<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;" title="Data de publicação">
											<label style="color: white;"><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row['created_projeto'])); ?></label>
										</div>
									</div>
									<div id="cabecalho-projeto-direita">
										<?php
											if($idNivel == 3){
												?>
													<button class="btn-deletar-projeto btn btn-light" id="<?php echo $row['ds_url_projeto']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 86%; height: 100%; border-radius: 0; border: 1px solid; text-align: center;">Excluir</button>
												<?php
											}else{
												if($num_pega_curtida > 0){
													?>
														<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: red; cursor: pointer;" id="<?php echo $row['cd_projeto']; ?>"></i>
														<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_projeto']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #DCDCDC; width: 50%; border-radius: 0; border: 1px solid;">Curtido</button> -->
													<?php
												}else{
													?>
														<i class="btn-projeto-curtida fa-regular fa-heart" style="font-size: 30px; color: white; cursor: pointer;" id="<?php echo $row['cd_projeto']; ?>"></i>
														<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_projeto']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
													<?php
												}
												if($row['id_autor_projeto'] == $cdUsuario){
													?>
														<i class="btn-editar-projeto fa-solid fa-gear" style="font-size: 30px; color: white; cursor: pointer;"></i>
														<!-- <button class="btn-editar-projeto btn btn-light" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Editar</button> -->
													<?php
												}else{
													if($num_pega_denuncia > 0){
														?>
															<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_projeto']; ?>" style="font-size: 30px;color: yellow; cursor: pointer;"></i>
															<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_projeto']; ?>" style="transition: 0.5s ease; background-color: #DCDCDC; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
														<?php
													}else{
														?>
															<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_projeto']; ?>" style="font-size: 30px; color: white; cursor: pointer;"></i>
															<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_projeto']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
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
											<?php
												if($row['id_autor_projeto'] == $cdUsuario){
													?>
														<a style="text-decoration: none; color: white;" href="meu_perfil.php"><img src="<?php echo $row['path_foto_usuario']; ?>" id="foto-autor-projeto" class="rounded-circle"></a>
														<a style="text-decoration: none; color: white; margin-top: 0.6%; margin-left: 1.4%;" href="meu_perfil.php"><?php echo $row['nm_usuario']; ?></a>
													<?php
												}else{
													?>
														<a style="text-decoration: none; color: white;" href="perfil.php?see=<?php echo $row['ds_url_usuario']; ?>"><img src="<?php echo $row['path_foto_usuario']; ?>" id="foto-autor-projeto" class="rounded-circle"></a>
														<a style="text-decoration: none; color: white; margin-top: 0.6%; margin-left: 1.4%;" href="perfil.php?see=<?php echo $row['ds_url_usuario']; ?>"><?php echo $row['nm_usuario']; ?></a>
													<?php
												}
											?>
											
										</div>
										<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;">
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
									<div id="desc-projeto" style="padding: 0; background-color: #49587c;">
										<button style="border-radius: 4px; width: 97%; margin-left: 1.5%; margin-right: 1.5%;" class="pchave-projeto" id="<?php echo $row['cd_pchave_projeto']; ?>">
											<?php echo $row['nm_pchave_projeto']; ?>
									 	</button>
									</div>
									<div id="footer-projeto" style="border-top: 1px solid; background-color: #49587c;">
										<div id="tabela-de-arquivos-projeto" style="padding: 1.5%;">
											<div style="text-align: center; border: 1px solid; padding-top: 1%; background-color: white; padding-bottom: 1%;">
												<label>ARQUIVOS</label>
											</div>
						  						<?php 
													$sql_arquivo = "SELECT * FROM tb_arquivo WHERE id_projeto_arquivo = '".$row['cd_projeto']."'";
													$query_arquivo = mysqli_query($mysqli, $sql_arquivo);
													$num_arquivo = mysqli_num_rows($query_arquivo);

													if($num_arquivo > 0){
														while($row_arquivo = mysqli_fetch_assoc($query_arquivo)){
															?>
																<div style="width: 100%; display: flex; background-color: white;">
																	<div style="width: 72%; padding-left: 2%; padding-top: 0.6%; padding-bottom: 0.6%; border: 1px solid; border-top: 0;" id="arquivo-do-projeto-esquerda">
																		<a title="nome do arquivo" style="text-decoration: none; color: black;"><?php echo $row_arquivo['nm_arquivo']; ?></a>
																	</div>
																	<div style="width: 28%; border: 1px solid; padding-top: 0.6%; padding-bottom: 0.6%; border-top: 0; border-left: 0; text-align: center;" id="arquivo-do-projeto-direita">
																		<a href="<?php echo $row_arquivo['ds_caminho']; ?>" style="text-decoration: none; color: black;">BAIXAR</a>
																	</div>
																</div>
															<?php
														}
													}else{
														?>
															<div style="width: 100%;">
																<div style="background-color: white; padding-top: 1%; padding-bottom: 1%; border: 1px solid; border-top: 0; text-align: center; background-color: white;" id="arquivo-do-projeto-esquerda">
																	<i style="color: black;">Este projeto não possui nenhum arquivo</i>
																</div>
															</div>	
														<?php
													}
												?>
										</div>
									</div>
								</div>

								<div class="projeto">
									<div id="titulo-projeto" style="display: flex; border-bottom: 1px solid; background-color: #2a3550; color: white;">
										<label style="padding-top: 1.3%; padding-bottom: 1.3%; padding-left: 1.5%;">DESCRIÇÃO</label>
									</div>
									<div id="desc-projeto" style="padding: 1.5%; background-color: #49587c;">
										<textarea style="width: 100%; padding: 1%; border-radius: 3px; border: 1px solid;" rows="4" readonly><?php echo $row['ds_projeto']; ?></textarea>
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
													if($row_comentario['id_autor_comentario_projeto'] == $cdUsuario){
														?>
														<div style="margin-top: 1%; margin-bottom: 1.5%; display: flex;">
												 			<div id="left-comentarios" style="width: 4%;">
												 				<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><img id="foto-comentario" class="rounded-circle" src="<?php echo $row_comentario['path_foto_usuario']; ?>"></a>
												 			</div>
												 			<div id="right-comentarios" style="width: 94%; margin-left: 2%;">
																<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><label>Você</label></a>
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_projeto'])); ?></label>
													 			<label style="margin-top: 0.2%; display: flex;">
													 				<textarea name="comentario" style="width: 96%;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_projeto']; ?></textarea>
													 				<button class="btn-editar-comentario" id="<?php echo $row_comentario['cd_comentario_projeto']; ?>" style="width: 4%; border: 1px solid; border-color: #DCDCDC; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"><i class="fa-solid fa-ellipsis"></i></button>
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
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_projeto'])); ?></label>
													 			<label style="display: flex; margin-top: 0.2%;">
													 				<textarea name="comentario" style="width: 100%; border-radius: 6px;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_projeto']; ?></textarea>
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
															<i style="color: black;">Este projeto não possui nenhum comentário</i>
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
							?>
							<script>
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
				
								$(document).ready(function(){
									$(".btn-alerta-cad").click(function(){
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

								})
							</script>
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

							<!-- Navbar (navega) -->
							<nav class="nav nav-pills nav-justified" id="nav-navega">
						  		<a class="nav-link p-3" id="a-navega-a" href="sobre_nao_logado.php">Quem somos</a>
						  		<a class="nav-link p-3" id="a-navega-b" href="projetos_nao_logado.php">Projetos</a>
						  		<a class="nav-link p-3" id="a-navega-c" href="escolas_nao_logado.php">Escolas</a>
						  		<a class="nav-link p-3" id="a-navega-f" href="ajuda_nao_logado.php">Ajuda</a>
							</nav>
							
							<!-- cabeçalho do projeto --> 
							<div id="cabecalho-projeto" style="width: 80%; margin-left: 10%; margin-right: 10%;">
								<div id="cabecalho-projeto-esquerda" style="display: flex; width: 100%;background-color: #2a3550; color: white; border: none;">
									<div id="titulo-projeto-esquerda" style="display: flex; width: 70%;" title="Nome do projeto">
										<label><?php echo $row['nm_projeto']; ?></label>
									</div>
									<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;" title="Data de publicação">
										<label style="color: white;"><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row['created_projeto'])); ?></label>
									</div>
								</div>
								<div id="cabecalho-projeto-direita">
									<i class="btn-alerta-cad fa-regular fa-heart" style="font-size: 30px; color: white; cursor: pointer;"></i>
									<!-- <button class="btn-alerta-cad btn" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
									<i class="btn-alerta-cad fa-solid fa-triangle-exclamation" style="font-size: 30px; color: white; cursor: pointer;"></i>
									<!-- <button class="btn-alerta-cad btn" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
								</div>
							</div>

							<div class="projeto" style="margin-top: 4%;">
								<div id="titulo-projeto" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid; background-color: #2a3550; color: white; ">
									<div id="titulo-projeto-esquerda" title="Autor" style="width: 70%; padding: 1%;">
										<a style="text-decoration: none; color: white;" class="btn-alerta-cad"><img src="<?php echo $row['path_foto_usuario']; ?>" id="foto-autor-projeto" class="rounded-circle"></a>
										<a style="text-decoration: none; color: white; margin-top: 0.6%; margin-left: 1.4%;" class="btn-alerta-cad"><?php echo $row['nm_usuario']; ?></a>
									</div>
									<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;">
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
									<div id="desc-projeto" style="padding: 0; background-color: #49587c;">
										<button style="border-radius: 4px; width: 97%; margin-left: 1.5%; margin-right: 1.5%;" class="pchave-projeto" id="<?php echo $row['cd_pchave_projeto']; ?>">
											<?php echo $row['nm_pchave_projeto']; ?>
									 	</button>
									</div>
									<div id="footer-projeto" style="border-top: 1px solid; background-color: #49587c;">
										<div id="tabela-de-arquivos-projeto" style="padding: 1.5%;">
											<div style="text-align: center; border: 1px solid; padding-top: 1%; background-color: white; padding-bottom: 1%;">
												<label>ARQUIVOS</label>
											</div>
					  						<?php 
												$sql_arquivo = "SELECT * FROM tb_arquivo WHERE id_projeto_arquivo = '".$row['cd_projeto']."'";
												$query_arquivo = mysqli_query($mysqli, $sql_arquivo);
												$num_arquivo = mysqli_num_rows($query_arquivo);

												if($num_arquivo > 0){
													while($row_arquivo = mysqli_fetch_assoc($query_arquivo)){
														?>
															<div style="width: 100%; display: flex;">
																<div style="width: 72%; padding-left: 2%; padding-top: 0.6%; padding-bottom: 0.6%; border: 1px solid; border-top: 0; background-color: white;" id="arquivo-do-projeto-esquerda">
																	<a title="nome do arquivo" style="text-decoration: none; color: black;"><?php echo $row_arquivo['nm_arquivo']; ?></a>
																</div>
																<div style="width: 28%; border: 1px solid; padding-top: 0.6%; padding-bottom: 0.6%; border-top: 0; border-left: 0; text-align: center;" id="arquivo-do-projeto-direita">
																	<a href="<?php echo $row_arquivo['ds_caminho']; ?>" style="text-decoration: none; color: black;">BAIXAR</a>
																</div>
															</div>
														<?php
													}
												}else{
													?>
														<div style="width: 100%;">
															<div style="padding-top: 1%; padding-bottom: 1%; border: 1px solid; border-top: 0; text-align: center; background-color: white;" id="arquivo-do-projeto-esquerda">
																<i style="color: black;">Este projeto não possui nenhum arquivo</i>
															</div>
														</div>	
													<?php
												}
											?>
										</div>
									</div>
								</div>

								<div class="projeto" style="margin-top: 4%;">
									<div id="titulo-projeto" style="display: flex; border-bottom: 1px solid; background-color: #2a3550; color: white;">
										<label style="padding-top: 1.3%; padding-bottom: 1.3%; padding-left: 1.5%;">DESCRIÇÃO</label>
									</div>
									<div id="desc-projeto" style="padding: 1.5%; background-color: #49587c;">
										<textarea style="width: 100%; padding: 1%; border-radius: 3px; border: 1px solid;" rows="4" readonly><?php echo $row['ds_projeto']; ?></textarea>
									</div>						
								</div>

								<div class="projeto" style="margin-top: 4%;">
									<div id="titulo-projeto" style="display: flex; border-bottom: 1px solid; background-color: #2a3550; color: white;">
										<label style="padding-top: 1.3%; padding-bottom: 1.3%; padding-left: 1.5%;">COMENTÁRIOS</label>
									</div>
									<div style="padding-top: 1%; padding-bottom: 1%; width: 100%; background-color: #49587c; color: white;">
										<?php
											if($num_contagem_comentario > 0){
												while($row_comentario = mysqli_fetch_assoc($query_contagem_comentario)){
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
									 					<div style="margin-top: 1%; margin-left: 1.5%; margin-bottom: 1.5%; margin-right: 1.5%; display: flex;">
													 		<div id="left-comentarios" style="width: 4%;">
													 			<img id="foto-comentario" class="btn-alerta-cad rounded-circle" src="<?php echo $row_comentario['path_foto_usuario']; ?>">
															</div>
												 			<div id="right-comentarios" style="width: 94%; margin-left: 2%;">
																<label class="btn-alerta-cad"><?php echo $row_comentario['nm_usuario']; ?></label>
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_projeto'])); ?></label>
														 		<label style="display: flex; margin-top: 0.2%;">
														 			<textarea name="comentario" style="width: 100%; border-radius: 6px;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_projeto']; ?></textarea>
														 		</label>
													 		</div>
														</div>	
													<?php
												}
											}else{
											?>
												<div style="width: 100%;">
													<div style="border: 1px solid #DCDCDC; border-radius: 4px; margin-left: 1.5%; margin-right: 1.5%; padding-top: 1%; padding-bottom: 1%; text-align: center; background-color: white;" id="arquivo-do-projeto-esquerda">
														<i style="color: black;">Este projeto não possui nenhum comentário</i>
													</div>
												</div>	
											<?php
											}
										?>
									</div>
									<div id="footer-projeto" style="border-top: 1px solid; padding: 1.5%; padding-bottom: 0; background-color: #49587c;">
										<textarea id="textarea-criar-comentario" style="width: 100%; padding: 1%; background-color: white;" rows="2" maxlength="400" placeholder="Digite algo aqui" disabled></textarea>
										<div style="text-align: right;">
											<button class="btn-alerta-cad btn" style="border-radius: 0; border: 1px solid black; width: 20%; margin-top: 0.5%; margin-bottom: 1%;">Postar comentário</button>
											<style>
												button.btn-publicar-comentario, button.btn-alerta-cad{
													background-color: #F0F0F0;
													transition: 0.5s ease;
												}
												button.btn-publicar-comentario:hover, button.btn-alerta-cad:hover{
													background-color: #DCDCDC;
													transition: 0.5s ease;
												}
											</style>
										</div>
									</div>
								</div>
							<?php							
						}
					}else{
						header('Location: index.php');
					}
				?>
				<div class="modal" tabindex="-1" id="modal-comentario-projeto"></div>
				<div class="modal" tabindex="-1" id="modal-edita-comentario-projeto"></div>
				<div class="modal" tabindex="-1" id="denuncia-projeto"></div>
				<div class="modal" tabindex="-1" id="cadastrar-login"></div>
				<div class="modal" tabindex="-1" id="pchave-projeto"></div>
				<div class="modal" tabindex="-1" id="modal-deletar-projeto-adm"></div>
			</body>
		</html>
		<?php
	}else{
		header('Location: index.php');
	}
?>