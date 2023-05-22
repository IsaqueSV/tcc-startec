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
	
	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$row_usuario = mysqli_fetch_assoc($query);

	$sql_pchave_periodo = "SELECT * FROM tb_pchave_vaga";
	$query_pchave_periodo = mysqli_query($mysqli, $sql_pchave_periodo);

	$sql_pchave_requisito = "SELECT * FROM tb_pchave_curriculo";
	$query_pchave_requisito = mysqli_query($mysqli, $sql_pchave_requisito);

	$img_caminho = $row_usuario['path_foto_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Criar vaga</title>
	<!-- Javascript --><script src="css/local/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap --><link href="css/local/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome --><link href="css/local/fontawesome/css/fontawesome.css" rel="stylesheet">
    <!-- Fontawesome --><link href="css/local/fontawesome/css/solid.css" rel="stylesheet">
    <!-- Jquery --><script src="css/local/js/jquery-3.6.1.min.js"></script>
    <!-- Jquery Mask --><script src="css/local/js/jquery.mask.min.js"></script>
    <!-- CSS --><link rel="stylesheet" href="css/navbar.css">
    <!-- CSS --><link rel="stylesheet" href="css/geral.css">
    <!-- CSS --><link rel="stylesheet" href="css/footer.css">
    <!-- JS --><script src="js/mask.js"></script>
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
		<label class="h5" id="titulo-label">CRIAR VAGA</label>
		<button id="titulo-btn" style="cursor: default;"><i class="fa-solid fa-plus"></i></button>
	</div>

	<!-- Criar projeto (form) -->
	<form action="config/vaga.php" method="post">
		<div class="row g-3" id="criar-vaga-form">
			<div class="col-md-12">
				<label for="nome-vaga" class="form-label">Nome da vaga: *</label>
				<input type="text" name="nome-vaga" placeholder="Digite aqui" maxlength="100" class="form-control" id="nome-vaga" required>
			</div>
			<div class="col-md-12">
				<label for="select-pchave" class="form-label">Ramo de candidatos: *</label>
				<select id="select-pchave" name="select-pchave" class="form-select" required>
					<option value="" selected>Selecione</option>
					<?php 
						while($row_requisito = mysqli_fetch_assoc($query_pchave_requisito)){
							?>
							<option value="<?php echo $row_requisito['cd_pchave_curriculo']; ?>"><?php echo $row_requisito['nm_pchave_curriculo']; ?></option>
							<?php
						}
					?>
				</select>
			</div>
			<div class="col-md-6">
				<label for="localizacao" class="form-label">Localização: *</label>
				<input type="text" name="localizacao" placeholder="Descreva a localização de sua vaga" maxlength="300" class="form-control" id="localizacao" required>
			</div>
			<div class="col-md-6">
				<label for="select-horario" class="form-label">Período: *</label>
				<select id="select-horario" name="select-horario" class="form-select" required>
					<option value="" selected>Selecione</option>
					<?php 
						while($row_horario = mysqli_fetch_assoc($query_pchave_periodo)){
							?>
							<option value="<?php echo $row_horario['cd_pchave_vaga']; ?>"><?php echo $row_horario['nm_pchave_vaga']; ?></option>
							<?php
						}
					?>
				</select>
			</div>
			<div class="col-md-12">
				<label for="email" class="form-label">Email: *</label>
				<input type="email" style="background-color: #F0F0F0;" name="email" placeholder="nome@exemplo.com" class="form-control" id="email" value="<?php echo $row_usuario['ds_email']; ?>" readonly>
			</div>
			<div class="col-md-12">
				<label for="telefone" class="form-label">Número de telefone: </label>
				<input type="text" name="telefone" placeholder="(00) 00000-0000" minlength="11" maxlength="11" class="form-control" id="telefone_vaga">
			</div>
			<div class="col-md-12">
				<label for="descricao" class="form-label">Descrição da vaga: *</label>
				<textarea name="descricao" class="form-control" rows="4" id="descricao" maxlength="2000" placeholder="Fale um pouco de sua vaga" required></textarea>
			</div>
		</div>

		<div class="col-md-12" style="width: 70%; margin: 4% 15% 0 15%;">
			<button class="btn btn-success" style="width: 10%; background-color: #7c0e8c; color: white; float: right; margin-bottom: 2%; border-color: white;" id="publica">Publicar</button>
			<a href="vagas_empresa.php" class="btn btn-danger" style="width: 10%; background-color: #3293b2; color: white; float: left; margin-bottom: 2%; border-color: white;" id="cancela">Cancelar</a>
		</div>
	</form>

</body>
</html>
