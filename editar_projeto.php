<?php
	include('banco/conexao.php');
    session_start();

    if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel']) AND isset($_GET['see'])){
        if($_GET['see'] == "" OR $_SESSION['cdUsuario'] == "" OR $_SESSION['idNivel'] == ""){
            header('Location: index.php');
        }else{
            $cdUsuario = $_SESSION['cdUsuario'];
            $idNivel = $_SESSION['idNivel'];
            $url = $_GET['see'];

            $sql_consulta = "SELECT * FROM tb_projeto INNER JOIN tb_usuario ON tb_projeto.id_autor_projeto = tb_usuario.cd_usuario INNER JOIN tb_pchave_projeto ON tb_projeto.id_pchave_projeto = tb_pchave_projeto.cd_pchave_projeto WHERE id_autor_projeto = '$cdUsuario' AND ds_url_projeto = '$url'";
            $query_consulta = mysqli_query($mysqli, $sql_consulta);
            $row_consulta = mysqli_fetch_assoc($query_consulta);
            $num_consulta = mysqli_num_rows($query_consulta);

            if($num_consulta > 0){
            	if($idNivel == 1){
            		$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
					$query = mysqli_query($mysqli, $sql);
					$row_usuario = mysqli_fetch_assoc($query);

					$result_chave = "SELECT * FROM tb_pchave_projeto";
					$resultado_chave = mysqli_query($mysqli, $result_chave);

					$img_caminho = $row_usuario['path_foto_usuario'];
            		?>
            		<!DOCTYPE html>
					<html>
					<head>
						<meta charset="UTF-8">
						<title>Editar projeto</title>
						<!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
					    <!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
					    <!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
					    <!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
					    <!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
					    <!-- Jquery Mask <script src="css/local/js/jquery.mask.min.js"></script> -->
					    <!-- CSS --><link rel="stylesheet" href="css/navbar.css">
					    <!-- CSS --><link rel="stylesheet" href="css/geral.css">
					    <!-- CSS --><link rel="stylesheet" href="css/footer.css">
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

						<!-- Título (barra) -->
						<div id="titulo">
							<label class="h5" id="titulo-label">EDITAR PROJETO</label>
							<button id="titulo-btn" style="cursor: default;"><i class="fa-solid fa-ellipsis"></i></button>
						</div>

						<!-- Criar projeto (form) -->
						<form action="config/atualiza-dados-projeto.php?see=<?php echo $row_consulta['ds_url_projeto']; ?>" method="post" enctype="multipart/form-data">
							<div class="row g-3" id="criar-projeto-form">
								<div class="col-md-12">
									<label for="nome-projeto" class="form-label">Nome do projeto: *</label>
									<input type="text" name="nome-projeto" placeholder="Digite aqui" maxlength="100" class="form-control" id="nome-projeto" value="<?php echo $row_consulta['nm_projeto']; ?>" required>
								</div>
								<div class="col-md-12">
									<label for="select-pchave" class="form-label">Principal linguagem de programação: *</label>
									<select id="select-pchave" name="select-pchave" class="form-select" required>
										<option value="<?php echo $row_consulta['nm_projeto']; ?>" selected><?php echo $row_consulta['nm_pchave_projeto']; ?></option>
										<?php 
											while($row_chave = mysqli_fetch_assoc($resultado_chave)){
												?>
												<option value="<?php echo $row_chave['cd_pchave_projeto']; ?>"><?php echo $row_chave['nm_pchave_projeto']; ?></option>
												<?php
											}
										?>
									</select>
								</div>
								<div class="col-md-12">
									<label for="desc-projeto" class="form-label">Descrição: </label>
									<?php
										if($row_consulta['ds_projeto'] == "Descrição não declarada"){
											?>
												<textarea name="desc-projeto" class="form-control" maxlength="2000" rows="4" id="desc-projeto" placeholder="Fale um pouco do seu projeto"></textarea>
											<?php
										}else{
											?>
												<textarea name="desc-projeto" class="form-control" maxlength="2000" rows="4" id="desc-projeto" placeholder="Fale um pouco do seu projeto"><?php echo $row_consulta['ds_projeto']; ?></textarea>
											<?php
										}
									?>
								</div>
							</div>

							<div class="row g-3" id="criar-projeto-form-2">
								<div class="input-group">
									<label for="github-diretorio" class="form-label">Diretório Github: </label>
									<div class="input-group">
										<?php
											if($row_usuario['nm_github'] == "Não declarado"){
												?>
												<input type="text" name="github-diretorio" placeholder="usuario/projeto" class="form-control" maxlength="200" id="github-diretorio" value="Diretório Github do projeto não declarado" readonly style="background-color: #F0F0F0;">
												<?php
											}else{
												if($row_consulta['ds_github'] == "Diretório Github do projeto não declarado"){
													?>
														<span class="input-group-text" id="https//git">github.com/<?php echo $row_consulta['nm_github']; ?>/</span>
											  			<input type="text" name="github-diretorio" placeholder="nome-do-diretório" class="form-control" maxlength="200" id="github-diretorio">
													<?php
												}else{
													$valor_git = $row_consulta['ds_github'];
													$github = explode('/', $valor_git);
													?>
														<span class="input-group-text" id="https//git">github.com/<?php echo $row_consulta['nm_github']; ?>/</span>
											  			<input type="text" name="github-diretorio" placeholder="nome-do-diretório" class="form-control" value="<?php echo $github[4]; ?>" maxlength="200" id="github-diretorio">
													<?php
												}
											}
										?>
									</div>
								</div>
								<div class="input-group">
									<label for="site-url" class="form-label">Url do projeto: </label>
									<div class="input-group">
										<?php
											if($row_consulta['ds_site'] == "Domínio do projeto não declarado"){
												?>	
													<span class="input-group-text" id="https">https://</span>
													<input type="text" name="site-url" placeholder="www.exemplo-de-projeto.com" class="form-control" maxlength="200" id="site-url">
												<?php
											}else{
												$valor = $row_consulta['ds_site'];
												$site = explode('//', $valor);
												?>
													<span class="input-group-text" id="https">https://</span>
									  				<input type="text" name="site-url" placeholder="www.exemplo-de-projeto.com" class="form-control" maxlength="200" value="<?php echo $site[1]; ?>" id="site-url">
												<?php
											}
										?>
									</div>
								</div>
								<div class="col-md-12" style="margin-top: 2%;">
									<label class="form-label">Arquivos: </label><br>
									<?php 
										if($row_consulta['arquivos'] == 0){
											?>
												<label class="form-control">Nenhum arquivo foi declarado</label>
											<?php
										}else{
											$cdProjeto = $row_consulta['cd_projeto'];
											$sql_arquivo = "SELECT * FROM tb_arquivo WHERE id_projeto_arquivo = '$cdProjeto' AND id_autor_arquivo = '$cdUsuario'";
											$query_arquivo = mysqli_query($mysqli, $sql_arquivo);
											$num_arquivo = mysqli_num_rows($query_arquivo);

											if($num_arquivo > 0){
												while($row_arquivo = mysqli_fetch_assoc($query_arquivo)){
													?>
														<div class="input-group mb-3">
															<a class="form-control" style="text-decoration: none;" href="<?php echo $row_arquivo['ds_caminho']; ?>" download><?php echo $row_arquivo['nm_arquivo'];?></a>
															<a class="input-group-text" style="text-decoration: none;" href="config/deletar-arquivo.php?see=<?php echo $row_arquivo['cd_arquivo']; ?>">Deletar</a>
														</div>
													<?php
												}
											}else{
												?>
													<label id="label" class="form-control">Nenhum arquivo foi declarado</label>
												<?php
											}
										}
									?>
									
									<input style="margin-top: 2%;" class="form-control" accept=".rar,.zip" name="arquivo[]" type="file" id="arquivo-projeto" multiple>
								</div>
							</div>
							
							<div class="col-md-12" style="width: 80%; margin-top: 2%; margin-left: 10%; margin-right: 10%;">
									<label style="padding: 2%;" class="alert alert-danger">
										IMPORTANTE: para que o projeto se mantenha é necessário que ao menos um dos seguintes campos estejam preenchidos: URL do projeto, diretório Github ou arquivos. Caso os três campos estejam vazios e o projeto seja salvo, o mesmo sera DELETADO instantâneamente
									</label>		
							</div>

							<div class="col-md-12" style="width: 70%; margin: 4% 15% 0 15%;">
								<input type="submit" class="btn btn-success" style="width: 10%; background-color: #7c0e8c; color: white; float: right; margin-bottom: 2%; border-color: white;" id="<?php echo $row_consulta['cd_projeto']; ?>" value="Salvar">
								<a href="config/excluir_projeto.php?see=<?php echo $row_consulta['ds_url_projeto']; ?>" class="btn btn-danger" style="width: 10%; background-color: #3293b2; color: white; float: left; margin-bottom: 2%; border-color: white;" id="<?php echo $row_consulta['ds_url_projeto']; ?>">Excluir</a>
							</div><br>
						</form>
					</body>
					</html>

            		<?php
            	}else{
            		header('Location: index.php');
            	}
            }else{
            	header('Location: index.php');
            }
        }
        //href="config/deletar-projeto.php?see=<?php echo $row_consulta['ds_url_projeto'];
    }else{
    	header('Location: index.php');
    }
?>