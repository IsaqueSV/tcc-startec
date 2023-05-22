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

	$cdUsuario = $_SESSION['cdUsuario'];
	$idNivel = $_SESSION['idNivel'];

	$sql = "SELECT * FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$dados = mysqli_fetch_object($query);

	$img_caminho = $dados->path_foto_usuario;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!--
		adiciona foto no site 
		<link rel="icon" href="dados/img/ft_usuarios/user.jpg"> 
	-->
	<title>Home</title>
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
	
	<div id="caixa-adm" style="width: 96%; margin-left: 2%; margin-right: 2%;">
		<div id="caixa-adm-titulo" style="width: 100%; text-align: center;">
			<label><h1 style="font-family: Roboto Mono; margin-top: 6vw; color: white;">Painel de Controle</h1></label>
		</div>
		<div id="caixa-adm-conteudo" style="margin-top: 2%;">
			<div id="row-caixa-adm" style="width: 100%; display: flex; margin-bottom: 1%;">
				<div id="metade-caixa-adm" style="width: 49%; margin-right: 1%; padding-top: 1.2%; padding-bottom: 1.2%; text-align: center;">
					<a href="alunos_adm.php" style="color: black; text-decoration: none;"><button style="width: 60%; margin-left: 35%; padding-top: 3%; padding-bottom: 3%; border: 1px solid;" class="btn btn-light">Alunos</button></a>
				</div>
				<div id="metade-caixa-adm" style="width: 49%; margin-left: 1%; padding-top: 1.2%; padding-bottom: 1.2%; text-align: center;">
					<a href="empresa_adm.php" style="color: black; text-decoration: none;"><button style="width: 60%; margin-right: 35%; padding-top: 3%; padding-bottom: 3%; border: 1px solid;" class="btn btn-light">Empresas</button></a>
				</div>
			</div>
			<div id="row-caixa-adm" style="width: 100%; display: flex; margin-bottom: 1%;">
				<div id="metade-caixa-adm" style="width: 49%; margin-right: 1%; padding-top: 1.2%; padding-bottom: 1.2%; text-align: center;">
					<a href="projetos_adm.php" style="color: black; text-decoration: none;"><button style="width: 60%; margin-left: 35%; padding-top: 3%; padding-bottom: 3%; border: 1px solid;" class="btn btn-light">Projetos</button></a>
				</div>
				<div id="metade-caixa-adm" style="width: 49%; margin-left: 1%; padding-top: 1.2%; padding-bottom: 1.2%; text-align: center;">
					<a href="vagas_adm.php" style="color: black; text-decoration: none;"><button style="width: 60%; margin-right: 35%; padding-top: 3%; padding-bottom: 3%; border: 1px solid;" class="btn btn-light">Vagas</button></a>
				</div>
			</div>
			<div id="row-caixa-adm" style="width: 100%; display: flex; margin-bottom: 1%;">
				<div id="metade-caixa-adm" style="width: 49%; margin-right: 1%; padding-top: 1.2%; padding-bottom: 1.2%; text-align: center;">
					<a href="curriculos_adm.php" style="color: black; text-decoration: none;"><button style="width: 60%; margin-left: 35%; padding-top: 3%; padding-bottom: 3%; border: 1px solid;" class="btn btn-light">Currículos</button></a>
				</div>
			</div>
		</div>
	</div>

</body>
</html>