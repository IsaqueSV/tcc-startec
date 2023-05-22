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

	$sql_pega_dados = "SELECT * FROM tb_usuario INNER JOIN tb_genero ON tb_usuario.id_genero = tb_genero.cd_genero INNER JOIN tb_etec ON tb_usuario.id_etec = tb_etec.cd_etec WHERE cd_usuario = '$cdUsuario'";
	$query_pega_dados = mysqli_query($mysqli, $sql_pega_dados);
	$row_pega_dados = mysqli_fetch_assoc($query_pega_dados); 
	$sql_estado_civil = "SELECT * FROM tb_estado_civil";
	$query_estado_civl = mysqli_query($mysqli, $sql_estado_civil);
	$sql_etec = "SELECT * FROM tb_etec";
	$query_etec = mysqli_query($mysqli, $sql_etec);
	$sql_genero = "SELECT * FROM tb_genero";
	$query_genero = mysqli_query($mysqli, $sql_genero);
	$sql_municipio = "SELECT * FROM tb_municipio";
	$query_municipio = mysqli_query($mysqli, $sql_municipio);
	$sql_pchave = "SELECT * FROM tb_pchave_curriculo";
	$query_pchave = mysqli_query($mysqli, $sql_pchave);

	$img_caminho = $row_pega_dados['path_foto_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Criar currículo</title>
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
	<script>
	    function Cep(){
	    	cidade = document.querySelector("#select-cidade");

	    	if(cidade.value == ""){
	    		document.getElementById("cep").value="";
	    	}if(cidade.value == "1"){
	    		document.getElementById("cep").value="11060-100";
	    	}if(cidade.value == "2"){
	    		document.getElementById("cep").value="11410-000";
	    	}if(cidade.value == "3"){
	    		document.getElementById("cep").value="11740-000";
	    	}if(cidade.value == "4"){
	    		document.getElementById("cep").value="11708-030";
	    	}if(cidade.value == "5"){
	    		document.getElementById("cep").value="11750-000";
	    	}if(cidade.value == "6"){
	    		document.getElementById("cep").value="11325-000";
	    	}if(cidade.value == "7"){
	    		document.getElementById("cep").value="11010-000";
	    	}

	    }
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

	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">CRIAR CURRÍCULO</label>
		<button id="titulo-btn" style="cursor: default;"><i class="fa-solid fa-plus"></i></button>
	</div>

	<!-- Criar projeto (form) -->
	<form action="config/curriculo.php" method="post" enctype="multipart/form-data">		
		<div class="container-fluid" id="div-form-body" style="padding: 3%; margin-bottom: 2%;">
			<div class="row">
				<div class="col-md-3" style="padding: 0;">
					<label>
						<img src="<?php echo $row_pega_dados['path_foto_usuario']; ?>" style="width: 300px; height: 300px;" class="img-thumbnail" id="uploadPreview">
					</label>
					<input type="hidden" value="<?php echo $row_pega_dados['path_foto_usuario']; ?>" name="foto" >
				</div>
				<div class="col-md-9" style="padding: 0; padding-top: 3%; padding-left: 2%;">
					<label for="nome" style="margin-bottom: 1%;">Nome completo: *</label>
					<input type="text" style="margin-bottom: 1.5%; background-color: #F0F0F0;" class="form-control" maxlength="100" name="nome" id="nome" value="<?php echo $row_pega_dados['nm_completo']; ?>" readonly required>
					<label for="email" style="margin-bottom: 1%;">Email: *</label>
					<input type="email" style="margin-bottom: 1.5%; background-color: #F0F0F0;" class="form-control" maxlength="300" name="email" id="email" value="<?php echo $row_pega_dados['ds_email']; ?>" readonly required>
					<label for="cargo" style="margin-bottom: 1%;">Cargo desejado: *</label>
					<input type="text" class="form-control" name="cargo" maxlength="300" id="cargo" placeholder="Designer-gráfico" required>
				</div>
			</div>
		</div>

		<div class="container-fluid" id="div-form-body" style="padding: 3%; margin-bottom: 2%;">
			<div class="row">
				<div class="col" style="padding: 0; margin-bottom: 1.5%;">
					<label for="select-pchave" style="margin-bottom: 1%;">Especialização em: *</label>
					<select class="form-select" name="select-pchave" id="select-pchave" required>
						<option value="" selected>Selecione</option>
						<?php 
							while($row_pchave = mysqli_fetch_assoc($query_pchave)){
								?>
								<option value="<?php echo $row_pchave['cd_pchave_curriculo']; ?>"><?php echo $row_pchave['nm_pchave_curriculo']; ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col" style="padding: 0; margin-bottom: 1.5%;">
					<label for="nascimento" style="margin-bottom: 1%;">Data de nascimento: *</label>
					<input type="date" class="form-control" max="2007-12-31" name="nascimento" id="nascimento" required>
				</div>
				<div class="col" style="padding: 0; margin-left: 2%; margin-bottom: 1.5%;">
					<label for="select-estado-civil" style="margin-bottom: 1%;">Estado civil: *</label>
					<select class="form-select" name="select-estado-civil" id="select-estado-civil" required>
						<option value="" selected>Selecione</option>
						<?php 
							while($row_estado_civil = mysqli_fetch_assoc($query_estado_civl)){
								?>
								<option value="<?php echo $row_estado_civil['cd_estado_civil']; ?>"><?php echo $row_estado_civil['nm_estado_civil']; ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-1" style="padding: 0; margin-bottom: 1.5%;">
					<label for="ddd" style="margin-bottom: 1%;">DDD: *</label>
					<input type="text" class="form-control" minlength="2" maxlength="2" name="ddd" id="ddd" placeholder="(99)" required>
				</div>
				<div class="col" style="margin-left: 2%; padding: 0; margin-bottom: 1.5%;">
					<label for="telefone" style="margin-bottom: 0.1%;">Número de telefone: *</label>
					<input type="text" class="form-control" minlength="9" maxlength="9" name="telefone" id="telefone" placeholder="99999-9999" required>
				</div>
			</div>

			<div class="row">
				<div class="col" style="padding: 0; margin-bottom: 1.5%;">
					<label for="select-cidade" style="margin-bottom: 1%;">Cidade: *</label>
					<select class="form-select" onchange="Cep()" name="select-cidade" id="select-cidade" required>
						<option value="" selected>Selecione</option>
						<?php 
							while($row_municipio = mysqli_fetch_assoc($query_municipio)){
								?>
								<option value="<?php echo $row_municipio['cd_municipio']; ?>"><?php echo $row_municipio['nm_municipio']; ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="col" style="padding: 0; margin-left: 2%; margin-bottom: 1.5%;">
					<label for="cep" style="margin-bottom: 1%;">CEP: *</label>
					<input type="text" class="form-control" minlength="8" maxlength="8" name="cep" id="cep" placeholder="99999-999" required>
				</div>
			</div>

			<div class="row">
				<div class="col" style="padding: 0;">
					<label for="select-etec" style="margin-bottom: 1%;">ETEC frequentada: *</label>
					<input type="text" class="form-select" style="background-color: #F0F0F0;" name="select-etec" id="select-etec" value="<?php echo $row_pega_dados['nm_etec']; ?>" readonly required>
				</div>
				<div class="col" style="padding: 0; margin-left: 2%;">
					<label for="select-genero" style="margin-bottom: 1%;">Gênero: *</label>
					<input type="text" class="form-select" style="margin-bottom: 1.5%; background-color: #F0F0F0;" name="select-genero" id="select-genero" value="<?php echo $row_pega_dados['nm_genero']; ?>" readonly required>
				</div>
			</div>
		</div>

		<div class="container-fluid" id="div-form-body" style="padding: 3%; margin-bottom: 2%;">
			<div class="row">
				<div class="col" style="padding: 0; margin-bottom: 2%;">
					<label for="idiomas" style="margin-bottom: 1%;">Idiomas: </label>
					<textarea name="idiomas" class="form-control" style="margin-bottom: 0.5%;" id="idiomas" rows="2" placeholder="Avalie e escreva aqui o seu nível de domínio sobre outros idiomas" maxlength="300"></textarea>
					<span><i>Exemplo: Inglês - avançado</i></span>
				</div>
			</div>

			<div class="row">
				<div class="col" style="padding: 0; margin-bottom: 2%;">
					<label for="qualidades" style="margin-bottom: 1%;">Qualidades: </label>
					<textarea name="qualidades" class="form-control" style="margin-bottom: 0.5%;" id="qualidades" rows="4" placeholder="Escreva aqui algumas de suas qualidades/habilidades que sejam relevantes para sua contratação" maxlength="500"></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col" style="padding: 0;">
					<label for="cursos" style="margin-bottom: 1%;">Cursos complementares: </label>
					<textarea name="cursos" class="form-control" style="margin-bottom: 0.5%;" id="cursos" rows="4" placeholder="Escreva aqui os principais cursos complementares prestados por você" maxlength="2000"></textarea>
					<span><i>Exemplo: Nome do curso - instituição criadora do curso - período do curso</i></span>
				</div>
			</div>
		</div>

		<div style="width: 70%; margin: 4% 15% 0 15%;">
			<button class="btn btn-success" style="width: 10%; background-color: #7c0e8c; color: white; float: right; margin-bottom: 2%; border-color: white;" id="publica">Publicar</button>
			<a href="curriculo_aluno.php" class="btn btn-danger" style="width: 10%; background-color: #3293b2; color: white; float: left; margin-bottom: 2%; border-color: white;" id="cancela">Cancelar</a>
		</div>
	</form>

</body>
</html>
