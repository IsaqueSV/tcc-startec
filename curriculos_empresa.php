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

	$sql = "SELECT path_foto_usuario FROM tb_usuario WHERE cd_usuario = '$cdUsuario'";
	$query = mysqli_query($mysqli, $sql);
	$row_usuario = mysqli_fetch_assoc($query);

	$filtro = "SELECT * FROM tb_pchave_curriculo";
	$query_filtro = mysqli_query($mysqli, $filtro);

	$consulta = "SELECT * FROM tb_curriculo INNER JOIN tb_usuario ON tb_curriculo.id_autor_curriculo = tb_usuario.cd_usuario INNER JOIN tb_pchave_curriculo ON tb_curriculo.id_pchave_curriculo = tb_pchave_curriculo.cd_pchave_curriculo INNER JOIN tb_estado_civil ON tb_curriculo.id_estado_civil = tb_estado_civil.cd_estado_civil INNER JOIN tb_municipio ON tb_curriculo.id_municipio = tb_municipio.cd_municipio INNER JOIN tb_etec ON tb_curriculo.id_etec_curriculo = tb_etec.cd_etec INNER JOIN tb_genero ON tb_curriculo.id_genero_curriculo = tb_genero.cd_genero ORDER BY cd_curriculo DESC";
	$query_consulta = mysqli_query($mysqli, $consulta);
	$contagem = mysqli_num_rows($query_consulta);

	$img_caminho = $row_usuario['path_foto_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Currículos</title>
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
			$("#pchave-curriculo").fadeOut();
			$("#resultado").hide();

			$("#btn-pesquisa").click(function(){
				$.ajax({
					url: "config/pesquisa-curriculo.php",
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

			$(".btn-curriculo-curtida").click(function(){
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

			$(".pchave-curriculo").click(function(){
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
		});
	</script>
	<style>
		div#desc-curriculo-quadrado{
			background-color: #F0F0F0;
			transition: 0.5s ease;
		}
		div#desc-curriculo-quadrado:hover{
			background-color: #DCDCDC;
			transition: 0.5s ease;
		}
	</style>
</head>
<body>
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

	
	<!-- Título (barra) -->
	<div id="titulo">
		<label class="h5" id="titulo-label">CURRÍCULOS</label>
		<button id="titulo-btn"><i style="font-size: 22px;" class="fa-regular fa-clipboard"></i></button>
	</div>

	<!-- Barra de pesquisa (pesquisa) -->
	<div class="input-group mb-3" id="div-pesquisa">
		<select class="form-select form-select-sm p-3" id="select-pesquisa">
			<option value=" " selected title="Filtrar busca">Filtros</option>
			<?php 
				while($row_filtro = mysqli_fetch_assoc($query_filtro)){
					?>
					<option value="<?php echo $row_filtro['cd_pchave_curriculo']; ?>"><?php echo $row_filtro['nm_pchave_curriculo']; ?></option>
					<?php
				}
			?>
		</select>
		<input type="text" class="form-control" placeholder="Pesquise algo..." id="text-pesquisa">
  		<button class="btn" type="button" id="btn-pesquisa"><i class="fa-solid fa-magnifying-glass" id="i-pesquisa"></i></button>
	</div><br>

	<!-- Resultado (resultado-pesquisa) -->
	<div class="alert" style="margin-top: 0; margin-top: 1%;" id="resultado" role="alert">
		<span id="resultado-pesquisa"></span>
	</div>

	<!-- Currículos (conteúdo) -->
	<div style="margin-top: 3%; margin-bottom: 5%;">
	<?php
		if($contagem <= 0){
			?>
			<div id="div-projeto">
				<label class='h6'>Nenhum currículo foi criado ainda!</label>
			</div>
			<?php
		}else{
			while($row_geral = mysqli_fetch_assoc($query_consulta)){
				$sql_pega_minha_curtida = "SELECT * FROM tb_curtida_curriculo INNER JOIN tb_usuario ON tb_curtida_curriculo.id_autor_curtida_curriculo = tb_usuario.cd_usuario WHERE id_autor_curtida_curriculo = '$cdUsuario' AND id_curtida_curriculo = '".$row_geral['cd_curriculo']."'";
				$query_pega_minha_curtida = mysqli_query($mysqli, $sql_pega_minha_curtida);
				$num_pega_minha_curtida = mysqli_num_rows($query_pega_minha_curtida);
				?>
				<div class="curriculo">
					<div id="titulo-curriculo" style="display: flex; align-items: center; justify-content: center; border-bottom: 1px solid;">
						<div id="titulo-curriculo-esquerda" style="width: 70%; padding: 1%;">
							<a href="curriculos.php?see=<?php echo $row_geral['ds_url_curriculo']; ?>" title="Nome do currículo" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_completo_curriculo']; ?></a> - 
							<a class="pchave-curriculo" id="<?php echo $row_geral['cd_pchave_curriculo']; ?>" title="Requisito" style="text-decoration: none; color: black; cursor: pointer;"><?php echo $row_geral['nm_pchave_curriculo']; ?></a>
						</div>
						<div id="titulo-curriculo-direita" style="width: 30%; text-align: right; margin-right: 1%;">
							<?php
								if($num_pega_minha_curtida > 0){
									?>
										<i class="btn-curriculo-curtida fa-solid fa-heart" style="font-size: 30px; color: red; cursor: pointer;" id="<?php echo $row_geral['cd_curriculo']; ?>"></i>

										<!-- <button class="btn-curriculo-curtida btn btn-light" id="<?php echo $row_geral['cd_curriculo']; ?>" style="transition: 0.5s ease; background-color: #DCDCDC; width: 50%; border-radius: 0; border: 1px solid;">Curtido</button> -->
									<?php	
								}else{
									?>
										<i class="btn-curriculo-curtida fa-solid fa-heart" style="font-size: 30px; color: black; cursor: pointer;" id="<?php echo $row_geral['cd_curriculo']; ?>"></i>

										<!-- <button class="btn-curriculo-curtida btn btn-light" id="<?php echo $row_geral['cd_curriculo']; ?>" style="transition: 0.5s ease; background-color: #F0F0F0; width: 50%; border-radius: 0; border: 1px solid;">Curtir</button> -->
									<?php
								}
							?>
						</div>
					</div>
					<div id="desc-curriculo" style="padding: 1%;">
						<div id="desc-curriculo-tabela">
							<div id="desc-curriculo-row" style="width: 100%; display: flex;">
								<div id="desc-curriculo-quadrado" title="Email para contato" style="padding: 0.5%; width: 50%; text-align: center; border: 1px solid;"><?php echo $row_geral['ds_email']; ?></div>
								<div id="desc-curriculo-quadrado" title="Cargo desejado" style="padding: 0.5%; width: 50%; text-align: center; border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid;"><?php echo $row_geral['ds_cargo']; ?></div>
							</div>
							<div id="desc-curriculo-row" style="width: 100%; display: flex;">
								<div id="desc-curriculo-quadrado" title="Etec frequentada" style="padding: 0.5%; width: 50%; text-align: center; border-left: 1px solid; border-bottom: 1px solid; border-right: 1px solid;"><?php echo $row_geral['nm_etec']; ?></div>
								<div id="desc-curriculo-quadrado" title="Gênero declarado" style="padding: 0.5%; width: 50%; text-align: center; border-bottom: 1px solid; border-right: 1px solid;"><?php echo $row_geral['nm_genero']; ?></div>
							</div>
						</div>
					</div>
					<div id="footer-curriculo" style="border-top: 1px solid; display: flex;">
						<div id="autor-curriculo-esquerda" style="width: 70%; padding: 1%;">
							<a href="perfil.php?see=<?php echo $row_geral['ds_url_usuario']; ?>" title="Autor" style="text-decoration: none; color: black;"><?php echo $row_geral['nm_usuario']; ?></a>
						</div>

						<div id="data-curriculo-direita" style="width: 30%; text-align: right; padding: 1%; margin-right: 1%;">
							<a title="Data de criação" style="text-decoration: none; color: black;"><?php date_default_timezone_set('America/New_York'); echo  date("d/m/Y H:i", strtotime($row_geral['created_curriculo'])); ?></a>
						</div>
					</div>
				</div>
			<?php
			}
		}
	?>
	</div>
	
	<div class="modal" tabindex="-1" id="modal-pesquisa-curriculo"></div>
	<div class="modal" tabindex="-1" id="pchave-curriculo"></div>
</body>
</html>