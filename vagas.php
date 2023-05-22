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

		$sql = "SELECT * FROM tb_vaga INNER JOIN tb_pchave_curriculo ON tb_vaga.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_pchave_vaga ON tb_vaga.id_pchave_vaga = tb_pchave_vaga.cd_pchave_vaga INNER JOIN tb_usuario ON tb_vaga.id_autor_vaga = tb_usuario.cd_usuario WHERE ds_url_vaga = '$url'";
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
			<title>Vaga - <?php echo $row['nm_vaga']; ?></title>
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
					$("#modal-edita-comentario-vaga").fadeOut();
					$("#modal-deletar-vaga-adm").fadeOut();
					$("#denuncia-vaga").fadeOut();
					$("#pchave-vaga").fadeOut();
					
					$(".btn-deletar-vaga").click(function(){
						$id_vaga = $(this).attr('id');

						$.ajax({
							url: "config/modal-deletar-vaga-adm.php",
							type: "POST",
							data: "idVaga="+$id_vaga,
							dataType: "html"
						}).done(function(resposta){
							$("#modal-deletar-vaga-adm").html(resposta);
							$("#modal-deletar-vaga-adm").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
							$("#modal-deletar-vaga-adm").fadeOut();
						}).always(function(){
							console.log("completou");
						});
					})

					$(".btn-projeto-denuncia").click(function(){
						$id_vaga_denuncia = $(this).attr('id');
						$.ajax({
							url: "config/modal-denuncia-vaga.php",
							type: "POST",
							data: "vagaDenunciada="+$id_vaga_denuncia,
							dataType: "html"
						}).done(function(resposta){
							$("#denuncia-vaga").html(resposta);
							$("#denuncia-vaga").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
							$("#denuncia-vaga").fadeOut();
						}).always(function(){
							console.log("completou");
						});
					});

					$(".btn-projeto-curtida").click(function(){
						$id_vaga_curtida = $(this).attr('id');

						$.ajax({
							url: "config/curtir-vaga.php",
							type: "POST",
							data: "vagaCurtida="+$id_vaga_curtida + "&autor="+ "<?php echo $cdUsuario; ?>",
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

					$(".candidatar").click(function(){
						$id_vaga_candidatada = $(this).attr('id');

						$.ajax({
							url: "config/candidatar-vaga.php",
							type: "POST",
							data: "vagaCandidato="+$id_vaga_candidatada + "&autor="+ "<?php echo $cdUsuario; ?>" + "&autorVaga="+ "<?php echo $row['id_autor_vaga'] ?>",
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

					$(".curriculo-candidato").click(function(){
						$id_candidato = $(this).attr('id');
						
						window.location.href = "curriculos.php?see="+$id_candidato;
					})

					$(".perfil-candidato").click(function(){
						$id_candidato = $(this).attr('id');
						
						window.location.href = "perfil.php?see="+$id_candidato;
					})

					$("#btn-publicar-comentario").click(function(){
						$texto_do_comentario = $("#textarea-criar-comentario").val();
						if($texto_do_comentario == "" || $texto_do_comentario == " "){

						}else{
							$.ajax({
								url: "config/comentar-vaga.php",
								type: "POST",
								data: "autor=" + "<?php echo $cdUsuario; ?>" + "&vagaComentada=" + "<?php echo $row['cd_vaga']; ?>" + "&desc-comentario="+$("#textarea-criar-comentario").val(),
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
							url: "config/modal-edita-comentario-vaga.php",
							type: "POST",
							data: "comentarioEdita="+$id_edita_comentario,
							dataType: "html"
						}).done(function(resposta){
							$("#modal-edita-comentario-vaga").html(resposta);
							$("#modal-edita-comentario-vaga").fadeIn();
						}).fail(function(jqXHR, textStatus ){
							console.log("Request failed: " + textStatus);
						}).always(function(){
							console.log("completou");
						});
					})

					$(".btn-editar-projeto").click(function(){
						window.location.href = "editar_vaga.php?see="+"<?php echo $url; ?>";
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
					div.curriculo-candidato{
						background-color: #F0F0F0;
						transition: 0.5s ease;
					}
					div.curriculo-candidato:hover{
						background-color: #DCDCDC;
						transition: 0.5s ease;
					}
					div.perfil-candidato{
						background-color: #F0F0F0;
						transition: 0.5s ease;
					}
					div.perfil-candidato:hover{
						background-color: #DCDCDC;
						transition: 0.5s ease;
					}
				</style>
			</head>
			<body>
				<?php
					if($num > 0){
						$sql_contagem_curtida = "SELECT * FROM tb_curtida_vaga WHERE id_curtida_vaga = '".$row['cd_vaga']."'";
						$query_contagem_curtida = mysqli_query($mysqli, $sql_contagem_curtida);
						$num_contagem_curtida = mysqli_num_rows($query_contagem_curtida);

						$sql_contagem_comentario = "SELECT * FROM tb_comentario_vaga INNER JOIN tb_usuario ON tb_comentario_vaga.id_autor_comentario_vaga = tb_usuario.cd_usuario WHERE id_comentario_vaga = '".$row['cd_vaga']."'";
						$query_contagem_comentario = mysqli_query($mysqli, $sql_contagem_comentario);
						$num_contagem_comentario = mysqli_num_rows($query_contagem_comentario);

						if(isset($cdUsuario) AND isset($idNivel)){
							$sql_eu = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
							$query_eu = mysqli_query($mysqli, $sql_eu);
							$dados_eu = mysqli_fetch_object($query_eu);

							$sql_curriculo_eu = "SELECT * FROM tb_curriculo WHERE id_autor_curriculo = '".$dados_eu->cd_usuario."'";
							$query_curriculo_eu = mysqli_query($mysqli, $sql_curriculo_eu);
							$num_curriculo_eu = mysqli_num_rows($query_curriculo_eu);
							$row_curriculo_eu = mysqli_fetch_assoc($query_curriculo_eu);

							$img_caminho = $dados_eu->path_foto_usuario;

							$sql_pega_curtida = "SELECT * FROM tb_curtida_vaga WHERE id_autor_curtida_vaga = '$cdUsuario' AND id_curtida_vaga = '".$row['cd_vaga']."'";
							$query_pega_curtida = mysqli_query($mysqli, $sql_pega_curtida);
							$num_pega_curtida = mysqli_num_rows($query_pega_curtida);

							$sql_pega_denuncia = "SELECT * FROM tb_denuncia_vaga WHERE id_autor_denuncia_vaga = '$cdUsuario' AND id_denuncia_vaga = '".$row['cd_vaga']."'";
							$query_pega_denuncia = mysqli_query($mysqli, $sql_pega_denuncia);
							$num_pega_denuncia = mysqli_num_rows($query_pega_denuncia);

							$sql_candidato = "SELECT * FROM tb_candidato WHERE id_vaga = '".$row['cd_vaga']."' AND id_candidato = '$cdUsuario'";
							$query_candidato = mysqli_query($mysqli, $sql_candidato);
							$num_candidato = mysqli_num_rows($query_candidato);

							$sql_conta_candidato = "SELECT * FROM tb_candidato INNER JOIN tb_usuario ON tb_candidato.id_candidato = tb_usuario.cd_usuario WHERE id_vaga = '".$row['cd_vaga']."'";
							$query_conta_candidato = mysqli_query($mysqli, $sql_conta_candidato);
							$num_conta_candidato = mysqli_num_rows($query_conta_candidato);

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
							}
							?>
								<!-- cabeçalho do projeto --> 
								<div id="cabecalho-projeto" style="width: 80%; margin-left: 10%; margin-right: 10%;">
									<div id="cabecalho-projeto-esquerda" style="display: flex; width: 100%; background-color: #2a3550; color: white; border: none;">
										<div id="titulo-projeto-esquerda" style="display: flex; width: 70%;" title="Nome da vaga">
											<label><?php echo $row['nm_vaga']; ?></label>
										</div>
										<div id="titulo-projeto-direita" style="width: 30%; text-align: right; margin-right: 1.8%;" title="Data de publicação">
											<label><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row['created_vaga'])); ?></label>
										</div>
									</div>
									<div id="cabecalho-projeto-direita">
										<?php
											if($idNivel == 3){
												?>
													<button class="btn-deletar-vaga btn btn-light" id="<?php echo $row['ds_url_vaga']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 86%; height: 100%; border-radius: 0; border: 1px solid; text-align: center;">Excluir</button>

													<!-- <button class="btn-deletar-vaga btn btn-light" id="<?php echo $row['ds_url_vaga']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 100%; border-radius: 0; border: 1px solid;">Excluir</button> -->
												<?php
											}else{
												if($num_pega_curtida > 0){
													?>
														<i class="btn-projeto-curtida fa-solid fa-heart" style="font-size: 30px; color: red; cursor: pointer;" id="<?php echo $row['cd_vaga']; ?>"></i>

														<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_vaga']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #DCDCDC; width: 50%; border-radius: 0; border: 1px solid;">Curtida</button> -->
													<?php
												}else{
													?>
														<i class="btn-projeto-curtida fa-regular fa-heart" style="font-size: 30px; color: white; cursor: pointer;" id="<?php echo $row['cd_vaga']; ?>"></i>
														<!-- <button class="btn-projeto-curtida btn btn-light" id="<?php echo $row['cd_vaga']; ?>" style="padding-top: 1%; padding-bottom: 1%; margin-right: 1%; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
													<?php
												}
												if($row['id_autor_vaga'] == $cdUsuario){
													?>
														<i class="btn-editar-projeto fa-solid fa-gear" style="font-size: 30px; color: white; cursor: pointer;"></i>
														<!-- <button class="btn-editar-projeto btn btn-light" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Editar</button> -->
													<?php
												}else{
													if($num_pega_denuncia > 0){
														?>
															<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_vaga']; ?>" style="font-size: 30px;color: yellow; cursor: pointer;"></i>
															<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_vaga']; ?>" style="transition: 0.5s ease; background-color: #DCDCDC; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
														<?php
													}else{
														?>
															<i class="btn-projeto-denuncia fa-solid fa-triangle-exclamation" id="<?php echo $row['cd_vaga']; ?>" style="font-size: 30px; color: white; cursor: pointer;"></i>
															<!-- <button class="btn-projeto-denuncia btn btn-light" id="<?php echo $row['cd_vaga']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; margin-left: 1%; width: 50%; border-radius: 0; border: 1px solid;">Denunciar</button> -->
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
												if($row['id_autor_vaga'] == $cdUsuario){
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
									<div id="desc-projeto" title="Especialização" style="padding: 0; background-color: #49587c;">
										<button style="border-radius: 4px; width: 97%; margin-left: 1.5%; margin-right: 1.5%;" class="pchave-projeto" id="<?php echo $row['cd_pchave_curriculo']; ?>">
											<?php echo $row['nm_pchave_curriculo']; ?>
									 	</button>
									</div>
									<div id="footer-projeto" style="border-top: 1px solid; background-color: #49587c;">
										<div id="tabela-de-arquivos-projeto" style="padding: 1.5%;">
											<div style="text-align: center; background-color: white; border: 1px solid; padding-top: 1%; padding-bottom: 1%;">
												<label>INFORMAÇÕES</label>
											</div>
						  					<div style="width: 100%; display: flex;">
												<div id="info-metade" title="Localização" style="width: 50%; padding-top: 0.6%; padding-bottom: 0.6%; border: 1px solid; border-top: 0; text-align: center;">
													<label><?php echo $row['ds_localizacao']; ?></label>
												</div>
												<div id="info-metade" title="Carga horária" style="width: 50%; padding-top: 0.6%; padding-bottom: 0.6%;border: 1px solid; border-top: 0; border-left: 0; text-align: center;">
													<label><?php echo $row['nm_pchave_vaga']; ?></label>
												</div>
											</div>
											<div style="width: 100%; display: flex;">
												<div id="info-metade" title="Email para contato" style="width: 50%; padding-top: 0.6%; padding-bottom: 0.6%;border: 1px solid; border-top: 0; text-align: center;">
													<label><?php echo $row['ds_contato_email']; ?></label>
												</div>
												<div id="info-metade" title="Telefone para contato" style="width: 50%; padding-top: 0.6%; padding-bottom: 0.6%;border: 1px solid; border-top: 0; border-left: 0; text-align: center;">
													<label><?php echo $row['ds_contato_telefone']; ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="projeto">
									<div id="titulo-projeto" style="display: flex; border-bottom: 1px solid; background-color: #2a3550; color: white;">
										<label style="padding-top: 1.3%; padding-bottom: 1.3%; padding-left: 1.5%;">DESCRIÇÃO</label>
									</div>
									<div id="desc-projeto" style="padding: 1.5%; background-color: #49587c;">
										<textarea style="width: 100%; padding: 1%;" rows="4" readonly><?php echo $row['ds_vaga']; ?></textarea>
									</div>
									<div id="footer-projeto" title="Candidatar-se para vaga" style="border-top: 1px solid; background-color: #49587c;">
										<?php
											if($idNivel == 1){
												if($num_curriculo_eu > 0){
													if($num_candidato > 0){
														?>
															<button style="border-radius: 4px; width: 97%; background-color: #DCDCDC; margin-left: 1.5%; margin-right: 1.5%; padding: 1%; border: 1px solid; margin-top: 0.6%; margin-bottom: 0.6%;" class="candidatar" id="<?php echo $row['cd_vaga']; ?>">
																Pedido enviado
														 	</button>
														<?php
													}else{
														?>
															<button style="border-radius: 4px; width: 97%; background-color: #F0F0F0; margin-left: 1.5%; margin-right: 1.5%; padding: 1%; border: 1px solid; margin-top: 0.6%; margin-bottom: 0.6%;" class="candidatar" id="<?php echo $row['cd_vaga']; ?>">
																Candidatar-se
														 	</button>
														<?php
													}
												}else{
													?>
														<button title="Para candidatar-se é necessário criar um currículo" style="border-radius: 4px; width: 97%; background-color: #F0F0F0; margin-left: 1.5%; margin-right: 1.5%; padding: 1%; border: 1px solid; margin-top: 0.6%; margin-bottom: 0.6%;" class="candidatar" disabled>
															Candidatar-se
														</button>
													<?php
												}
											}else if($idNivel == 2){
												?>
												<div id="tabela-de-arquivos-projeto" style="padding: 1.5%;">
													<div style="text-align: center; border: 1px solid; padding-top: 1%; padding-bottom: 1%; background-color: white;">
														<label>CANDIDATOS</label>
													</div>
												<?php
													if($num_conta_candidato > 0){
														while($row_candidato = mysqli_fetch_assoc($query_conta_candidato)){
															$sql_curriculo = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario WHERE id_autor_curriculo = '".$row_candidato['cd_usuario']."'";
															$query_curriculo = mysqli_query($mysqli, $sql_curriculo);
															$row_curriculo = mysqli_fetch_assoc($query_curriculo);

															?>
													  			<div style="width: 100%; display: flex;  background-color: white;">
																	<div class="perfil-candidato" id="<?php echo $row_curriculo['ds_url_usuario']; ?>" title="Nome de usuário do candidato" style="cursor: pointer; width: 70%; padding-top: 0.6%; padding-bottom: 0.6%; border: 1px solid; border-top: 0; text-align: center;">
																		<label><?php echo $row_candidato['nm_usuario']; ?></label>
																	</div>
																	<div class="curriculo-candidato" id="<?php echo $row_curriculo['ds_url_curriculo']; ?>" title="Currículo" style="cursor: pointer; width: 30%; padding-top: 0.6%; padding-bottom: 0.6%;border: 1px solid; border-top: 0; border-left: 0; text-align: center;  background-color: white;">
																		<label>Currículo</label>
																	</div>
																</div>
															<?php
														}
												}else{
													?>
														<div style="width: 100%; background-color: white;">
															<div style="border: 1px solid black; border-top: 0; padding-top: 1%; padding-bottom: 1%; text-align: center;" id="arquivo-do-projeto-esquerda">
															<i style="color: gray;">Esta vaga não possui nenhum candidato</i>
															</div>
														</div>
													<?php
												}
											}
											
										?>
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
													if($row_comentario['id_autor_comentario_vaga'] == $cdUsuario){
														?>
														<div style="margin-top: 1%; margin-bottom: 1.5%; display: flex;">
												 			<div id="left-comentarios" style="width: 4%;">
												 				<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><img id="foto-comentario" class="rounded-circle" src="<?php echo $row_comentario['path_foto_usuario']; ?>"></a>
												 			</div>
												 			<div id="right-comentarios" style="width: 94%; margin-left: 2%;">
																<a href="meu_perfil.php" style="color: white; text-decoration: none; cursor: pointer;"><label>Você</label></a>
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_vaga'])); ?></label>
													 			<label style="margin-top: 0.2%; display: flex;">
													 				<textarea name="comentario" style="width: 96%;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_vaga']; ?></textarea>
													 				<button class="btn-editar-comentario" id="<?php echo $row_comentario['cd_comentario_vaga']; ?>" style="width: 4%; border: 1px solid; border-color: #DCDCDC; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"><i class="fa-solid fa-ellipsis"></i></button>
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
																<label style="float: right; color: white;"><?php date_default_timezone_set('America/New_York'); echo date("d/m/Y H:i", strtotime($row_comentario['created_comentario_vaga'])); ?></label>
													 			<label style="display: flex; margin-top: 0.2%;">
													 				<textarea name="comentario" style="width: 100%; border-radius: 6px;" rows="2" class="form-control" id="criar-comentario-projeto" readonly><?php echo $row_comentario['ds_comentario_vaga']; ?></textarea>
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
															<i style="color: black;">Esta vaga não possui nenhum comentário</i>
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
					}else{
						header('Location: index.php');
					}
				?>
				<div class="modal" tabindex="-1" id="modal-comentario-vaga"></div>
				<div class="modal" tabindex="-1" id="modal-edita-comentario-vaga"></div>
				<div class="modal" tabindex="-1" id="denuncia-vaga"></div>
				<div class="modal" tabindex="-1" id="pchave-vaga"></div>
				<div class="modal" tabindex="-1" id="modal-deletar-vaga-adm"></div>
			</body>
		</html>
		<?php
	}else{
		header('Location: index.php');
	}
?>