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
	<title>Criar projeto</title>
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
		<label class="h5" id="titulo-label">CRIAR PROJETO</label>
		<button id="titulo-btn" style="cursor: default;"><i class="fa-solid fa-plus"></i></button>
	</div>

	<!-- Criar projeto (form) -->
	<form action="config/projeto.php" method="post" enctype="multipart/form-data">
		<div class="row g-3" id="criar-projeto-form">
			<div class="col-md-12">
				<label for="nome-projeto" class="form-label">Nome do projeto: *</label>
				<input type="text" name="nome-projeto" placeholder="Digite aqui" maxlength="100" class="form-control" id="nome-projeto" required>
			</div>
			<div class="col-md-12">
				<label for="select-pchave" class="form-label">Principal linguagem de programação: *</label>
				<select id="select-pchave" name="select-pchave" class="form-select" required>
					<option value="" selected>Selecione</option>
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
				<textarea name="desc-projeto" class="form-control" maxlength="2000" rows="4" id="desc-projeto" placeholder="Fale um pouco do seu projeto"></textarea>
			</div>
		</div>

		<div class="row g-3" id="criar-projeto-form-2">
			<div class="input-group">
				<label for="github-diretorio" class="form-label">Diretório Github: </label>
				<div class="input-group">
					<?php
						if($row_usuario['nm_github'] == "Não declarado"){
							?>
				  				<input type="text" name="github-diretorio" placeholder="usuario/projeto" class="form-control" maxlength="200" id="github-diretorio" value="Não declarado" readonly style="background-color: #F0F0F0;">
							<?php
						}else{
							?>
								<span class="input-group-text" id="https//git">github.com/<?php echo $row_usuario['nm_github']; ?>/</span>
				  				<input type="text" name="github-diretorio" placeholder="nome-do-diretório" class="form-control" maxlength="200" id="github-diretorio">
							<?php
						}
					?>
				</div>
			</div>
			<div class="input-group">
				<label for="site-url" class="form-label">Url do projeto: </label>
				<div class="input-group">
					<span class="input-group-text" id="https">https://</span>
				  	<input type="text" name="site-url" placeholder="www.exemplo-de-projeto.com" class="form-control" maxlength="200" id="site-url">
				</div>
			</div>
			<div class="col-md-12">
				<label for="arquivo-projeto" class="form-label">Inserir arquivo (.rar, .zip) - (max: 8 MB): </label>
				<input class="form-control" accept=".rar,.zip" name="arquivo[]" type="file" id="arquivo-projeto" multiple>
			</div>
		</div>
		<div class="col-md-12" style="width: 70%; margin: 4% 15% 0 15%;">
			<button class="btn" style="width: 10%; background-color: #7c0e8c; color: white; float: right; margin-bottom: 2%; border-color: white;" id="publica">Publicar</button>
			<a href="projetos_aluno.php" class="btn" style="width: 10%; background-color: #3293b2; color: white; float: left; margin-bottom: 2%; border-color: white;" id="cancela">Cancelar</a>
		</div><br>
	</form>
</body>
</html>
