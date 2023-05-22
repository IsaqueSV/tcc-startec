<?php
	include('../banco/conexao.php');
	session_start();
	
	if(isset($_POST['idDenuncia'])){
		if(empty($_POST['idDenuncia'])){
			header('Location: ../index.php');	
		}else{
			if(isset($_SESSION['cdUsuario']) AND isset($_SESSION['idNivel'])){
				$cdUsuario = $_SESSION['cdUsuario'];
				$idNivel = $_SESSION['idNivel'];		

				if($idNivel != 3){
					header('Location: ../index.php');
				}
				$idDenuncia = $_POST['idDenuncia'];
				$nivelMotivo = $_POST['nivelMotivo'];
			}
		}
	}else{
		header('Location: ../index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		#modal-deletar-denuncia-adm{ 
			background: rgb(49,149,179);
			background: linear-gradient(90deg, rgba(49,149,179,1) 0%, rgba(107,38,148,1) 80%, rgba(126,12,140,1) 100%);background: rgb(49,149,179);
			background: linear-gradient(90deg, rgba(49,149,179,1) 0%, rgba(107,38,148,1) 80%, rgba(126,12,140,1) 100%);
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			background-blend-mode: darken;
		}

		div.modal-content{
			border: 1px solid;
		}
	</style>
	<script>
	$(document).ready(function(){
		$("#btn-fecha-modal-deletar-denuncia-adm").click(function(){
			$("#modal-deletar-denuncia-adm").fadeOut();
		});

		$("#btn-deletar-usuario-confirmar").click(function(){
			window.location.href = "config/excluir_denuncia_usuario.php?see="+"<?php echo $idDenuncia; ?>";
		});

		$("#btn-deletar-projeto-confirmar").click(function(){
			window.location.href = "config/excluir_denuncia_projeto.php?see="+"<?php echo $idDenuncia; ?>";
		});

		$("#btn-deletar-curriculo-confirmar").click(function(){
			window.location.href = "config/excluir_denuncia_curriculo.php?see="+"<?php echo $idDenuncia; ?>";
		});

		$("#btn-deletar-vaga-confirmar").click(function(){
			window.location.href = "config/excluir_denuncia_vaga.php?see="+"<?php echo $idDenuncia; ?>";
		});
	});

	</script>
</head>
<body>
</body>
</html>
<?php
	if($nivelMotivo == 1){
		// usuario

		$sql_denuncia = "SELECT * FROM tb_denuncia_usuario INNER JOIN tb_usuario ON tb_denuncia_usuario.id_autor_denuncia_usuario = tb_usuario.cd_usuario WHERE cd_denuncia_usuario = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-denuncia-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente a denúncia Nº <b>".$row_denuncia['cd_denuncia_usuario']."</b>, feita por <b>".$row_denuncia['nm_usuario']."</b>.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-usuario-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 2){
		// projeto

		$sql_denuncia = "SELECT * FROM tb_denuncia_projeto INNER JOIN tb_usuario ON tb_denuncia_projeto.id_autor_denuncia_projeto = tb_usuario.cd_usuario WHERE cd_denuncia_projeto = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-denuncia-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente a denúncia Nº <b>".$row_denuncia['cd_denuncia_projeto']."</b>, feita por <b>".$row_denuncia['nm_usuario']."</b>.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-projeto-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 3){
		// curriculo

		$sql_denuncia = "SELECT * FROM tb_denuncia_curriculo INNER JOIN tb_usuario ON tb_denuncia_curriculo.id_autor_denuncia_curriculo = tb_usuario.cd_usuario WHERE cd_denuncia_curriculo = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-denuncia-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente a denúncia Nº <b>".$row_denuncia['cd_denuncia_curriculo']."</b>, feita por <b>".$row_denuncia['nm_usuario']."</b>.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-curriculo-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
	}else if($nivelMotivo == 4){
		// vaga

		$sql_denuncia = "SELECT * FROM tb_denuncia_vaga INNER JOIN tb_usuario ON tb_denuncia_vaga.id_autor_denuncia_vaga = tb_usuario.cd_usuario WHERE cd_denuncia_vaga = '$idDenuncia'";
		$query_denuncia = mysqli_query($mysqli, $sql_denuncia);
		$row_denuncia = mysqli_fetch_assoc($query_denuncia);
	
		$modal = "<div class='modal-dialog modal-dialog-centered modal-lg'>
				 	<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title'>DENÚNCIA</h5>
							<button type='button' class='btn-close' aria-label='Close' id='btn-fecha-modal-deletar-denuncia-adm'></button>
						</div>
				 		<div class='modal-body'>
				    		<div class='col-md-12 style='margin-right: 2%;'>
								<label class='alert'>
									Essa ação não pode ser desfeita. Isso excluirá permanentemente a denúncia Nº <b>".$row_denuncia['cd_denuncia_vaga']."</b>, feita por <b>".$row_denuncia['nm_usuario']."</b>.<br>
								</label>
							</div>
						</div>
						<div class='footer' style='padding: 2%; border-top: 1px solid #DCDCDC;'>
							<button type='button' class='btn' style='float: right; background-color: #1e7fbc; color: white;' id='btn-deletar-vaga-confirmar'>Confirmar</button>
						</div>
					</div>
				</div>";
	}else{

	}

	echo $modal;
?>